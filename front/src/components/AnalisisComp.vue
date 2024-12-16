<script setup>
import { ref } from 'vue';

const data = ref([]);

fetch('http://localhost:8000/api/analisis')
    .then(response => response.json())
    .then(json => {
        data.value = json;
    })
    .catch(error => {
        console.error('Error al obtener los datos:', error);
    });
</script>

<template>
    <div>
        Hola, soc el component
        <ul v-if="data && data.length">
            <li v-for="(item, index) in data" :key="index">
                {{ item.pregunta.relacion }}
            </li>
        </ul>
        <p v-else>Cargando datos...</p>
    </div>
</template>

<style scoped>
</style>