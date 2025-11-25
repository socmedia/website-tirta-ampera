import * as L from "leaflet";
import "leaflet/dist/leaflet.css";
import "../css/vendor/leaflet.css";

// Custom pin icon
const arahPinIcon = L.icon({
    iconUrl: "/assets/images/icons/arah_location.min.svg",
    iconSize: [32, 32],
    iconAnchor: [16, 48],
    popupAnchor: [0, -40],
    className: "leaflet-marker-icon",
});

// Alpine.js store for Leaflet
Alpine.store("leaflet", {
    map: null,
    markers: [],

    async initMaps(config = {}) {
        const { selector, locations, options = {} } = config;

        const center = options.center || [-2.5489, 118.0149]; // default Indonesia
        const zoom = options.zoom || 5;

        this.map = L.map(selector).setView(center, zoom);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>',
        }).addTo(this.map);

        locations.forEach((loc) => {
            this.addMarker([loc.latitude, loc.longitude], {
                name: loc.name,
                thumbnail: loc.thumbnail,
                thumbnail_url: loc.thumbnail_url,
                category_name: loc.category_name,
                regency: loc.regency_name,
                province: loc.province_name,
                maps_link: loc.maps_link,
            });
        });
    },

    addMarker(latlng, location = {}, openPopup = false) {
        if (!this.map) return;

        const popupContent = `
                <div class="w-full" x-data="location">
                    ${
                        location.thumbnail
                            ? `<div class="w-full aspect-[4/3] mb-3 overflow-hidden rounded-lg shadow">
                                    <img src="${location.thumbnail_url}" alt="${location.name}"
                                        class="w-full h-full object-cover">
                                </div>
                                `
                            : ""
                    }
                    <div class="w-full">
                        <p class="badge solid-primary badge-sm">
                            ${location.category_name || "-"}
                        </p>
                        <h3 class="font-semibold text-base text-neutral-800">
                            ${location.name || "Tanpa Nama"}
                        </h3>
                        <p class="text-xs text-neutral-500">
                            ${location.regency ? location.regency : ""}
                            ${
                                location.province
                                    ? (location.regency ? ", " : "") +
                                      location.province
                                    : ""
                            }
                        </p>

                        <a href="https://www.google.com/maps?q=${latlng[0]},${
            latlng[1]
        }"
                            target="_blank"
                            class="mt-2 inline-block text-xs font-medium text-blue-600 hover:underline">
                            📍 Lihat di Google Maps
                        </a>
                    </div>
                </div>
            `;

        const marker = L.marker(latlng, { icon: arahPinIcon }).addTo(this.map);
        marker.bindPopup(popupContent);
        if (openPopup) marker.openPopup();

        this.markers.push(marker);
        return marker;
    },

    clearMarkers() {
        this.markers.forEach((marker) => this.map?.removeLayer(marker));
        this.markers = [];
    },
});
