<template>
  <div class="row">
    <Loader v-if="isLoading" />
    <div class="col-12 col-lg-6">
      <h3>Contatta il proprietario</h3>
      <div id="contact-form">
        <div class="mb-3">
          <input
            type="text"
            id="name"
            v-model="form.guest_name"
            class="form-control"
            :class="{ 'is-invalid': errors.guest_name }"
          />
          <div v-if="errors.guest_name" class="invalid-feedback">
            {{ errors.guest_name }}
          </div>
          <label v-else for="name" class="">Il tuo nome</label>
        </div>
        <div class="mb-3">
          <input
            type="text"
            id="email"
            v-model="form.guest_email"
            class="form-control"
            :class="{ 'is-invalid': errors.guest_email }"
          />
          <div v-if="errors.guest_email" class="invalid-feedback">
            {{ errors.guest_email }}
          </div>
          <label v-else for="email">La tua email</label>
        </div>
        <div class="mb-3">
          <textarea
            type="text"
            id="message"
            v-model="form.content"
            rows="4"
            class="form-control md-textarea"
            :class="{ 'is-invalid': errors.content }"
          ></textarea>
          <div v-if="errors.content" class="invalid-feedback">
            {{ errors.content }}
          </div>
          <label v-else for="message">Il tuo messaggio</label>
        </div>
        <div class="mb-3">
          <button class="btn btn-primary" @click="sendMessage">Invia</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Loader from "../components/Loader.vue";
import { isEmpty } from "lodash";

export default {
  name: "ContactForm",
  data() {
    return {
      form: {
        guest_name: "",
        guest_email: "",
        content: "",
      },
      errors: {},
      isLoading: false,
    };
  },
  props: ["apartmentId"],
  components: { Loader },
  computed: {
    hasErrors() {
      // ! Ha errori se non è vuoto, se è vuoto non ha errori
      return !isEmpty(this.errors);
    },
  },
  methods: {
    validateForm() {
      // Validazione
      const errors = {}; // ! oggetto vuoto inizialmente

      if (!this.form.guest_name.trim())
        errors.guest_name = "Il nome non è valido.";
      if (!this.form.guest_email.trim())
        errors.guest_email = "La mail è obbligatoria.";
      if (!this.form.content.trim())
        errors.content = "Il testo del messaggio è obbligatorio.";

      // Controllo che sia una mail e che sia valida usando le espressioni regolari
      if (
        this.form.guest_email.trim() &&
        !this.form.guest_email.match(
          /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        )
      )
        errors.guest_email = "La mail non è valida";

      this.errors = errors;
    },
    sendMessage() {
      // # Richiamo validateForm
      this.validateForm();

      // Se nel controllo front-end non risultano errori, inserisco i dati nel db
      if (!this.hasErrors) {
        this.isLoading = true;

        // Inserisco tra i dati del form anche l'id dell'appartamento
        this.form.apartment_id = this.apartmentId;

        // Creo una variabile per recuperare i params
        const params = {
          ...this.form,
        };

        // # Chiamo axios in POST per mandare i dati e gli passo params
        // potrei passare direttamente this.form perchè i campi COINCIDONO
        axios
          .post("http://127.0.0.1:8000/api/contact", params)
          .then((results) => {
            // Controllo se comunque mi arrivano errori DAL BACKEND
            if (results.data.errors) {
              // Prendo gli errori DA LARAVEL e li metto comunque dentro errors
              const { guest_name, guest_email, content } = results.data.errors;
              const errors = {};
              if (guest_name) errors.guest_name = guest_name[0];
              if (guest_email) errors.guest_email = guest_email[0];
              if (content) errors.content = content[0];
              this.errors = errors;
              this.error("Fallito", "Rileggi gli errori.");
            } else {
              this.form.guest_name = "";
              this.form.guest_email = "";
              this.form.content = "";
              // ? Richiamo una funzione per mostrare un popup con un messaggio di successo
              this.success("Perfetto", "Messaggio inviato con successo.");
            }
          })
          .catch((err) => {
            this.error("Fallito", "Impossibile comunicare con il server.");
          })
          .then(() => {
            this.isLoading = false;
          });
      }
    },
    success(titleSuccess, messageSuccess) {
      this.$swal({
        icon: "success",
        title: titleSuccess,
        text: messageSuccess,
      });
    },
    error(titleError, messageError) {
      this.$swal({
        icon: "error",
        title: titleError,
        text: messageError,
      });
    },
  },
};
</script>

<style lang="scss" scoped>
div#contact-form {
  input,
  textarea {
    border-radius: 0;
    border-color: #ff385c;
  }
}
</style>
