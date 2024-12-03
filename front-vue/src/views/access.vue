<script>
import { ref } from "vue";

import Login from "../components/login.vue";
import Register from "../components/register.vue";

export default {
    components: {
        Login,
        Register,
    },
    setup() {
        return {};
    },
};
</script>

<template>
    <Login />
</template>

<style scoped>
/* Agrega aquí tu estilo personalizado */
</style>
