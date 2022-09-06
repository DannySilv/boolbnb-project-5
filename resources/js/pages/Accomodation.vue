<template>
    <div class="ms-container d-flex justify-content-center">
        <div class="card cardolina" style="width: 650px">
            <div v-if="accomodation.image">
                <img
                    :src="accomodation.image"
                    class="card-img-top"
                    alt="Card image cap"
                />
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ accomodation.name }}</h5>
                <p>
                    {{ accomodation.description }}
                </p>
                <p>Stanze: {{ accomodation.n_rooms }}</p>
                <p>Posti letto: {{ accomodation.n_beds }}</p>
                <p>Bagni: {{ accomodation.n_bathrooms }}</p>
                <p>Dimensione: {{ accomodation.size_sqm }} m²</p>
                <p>Indirizzo: {{ accomodation.address }}</p>
                <ul>
                    Servizi:
                    <li
                        v-for="(facility, idx) in accomodation.facilities"
                        :key="idx"
                    >
                        {{ facility.name }}
                    </li>
                </ul>
                <Map :accomodation="accomodation" />
            </div>
        </div>

        <div class="cardolina">
            <h3 class="mb-5">
                Contatta il proprietario di questo appartamento
            </h3>
            <form @submit.prevent="sendMessage">
                <!-- Input nome -->
                <div class="form-group">
                    <label for="user_name">Inserisci il tuo nome</label>
                    <input
                        type="text"
                        class="form-control"
                        id="user_name"
                        placeholder="Nome"
                        v-model="user_name"
                    />
                </div>

                <!-- Input cognome -->
                <div class="form-group">
                    <label for="user_surname">Inserisci il tuo cognome</label>
                    <input
                        type="text"
                        class="form-control"
                        id="user_surname"
                        placeholder="Cognome"
                        v-model="user_surname"
                    />
                </div>

                <!-- Input email -->
                <div class="form-group">
                    <label for="email">Inserisci la tua email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        placeholder="Email"
                        v-model="email"
                    />
                </div>

                <!-- Input text_message -->
                <div class="form-group">
                    <label for="message_text">Inserisci il tuo messaggio</label>
                    <textarea
                        type="message_text"
                        class="form-control"
                        id="message_text"
                        placeholder="Cosa vuoi scriverci..."
                        v-model="message_text"
                    ></textarea>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn ms_btn">
                    {{ sending ? "Inviato" : "Invia messaggio" }}
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import Map from "../components/Map.vue";

export default {
    name: "Accomodation",
    components: {
        Map,
    },
    data() {
        return {
            user_name: "",
            user_surname: "",
            email: "",
            message_text: "",
            accomodation_id: null,
            user_id: null,
            accomodation: null,
            sending: false,
            success: false,
        };
    },
    created() {
        this.getAccomodationInfo();
    },
    methods: {
        getAccomodationInfo() {
            const slug = this.$route.params.slug;
            axios.get(`/api/accomodations/${slug}`).then((resp) => {
                if (resp.data.success) {
                    this.accomodation = resp.data.results;
                    this.accomodation_id = resp.data.results.id;
                    this.user_id = resp.data.results.user_id;
                } else {
                    this.$router.push({ name: "not-found" });
                }
            });
        },
        sendMessage() {
            this.sending = true;
            axios
                .post("http://127.0.0.1:8000/api/messages", {
                    user_name: this.user_name,
                    user_surname: this.user_surname,
                    email: this.email,
                    message_text: this.message_text,
                    accomodation_id: this.accomodation_id,
                    user_id: this.user_id,
                })
                .then(() => {
                    if (
                        this.user_name &&
                        this.user_surname &&
                        this.email &&
                        this.message_text &&
                        this.accomodation_id &&
                        this.user_id
                    ) {
                        this.user_name = "";
                        this.user_surname = "";
                        this.email = "";
                        this.message_text = "";
                        this.success = true;
                        this.sending = false;
                        // console.log(resp);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style lang="scss" scoped>
.cardolina {
    margin: 4rem auto;
    p {
        font-weight: lighter;
    }
    li {
        display: inline-block;
        margin: 0 0.5rem;
        font-weight: lighter;
    }
}

.ms_btn {
    width: 100%;
    margin: 1rem 0;
    border: 1px solid #de2547;
    color: #de2547;
    transition: all 0.3s;
    &:hover {
        background-color: #de2547;
        color: white;
    }
}
</style>
