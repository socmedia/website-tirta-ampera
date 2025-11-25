import TurndownService from "turndown";
import markdownit from "markdown-it";
import hljs from "highlight.js";

import {
    ClassicEditor,
    BlockToolbar,
    Essentials,
    Bold,
    Italic,
    Paragraph,
    Markdown,
    Heading,
    List,
    Link,
    BlockQuote,
    Code,
    CodeBlock,
    ImageInsertUI,
    ImageUpload,
    Image,
} from "ckeditor5";

import "highlight.js/styles/atom-one-dark.css";
import "ckeditor5/ckeditor5.css";

// Fix for "Uncaught Error: This is an abstract method."
// The error is likely caused by trying to instantiate Editor directly, which is abstract.
// Instead, you must use a concrete CKEditor 5 build (e.g., ClassicEditor, InlineEditor, BalloonEditor, etc.)
// We'll assume ClassicEditor is available from ckeditor5/builds/classic-editor (or similar).
// If you use a custom build, import it accordingly.

(function () {
    Alpine.data("editor", ({ id, modelable }) => ({
        editor: null,
        turndownService: new TurndownService({
            headingStyle: "atx",
            codeBlockStyle: "fenced",
            bulletListMarker: "-",
            emDelimiter: "*",
            strongDelimiter: "**",
        }),
        markdownit: null,

        init() {
            this.setupMarkdownIt();
            this.setupTableRendering();
            this.setupEditor();
        },

        setupMarkdownIt() {
            this.markdownit = new markdownit({
                html: true,
                linkify: true,
                typographer: true,
                highlight: this.highlightCode.bind(this),
            });
        },

        highlightCode(str, lang) {
            if (lang && hljs.getLanguage(lang)) {
                try {
                    return `<pre><code class="hljs language-${lang}">${
                        hljs.highlight(str, { language: lang }).value
                    }</code></pre>`;
                } catch (_) {}
            }
            return `<pre><code class="hljs">${markdownit.utils.escapeHtml(
                str
            )}</code></pre>`;
        },

        setupTableRendering() {
            const defaultOpen =
                this.markdownit.renderer.rules.table_open ||
                ((tokens, idx, options, env, self) =>
                    self.renderToken(tokens, idx, options));
            this.markdownit.renderer.rules.table_open = (
                tokens,
                idx,
                options,
                env,
                self
            ) =>
                '<div class="table-responsive">' +
                defaultOpen(tokens, idx, options, env, self);

            const defaultClose =
                this.markdownit.renderer.rules.table_close ||
                ((tokens, idx, options, env, self) =>
                    self.renderToken(tokens, idx, options));
            this.markdownit.renderer.rules.table_close = (
                tokens,
                idx,
                options,
                env,
                self
            ) => defaultClose(tokens, idx, options, env, self) + "</div>";
        },

        setupEditor() {
            const hiddenInput = document.getElementById(`editor-value-${id}`);
            const markdown = hiddenInput.value;
            const html = this.markdownit.render(markdown);

            const div = document.createElement("div");
            div.innerHTML = html;
            this.$el.appendChild(div);

            ClassicEditor.create(div, this.config)
                .then((editorInstance) => {
                    // ✅ Store in non-reactive reference
                    Object.defineProperty(this, "$editor", {
                        value: editorInstance,
                        writable: false,
                        configurable: true,
                        enumerable: false,
                    });

                    // Sync on changes
                    editorInstance.model.document.on("change:data", () =>
                        this.sync()
                    );
                    editorInstance.ui.focusTracker.on(
                        "change:isFocused",
                        (_, __, isFocused) => {
                            if (!isFocused) this.sync();
                        }
                    );
                })
                .catch((error) => console.error("CKEditor init error", error));
        },

        syncToLivewire() {
            const html = this.editor.getData();
            const markdown = this.turndownService.turndown(html);
            document.getElementById(`editor-value-${id}`).value = markdown;

            if (modelable) {
                const lw = Livewire.find(
                    this.$el.closest("[wire\\:id]").getAttribute("wire:id")
                );
                if (lw) {
                    lw.set(modelable, markdown);
                }
            }
        },

        // The config below is for custom builds. If using ClassicEditor build, you may not need to specify plugins.
        config: {
            licenseKey: "GPL",
            plugins: [
                BlockToolbar,
                Essentials,
                Bold,
                Italic,
                Paragraph,
                Markdown,
                Heading,
                List,
                Link,
                BlockQuote,
                Code,
                CodeBlock,
                ImageInsertUI,
                ImageUpload,
                Image,
            ],
            toolbar: [
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
                ],
            },
        },
    }));
})();
