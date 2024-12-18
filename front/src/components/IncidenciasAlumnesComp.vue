<template>
    <div id="filtre">
        <select v-model="selectedCurs">
            <option value="">Todos los cursos</option>
            <option v-for="curs in cursosUnicos" :key="curs" :value="curs">
                {{ curs }}
            </option>
        </select>

        <select v-model="selectedTorn">
            <option value="">Todos los turnos</option>
            <option v-for="torn in tornsUnics" :key="torn" :value="torn">
                {{ torn }}
            </option>
        </select>
    </div>

    <div>
        <h1>Lista de Alumnos</h1>
        <p v-for="alumne in alumnesFiltrats" :key="alumne.id">
            Nom: {{ alumne.nom }}
            <br>
            Cognom: {{ alumne.cognoms }}
            <br>
            Email: {{ alumne.email }}
            <br>
            Curs: {{ alumne.curs?.name }} <!-- Usando encadenamiento opcional -->
            <br>
            Torn: {{ alumne.torn?.torn }} <!-- Usando encadenamiento opcional -->
            <button @click="verDetall(alumne.id)">Més informació</button>
        </p>
        <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { getAlumnes } from '../services/communictationManager';

const alumnes = ref([]);
const errorMessage = ref('');
const selectedCurs = ref('');
const selectedTorn = ref('');
const router = useRouter();

onMounted(async () => {
    try {
        const data = await getAlumnes();
        alumnes.value = data;
    } catch (error) {
        errorMessage.value = 'No se han podido cargar los alumnos.';
    }
});

const cursosUnicos = computed(() => {
    return [...new Set(alumnes.value.map(alumne => alumne.curs?.name))]; // Usamos ?. para evitar errores
});

const tornsUnics = computed(() => {
    return [...new Set(alumnes.value.map(alumne => alumne.torn?.torn))]; // Usamos ?. para evitar errores
});

const alumnesFiltrats = computed(() => {
    return alumnes.value.filter(alumne => {
        const cumpleCurs = selectedCurs.value === '' || alumne.curs?.name === selectedCurs.value;
        const cumpleTorn = selectedTorn.value === '' || alumne.torn?.torn === selectedTorn.value;
        return cumpleCurs && cumpleTorn;
    });
});

const verDetall = (id) => {
    router.push(`/admin/alumnes/${id}`);
};
</script>

<style scoped>
.error-message {
    color: red;
    margin-top: 20px;
    font-weight: bold;
}

p {
    border: 1px solid black;
    padding: 10px;
}
</style>