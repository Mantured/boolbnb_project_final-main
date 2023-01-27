/* const submitForm = document.getElementById('submit'); */
const submitForm = document.getElementById('submit-form');
//declaration of an empty object for later errors existance checks
let checkErrors = {};
/* submitForm.addEventListener('click', function (event) { */
submitForm.addEventListener('submit', function (event) {
    //declaration of empty object for errors comparison
    const errors = {};
    //removal of any previously exisiting error span
    const stringErrors = document.querySelectorAll(".string-error");
    stringErrors.forEach(element => {
        element.remove()
    });
    //real validation from here
    if ((title.value.trim() === "") || (title.value.trim().length < 3) || (title.value.trim().length > 100)) {
        errors.title = `Inserisci un titolo dell\'inserzione che abbia tra i 3 e i 100 caratteri (al momento: ${title.value.trim().length})`;
    }
    if (description.value.trim().length < 10) {
        errors.description = `Inserisci una descrizione con almeno 10 caratteri. (al momento: ${description.value.trim().length})`;
    }
    if ((beds_number.value <= 0) || (beds_number.value > 20) || isNaN(beds_number.value)) {
        errors.beds_number = 'Inserisci un valore numerico tra 1 e 20';
    }
    if ((rooms_number.value <= 0) || (rooms_number.value > 20) || isNaN(rooms_number.value)) {
        errors.rooms_number = 'Inserisci un valore numerico tra 1 e 20';
    }
    if ((bathrooms_number.value <= 0) || (bathrooms_number.value > 20) || isNaN(bathrooms_number.value)) {
        errors.bathrooms_number = 'Inserisci un valore numerico tra 1 e 20';
    }
    if ((square_meters.value < 20) || (square_meters.value > 200) || isNaN(square_meters.value)) {
        errors.square_meters = 'Inserisci un valore numerico tra 20 e 200';
    }
    if ((price_per_night.value <= 0) || (price_per_night.value > 99999) || isNaN(price_per_night.value)) {
        errors.price_per_night = 'Inserisci un valore numerico tra 1 e 99999';
    }
    if ((address.value.trim() === "")) {
        errors.address = 'Inserisci un indirizzo';
    }
    // # Inizio la validazione sulle immagini
    console.log(image_path)
    const files = document.getElementById('image_path').files;
    if (files.length > 0) {
        for (const key in files) {
            if (Object.hasOwnProperty.call(files, key)) {
                const file = files[key];
                console.log(file)
                if (file.size > 2048000) {
                    console.warn(file.size + ' file troppo grande')
                    errors.image_path = 'File troppo grande'
                } else {
                    console.warn(file.size + ' file grande il giusto')
                    const uploadedFileName = file.name;
                    if (isImage(uploadedFileName) == true) {
                        console.log('immagine ok ad ultimo step validativo')
                        console.log(file.size)
                        console.log(file.name)
                    }
                    if (isImage(uploadedFileName) == false) {
                        console.error('formato sbagliato')
                        console.error(file.size)
                        console.error(file.name)
                        errors.image_path = 'Immagine nel formato errato'
                    }
                }
            }
        }
    } /* else {
        errors.image_path = 'Inserisci un\'immagine'
    } */
    console.log(image_path.value)
    //comparison of errors.key with parent div attribute (name), for error-span creation (v-if of VUEJS)
    for (const key in errors) {
        /* const parents = document.querySelectorAll('.ax-wrapper') */
        const parents = submitForm.querySelectorAll('.ax-wrapper')
        parents.forEach(parent => {
            let attribute = parent.getAttribute('name');
            if (key == attribute) {
                const errorSpan = document.createElement("span");
                errorSpan.classList.add("text-danger", "string-error");
                errorSpan.innerHTML = errors[key];
                parent.appendChild(errorSpan);
            }
        });
    }
    //errors existance check for form sending prevention
    checkErrors = errors;
    if (Object.keys(checkErrors).length !== 0) {
        event.preventDefault();
    }
});

/**
 * This function, given a string, divides it into an array by the dot (.), and returns the string at the last position of the array, which is typically the type of the file (file.something). Returns a string.
 **/
function getExtension(filename) {
    const parts = filename.split('.');
    return parts[parts.length - 1];
}
/**
 * This function, given a string, calls another function which returns the type of the file and compares it with all acceptable type formats. Returns a boolean.
**/
function isImage(filename) {
    const ext = getExtension(filename);
    switch (ext.toLowerCase()) {
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'bmp':
        case 'png':
            return true;
    }
    return false;
}





// //declaration of the dom element which recieves the input with the file
// const file = document.getElementById('image_path').files[0];
// //start of file validation, firstly existance, then size, then type
// if(file){
//     if(file.size > 3000000){
//         console.warn(file.size + ' file troppo grande')
//         console.log(file)
//     } else{
//         console.warn(file.size + ' file grande il giusto')
//         const uploadedFileName = file.name;
//         if(isImage(uploadedFileName) == true){
//             console.log('immagine ok ad ultimo step validativo')
//         }
//         if(isImage(uploadedFileName) == false) {
//             console.error('formato sbagliato')
//             errors.image_path = 'Immagine nel formato errato'
//         }
//     }
//     //getAsText(file);
// } else{
//     errors.image_path = 'Inserisci un\'immagine'
// }
