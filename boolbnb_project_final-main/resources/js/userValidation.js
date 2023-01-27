import moment from 'moment';
moment().format();

let submitButton = document.getElementById('submit');
let checkErrors = {};
submitButton.addEventListener('click',function(event){
    const errors = {};
    
    const stringErrors = document.querySelectorAll(".string-error");
    stringErrors.forEach(element => {
        element.remove()
    });

    //tentative time+age checks
    if((date_of_birth.value.trim() === "")){
        errors.date_of_birth = 'Inserisci una data di nascita';
    }
    if(date_of_birth.value){
        const adulthood = moment().subtract(18 , 'years')
        if(moment(date_of_birth.value).isAfter(adulthood)){
            console.warn(moment().diff(date_of_birth.value, 'years'))
            console.error(date_of_birth.value);
            errors.date_of_birth = 'Mi spiace, devi essere maggiorenne per poterti iscrivere al sito';
        }
    }

    //working set of checks
    if((first_name.value.trim() === "") || (first_name.value.trim().length < 3) || (first_name.value.trim().length > 100)){
        errors.first_name = 'Inserisci un nome test';
    }
    if((last_name.value.trim() === "") || (last_name.value.trim().length < 3) || (last_name.value.trim().length > 100)){
        errors.last_name = 'Inserisci un cognome test';
    }
    if((password.value.trim() === "") || (password.value.trim().length <= 7) || (password.value.trim().length > 16)){
        errors.password = 'Inserisci una password tra 8 e 16 caratteri';
    }
    if((!email.value.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/))){
        errors.email = 'Inserisci un idirizzo email valido';
    }
    const confirm = document.getElementById('password-confirm')
    if((confirm.value.trim() !== password.value.trim())){
        errors.password_confirmation = 'Le password non corrispondono';
    }

    for (const key in errors) {
    const parents = document.querySelectorAll('.ax-wrapper')
    parents.forEach(parent => {
        let attribute = parent.getAttribute('name');
        if(key == attribute){
            const errorSpan = document.createElement("span");
            errorSpan.classList.add("text-danger", "string-error");
            errorSpan.innerHTML = errors[key];
            parent.appendChild(errorSpan);
        }
    });
    }

    checkErrors = errors;
    if(Object.keys(checkErrors).length !== 0){
    event.preventDefault();
    }
    
});