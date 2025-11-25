import * as libphonenumber from "libphonenumber-js";

Alpine.store("libphonenumber", {
    countries: [],

    allowedCountryCodes: [
        "ID", // Indonesia
        "US", // United States
        "GB", // United Kingdom
        "JP", // Japan
        "SG", // Singapore
        "AU", // Australia
    ],
    alpha2ToAlpha3: {
        ID: "IDN",
        US: "USA",
        GB: "GBR",
        JP: "JPN",
        SG: "SGP",
        AU: "AUS",
    },
    init(config = {}) {
        // console.log(true);

        if (
            config.allowedCountryCodes &&
            Array.isArray(config.allowedCountryCodes)
        ) {
            this.allowedCountryCodes = config.allowedCountryCodes;
        }
        if (
            config.alpha2ToAlpha3 &&
            typeof config.alpha2ToAlpha3 === "object"
        ) {
            this.alpha2ToAlpha3 = {
                ...this.alpha2ToAlpha3,
                ...config.alpha2ToAlpha3,
            };
        }

        this.countries = this.getCountries();
    },
    getCountries() {
        const countries = this.allowedCountryCodes
            .filter((country) =>
                libphonenumber.getCountries().includes(country)
            )
            .map((country) => {
                const countryCode = country.toLowerCase();
                const phoneCode = libphonenumber.getCountryCallingCode(country);
                // Get flag emoji from country code
                const flag = countryCode
                    .toUpperCase()
                    .replace(/./g, (char) =>
                        String.fromCodePoint(127397 + char.charCodeAt())
                    );
                const countryCode3 =
                    this.alpha2ToAlpha3[country] || country.toUpperCase();
                return {
                    countryCode,
                    phoneCode,
                    flag,
                    countryCode3,
                };
            })
            .sort((a, b) => a.countryCode.localeCompare(b.countryCode));
        return countries;
    },
});
