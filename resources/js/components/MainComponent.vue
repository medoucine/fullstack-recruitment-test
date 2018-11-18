<template>
    <div>
        <header>
            <h1 class="display-3 text-center">
                <img src="https://www.medoucine.com/images/logos/logo.svg" width="350"/>
            </h1>
            <div class="container">
                <select v-model="city" v-on:change="fetchPractices()" class="custom-select">
                    <option value="" disabled selected hidden>Choisir une ville</option>
                    <option v-for="city in cities" v-bind:value="city">
                        {{ city }}
                    </option>
                </select>
                <select v-model="practice" class="custom-select" :disabled="practices.length <= 0">
                    <option value="" disabled selected hidden>Choisir une spécialité</option>
                    <option v-for="practice in practices" v-bind:value="practice">
                        {{ practice }}
                    </option>
                </select>
                <button type="button" class="btn"
                        v-on:click="fetchTherapists()">Rechercher
                </button>
            </div>
        </header>
        <div id="therapists" v-if="therapists.length > 0">
            <div class="container">
                <therapist-component
                    v-for="therapist in therapists"
                    v-bind:therapist="therapist"
                ></therapist-component>
            </div>
        </div>
        <footer>
            <div class="container">
                <div class="row">
                    <city-practices-component
                        v-for="city in cities"
                        v-bind:city="city"
                        class="col"
                    ></city-practices-component>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                city: '',
                practice: '',
                cities: [],
                practices: [],
                therapists: []
            }
        },
        methods: {
            fetchCities() {
                $.ajax({
                    url: "/api/city",
                    success: results => this.cities = results
                });
            },
            fetchPractices() {
                this.practice = '';
                $.ajax({
                    url: "/api/city/" + this.city + "/practice",
                    success: results => this.practices = results
                });
            },
            fetchTherapists() {
                $.ajax({
                    url: "/api/city/" + this.city + '/practice/' + this.practice + '/therapist',
                    success: results => this.therapists = results
                });
            }
        },
        mounted() {
            this.fetchCities();
        },
    }
</script>
