<template>
    <div class="cardolina2">
        <h3 class="mb-5">Contatta il proprietario di questo appartamento</h3>
        <form>
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
            <button
                type="submit"
                class="btn ms_btn"
                @click.prevent="sendMessage()"
            >
                {{ sending ? "Inviato" : "Invia messaggio" }}
            </button>
        </form>
    </div>
</template>

<script>
export default {
    name: "Contact",
    props: {
        accomodationToContact: Object,
    },
    data() {
        return {
            user_name: "",
            user_surname: "",
            email: "",
            message_text: "",
            accomodation_id: accomodation.id,
            user_id: accomodation.user_id,
            sending: false,
            success: false,
        };
    },
    methods: {
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
.cardolina2 {
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
