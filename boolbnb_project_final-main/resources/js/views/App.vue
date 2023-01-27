<template>
  <div>
    <Header
      @apartmentsFiltered="getApartmentsFiltered"
      @addressObject="getAddress"
    />
    <Main
      :apartmentsFiltered="apartmentsFiltered"
      :addressObject="addressObject"
    />
  </div>
</template>

<script>
import Header from "../components/Header.vue";
import Main from "../components/Main.vue";

export default {
  name: "App",
  components: {
    Header,
    Main,
    /* Map, */
  },
  data: function () {
    return {
      apartmentsFiltered: [],
      addressObject: {},
    };
  },
  methods: {
    getApartmentsFiltered(apartmentsFiltered) {
      this.apartmentsFiltered = apartmentsFiltered;
      this.$emit("apartmentsFiltered", this.apartmentsFiltered);
    },
    getAddress(obj) {
      this.addressObject = obj;
      this.$emit("addressObject", this.addressObject);
    },
  },
};
</script>
<style lang="scss"></style>
