<template>
    <span class="alert alert-success mx-5" role="alert" v-if="type==='success'">
        {{ text }}
    </span>
    <span class="alert alert-danger mx-5" role="alert" v-if="type==='danger'">
        {{ text }}
    </span>
</template>

<script>
    export default {
        mounted() {
            console.log('Message mounted.');
        },
        props: ['type', 'text'],
    }
</script>
