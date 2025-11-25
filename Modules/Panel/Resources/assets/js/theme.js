import Toastify from "toastify-js";
import ColorThief from "colorthief/dist/color-thief.mjs";
import dropdownTeleport from "./dropdown.js";

window.colorThiefInstance = new ColorThief();

(function () {
    document.addEventListener("alpine:init", () => {
        Alpine.data("dropdownTeleport", dropdownTeleport);

        Alpine.store("ui", {
            // Theme
            dark:
                localStorage.theme === "dark" ||
                (!("theme" in localStorage) &&
                    window.matchMedia("(prefers-color-scheme: dark)").matches),

            toggleTheme() {
                this.dark = !this.dark;
                localStorage.theme = this.dark ? "dark" : "light";
                document.documentElement.classList.toggle("dark", this.dark);
            },

            setTheme(mode) {
                this.dark = mode === "dark";
                localStorage.theme = mode;
                document.documentElement.classList.toggle("dark", this.dark);
            },

            // Sidebar
            sidebarOpen: false,
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
            },
            closeSidebar() {
                this.sidebarOpen = false;
            },

            // Scroll
            scrollUp(el) {
                (
                    el.closest("body") || document.querySelector("body")
                ).scrollIntoView({ behavior: "smooth" });
            },

            // Toast
            toastMarkup(message, type = "default") {
                let color = {
                    success: "shadow-lg bg-blue-600 text-sm text-white",
                    error: "shadow-lg bg-red-500 text-sm text-white",
                    warning: "shadow-lg bg-yellow-500 text-sm text-white",
                    default:
                        "shadow-lg bg-gray-800 text-sm text-white rounded-lg p-4 dark:bg-white dark:text-neutral-800",
                }[type];

                let icon = {
                    success: "bx-check-circle",
                    error: "bx-x-circle",
                    warning: "bx-error",
                    default: "bx-info-circle",
                }[type];

                return `
                    <div class="flex items-center gap-2 p-4 rounded-md ${color}">
                        <i class="bx ${icon} text-lg"></i>
                        <p class="text-sm toast-description">${message}</p>
                        <div class="ms-auto">
                            <button onclick="Alpine.store('ui').tostifyCustomClose(event.target)"
                                type="button"
                                class="inline-flex justify-center items-center rounded-lg opacity-50 size-5 hover:opacity-100 focus:outline-none"
                                aria-label="Close">
                                <span class="sr-only">Close</span>
                                <i class="text-lg bx bx-x"></i>
                            </button>
                        </div>
                    </div>
                `;
            },

            notify(message, type = "default") {
                Toastify({
                    gravity: "bottom",
                    text: this.toastMarkup(message, type),
                    duration: 8000,
                    close: true,
                    className: "ssh-toast",
                    escapeMarkup: false,
                    offset: {
                        y: 20,
                    },
                }).showToast();
            },

            tostifyCustomClose(el) {
                const parent = el.closest(".toastify");
                const close = parent.querySelector(".toast-close");
                close.click();
            },

            // Init
            init() {
                document.documentElement.classList.toggle("dark", this.dark);
            },
        });

        Alpine.data("colorThief", () => ({
            rgb: [0, 0, 0],
            gradient: "",

            getColor(img) {
                const apply = () => {
                    this.rgb = window.colorThiefInstance.getColor(img);
                    const [r, g, b] = this.rgb;
                    this.gradient = `radial-gradient(circle at center,
            rgba(${r}, ${g}, ${b}, 0.8) 0%,
            rgba(${r}, ${g}, ${b}, 0.05) 70%,
            transparent 100%)`;
                };

                if (img.complete) apply();
                else img.onload = apply;
            },
        }));
    });

    window.addEventListener("updatedLocale", () => window.location.reload());

    document.addEventListener("notify", function (e) {
        const res = e.detail[0];
        Alpine.store("ui").notify(res.message, res.type);
    });

    window.addEventListener("resize", () => {
        Alpine.store("ui").sidebarOpen = window.innerWidth >= 1024;
    });
})();
