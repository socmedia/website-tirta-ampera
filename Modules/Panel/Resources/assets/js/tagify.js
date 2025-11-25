import Tagify from "@yaireo/tagify";

window.Tagify = Tagify;

(function () {
    Alpine.data("tagify", () => ({
        tagify: null,
        config: null,
        init() {
            const input = this.$el.querySelector("input");

            // Prevent multiple initializations
            if (input?._tagify) {
                this.tagify = input._tagify;
                return;
            }

            try {
                const rawConfig = this.$el.getAttribute("data-config") || "{}";
                this.config = JSON.parse(rawConfig);

                // Handle whitelist config
                const whitelist = this.config.whitelist;
                if (whitelist?.length) {
                    this.config.whitelist = whitelist.map((item) => ({
                        ...(typeof item === "object" ? item : { value: item }),
                        editable: false,
                    }));
                    this.config.enforceWhitelist = true;
                }

                // Handle maxTags config
                if (this.config.maxTags > 0) {
                    this.config.maxTags = this.config.maxTags;
                } else {
                    delete this.config.maxTags;
                }

                // Tagify event callbacks
                this.config.callbacks = {
                    remove: (e) =>
                        Livewire.dispatch("handleTagifyUpdate", [
                            this.getTagValues(),
                        ]),
                    change: (e) =>
                        Livewire.dispatch("handleTagifyUpdate", [
                            this.getTagValues(),
                        ]),
                };
            } catch (e) {
                console.error("Invalid JSON in data-config:", e);
                this.config = {};
            }

            this.initTagify();
        },

        initTagify() {
            const input = this.$el.querySelector("input");
            if (!input) return;

            this.tagify = new Tagify(input, this.config);

            document.addEventListener("resetThirdParty", () => this.reset());
        },

        reset() {
            if (this.tagify) {
                this.tagify.removeAllTags();
                this.tagify.DOM.input.value = "";
            }
        },

        getTagValues() {
            return this.tagify.value.map((tag) => tag.value);
        },
    }));
})();
