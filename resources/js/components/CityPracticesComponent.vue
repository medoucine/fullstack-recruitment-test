<template>
    <div class="city-practices">
        <h2>{{ city }}</h2>
        <ul class="practices">
            <li v-for="practice in practices" v-on:click="fetchTherapists(practice)">{{ practice }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['city'],
        data() {
            return {
                practices: []
            }
        },
        methods: {
            fetchPractices() {
                $.ajax({
                    url: "/api/city/" + this.city + "/practice",
                    success: results => this.practices = results
                });
            },
            fetchTherapists(practice) {
                this.$parent.city = this.city;
                this.$parent.practices = this.practices;
                this.$parent.practice = practice;
                this.$parent.fetchTherapists();
            }
        },
        mounted() {
            this.fetchPractices();
        },
    }
</script>
