<template>
    <div>
        <Jumbotron />
        <SponsoredApartments />
    </div>
</template>

<script>
import Jumbotron from "../components/Jumbotron.vue";
import SponsoredApartments from "../components/SponsoredApartments.vue";

export default {
    name: "Home",
    components: {
        Jumbotron,
        SponsoredApartments,
    },
};
</script>

<style></style>
