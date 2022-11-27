<template>

    <div class="container">
        <div class="login  ">
            <div class="">
                <h1 id="main-signup-title" class="title is-3 signup-title">
                    Iniciar sesión
                </h1>
                <h2>
                    Bienvenido de regreso a tu cuenta
                </h2>

                <div class="alert alert-primary alert-dismissible none mb-4" v-bind:class="[error_class]">
                    <a v-html="server_errors"></a>
                    {{ message }}
                </div>

                <div>
                    <form class="signup-form is-mobile-spaced" @submit.prevent="submit_form">
                        <div>
                            <div>
                                <div class="control has-validation">
                                    <div class="auth-label">
                                        Correo Electrónico
                                    </div>
                                    <input type="email" name="email" v-model="email" autocomplete="off" v-validate="
                                        'required|email'
                                    " class="input" :placeholder="'Por favor ingrese su correo electrónico registrado'" />


                                </div>
                            </div>
                            <div class="column is-12">
                                <div class="control has-validation">
                                    <div class="auth-label">
                                        Contraseña
                                    </div>
                                    <input type="password" name="password" v-model="password" v-validate="'required'"
                                        autocomplete="new-password" class="input"
                                        :placeholder="'Por favor, introduzca su contraseña'" />


                                </div>
                            </div>



                            <div>
                                <button type="submit" class="btn btn-primary" v-bind:disabled="
                                    processing == true
                                ">
                                    <i class="fa fa-circle-notch fa-spin" v-if="processing == true"></i>
                                    <span v-else>
                                        Iniciar sesión
                                    </span>
                                </button>
                                <span>
                                    O crear tu cuenta
                                    <a href="/register" class="">
                                        pokemon
                                    </a>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
"use strict";

export default {
    data() {
        return {
            server_errors: "",
            error_class: "",
            processing: false,
            email: "",
            password: "",
            message: this.prop_message,
        };
    },
    props: {
        prop_message: String,
        preview_mode: Boolean,
        company_logo: String,
    },
    mounted() {
        console.log("Página de inicio de sesión cargada");
    },
    methods: {
        submit_form() {
            this.processing = true;

            var formData = new FormData();
            formData.append("email", this.email == null ? "" : this.email);
            formData.append(
                "password",
                this.password == null ? "" : this.password
            );

            axios
                .post("/api/user/authenticate", formData)
                .then((response) => {
                    this.processing = false;
                    if (response.data.status_code === 200) {
                        localStorage.setItem("user", response.data.data.id);
                        window.location.href = "/pokemons";
                    } else {
                        try {
                            var error_json = JSON.parse(response.data.msg);
                            this.loop_api_errors(error_json);
                        } catch (err) {
                            this.server_errors = response.data.msg;
                        }
                        this.error_class = "error";
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
