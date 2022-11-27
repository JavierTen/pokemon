<template>
    <div>
        <div class="signup-nav">
            <div class="signup-nav-inner">
                <a href="/" class="logo"
                    ><img
                        class="small-footer-logo light-image-l"
                        src="/assets/img/logos/logo/logo.svg"
                        alt=""
                /></a>
            </div>
        </div>

        <div class="signup-wrapper">
            <img
                class="card-bg"
                src="/images/backgrounds/signup/vuero-signup.png"
                alt=""
            />

            <div class="hero is-fullheight">
                <div class="hero-body">
                    <div class="container">
                        <div class="columns signup-columns">
                            <div class="column is-5 is-offset-1">
                                <h1
                                    id="main-signup-title"
                                    class="title is-3 signup-title"
                                >
                                    ¡Bienvenid@!
                                </h1>
                                <h2
                                    id="main-signup-subtitle"
                                    class="subtitle signup-subtitle"
                                >
                                    Para empezar compártenos la siguiente
                                    información
                                </h2>

                                <div
                                    class="alert alert-primary alert-dismissible none mb-4"
                                    v-bind:class="[error_class]"
                                >
                                    <span><i class="mdi mdi-alert"></i></span>
                                    <a v-html="server_errors"></a>
                                    {{ message }}
                                </div>

                                <div
                                    class="signup-card login-wrapper auth-wrapper-inner"
                                >
                                    <form
                                        class="signup-form is-mobile-spaced"
                                        @submit.prevent="submit_form"
                                    >
                                        <div class="columns is-multiline">
                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control">
                                                        <input
                                                            type="email"
                                                            name="email"
                                                            v-model="email"
                                                            autocomplete="off"
                                                            v-validate="
                                                                'required|email'
                                                            "
                                                            class="input"
                                                            :placeholder="'Por favor ingrese su correo electrónico registrado'"
                                                        />

                                                        <div class="auth-label">
                                                            Correo Electrónico
                                                        </div>
                                                        <!----><!----><!---->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control">
                                                        <input
                                                            type="password"
                                                            name="password"
                                                            v-model="password"
                                                            autocomplete="off"
                                                            v-validate="
                                                                'required'
                                                            "
                                                            class="input"
                                                            :placeholder="'Por favor ingrese su contraseña'"
                                                        />

                                                        <div class="auth-label">
                                                            Contraseña
                                                        </div>
                                                        <!----><!----><!---->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="column control is-flex">
                                                <button
                                                    type="submit"
                                                    class="button button v-button is-bold is-fullwidth is-raised is-primary"
                                                    v-bind:disabled="
                                                        processing == true
                                                    "
                                                >
                                                    <i
                                                        class="fa fa-circle-notch fa-spin"
                                                        v-if="
                                                            processing == true
                                                        "
                                                    ></i>
                                                    <span v-else>
                                                        Siguiente
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
                .post("/api/user/register", formData)
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
