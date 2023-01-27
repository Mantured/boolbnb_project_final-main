<template>
  <section id="jumbotron" class="position-relative text-white">
    <div class="layover"></div>
    <div class="title-wrapper">
      <h1 class="title">
        Lasciati guidare verso nuove mete ed esperienze indimenticabili!
      </h1>
      <h2 class="sub-title">Esplora migliaia di destinazioni!</h2>
    </div>
  </section>
</template>

<script>
export default {
  name: "Jumbotron",
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/style.scss";
section#jumbotron {
  background-image: url("https://wallpaperaccess.com/full/219778.jpg");
  background-size: cover;
  background-position: center;
  height: calc(100vh - 84.4px);

  div.layover {
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
  }

  div.title-wrapper {
    width: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    h1.title {
      font-weight: 600;
      font-size: 4.5rem;
      margin-bottom: 2.5rem;
    }
  }
}
</style>
