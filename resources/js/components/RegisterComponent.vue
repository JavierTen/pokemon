<template>
    <div>
        <div class="container">

            <div class="signin">
                <div class="hero-body">
                    <div class="container">
                        <div class="columns signup-columns">
                            <div class="column m-4">
                                <h1 id="main-signup-title" class="title is-3 signup-title">
                                    Welcome to Pokemon!
                                </h1>
                                <h2 id="main-signup-subtitle" class="subtitle signup-subtitle">
                                    To get started, share the following information with us.
                                </h2>

                                <div class="alert alert-primary alert-dismissible none mb-4"
                                    v-bind:class="[error_class]">
                                    <span><i class="mdi mdi-alert"></i></span>
                                    <a v-html="server_errors"></a>
                                    {{ message }}
                                </div>

                                <div class="signup-card login-wrapper auth-wrapper-inner">
                                    <form class="signup-form is-mobile-spaced" @submit.prevent="submit_form">
                                        <div class="columns is-multiline">
                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control">
                                                        <div class="auth-label">
                                                            Email
                                                        </div>
                                                        <input type="email" name="email" v-model="email"
                                                            autocomplete="off" v-validate="
                                                                'required|email'
                                                            " class="input"
                                                            :placeholder="'Please enter your email'" />


                                                        <!---->
                                                        <!---->
                                                        <!---->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="column is-12">
                                                <div class="field">
                                                    <div class="control">
                                                        <div class="auth-label">
                                                            Password
                                                        </div>
                                                        <input type="password" name="password" v-model="password"
                                                            autocomplete="off" v-validate="
                                                                'required'
                                                            " class="input"
                                                            :placeholder="'Please enter your password'" />


                                                        <!---->
                                                        <!---->
                                                        <!---->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="display_grid">
                                                <button type="submit" class="btn btn-primary" v-bind:disabled="
                                                    processing == true
                                                ">
                                                    <i class="fa fa-circle-notch fa-spin" v-if="
                                                        processing == true
                                                    "></i>
                                                    <span v-else>
                                                        Go to pokemon
                                                    </span>
                                                </button>
                                                <span class="align-content-center">
                                                    or login with your account
                                                    <a href="/login" class="">
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
