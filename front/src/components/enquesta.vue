<script setup>
    import { ref, onMounted, computed } from 'vue';
    import { useCounterStore } from '../stores/counter';

    const BASE_URL = "http://localhost:8000";
    const preguntas = ref([]);

    const counterStore = useCounterStore();
    const companysClase = computed(() => counterStore.userData?.companys_clase || []);

    const fetchPreguntas = async () => {
        try {
            const response = await fetch(`${BASE_URL}/api/preguntas`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                },
            });

            if (response.ok) {
                const data = await response.json();
                preguntas.value = data;
            } else {
                console.error('Error al obtener las preguntas', response.status);
            }
        } catch (error) {
            console.error('Error de red o servidor:', error);
        }
    };

    onMounted(() => {
        fetchPreguntas();
    });
</script>

<template>
    <h1>Enquesta</h1>
    <h2>Companys Clase</h2>
    <ul v-if="companysClase.length > 0">
        <li v-for="(company, index) in companysClase" :key="index">
            {{ company.nom }} {{ company.cognoms }}
        </li>
    </ul>
    <p v-else>No hay companys disponibles.</p>

    <h2>Preguntas</h2>
    <ul v-if="preguntas.length > 0">
        <li v-for="pregunta in preguntas" :key="pregunta.id">
            {{ pregunta.pregunta }}
        </li>
    </ul>
    <p v-else>No hay preguntas disponibles.</p>
</template>

<style scoped></style>