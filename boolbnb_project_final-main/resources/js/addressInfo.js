window.axios = axios.create();
delete axios.defaults.headers.common["X-CSRF-TOKEN"];
delete axios.defaults.headers.common["X-Requested-With"];

const searchBtn = document.querySelector("#address");
const resultList = document.querySelector("#result_address");
let searchResults = [];
let timeout = null;
searchBtn.addEventListener("keyup", function () {
    let searchKeyword = searchBtn.value;
    //console.log(searchKeyword);
    if (searchKeyword != "") {
        searchResults = [];
        // Resetto l'ul list
        resultList.innerHTML = "";
        //console.warn(searchResults);
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            /* axios.get(`https://api.tomtom.com/search/2/geocode/${searchKeyword}.json?`, {
            https://api.tomtom.com/search/2/search/${searchKeyword}.json?extendedPostalCodesFor=Str&minFuzzyLevel=1&maxFuzzyLevel=2&view=Unified&relatedPois=off
            params: {
            key: 's8boc4axPouT3YgGSwbGAvGgKUPi6ec1',
            limit: 5,
        }
      }) */
            axios
                .get(
                    `https://api.tomtom.com/search/2/geocode/${searchKeyword}.json?`,
                    {
                        params: {
                            key: "s8boc4axPouT3YgGSwbGAvGgKUPi6ec1",
                            countrySet: "IT",
                            limit: 5,
                        },
                    }
                )
                .then((response) => {
                    resultList.classList.remove("d-none");
                    resultList.classList.add("d-block");
                    // prendo il numero di risultati ottenuti
                    const numResult = response.data.summary.numResults;
                    // Ciclo per il numero di risultati ottenuto
                    for (let i = 0; i < numResult; i++) {
                        /* console.error(response.data.results[i].address.freeformAddress); */
                        searchResults.push(
                            response.data.results[i].address.freeformAddress
                        );
                        const newLi = document.createElement("li");
                        /* newLi.innerHTML = response.data.results[i].address.freeformAddress; */
                        newLi.innerHTML = searchResults[i];
                        resultList.appendChild(newLi);
                        const position = response.data.results[i].position;
                        clickElement(newLi, resultList, position); // richiamo la mia funzione
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }, 500);
    }
});

function clickElement(element, list, position) {
    element.addEventListener("click", function () {
        searchBtn.value = element.innerHTML;
        list.classList.remove("d-block");
        list.classList.add("d-none");
        console.log(
            `L'indirizzo scelto è ${searchBtn.value}, lat ${position.lat}, long ${position.lon}`
        );
        const latitude = document.getElementById("latitude");
        latitude.value = position.lat;
        const longitude = document.getElementById("longitude");
        longitude.value = position.lon;
    });
}
