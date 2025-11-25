import Toastify from "toastify-js";

(function () {
    document.addEventListener("alpine:init", () => {
        Alpine.store("cookieConsent", {
            // State
            showBanner: false,
            isAccepted: false,
            showSettings: false,
            analytics: true,
            marketing: true,

            // Private helpers
            _getCookie(name) {
                let nameEQ = name + "=";
                let ca = document.cookie.split(";");
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == " ") c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0)
                        return c.substring(nameEQ.length, c.length);
                }
                return null;
            },
            _setCookie(name, value, days) {
                let expires = "";
                if (days) {
                    const date = new Date();
                    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie =
                    name + "=" + (value || "") + expires + "; path=/";
            },

            _runTracking() {
                var ids = window.trackingIds || {};

                if (this.analytics && ids.googleAnalyticsId) {
                    injectGoogleAnalytics(ids.googleAnalyticsId);
                }

                if (this.marketing && ids.facebookPixelId) {
                    injectFacebookPixel(ids.facebookPixelId);
                }

                if (this.marketing && ids.googleTagManagerId) {
                    injectGoogleTagManager(ids.googleTagManagerId);
                }
            },

            init() {
                // Cek preferensi yang pernah disimpan
                let cookie = this._getCookie("cookies_preference");
                if (cookie) {
                    try {
                        let pref = JSON.parse(cookie);
                        this.analytics =
                            typeof pref.analytics !== "undefined"
                                ? pref.analytics
                                : true;
                        this.marketing =
                            typeof pref.marketing !== "undefined"
                                ? pref.marketing
                                : true;
                    } catch (e) {
                        this.analytics = true;
                        this.marketing = true;
                    }
                } else {
                    this.analytics = true;
                    this.marketing = true;
                }

                if (!this._getCookie("cookies_accepted")) {
                    this.showBanner = true;
                    this.isAccepted = false;
                } else {
                    this.showBanner = false;
                    this.isAccepted = true;
                    setTimeout(() => {
                        this._runTracking();
                    }, 300);
                }
            },

            accept() {
                this._setCookie("cookies_accepted", "1", 365);
                this._setCookie(
                    "cookies_preference",
                    JSON.stringify({
                        analytics: true,
                        marketing: true,
                    }),
                    365
                );
                this.analytics = true;
                this.marketing = true;
                this.showBanner = false;
                this.isAccepted = true;
                setTimeout(() => {
                    this._runTracking();
                }, 300);
            },

            saveSettings(a, m) {
                this.analytics = a;
                this.marketing = m;
                this._setCookie(
                    "cookies_preference",
                    JSON.stringify({
                        analytics: this.analytics,
                        marketing: this.marketing,
                    }),
                    365
                );
                this._setCookie("cookies_accepted", "1", 365);
                this.isAccepted = true;
                this.showBanner = false;
                setTimeout(() => {
                    this._runTracking();
                }, 300);
            },
        });

        // -- UI STORE as previously --
        Alpine.store("ui", {
            // Add separate scrolled states for UI elements
            navbarScrolled: false,
            breadcrumbScrolled: false,

            navbarScrollThreshold: 0,
            breadcrumbScrollThreshold: 0,

            setupScrollThreshold(el, type = "breadcrumb") {
                if (!el) return;
                if (type === "navbar") {
                    this.navbarScrollThreshold = el.getBoundingClientRect().y;
                } else {
                    this.breadcrumbScrollThreshold =
                        el.getBoundingClientRect().y;
                }
                if (!this._scrollListenerAdded) {
                    window.addEventListener("scroll", () => {
                        this.updateScrolledWithThresholds();
                    });
                    this._scrollListenerAdded = true;
                }
            },

            updateScrolledWithThresholds() {
                this.navbarScrolled =
                    window.scrollY > this.navbarScrollThreshold;
                this.breadcrumbScrolled =
                    window.scrollY > this.breadcrumbScrollThreshold;
                return {
                    navbar: this.navbarScrolled,
                    breadcrumb: this.breadcrumbScrolled,
                };
            },

            // Sidebar
            sidebarOpen: false,
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
            },
            closeSidebar() {
                this.sidebarOpen = false;
            },

            // Toast
            toastMarkup(message, type = "default") {
                let color = {
                    success: "shadow-lg bg-blue-600 text-sm text-white",
                    error: "shadow-lg bg-red-500 text-sm text-white",
                    warning: "shadow-lg bg-yellow-500 text-sm text-white",
                    default:
                        "shadow-lg bg-gray-800 text-sm text-white rounded-lg p-4",
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
                        <span class="text-sm">${message}</span>
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
                // Set up scroll event for scrolled state (default: threshold 0)
                window.addEventListener("scroll", () => {
                    this.scrolled = window.scrollY > 0;
                });
                // Set initial scrolled state when DOM is loaded
                this.scrolled = window.scrollY > 0;
            },
        });
    });

    // --- Inject functions from master.blade.php to global scope (only if not present) ---
    if (typeof window.injectScript !== "function") {
        window.injectScript = function (src, opt = {}) {
            if (opt.id && document.getElementById(opt.id)) return;
            var s = document.createElement("script");
            s.src = src;
            if (opt.async) s.async = true;
            if (opt.id) s.id = opt.id;
            document.head.appendChild(s);
        };
    }
    if (typeof window.injectFacebookPixel !== "function") {
        window.injectFacebookPixel = function (id) {
            if (window.fbq || !id) return;
            !(function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod
                        ? n.callMethod.apply(n, arguments)
                        : n.queue.push(arguments);
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = "2.0";
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s);
            })(
                window,
                document,
                "script",
                "https://connect.facebook.net/en_US/fbevents.js"
            );
            fbq("init", id);
            fbq("track", "PageView");
        };
    }
    if (typeof window.injectGoogleAnalytics !== "function") {
        window.injectGoogleAnalytics = function (id) {
            if (!id) return;
            if (window.gtag) return;
            window.injectScript(
                "https://www.googletagmanager.com/gtag/js?id=" + id,
                {
                    async: true,
                    id: "ga-script",
                }
            );
            window.dataLayer = window.dataLayer || [];
            window.gtag = function () {
                dataLayer.push(arguments);
            };
            gtag("js", new Date());
            gtag("config", id);
        };
    }
    if (typeof window.injectGoogleTagManager !== "function") {
        window.injectGoogleTagManager = function (id) {
            if (!id) return;
            if (document.getElementById("gtm-js")) return;
            (function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    "gtm.start": new Date().getTime(),
                    event: "gtm.js",
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != "dataLayer" ? "&l=" + l : "";
                j.async = true;
                j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
                j.id = "gtm-js";
                f.parentNode.insertBefore(j, f);
            })(window, document, "script", "dataLayer", id);

            // Insert GTM <noscript> iframe if not already present
            var ns = document.getElementById("gtm-noscript");
            if (!ns) {
                var div = document.getElementById("gtm-noscript-placeholder");
                if (div) {
                    var noScript = document.createElement("noscript");
                    noScript.id = "gtm-noscript";
                    noScript.innerHTML =
                        '<iframe src="https://www.googletagmanager.com/ns.html?id=' +
                        id +
                        '" height="0" width="0" style="display:none;visibility:hidden"></iframe>';
                    div.appendChild(noScript);
                }
            }
        };
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Set initial scrolled state for Alpine.store('ui') when DOM is loaded
        if (window.Alpine && Alpine.store("ui")) {
            Alpine.store("ui").scrolled = window.scrollY > 0;
        }
    });

    document.addEventListener("notify", function (e) {
        const res = e.detail[0];
        Alpine.store("ui").notify(res.message, res.type);
    });

    window.addEventListener("resize", () => {
        Alpine.store("ui").sidebarOpen = window.innerWidth >= 1024;
    });

    window.addEventListener("updatedLocale", (e) => {
        const lang = e.detail[0];

        if (lang) {
            const url = new URL(window.location.href);
            url.searchParams.set("lang", lang);
            window.location.href = url.toString();
        } else {
            window.location.reload();
        }
    });

    // Prevent all Livewire error popups except for 419 (session expired)
    if (window.Livewire && window.Livewire.hook) {
        window.Livewire.hook("request", ({ fail }) => {
            fail(({ status, preventDefault }) => {
                if (status === 419) {
                    alert("Session expired. The page will reload.");
                    window.location.reload();
                    preventDefault();
                }
            });
        });
    }

    function infiniteScrollComponent(config = {}) {
        const defaultConfig = {
            resultsListEl: null,
            loadingMore: false,
            hasMoreItems: false,
            threshold: 40,
            __wire: null,
            init() {
                this.resultsListEl.addEventListener("scroll", () => {
                    console.log("scrolled");
                    if (
                        !this.loadingMore &&
                        this.resultsListEl.scrollTop +
                            this.resultsListEl.clientHeight >=
                            this.resultsListEl.scrollHeight - this.threshold
                    ) {
                        if (this.hasMoreItems._x_interceptor) {
                            this.loadingMore = true;
                            this.__wire
                                .loadMore()
                                .then(() => (this.loadingMore = false));
                        }
                    }
                });
            },
        };
        return Object.assign(defaultConfig, config);
    }

    Alpine.store("infiniteScroll", infiniteScrollComponent);
})();
