<template>
    <div>
        <!-- Mostrar el ID del usuario autenticado -->
        <h1>Usuario ID: {{ userData.user.id }}</h1>

        <div v-if="preguntas.length > 0">
            <!-- Mostrar la pregunta actual -->
            <div>
                <h2>Pregunta {{ PaginaActual + 1 }} de {{ preguntas.length }}</h2>
                <p>{{ preguntas[PaginaActual].pregunta }}</p>
            </div>

            <!-- Desplegables para la pregunta actual -->
            <div>
                <div v-for="selectorId in [1, 2, 3]" :key="selectorId" class="desplegable">
                    <label :for="`selector-${selectorId}`">Selección {{ selectorId }}</label>
                    <select :id="`selector-${selectorId}`" :value="asignaciones[preguntas[PaginaActual].id][selectorId]"
                        @change="(event) => actualizarAsignacion(preguntas[PaginaActual].id, selectorId, event.target.value)">
                        <option value="" disabled>Selecciona un compañero</option>
                        <option v-for="companion in companysClase" :key="companion.id" :value="companion.id">
                            {{ companion.nom }} {{ companion.cognoms }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Controles de navegación -->
            <div class="navegacion">
                <button @click="PaginaAnterior" :disabled="PaginaActual === 0">Anterior</button>
                <button @click="SiguientePagina" :disabled="PaginaActual === preguntas.length - 1">Siguiente</button>
            </div>
        </div>

        <div v-else>
            <p>Cargando preguntas...</p>
        </div>

        <!-- Botón para publicar respuestas -->
        <div class="publicar">
            <button @click="publicarRespostas" :disabled="!validarAsignaciones()">
                Publicar Respuestas
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useCounterStore } from '../stores/counter';

const preguntas = ref([]);
const PaginaActual = ref(0);
const asignaciones = ref({});
const counterStore = useCounterStore();
const BASE_URL = "http://localhost:8000";
const companysClase = computed(() => counterStore.userData?.companys_clase || []);
const userData = computed(() => counterStore.userData || {});  // Accedemos al usuario desde Pinia

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
            asignaciones.value[pregunta.id] = { 1: '', 2: '', 3: '' };
        });
    }
};

const actualizarAsignacion = (preguntaId, selectorId, valor) => {
    if (!asignaciones.value[preguntaId]) {
        asignaciones.value[preguntaId] = { 1: '', 2: '', 3: '' };
    }
    asignaciones.value[preguntaId][selectorId] = valor;
};

const validarAsignaciones = () => {
    for (const preguntaId in asignaciones.value) {
        const respuestas = asignaciones.value[preguntaId];
        if (Object.values(respuestas).some((value) => value === '')) {
            return false;
        }
    }
    return true;
};

const publicarRespostas = async () => {
    if (!validarAsignaciones()) {
        alert('Por favor, completa todas las asignaciones antes de continuar.');
        return;
    }

    // Verificar si el usuario está correctamente cargado en Pinia
    if (!userData.value || !userData.value.user || !userData.value.user.id) {
        alert('No se ha encontrado el ID del alumno emisor en el estado de usuario.');
        console.error('User data:', userData.value);
        return;
    }

    // Obtener el ID del alumno emisor directamente desde userData
    const idAlumnoEmisor = parseInt(userData.value.user.id, 10);

    // Verifica si el ID es válido
    if (isNaN(idAlumnoEmisor)) {
        alert('El ID del alumno emisor no es válido.');
        return;
    }

    // Crear un array con los datos de cada pregunta
    const data = Object.keys(asignaciones.value).map((preguntaId) => ({
        id_pregunta: parseInt(preguntaId, 10),
        resposta1: parseInt(asignaciones.value[preguntaId][1], 10),
        resposta2: parseInt(asignaciones.value[preguntaId][2], 10),
        resposta3: parseInt(asignaciones.value[preguntaId][3], 10),
        id_alumno_emisor: idAlumnoEmisor,  // Usamos el id del alumno emisor
    }));

    // Ver el JSON que se va a enviar
    console.log("Datos a enviar:", JSON.stringify({ respuestas: data }, null, 2));

    try {
        const response = await fetch(`${BASE_URL}/api/publicar-respostas`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ respuestas: data }), // Enviar en el formato correcto
        });

        if (response.ok) {
            alert('Respuestas enviadas correctamente.');
        } else {
            const errorData = await response.json();
            console.error('Error al enviar las respuestas:', errorData);
            alert('Hubo un error al enviar las respuestas. Intenta nuevamente.');
        }
    } catch (error) {
        console.error('Error de red:', error);
        alert('Hubo un problema con la conexión.');
    }
};


const SiguientePagina = () => {
    if (PaginaActual.value < preguntas.value.length - 1) PaginaActual.value++;
};

const PaginaAnterior = () => {
    if (PaginaActual.value > 0) PaginaActual.value--;
};

onMounted(() => {
    fetchPreguntas();
});
</script>

<style scoped>
.desplegable {
    margin-bottom: 16px;
}

.navegacion {
    margin-top: 16px;
    display: flex;
    justify-content: space-between;
}

.publicar {
    margin-top: 32px;
    text-align: center;
}

button {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
}

button:disabled {
    background-color: #d6d6d6;
    cursor: not-allowed;
}
</style>
