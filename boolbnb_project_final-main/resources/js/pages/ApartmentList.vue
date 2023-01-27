<template>
    <div class="my-container-fluid py-5">
        <div class="row">
            <div class="col-12">
                <form id="filter-search" class="pb-4">
                    <div class="input-wrapper">
                        <!-- raggio km -->
                        <div class="my-input-group">
                            <label class="input-group-label" for="radius"
                                >Raggio</label
                            >
                            <input
                                class="mx-2"
                                type="range"
                                min="5"
                                max="25"
                                step="1"
                                v-model="radius"
                                id="radius"
                            />
                            <span>{{ radius }} km</span>
                        </div>
                        <!-- n stanze -->
                        <div class="my-input-group">
                            <label class="input-group-label"
                                >Numero di Stanze</label
                            >
                            <input
                                type="number"
                                min="1"
                                max="20"
                                class="form-control my-custom"
                                aria-label="bedrooms"
                                v-model="rooms"
                            />
                        </div>
                        <!-- letti -->
                        <div class="my-input-group">
                            <label class="input-group-label"
                                >Numero letti</label
                            >
                            <input
                                type="number"
                                min="1"
                                max="20"
                                class="form-control my-custom"
                                aria-label="bed-numbers"
                                v-model="beds"
                            />
                        </div>
                        <!-- Invio finale per chiamata API -->
                        <div class="my-input-group">
                            <button
                                class="btn btn-primary"
                                type="submit"
                                @click.prevent="
                                    getApartment(radius, rooms, beds, services)
                                "
                            >
                                Filtra
                            </button>
                        </div>
                    </div>
                    <!-- servizi  -->
                    <div id="services" class="input-group mb-3">
                        <span
                            v-for="(element, index) in allServices"
                            :key="index"
                        >
                            <input
                                class="form-check-input"
                                type="checkbox"
                                :value="element.id"
                                name="service[]"
                                v-model="services"
                            />
                            <label
                                for="service"
                                class="form-label badge rounded-pill mb-1 text-black-50"
                            >
                                {{ element.name }}
                            </label>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div id="result-search" v-if="apartmentsToShow.length > 0">
                    <div
                        class="card mb-3 w-100"
                        v-for="(result, index) in apartmentsToShow"
                        :key="index"
                    >
                        <div class="row g-0">
                            <div class="col-md-5">
                                <a :href="`/apartment/${result.id}`">
                                    <img
                                        :src="`../../storage/${result.apartment_images[0].image_path}`"
                                        class="my-card-img rounded-start"
                                        alt="image"
                                    />
                                </a>
                            </div>
                            <div class="col-md-7 my-card-info">
                                <div class="card-body">
                                    <h5 class="card-title mb-0">
                                        <a :href="`/apartment/${result.id}`">
                                            {{
                                                result.title[0].toUpperCase() +
                                                result.title.substring(1)
                                            }}
                                        </a>
                                    </h5>
                                    <!-- <router-link
                    :to="{ name: 'apartment-show', params: { id: result.id } }"
                  >
                    Leggi di piu...
                  </router-link> -->
                                    <p class="card-text">
                                        <small class="text-muted">{{
                                            result.address
                                        }}</small>
                                    </p>
                                </div>
                                <div class="my-card-footer">
                                    <div>
                                        <span>
                                            <i class="fas fa-building"></i>
                                            {{ result.rooms_number }}Max
                                        </span>
                                        <span>
                                            <i class="fas fa-bed"></i>
                                            {{ result.beds_number }}Max
                                        </span>
                                    </div>
                                    <p class="card-text">
                                        <span class="price fw-bold"
                                            >{{ result.price_per_night }}€</span
                                        >
                                        /notte
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 v-else>
                    Mi dispiace, non ho trovato nulla
                    <i class="fas fa-frown"></i>
                </h2>
            </div>
            <div id="my-map" class="col-12 col-lg-6">
                <Map
                    :apartmentsToShow="apartmentsToShow"
                    :addressObject="addressObject"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Map from "./Map.vue";
export default {
    name: "ApartmentList",
    components: {
        Map,
    },
    props: {
        apartmentsFiltered: Array,
        addressObject: Object,
    },
    data: function () {
        return {
            radius: 20,
            beds: 1,
            rooms: 1,
            apartmentsToShow: [],
            allServices: [],
            services: [],
        };
    },
    watch: {
        apartmentsFiltered(newValue, oldValue) {
            if (oldValue !== newValue) {
                this.apartmentsToShow = this.apartmentsFiltered;
            }
        },
    },
    methods: {
        getApartment: function (radius, rooms, beds, services) {
            let latNr = this.addressObject.lat;
            let lonNr = this.addressObject.lon;

            const params = new URLSearchParams();
            params.append("lat", latNr);
            params.append("lon", lonNr);
            params.append("rooms_number", rooms);
            params.append("beds_number", beds);
            params.append("radius", radius);
            params.append("services", services);
            console.log(params);
            const request = {
                params: params,
            };
            axios
                .get("./api/apartments/filter", request)
                .then((response) => {
                    this.apartmentsToShow = [];
                    this.apartmentsToShow = response.data.results;
                    console.error(this.apartmentsToShow);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        getServices() {
            axios
                .get(`http://127.0.0.1:8000/api/services`)
                .then((response) => {
                    this.allServices = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    computed: {
        change() {
            return this.apartmentsFiltered;
        },
    },
    created() {
        this.getServices();
    },
};
</script>

<style scoped lang="scss">
form#filter-search {
    div.input-wrapper {
        display: flex;
        flex-wrap: wrap;

        div.my-input-group {
            display: flex;
            align-items: center;
            margin-right: 3rem;
            margin-bottom: 1rem;

            .my-custom {
                width: 70px;
                margin-left: 0.5rem;
            }
        }
    }

    div#services {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
}

div.card {
    border-radius: 0.25rem !important;

    .my-card-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    div.my-card-info {
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        h5 > a {
            color: black;
            text-decoration: none;
        }

        .my-card-footer {
            display: flex;
            justify-content: space-between;
            padding: 1rem;

            span {
                padding-right: 0.5rem;
            }

            p {
                margin: 0;
            }
        }
    }
}
</style>
