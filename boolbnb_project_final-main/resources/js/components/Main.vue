<template>
    <router-view
        :apartmentsFiltered="apartmentsFiltered"
        :addressObject="addressObject"
    ></router-view>
</template>

<script>
export default {
    name: "Main",
    props: {
        apartmentsFiltered: Array,
        addressObject: Object,
    },
};
</script>

<style></style>
