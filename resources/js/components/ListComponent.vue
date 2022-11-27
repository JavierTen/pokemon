<template>
    <div class="container">


        <div class="row row_list">
            <div class="card col-lg-4 col-md-6 col-sm-12 m-3" style="width: 18rem;" v-for="(pokemon, index) in pokemons">
            <div class="card-body ">
                <h5 class="card-title label_pokemon_list">{{ pokemon.name }}</h5>
                <p class="card-text label_pokemon_list">{{pokemon.gender}}</p>
                <a v-bind:href="'/pokemons/view/' + pokemon.name" class="btn btn-primary see_more">See more</a>
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
            message: this.prop_message,
        };
    },
    props: {
        pokemons: {},
        select: null,
        prop_message: String,
    },
    methods: {
        getPokemons() {
            axios
                .get("https://gopokemon.herokuapp.com/api/user/pokemons")
                .then((response) => (this.pokemons = response.data.data))
                .catch((error) => {
                    console.log(error);
                    this.errored = true;
                });
        },
    },
    mounted() {
        this.getPokemons();
    },
};
</script>
