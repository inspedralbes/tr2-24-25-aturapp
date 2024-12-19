<template>
    <div v-if="alumne">
        <h1>Detalles del Alumno</h1>
        <p>Nom: {{ alumne.nom }}</p>
        <p>Cognom: {{ alumne.cognoms }}</p>
        <p>Email: {{ alumne.email }}</p>
        <p>Curs: {{ alumne.curs?.name }}</p>
        <p>Torn: {{ alumne.torn?.torn }}</p>

        <h2>Alertas del Alumno</h2>
        <div v-if="alertas.length > 0">
            <ul>
                <li v-for="alerta in alertas" :key="alerta.id">
                    <strong>Sector:</strong> {{ alerta.sector }} <br>
                    <strong>Planta:</strong> {{ alerta.planta }} <br>
                    <strong>Descripción:</strong> {{ alerta.descripcion }} <br>
                    <strong>Estado:</strong> {{ alerta.estado }} <br>
                    <strong>Fecha:</strong> {{ alerta.created_at }}
                </li>
            </ul>
        </div>
        <p v-else>No hi han alertes registrades per aquest alumne</p>
    </div>
    <div v-else>
        <p>Cargando datos...</p>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import { useRoute } from 'vue-router';
    import { getAlumneById, alertasAlumne } from '../services/communictationManager';

    const route = useRoute();
    const alumne = ref(null);
    const alertas = ref([]);
    const errorMessage = ref('');

    onMounted(async () => {
        const id = route.params.id;
        try {
            const data = await getAlumneById(id);
            alumne.value = data.alumne;

            const alertasData = await alertasAlumne(id);
            alertas.value = alertasData;
        } catch (error) {
            errorMessage.value = 'No s\'han pogut carregar les dades';
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
