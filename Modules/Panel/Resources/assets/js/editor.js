import hljs from "highlight.js";
import {
    BalloonEditor,
    Autoformat,
    Bold,
    Italic,
    BlockQuote,
    Base64UploadAdapter,
    CloudServices,
    Essentials,
    Heading,
    Image,
    ImageCaption,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    PictureEditing,
    Indent,
    IndentBlock,
    Link,
    List,
    MediaEmbed,
    Mention,
    Paragraph,
    PasteFromOffice,
    Table,
    TableToolbar,
    TextTransformation,
    BlockToolbar,
    Code,
    CodeBlock,
} from "ckeditor5";

import RemoveImagePlugin from "./editor/remove-image-plugin";
import SimpleUploadAdapter from "./editor/simple-upload-adapter";

import "ckeditor5/ckeditor5.css";
import "../css/vendor/ckeditor.css";

// Alpine data component
function editor({ id, modelable, placeholder = "Start writing..." }) {
    return {
        // Core state
        editor: null,
        editorId: id ?? null,
        modelable: modelable ?? null,
        placeholder,
        result: null,

        // Configs
        uploadUrl: "/api/v1/common/image/store",
        deleteUrl: "/api/v1/common/image/remove",
        config: {
            licenseKey: "GPL",
            plugins: [
                Autoformat,
                BlockQuote,
                BlockToolbar,
                Bold,
                CloudServices,
                Essentials,
                Heading,
                Image,
                ImageCaption,
                ImageStyle,
                ImageToolbar,
                ImageUpload,
                Base64UploadAdapter,
                Indent,
                IndentBlock,
                Italic,
                Link,
                List,
                MediaEmbed,
                Mention,
                Paragraph,
                PasteFromOffice,
                PictureEditing,
                Table,
                TableToolbar,
                TextTransformation,
                Code,
                CodeBlock,
                RemoveImagePlugin,
            ],
            blockToolbar: [
                "undo",
                "redo",
                "|",
                "heading",
                "|",
                "bold",
                "italic",
                "link",
                "|",
                "bulletedList",
                "numberedList",
                "uploadImage",
                "|",
                "blockQuote",
                "code",
                "codeBlock",
            ],
            image: {
                toolbar: [
                    "imageStyle:inline",
                    "imageStyle:block",
                    "imageStyle:side",
                    "|",
                    "toggleImageCaption",
                    "imageTextAlternative",
                    "|",
                    "removeImage",
                ],
            },
            placeholder,
        },

        // --- INIT & LIFECYCLE ---

        init() {
            this.setupEditor();

            // Listen for Livewire event to update this editor's content, but only if the editorId matches this instance
            window.addEventListener("contentTranslated", (event) => {
                const { content, editorId } = event.detail[0];

                if (editorId != this.editorId) {
                    this.setContentFromHtml(content, editorId);
                }
            });

            // Listen for Livewire resetThirdParty event to clear all editors
            window.addEventListener("resetThirdParty", () => {
                this.resetCkeditor();
            });

            // Watch for modelable changes (if present)
            if (
                this.modelable !== null &&
                typeof this.modelable !== "undefined"
            ) {
                this.$watch("modelable", (value) => {
                    if (value !== this.result) {
                        this.setContentFromHtml(value ?? "");
                    }
                });
            }
        },

        // --- EDITOR SETUP & CONTENT ---

        setupEditor() {
            const element = this.$el;
            const input = element.querySelector(`#value-${this.editorId}`);
            let rawContent = "";

            if (input) {
                rawContent = input.value;
            }

            // Create a div for CKEditor
            const div = document.createElement("div");
            div.setAttribute("id", this.editorId);
            div.style.minHeight = "200px";
            div.setAttribute("data-placeholder", this.placeholder);
            div.setAttribute("tabindex", "0");
            div.innerHTML = rawContent;
            element.appendChild(div);

            this.config.deleteImageFromServer =
                this.deleteImageFromServer.bind(this);

            BalloonEditor.create(div, this.config)
                .then((editor) => {
                    this.editor = editor;
                    editor.plugins.get("FileRepository").createUploadAdapter = (
                        loader
                    ) => new SimpleUploadAdapter(loader, this.uploadUrl);

                    // Blur event: fallback to HTML and dispatch
                    editor.ui.focusTracker.on(
                        "change:isFocused",
                        (evt, name, isFocused) => {
                            if (!isFocused) {
                                this.handleBlurFallback(editor);
                            }
                        }
                    );

                    this.setupImageRemoveOnDelKey(editor);
                })
                .catch(this.handleEditorError.bind(this));
        },

        setContentFromHtml(newHtml, id) {
            // Set hidden input
            const input = this.$el.querySelector(`#value-${this.editorId}`);
            if (input) input.value = newHtml;

            // Update editor data
            if (this.editor) {
                try {
                    document
                        .querySelector("#" + id)
                        .ckeditorInstance.data.set(newHtml);
                } catch (e) {
                    console.error("Failed to set data in editor:", e);
                }
            }

            // Update internal result only if it's not reactive/proxied
            try {
                this.result = newHtml;
            } catch (e) {
                console.warn(
                    "Could not assign to result (possibly proxied):",
                    e
                );
            }
        },

        resetCkeditor() {
            document
                .querySelectorAll(".ck-editor__editable")
                .forEach((element) => {
                    element.ckeditorInstance?.data.set("");
                });
        },

        // --- IMAGE HANDLING ---

        setupImageRemoveOnDelKey(editor) {
            const viewDocument = editor.editing.view.document;
            viewDocument.on("keydown", (evt, data) => {
                if (data.keyCode === 8 || data.keyCode === 46) {
                    const model = editor.model;
                    const selection = model.document.selection;
                    const position = selection.getFirstPosition();
                    const index = position.path[0];
                    const element = position.root._children._nodes[index];
                    const deleteFn = editor.config.get("deleteImageFromServer");

                    if (element && element.name === "imageBlock") {
                        const imageSrc =
                            element.getAttribute("src") ||
                            (element.getAttribute("attributes") &&
                                element.getAttribute("attributes").src);

                        const removeFromEditor = () => {
                            model.change((writer) => {
                                writer.remove(element);
                            });
                        };

                        if (typeof deleteFn === "function") {
                            const result = deleteFn(imageSrc);
                            if (result?.then) {
                                return result
                                    .then(removeFromEditor)
                                    .catch((e) => {
                                        console.warn(
                                            "Image deletion failed:",
                                            e
                                        );
                                        removeFromEditor();
                                    });
                            }
                        }

                        data.preventDefault();
                        evt.stop();
                    }
                }
            });
        },

        async deleteImageFromServer(imageUrl) {
            if (!imageUrl) return;

            let url = imageUrl;
            try {
                const appUrl = document.head.querySelector(
                    'meta[name="app-url"]'
                )?.content;
                if (appUrl && url.startsWith(appUrl)) {
                    url = url.replace(appUrl, "");
                }
            } catch (e) {}

            const token =
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content") || "";

            try {
                await fetch(this.deleteUrl, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                    },
                    body: JSON.stringify({ url }),
                });
            } catch (e) {
                console.warn("Image delete failed", e);
            }
        },

        // --- ERROR & BLUR HANDLING ---

        handleEditorError(error) {
            console.error(error);
        },

        // Fallback blur handler for the initial div before CKEditor is ready
        handleBlurFallback(editor) {
            const html = editor.getData();
            this.result = html;

            // Update hidden input if it exists
            const input = this.$el.querySelector(`#value-${this.editorId}`);
            if (input) input.value = html;

            // Dispatch Livewire event
            Livewire.dispatch("updatedEditor", [
                html,
                this.editorId,
                this.modelable,
            ]);
        },
    };
}

(function () {
    Alpine.data("editor", editor);
})();
