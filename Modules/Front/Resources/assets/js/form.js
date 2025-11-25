Alpine.store("inputRange", {
    min: 0,
    max: 500000,
    minGap: 100,
    minValue: 0,
    maxValue: 500000,

    init(config = {}) {
        Object.assign(this, config);
    },

    // Format angka biasa (1.000)
    formatNumber(value) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    // Format dengan prefix Rp
    formatRupiah(value) {
        return "Rp " + this.formatNumber(value);
    },

    // Ambil angka dari string "Rp 10.000"
    parseRupiah(str) {
        return parseInt((str || "").replace(/[^\d]/g, "")) || 0;
    },

    updateFromSlider(which) {
        this.minValue = Math.max(this.min, Math.min(this.minValue, this.max));
        this.maxValue = Math.max(this.min, Math.min(this.maxValue, this.max));

        if (this.maxValue - this.minValue < this.minGap) {
            if (which === "min") {
                this.minValue = this.maxValue - this.minGap;
            } else {
                this.maxValue = this.minValue + this.minGap;
            }
        }
    },

    updateFromInput() {
        this.minValue = Math.max(this.min, Math.min(this.minValue, this.max));
        this.maxValue = Math.max(this.min, Math.min(this.maxValue, this.max));

        if (this.minValue > this.maxValue) {
            this.minValue = this.maxValue;
        }
        if (this.maxValue < this.minValue) {
            this.maxValue = this.minValue;
        }

        if (this.maxValue - this.minValue < this.minGap) {
            if (this.$refs && this.$refs.minValue === document.activeElement) {
                this.minValue = this.maxValue - this.minGap;
            } else {
                this.maxValue = this.minValue + this.minGap;
            }
        }
    },

    trackStyle() {
        const percentMin =
            ((this.minValue - this.min) / (this.max - this.min)) * 100;
        const percentMax =
            ((this.maxValue - this.min) / (this.max - this.min)) * 100;
        return `left: ${percentMin}%; right: ${100 - percentMax}%;`;
    },
});
