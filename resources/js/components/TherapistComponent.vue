<template>
    <div class="therapist">
        <b>{{ therapist.name }}</b><br>
        {{ therapist.city }}<br>
        {{ therapist.practices.join(', ') }}
        <div class="clearfix"></div>
    </div>
</template>

<script>
    export default {
        props: ['therapist']
    }
</script>
