// remove-image-plugin.js
import { Plugin, Command, ButtonView } from "ckeditor5";

const trashIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M17 6V4c0-1.1-.9-2-2-2H9c-1.1 0-2 .9-2 2v2H2v2h2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8h2V6zM9 4h6v2H9zM6 20V8h12v12z"></path><path d="M9 10h2v8H9zM13 10h2v8h-2z"></path></svg>`;

class RemoveImageCommand extends Command {
    execute() {
        const editor = this.editor;
        const model = editor.model;
        const selection = model.document.selection;
        const imageElement = selection.getSelectedElement();

        // Check if the selected element is an imageBlock
        if (!imageElement || imageElement.name !== "imageBlock") return;

        // Get the src attribute from the image element's attributes object
        const imageSrc =
            imageElement.getAttribute("src") ||
            (imageElement.getAttribute("attributes") &&
                imageElement.getAttribute("attributes").src);

        const deleteFn = editor.config.get("deleteImageFromServer");

        const removeFromEditor = () => {
            model.change((writer) => {
                writer.remove(imageElement);
            });
        };

        if (typeof deleteFn === "function") {
            const result = deleteFn(imageSrc);
            if (result?.then) {
                return result.then(removeFromEditor).catch((e) => {
                    console.warn("Image deletion failed:", e);
                    removeFromEditor();
                });
            }
        }

        removeFromEditor();
    }

    refresh() {
        const model = this.editor.model;
        const selection = model.document.selection;
        const selectedElement = selection.getSelectedElement();
        this.isEnabled =
            selectedElement && selectedElement.name === "imageBlock";
    }
}

export default class RemoveImagePlugin extends Plugin {
    init() {
        const editor = this.editor;

        editor.commands.add("removeImage", new RemoveImageCommand(editor));

        editor.ui.componentFactory.add("removeImage", (locale) => {
            const view = new ButtonView(locale);
            const command = editor.commands.get("removeImage");

            view.set({
                label: "Remove image",
                icon: trashIcon,
                tooltip: true,
            });

            view.bind("isEnabled").to(command, "isEnabled");

            view.on("execute", () => {
                editor.execute("removeImage");
            });

            return view;
        });
    }
}
