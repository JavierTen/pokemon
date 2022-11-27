<template>
    <div class="container">
        <div class="row m-2">
            <a class="back" v-bind:href="'/pokemons'"><i class="back_icon"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg></i>
                        Back</a>
            <div class="col-lg-5 col-sm-6 ">
                <div class="display_flex">
                    <p class="name_pokemon"> {{ pokemon.name }} </p>
                    <img v-bind:src="pokemon.sprites.back_default" class="card-img-top avatar_pokemon">
                    <div>

                    </div>

                </div>

                <div class="display_flex">
                    <p class="data_pokemon"> Base experience: {{ pokemon.base_experience }} </p>
                    <p class="data_pokemon"> Height: {{ pokemon.height }} </p>
                    <p class="data_pokemon"> Weight: {{ pokemon.weight }} </p>
                </div>

                <h4>Stats</h4>


                <div class="display_flex">
                    <div class="row row_ml">
                        <p v-for="stat in  pokemon.stats " class="data_pokemon col-lg-4">{{ stat.stat.name }} : {{ stat.base_stat }}</p>
                    </div>

                </div>
                <h4>Abilities</h4>
                <div class="display_flex">
                    <div class="row row_ml">
                        <p v-for="ability in  pokemon.abilities" class="data_pokemon col-lg-4">{{ ability.ability.name }}</p>
                    </div>

                </div>
            </div>
            <div class="col-sm-7 pokemon display_block">
                <div class="align-end">
                    <button class="btn btn-primary button_favorites_pokemon" v-on:click="favorite(pokemon.id)"> <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M287.9 0C297.1 0 305.5 5.25 309.5 13.52L378.1 154.8L531.4 177.5C540.4 178.8 547.8 185.1 550.7 193.7C553.5 202.4 551.2 211.9 544.8 218.2L433.6 328.4L459.9 483.9C461.4 492.9 457.7 502.1 450.2 507.4C442.8 512.7 432.1 513.4 424.9 509.1L287.9 435.9L150.1 509.1C142.9 513.4 133.1 512.7 125.6 507.4C118.2 502.1 114.5 492.9 115.1 483.9L142.2 328.4L31.11 218.2C24.65 211.9 22.36 202.4 25.2 193.7C28.03 185.1 35.5 178.8 44.49 177.5L197.7 154.8L266.3 13.52C270.4 5.249 278.7 0 287.9 0L287.9 0zM287.9 78.95L235.4 187.2C231.9 194.3 225.1 199.3 217.3 200.5L98.98 217.9L184.9 303C190.4 308.5 192.9 316.4 191.6 324.1L171.4 443.7L276.6 387.5C283.7 383.7 292.2 383.7 299.2 387.5L404.4 443.7L384.2 324.1C382.9 316.4 385.5 308.5 391 303L476.9 217.9L358.6 200.5C350.7 199.3 343.9 194.3 340.5 187.2L287.9 78.95z"/></svg></i> Add to favorites</button>

                </div>
                <img  v-bind:src="pokemon.sprites.other.home.front_default" >

            </div>

        </div>

        <div class="display_flex">


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
            name: this.$attrs.name,
            ref: null,
            id: null,
            message: this.prop_message,
        };
    },
    props: {
        pokemon: {},
        prop_message: String,
    },
    methods: {

        favorite: function (ref) {
            this.ref = ref;
            this.id = localStorage.getItem("user");

            var formData = new FormData();
            formData.append("id", this.id);
            formData.append("ref", this.ref);

            axios
                .post("/api/user/pokemons/favorite", formData)
                .then((response) => {
                    this.processing = false;
                    if (response.data.status_code === 200) {
                        alert('You added this pokemon to your favorites');
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

        getPokemon() {
            axios
                .get("http://127.0.0.1:8000/api/user/pokemons/view/" + this.name)
                .then((response) => (this.pokemon = response.data.data))
                .catch((error) => {
                    console.log(error);
                    this.errored = true;
                });
        },
    },
    mounted() {
        this.name = this.$attrs.name;
        this.getPokemon();
    },
};
</script>
