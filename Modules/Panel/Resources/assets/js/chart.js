// Import ApexCharts and its styles
import ApexCharts from "apexcharts";
import "apexcharts/dist/apexcharts.css";

// Default config for all charts
const DEFAULT_CONFIG = {
    stroke: { curve: "smooth", width: 3 },
    dataLabels: { enabled: false },
    legend: { show: false },
    tooltip: { theme: undefined }, // will be set by theme
};

Alpine.data("apexChart", (config = {}) => ({
    chart: null,
    config: config,
    theme: null,
    getTheme() {
        // Try to detect theme from <html> or Alpine store, fallback to 'light'
        if (this.theme) return this.theme;
        if (document.documentElement.classList.contains("dark")) return "dark";
        return "light";
    },
    buildOptions() {
        // Compose options from default, shared(theme), theme-specific, and options
        const theme = this.getTheme();

        // Default config (deep clone)
        let defaults = JSON.parse(JSON.stringify(DEFAULT_CONFIG));

        // Compose shared config
        let shared =
            typeof this.config.shared === "function"
                ? this.config.shared(theme)
                : {};

        // Theme-specific config
        let themeOpts = this.config[theme] || {};

        // User options
        let baseOptions = this.config.options || {};

        // Deep merge for objects
        const deepMerge = (target, source) => {
            for (const key in source) {
                if (
                    source[key] &&
                    typeof source[key] === "object" &&
                    !Array.isArray(source[key])
                ) {
                    if (!target[key]) target[key] = {};
                    deepMerge(target[key], source[key]);
                } else {
                    target[key] = source[key];
                }
            }
            return target;
        };

        // Merge: defaults -> shared -> themeOpts -> baseOptions (baseOptions can override)
        let merged = deepMerge(
            deepMerge(
                deepMerge(
                    JSON.parse(JSON.stringify(defaults)),
                    JSON.parse(JSON.stringify(shared))
                ),
                JSON.parse(JSON.stringify(themeOpts))
            ),
            JSON.parse(JSON.stringify(baseOptions))
        );

        // Ensure chart.type is set
        if (!merged.chart) merged.chart = {};
        if (!merged.chart.type) merged.chart.type = "line";

        // Set tooltip theme if not set
        if (merged.tooltip && !merged.tooltip.theme) {
            merged.tooltip.theme = theme;
        }

        return merged;
    },
    init() {
        // Allow theme switching
        this.theme = this.getTheme();

        // Render chart
        const options = this.buildOptions();
        this.chart = new ApexCharts(this.$refs.chart, options);
        this.chart.render();

        // Listen for theme changes (if using Alpine store or html class)
        const observer = new MutationObserver(() => {
            const newTheme = this.getTheme();
            if (newTheme !== this.theme) {
                this.theme = newTheme;
                this.updateOptions();
            }
        });
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ["class"],
        });
        this._themeObserver = observer;
    },
    updateOptions(newOptions = null) {
        if (this.chart) {
            // If newOptions provided, merge with config.options
            if (newOptions) {
                this.config.options = newOptions;
            }
            const options = this.buildOptions();
            this.chart.updateOptions(options);
        }
    },
    updateSeries(newSeries) {
        if (this.chart) {
            this.chart.updateSeries(newSeries);
        }
    },
    destroy() {
        if (this.chart) {
            this.chart.destroy();
            this.chart = null;
        }
        if (this._themeObserver) {
            this._themeObserver.disconnect();
            this._themeObserver = null;
        }
    },
}));
