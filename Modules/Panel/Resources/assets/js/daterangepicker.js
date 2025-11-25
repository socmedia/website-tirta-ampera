import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
import "../css/vendor/flatpickr.css";

Alpine.data("daterangepicker", () => ({
    startDate: null,
    endDate: null,
    modelable: null,
    picker: null,

    init(config = {}) {
        this.startDate = config.startDate ?? null;
        this.endDate = config.endDate ?? null;
        this.modelable = config.modelable ?? null;

        this.picker = flatpickr(this.$refs.input, {
            mode: "range",
            dateFormat: "Y-m-d",
            defaultDate: [this.startDate, this.endDate].filter(Boolean),
            onChange: (selectedDates) => {
                if (selectedDates.length === 2) {
                    this.startDate = selectedDates[0]
                        .toLocaleDateString("id-ID")
                        .replaceAll("/", "-");

                    this.endDate = selectedDates[1]
                        .toLocaleDateString("id-ID")
                        .replaceAll("/", "-");

                    if (this.modelable) {
                        this.modelable.start = this.startDate;
                        this.modelable.end = this.endDate;
                    }

                    this.$dispatch("updatedDaterangePicker", [
                        {
                            start: this.startDate,
                            end: this.endDate,
                        },
                    ]);
                }
            },
        });
    },
}));
