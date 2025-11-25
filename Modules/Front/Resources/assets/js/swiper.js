import Swiper, { Navigation, Pagination, Autoplay } from "swiper";
import "swiper/swiper-bundle.css";
import "../css/vendor/swiper.css";

Alpine.store("swiper", {
    instances: {},

    /**
     * Init Swiper reusable
     */
    init(config = {}) {
        const { key, selector, options } = config;

        if (typeof key === "undefined" || typeof selector === "undefined") {
            console.warn(
                "Swiper init requires 'key' and 'selector' properties in the config object."
            );
            return null;
        }

        const defaultOptions = {
            modules: [Navigation, Pagination, Autoplay],
            loop: true,
            slidesPerView: 1,
            spaceBetween: 16,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            autoplay: false,
            breakpoints: {
                640: { slidesPerView: 1, spaceBetween: 16 },
                768: { slidesPerView: 2, spaceBetween: 24 },
                1024: { slidesPerView: 3, spaceBetween: 32 },
            },
        };

        const swiperOptions = Object.assign({}, defaultOptions, options);

        let container;
        if (typeof selector === "string") {
            container = document.querySelector(selector);
        } else if (selector instanceof HTMLElement) {
            container = selector;
        }

        if (!container) {
            console.warn("Swiper container not found:", selector);
            return null;
        }

        const instance = new Swiper(container, swiperOptions);
        this.instances[key] = instance;
        return instance;
    },

    /**
     * Get swiper instance by key
     */
    get(key) {
        return this.instances[key] || null;
    },
});
