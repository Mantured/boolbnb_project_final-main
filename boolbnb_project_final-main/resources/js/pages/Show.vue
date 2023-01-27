<template>
  <div class="my-show-container m-auto py-5">
    <div class="row">
      <div class="col-12">
        <div>
          <h1>
            {{
              apartment.title[0].toUpperCase() + apartment.title.substring(1)
            }}
          </h1>
          <h4>{{ apartment.address }}</h4>
        </div>
      </div>
    </div>
    <div class="row mb-5">
      <div class="col-lg-6 col-md-12 pe-0">
        <img
          v-if="apartment.apartment_images"
          class="show-main-image img-fluid"
          :src="`../../storage/${apartment.apartment_images[0].image_path}`"
          alt="image"
        />
      </div>
      <div class="col-lg-6 col-md-12">
        <ul class="row gallery" v-if="apartment.apartment_images.length > 0">
          <li
            class="col-lg-6 col-md-3"
            v-for="(image, index) in apartment.apartment_images"
            :key="index"
          >
            <img
              class="show-side-images"
              :src="`../../storage/${image.image_path}`"
              alt="image"
            />
          </li>
        </ul>
        <div
          class="d-flex justify-content-center align-items-center flex-column"
          v-if="apartment.apartment_images.length > 6"
        >
          <div class="more btn">Show more</div>
          <div class="less btn">Show less</div>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- Colonna descrizione -->
      <div class="col-12 col-lg-8">
        <h3>Descrizione</h3>
        <p>{{ apartment.description }}</p>
      </div>
      <!-- Colonna ripilogo offerta -->
      <div class="col-12 col-lg-4">
        <div class="card card-show">
          <div class="card-body">
            <h4 class="card-title text-center bb-magenta pb-3">
              <span class="fw-bold">
                {{ apartment.price_per_night }} &euro;
              </span>
              /notte
            </h4>
            <div class="d-flex justify-content-between mx-2">
              <h5 class="card-text fw-bold">Stanze:</h5>
              <h5 class="card-text">
                {{ apartment.rooms_number }}
              </h5>
            </div>
            <div class="d-flex justify-content-between mx-2">
              <h5 class="card-text fw-bold">Bagni:</h5>
              <h5 class="card-text">
                {{ apartment.bathrooms_number }}
              </h5>
            </div>
            <div class="d-flex justify-content-between mx-2">
              <h5 class="card-text fw-bold">Letti:</h5>
              <h5 class="card-text">
                {{ apartment.beds_number }}
              </h5>
            </div>
            <div class="d-flex justify-content-between mx-2">
              <h5 class="card-text fw-bold">M<sup>2</sup>:</h5>
              <h5 class="card-text">
                {{ apartment.square_meters }}
              </h5>
            </div>
          </div>
        </div>
      </div>
      <!-- Colonna servizi inclusi -->
      <div class="col-12 col-lg-8">
        <div id="services" v-if="apartment.services.length > 0">
          <h3 class="mt-5">Servizi Inclusi</h3>
          <span
            class="badge rounded-pill bg-magenta me-2 mb-1"
            v-for="(result, index) in apartment.services"
            :key="index"
          >
            {{ result.name }}
          </span>
        </div>
      </div>
    </div>
    <!-- <div class="row" v-if='message'>
      <div class="col-12">
        <h1>
          {{ message }}
        </h1>
      </div>
    </div> -->
    <div class="row">
      <div class="col-12 my-5">
        <h3 class="">Dove ci troviamo</h3>
        <SingleMap :apartment="apartment" />
      </div>
    </div>
    <ContactForm :apartmentId="this.$route.params.id" />
  </div>
</template>

<script>
import SingleMap from "../components/SingleMap.vue";
import ContactForm from "../components/ContactForm.vue";

export default {
  name: "Show",
  data: function () {
    return {
      apartment: [],
      message: '',
    };
  },
  components: { ContactForm, SingleMap },
  props: {},
  methods: {
    getApartment(apartmentId) {
      axios
        .get(`http://localhost:8000/api/apartments/${apartmentId}`)
        .then((response) => {
          console.warn("ho richiamato il singolo post by ID");
          this.apartment = response.data.results;
        })
        .catch((error) => {
          console.log(error);
          this.message = 'Appartamento non disponibile';
        });
    },
  },
  created() {
    this.getApartment(this.$route.params.id);
  },
};
</script>

<style lang="scss" scoped>
.gallery li {
  display: block;
}
.info-card {
  height: 250px;
}
</style>
