<template>
    <div>


        <div class="container center_form_update">

            <div class="update_data m-2">
                <div class="columns m-4">
                    <div class="column is-5 m-2">
                        <h4  class="subtitle signup-subtitle">
                            Update your account information
                        </h4>

                        <div class="alert alert-primary alert-dismissible none mb-4" v-bind:class="[error_class]">
                            <span><i class="mdi mdi-alert"></i></span>
                            <a v-html="server_errors"></a>
                            {{ message }}
                        </div>


                            <form @submit.prevent="submit_form">
                                <div class="columns is-multiline">
                                    <div class="column is-12">
                                        <div class="field">
                                            <div class="control">
                                                <div class="update-label">
                                                    Fullname
                                                </div>
                                                <input type="text" name="name" v-model="name" autocomplete="off"
                                                    v-validate="
                                                        'required'
                                                    " class="input" :placeholder="''" />

                                                <!---->
                                                <!---->
                                                <!---->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column is-12">
                                        <div class="field">
                                            <div class="control">
                                                <div class="update-label">
                                                    Address
                                                </div>
                                                <input type="text" name="address" v-model="address" autocomplete="off"
                                                    v-validate="
                                                        'required'
                                                    " class="input" :placeholder="''" />

                                                <!---->
                                                <!---->
                                                <!---->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column is-12">
                                        <div class="field">
                                            <div class="control">
                                                <div class="update-label">
                                                    City
                                                </div>
                                                <input type="text" name="city" v-model="city" autocomplete="off"
                                                    v-validate="
                                                        'required'
                                                    " class="input" :placeholder="''" />

                                                <!---->
                                                <!---->
                                                <!---->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column is-12">
                                        <div class="field">
                                            <div class="control">
                                                <div class="update-label">
                                                    Birthday
                                                </div>
                                                <input type="date" name="birthdate" v-model="birthdate"
                                                    autocomplete="off" v-validate="
                                                        'required'
                                                    " class="input" :placeholder="''" />

                                                <!---->
                                                <!---->
                                                <!---->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column is-12">
                                        <div class="field">
                                            <div class="control">
                                                <div class="update-label">
                                                    Email
                                                </div>
                                                <input type="email" name="email" v-model="email" autocomplete="off"
                                                    v-validate="
                                                        'required|email'
                                                    " class="input" :placeholder="''" />

                                                <!---->
                                                <!---->
                                                <!---->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column is-12">
                                        <div class="field">
                                            <div class="control">
                                                <div class="update-label">
                                                    Password
                                                </div>
                                                <input type="password" name="password" v-model="password"
                                                    autocomplete="off" class="input" :placeholder="''" />

                                                <!---->
                                                <!---->
                                                <!---->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column control is-flex ">
                                        <button type="submit" class="btn btn-primary btn_save_update" v-bind:disabled="
                                            processing == true
                                        ">
                                            <i class="fa fa-circle-notch fa-spin" v-if="
                                                processing == true
                                            "></i>
                                            <span v-else>
                                                Save
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
            name: "",
            city: "",
            address: "",
            birthdate: "",
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
            formData.append("name", this.name == null ? "" : this.name);
            formData.append("city", this.city == null ? "" : this.city);
            formData.append(
                "address",
                this.address == null ? "" : this.address
            );
            formData.append(
                "birthdate",
                this.birthdate == null ? "" : this.birthdate
            );

            formData.append(
                "password",
                this.password == null ? "" : this.password
            );
            axios
                .post("/api/user/update", formData)
                .then((response) => {
                    this.processing = false;
                    if (response.data.status_code === 200) {
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
