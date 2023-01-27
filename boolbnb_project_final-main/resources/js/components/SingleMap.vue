<template>
    <div class="map" id="map" ref="mapRef"></div>
</template>

<script>
import tt from "@tomtom-international/web-sdk-maps";
export default {
    name: "SingleMap",
    props: ["apartment"],
    data: function () {
        return {
            popupOffsets: {
                top: [0, 0],
                bottom: [0, -40],
                "bottom-right": [0, -70],
                "bottom-left": [0, -70],
                left: [25, -35],
                right: [-25, -35],
            },
            array:[],
        };
    },
    methods: {
        initializeMap(lon, lat) {
            this.map = tt.map({
                key: "s8boc4axPouT3YgGSwbGAvGgKUPi6ec1",
                container: this.$refs.mapRef,
                center: [lon, lat],
                zoom: 12,
            });
            let marker = new tt.Marker().setLngLat([lon, lat]).addTo(this.map);
            let popup = new tt.Popup({ offset: this.popupOffsets }).setHTML(
                `<b>${this.apartment.title}</b><pre> prezzo per notte: ${this.apartment.price_per_night} €</pre>`
            );
            marker.setPopup(popup).togglePopup();
            this.map.addControl(new tt.FullscreenControl(), "top-left");
            this.map.addControl(new tt.NavigationControl(), "top-left");
            this.map = Object.freeze(map);
        },
    },
    mounted() {
        this.initializeMap(this.apartment.longitude, this.apartment.latitude);
    },
    // watch: {
    //     apartment() {
    //         this.array = this.apartment;
    //         this.initializeMap(this.array.longitude, this.array.latitude);
    //     },
    // }
};
</script>

<style lang="scss" scoped>
#map {
    width: 100%;
    height: 500px;
}
</style>
