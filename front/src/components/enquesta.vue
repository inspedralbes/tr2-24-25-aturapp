<script setup>
    import { ref, onMounted, computed } from 'vue';
    import { useCounterStore } from '../stores/counter';

    const preguntas = ref([]);
    const PaginaActual = ref(0);
    const BASE_URL = "http://localhost:8000";

    const asignaciones = ref({});
    const counterStore = useCounterStore();
    const companysClase = computed(() => counterStore.userData?.companys_clase || []);

    const fetchPreguntas = async () => {
        const response = await fetch(`${BASE_URL}/api/preguntas`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
        });

        if (response.ok) {
            const data = await response.json();
            preguntas.value = data;

            preguntas.value.forEach((pregunta) => {
                asignaciones.value[pregunta.id] = {};
            });
        }
    };

    const actualizarAsignacion = (preguntaId, selectorId, valor) => {
        if (!asignaciones.value[preguntaId]) {
            asignaciones.value[preguntaId] = {};
        }
        asignaciones.value[preguntaId][selectorId] = valor;
    };

    const mostrarAsignaciones = () => { console.log(asignaciones.value); };

    const SiguientePagina = () => { 
        if (PaginaActual.value < preguntas.value.length - 1) PaginaActual.value++;
    };

    const PaginaAnterior = () => { if (PaginaActual.value > 0) PaginaActual.value--; };

    onMounted(() => {
        fetchPreguntas();
    });
</script>

<template>
    <h5>Selecciona 3 companys per cada pregunta</h5>
    <div v-if="preguntas.length > 0">
        <p>{{ preguntas[PaginaActual].pregunta }}</p>

        <button @click="PaginaAnterior" :disabled="PaginaActual === 0">←</button>
        <button @click="SiguientePagina" :disabled="PaginaActual === preguntas.length - 1">→</button>

        <div id="companys">
            <select
                v-for="n in 3" 
                :key="n" 
                v-if="companysClase.length > 0"
                :id="`pregunta-${preguntas[PaginaActual].id}-selector-${n}`"
                @change="(e) => actualizarAsignacion(preguntas[PaginaActual].id, n, e.target.value)"
            >
                <option value="" disabled selected>Selecciona una persona</option>
                <option 
                    v-for="(company, index) in companysClase" 
                    :key="index" 
                    :value="company.nom + ' ' + company.cognoms"
                >
                    {{ company.nom }} {{ company.cognoms }}
                </option>
            </select>
            <p v-else>No hay companys disponibles.</p>
        </div>

        <button @click="mostrarAsignaciones">Mostrar asignaciones</button>

        <p>Página {{ PaginaActual + 1 }} de {{ preguntas.length }}</p>
    </div>
    <p v-else>No hay preguntas disponibles.</p>
</template>

<style scoped>
</style>