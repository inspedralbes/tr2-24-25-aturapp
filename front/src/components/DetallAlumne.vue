<template>
    <div v-if="alumne">
        <h1>Detalles del Alumno</h1>
        <p>Nom: {{ alumne.nom }}</p>
        <p>Cognom: {{ alumne.cognoms }}</p>
        <p>Email: {{ alumne.email }}</p>
        <p>Curs: {{ alumne.curs?.name }}</p>
        <p>Torn: {{ alumne.torn?.torn }}</p>
    </div>
    <div v-else>
        <p>Cargando datos...</p>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { getAlumneById } from '../services/communictationManager';

const route = useRoute();
const alumne = ref(null);
const errorMessage = ref('');

onMounted(async () => {
    const id = route.params.id;
    try {
        const data = await getAlumneById(id);
        alumne.value = data.alumne;
    } catch (error) {
        errorMessage.value = 'No se pudo cargar el alumno.';
    }
});
</script>


<style scoped>
p {
    margin: 5px 0;
}

button {
    margin-top: 20px;
    padding: 10px 20px;
    cursor: pointer;
}
</style>
