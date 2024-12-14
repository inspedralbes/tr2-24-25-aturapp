<script setup>
    import { ref, onMounted, computed } from 'vue';
    import { useCounterStore } from '../stores/counter';

    const preguntas = ref([]);
    const PaginaActual = ref(0);
    const asignaciones = ref({});
    const counterStore = useCounterStore();
    const BASE_URL = "http://localhost:8000";
    const userData = computed(() => counterStore.userData || {});
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
            if (Object.values(respuestas).some((value) => value === '')) return false;
        } 
        return true;
    };

    const publicarRespostas = async () => {
        if (!validarAsignaciones()) {
            alert('Por favor, completa todas las asignaciones antes de continuar.');
            return;
        }

        if (!userData.value || !userData.value.user || !userData.value.user.id) {
            alert('No s\'ha trobat l\'id de l\'usuari');
            return;
        }

        const idAlumnoEmisor = parseInt(userData.value.user.id, 10);
        const idCursAlumnoEmisor = parseInt(userData.value.course?.id || userData.value.curs, 10);

        if (isNaN(idAlumnoEmisor) || isNaN(idCursAlumnoEmisor)) {
            alert('El ID del alumno o el curso no es válido.');
            return;
        }

        counterStore.$patch({
            cursoActual: idCursAlumnoEmisor,
        });

        const data = Object.keys(asignaciones.value).map((preguntaId) => ({
            id_pregunta: parseInt(preguntaId, 10),
            resposta1: parseInt(asignaciones.value[preguntaId][1], 10),
            resposta2: parseInt(asignaciones.value[preguntaId][2], 10),
            resposta3: parseInt(asignaciones.value[preguntaId][3], 10),
            id_alumno_emisor: idAlumnoEmisor,
            id_curs_alumno_emisor: idCursAlumnoEmisor,
        }));

        const response = await fetch(`${BASE_URL}/api/publicar-respostas`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ respuestas: data }),
        });

        if (response.ok) {
            alert('Respuestas enviadas correctamente.');
        } else {
            const errorData = await response.json();
            alert('Hubo un error al enviar las respuestas. Intenta nuevamente.');
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


<template>
    <div>
        <div id="divGeneral" v-if="preguntas.length > 0">
            <div>
                <h2>{{ PaginaActual + 1 }} / {{ preguntas.length }}</h2>
                <p>{{ preguntas[PaginaActual].pregunta }}</p>
            </div>

            <div>
                <div v-for="selectorId in [1, 2, 3]" :key="selectorId" class="desplegable">
                    <label :for="`selector-${selectorId}`">Selecció {{ selectorId }}</label>
                    <select :id="`selector-${selectorId}`" :value="asignaciones[preguntas[PaginaActual].id][selectorId]"
                        @change="(event) => actualizarAsignacion(preguntas[PaginaActual].id, selectorId, event.target.value)">
                        <option value="" disabled>Selecciona un company</option>
                        <option v-for="companion in companysClase" :key="companion.id" :value="companion.id">
                            {{ companion.nom }} {{ companion.cognoms }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="navegacion">
                <button @click="PaginaAnterior" :disabled="PaginaActual === 0">Anterior</button>
                <button @click="SiguientePagina" :disabled="PaginaActual === preguntas.length - 1">Següent</button>
            </div>
        </div>

        <div v-else class="loader"></div>

        <div class="publicar">
            <button @click="publicarRespostas" :disabled="!validarAsignaciones()">
                Publicar Respostas
            </button>
        </div>
    </div>
</template>

<style scoped>
body {
    width: 90%;
    color: #333;
    margin: 0 auto;
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
}

#divGeneral {
    padding: 20px;
    margin: 0 auto;
    max-width: 600px;
    border-radius: 8px;
    background-color: #ffffff;
}

.desplegable {
    display: flex;
    margin-bottom: 16px;
    flex-direction: column;
}

.desplegable label {
    color: #555;
    font-weight: bold;
    margin-bottom: 8px;
}

.desplegable select {
    padding: 10px;
    color: #333;
    font-size: 14px;
    border-radius: 4px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    transition: border-color 0.3s;
}

.desplegable select:focus {
    outline: none;
    border-color: #ff0000;
    box-shadow: 0 0 2px rgba(255, 0, 0, 0.5);
}

.navegacion {
    display: flex;
    margin-top: 16px;
    justify-content: space-between;
}

button {
    border: none;
    color: white;
    font-size: 14px;
    cursor: pointer;
    padding: 10px 20px;
    border-radius: 4px;
    background-color: #ff0000;
    transition: background-color 0.3s, transform 0.2s;
}

button:hover {
    background-color: #e10000;
    transform: translateY(-2px);
}

button:disabled {
    cursor: not-allowed;
    background-color: #d6d6d6;
}

button:disabled:hover {
    transform: none;
}

.publicar {
    margin-top: 32px;
    text-align: center;
}

h2 {
    font-size: 20px;
    text-align: center;
    margin-bottom: 16px;
}

p {
    font-size: 16px;
    line-height: 1.5;
    margin-bottom: 16px;
}

/*==== LOADER ===============*/
.loader {
    width: 130px;
    display: block;
    margin: 30px auto;
    position: relative;
    --height-of-loader: 4px;
    background-color: red;
    height: var(--height-of-loader);
}

.loader::before {
    top: 0;
    left: 0;
    width: 0%;
    content: "";
    height: 100%;
    position: absolute;
    border-radius: 30px;
    background: white;
    animation: moving 1s ease-in-out infinite;
    ;
}

@keyframes moving {
    50% {
        width: 100%;
    }

    100% {
        right: 0;
        width: 0;
        left: unset;
    }
}
</style>