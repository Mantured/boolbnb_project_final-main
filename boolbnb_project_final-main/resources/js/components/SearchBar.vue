<template>
    <div class="search">
        <input
            type="text"
            aria-describedby="basic-addon1"
            placeholder="Dove Vuoi Andare?"
            v-model="addressSearch"
            @keyup="getAddress(addressSearch)"
        />
        <ul
            id="result_address"
            class="position-absolute w-100"
            v-show="searchResults.length > 0"
        >
            <li
                v-for="(result, index) in searchResults"
                :key="index"
                @click="getApartment(result, 20)"
            >
                <router-link class="text-decoration-none" :to="{ name: 'apartment' }"
                    >{{ result.address }}
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "SearchBar",
    data: function () {
        return {
            addressSearch: "",
            searchResults: [],
            apartments: [],
        };
    },
    methods: {
        getAddress: function (string) {
            let timeout = null;
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                axios
                    .get(
                        `https://api.tomtom.com/search/2/geocode/${string}.json?`,
                        {
                            params: {
                                key: "s8boc4axPouT3YgGSwbGAvGgKUPi6ec1",
                                countrySet: "IT",
                                limit: 5,
                            },
                        }
                    )
                    .then((response) => {
                        this.searchResults = [];
                        const numResult = response.data.summary.numResults;
                        for (let i = 0; i < numResult; i++) {
                            this.searchResults.push({
                                address:
                                    response.data.results[i].address
                                        .freeformAddress,
                                lat: response.data.results[i].position.lat,
                                lon: response.data.results[i].position.lon,
                            });
                        }
                        console.log(this.searchResults);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }, 1000);
        },
        getApartment: function (addressObj, km) {
            axios
                .get(
                    `http://127.0.0.1:8000/api/apartments/search/${addressObj.lat}&${addressObj.lon}&${km}`
                )
                .then((response) => {
                    /*  console.warn(response.data); */
                    this.apartments = response.data.results;
                    this.$emit("apartmentsFiltered", this.apartments);
                    this.$emit("addressObject", addressObj);
                })
                .catch();
            this.addressSearch = addressObj.address;
            this.searchResults = [];
        },
    },
};
</script>

<style lang="scss" scoped>
div.search {
    flex-basis: calc(100% / 3);
    position: relative;
  //border: 1px solid red;

    input {
        width: 100%;
        border: none;
        padding: 0.6rem;
        padding-left: 2rem;
        border-radius: 30px;
        box-shadow: 1px 4px 21px -2px rgba(0, 0, 0, 0.68);
        //box-shadow: 0 0.5rem 0.7rem rgba(0, 0, 0, 0.1);
    }
    ul#result_address {
        margin-top: .5rem;
    }
}
</style>
