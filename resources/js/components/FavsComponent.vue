<template>
    <div class="container">


        <div class="row">
            <div class="card col-lg-4 col-md-6 col-sm-12 m-3" style="width: 18rem;" v-for="(pokemon, index) in pokemons">
            <img  v-bind:src="pokemon.image" class="card-img-top" >
            <div class="card-body">
                <h5 class="card-title">{{ pokemon.name }}</h5>
                <p class="card-text">{{pokemon.gender}}</p>
                <a v-bind:href="'/pokemons/view/' + pokemon.id" class="btn btn-primary">Ver más</a>
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
