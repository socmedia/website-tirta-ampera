export default function dropdownTeleport() {
    return {
        dropdownOpen: false,
        triggerEl: null,
        menuEl: null,
        _listenersAdded: false,

        toggle(trigger) {
            this.triggerEl = trigger;
            this.menuEl = this.$refs.menuEl;

            this.dropdownOpen = !this.dropdownOpen;

            if (this.dropdownOpen) {
                this.showMenu();
                this.addListeners();
            } else {
                this.hideMenu();
            }
        },

        showMenu() {
            if (!this.menuEl || !this.triggerEl) return;

            this.positionMenu();
            this.menuEl.classList.remove("hidden");
            this.dropdownOpen = true;
        },

        hideMenu() {
            if (this.menuEl) {
                this.menuEl.classList.add("hidden");
            }
            this.dropdownOpen = false;
        },

        positionMenu() {
            if (!this.triggerEl || !this.menuEl) return;

            const trigger = this.triggerEl;
            const rect = this.triggerEl.getBoundingClientRect();
            const menuHeight = this.menuEl.offsetHeight || 200;
            const menuWidth = this.menuEl.offsetWidth || 168;
            const spaceBelow = window.innerHeight - rect.bottom;
            const spaceAbove = rect.top;

            this.menuEl.style.position = "absolute";

            if (spaceBelow < menuHeight && spaceAbove > menuHeight) {
                this.menuEl.style.top = `${
                    rect.top + rect.height * 1.5 + window.scrollY - menuHeight
                }px`;
            } else {
                this.menuEl.style.top = `${rect.bottom + window.scrollY}px`;
            }

            this.menuEl.style.left = `${
                rect.x - (menuWidth - rect.width + window.scrollX)
            }px`;
        },

        addListeners() {
            if (this._listenersAdded) return;
            this._listenersAdded = true;

            const handler = (e) => {
                if (
                    this.dropdownOpen &&
                    this.menuEl &&
                    !this.menuEl.contains(e.target) &&
                    !this.triggerEl.contains(e.target)
                ) {
                    this.hideMenu();
                }
            };

            document.addEventListener("click", handler);
            window.addEventListener("resize", () => {
                if (this.dropdownOpen) this.positionMenu();
            });
            window.addEventListener(
                "scroll",
                () => {
                    if (this.dropdownOpen) this.positionMenu();
                },
                true
            );
        },
    };
}
