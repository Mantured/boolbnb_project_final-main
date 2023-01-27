<template>
  <div class="my-container-fluid py-5">
    <div
      class="my-card"
      v-for="(apartment, index) in apartmentList"
      :key="index"
    >
      <div
        :id="`card_${index}`"
        class="carousel slide"
        data-bs-interval="false"
      >
        <div class="carousel-inner">
          <div
            class="carousel-item"
            :class="index == 0 ? 'active' : ''"
            v-for="(image, index) in apartment.apartment_images"
            :key="index"
          >
            <router-link
              :to="{
                name: 'apartment-show',
                params: { id: apartment.id },
              }"
            >
              <img
                :src="`../../storage/${image.image_path}`"
                class="d-block"
                alt="image 1"
              />
            </router-link>
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          :data-bs-target="`#card_${index}`"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          :data-bs-target="`#card_${index}`"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
        <span v-if="apartment.sponsored" class="sponsored-star">
          <i class="fas fa-crown text-warning"></i
        ></span>
      </div>
      <div class="my-card-body">
        <div v-if="apartment.address.length < 20">
          <h6 class="address">
            <router-link
              class="address-link"
              :to="{
                name: 'apartment-show',
                params: { id: apartment.id },
              }"
              >{{ apartment.address }}
            </router-link>
          </h6>
        </div>
        <div v-else>
          <h6 class="address">
            <router-link
              class="address-link"
              :to="{
                name: 'apartment-show',
                params: { id: apartment.id },
              }"
            >
              {{ apartment.address.substring(0, 25) + "..." }}
            </router-link>
          </h6>
        </div>

        <!-- <h6 class="address">
          <router-link
            class="address-link"
            :to="{ name: 'apartment-show', params: { id: apartment.id } }"
          >
            {{ apartment.address }}
          </router-link>
        </h6> -->
        <span class="price">{{ apartment.price_per_night }}€</span>
        <span>/notte</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "SponsoredApartments",
  components: {},
  data() {
    return {
      apartmentList: [],
      apartmentFiller: [],
    };
  },

  created() {
    this.getRandom();
    this.getSponsored();
  },
  methods: {
    // getApartments() {
    //   axios
    //     .get(`http://127.0.0.1:8000/api/apartments/sponsored`)
    //     .then((result) => {
    //       this.apartmentList = result.data.data;
    //       console.log(this.apartmentList);
    //     })
    //     .catch((error) => {
    //       console.log(error);
    //     });
    // },
    getSponsored() {
      axios
        .get(`http://127.0.0.1:8000/api/apartments/sponsored`)
        .then((result) => {
          // Richiesta andata a buon fine
          // Inserisco il risultato della ricerca nell'array e stampo un messaggio a video
          console.warn("Recupero la lista degli appartamenti");
          //console.log(this.apartmentList)
          this.apartmentList = result.data;
          this.apartmentList.forEach((element) => {
            element.sponsored = true;
          });
          //console.warn(this.apartmentList)
          if (this.apartmentList.length < 15) {
            console.error(this.apartmentFiller);
            this.apartmentFiller.forEach((element) => {
              element.sponsored = false;
            });
            let difference = 15 - this.apartmentList.length;
            for (let i = 0; i < difference; i++) {
              const element = this.apartmentFiller[i];
              this.apartmentList.push(element);
            }
          }

          console.log(this.apartmentList);
        })
        .catch((error) => {
          // Errore nella richiesta
          console.log(error);
        });
    },
    getRandom() {
      axios
        .get(`http://127.0.0.1:8000/api/apartments/random`)
        .then((result) => {
          this.apartmentFiller = result.data;
          //console.error(result.data);
          console.warn(this.apartmentFiller);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style lang="scss" scoped>
div.my-container-fluid {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;

  div.my-card {
    margin: 1rem 0;

    div.carousel.slide {
      width: 300px;
      height: 300px;

      .carousel-inner,
      .carousel-item {
        height: 100%;

        img {
          width: 100%;
          height: 100%;
          border-radius: 20px;
          object-fit: cover;
        }
      }

      span.sponsored-star {
        position: absolute;
        right: 0;
        top: 0;
        padding: 1rem;
      }
    }

    div.my-card-body {
      h6.address,
      span.price {
        font-size: 1.1rem;
        font-weight: 600;
      }

      h6.address {
        margin: 0.8rem 0 0.1rem !important;

        .address-link {
          color: black;
          text-decoration: none;
        }
      }
    }
  }
}

/* @media screen and (max-width: 992px) {
  div.my-container-fluid {
    background-color: red;
    justify-content: center;
    div.my-card {
      div.carousel.slide {
        width: 350px;
        height: 350px;
      }
    }
  }
}

@media screen and (max-width: 576px) {
  div.my-container-fluid {
    background-color: rebeccapurple;
    justify-content: center;
    div.my-card {
      div.carousel.slide {
        width: 400px;
        height: 400px;
      }
    }
  }
} */
</style>
