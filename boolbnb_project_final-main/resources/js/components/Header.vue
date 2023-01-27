<template>
  <nav class="my-container-fluid">
    <a class="logo" href="/"><img :src="image_src" alt="boolbnb_logo" /></a>

    <SearchBar
      @apartmentsFiltered="getApartmentsFiltered"
      @addressObject="getAddress"
    />
    <div class="my-dropdown">
      <a
        class="btn"
        type="button"
        id="dropdownMenuLink"
        data-bs-toggle="dropdown"
        aria-expanded="false"
      >
        <i class="fas fa-bars"></i>
        <div class="omino">
          <i class="far fa-user"></i>
        </div>
      </a>

      <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuLink">
        <li><a class="dropdown-item" href="/login">Area Host</a></li>
        <li><hr class="dropdown-divider" /></li>
        <li v-for="(navItem, index) in navItems" :key="index">
          <router-link class="abaut-btn" :to="{ name: navItem.routeName }">
            {{ navItem.label }}
          </router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import SearchBar from "./SearchBar.vue";
export default {
  name: "Header",
  components: {
    SearchBar,
  },
  data: function () {
    return {
      image_src: "/images/logo-boolbnb.png",
      apartmentsFiltered: [],
      navItems: [
        {
          label: "About us",
          routeName: "about-us",
        },
      ],
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

<style lang="scss" scoped>
nav.my-container-fluid {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 1.2rem;
  padding-bottom: 1.2rem;
  background-color: white;
}

div.my-dropdown {
  border: 1px solid lightgrey;
  border-radius: 30px;

  a {
    div.omino {
      display: inline-block;
      width: 30px;
      height: 30px;
      line-height: 30px;
      margin-left: 0.2rem;
      font-size: 1rem;
      border-radius: 50%;
      background-color: #717171;
      color: white;
      text-align: center;
    }
  }
}
</style>
