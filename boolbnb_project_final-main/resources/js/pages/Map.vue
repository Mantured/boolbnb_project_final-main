<template>
    <div class="map" id="map" ref="mapRef"></div>
</template>

<script>
import tt from "@tomtom-international/web-sdk-maps";

export default {
    name: "Map",
    props: {
        addressObject: Object,
        apartmentsToShow: Array,
    },
    data: function () {
        return {
            lat: "",
            lon: "",
            center: "",
            popupOffsets: {
                top: [0, 0],
                bottom: [0, -40],
                "bottom-right": [0, -70],
                "bottom-left": [0, -70],
                left: [25, -35],
                right: [-25, -35],
            },
        };
    },
    methods: {
        getPosition() {
            this.lat = this.addressObject.lat;
            this.lon = this.addressObject.lon;
        },
        initializeMap() {
            if (this.lat == "" && this.lon == "") {
                this.center = { lon: 12.457285, lat: 41.902273 };
            } else {
                this.center = [this.lon, this.lat];
            }

            this.map = tt.map({
                key: "s8boc4axPouT3YgGSwbGAvGgKUPi6ec1",
                container: this.$refs.mapRef,
                center: this.center,
                zoom: 12,
            });
            this.apartmentsToShow.forEach((element) => {
                let marker = new tt.Marker()
                    .setLngLat([element["longitude"], element["latitude"]])
                    .addTo(this.map);
                let popup = new tt.Popup({ offset: this.popupOffsets }).setHTML(
                    `<b>${element.title}</b><br/>`
                );
                marker.setPopup(popup).togglePopup();
            });
            this.map.addControl(new tt.FullscreenControl(), "top-left");
            this.map.addControl(new tt.NavigationControl(), "top-left");
            this.map = Object.freeze(map);
        },
        getPosition() {
            this.lat = this.addressObject.lat;
            this.lon = this.addressObject.lon;
        },
    },
    mounted() {
        this.initializeMap();
    },
    watch: {
        apartmentsToShow() {
            this.getPosition();
            this.initializeMap();
        },
    },
};
</script>

<style lang="scss" scoped>
#map {
    width: 100%;
    height: 500px;
}
</style>
