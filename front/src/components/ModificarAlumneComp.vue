<template>
    <div>
        <h1>Modificar Alumne</h1>
        <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
        <div v-else-if="!alumne">Cargando datos del alumno...</div>
        <div v-else>
            <form @submit.prevent="guardarCambios">
                <label for="nom">Nom:</label>
                <input id="nom" v-model="alumneEdit.nom" type="text" required />

                <label for="cognoms">Cognoms:</label>
                <input id="cognoms" v-model="alumneEdit.cognoms" type="text" required />

                <label for="email">Email:</label>
                <input id="email" v-model="alumneEdit.email" type="email" required />

                <label for="dni">DNI:</label>
                <input id="dni" v-model="alumneEdit.dni" type="text" required />

                <label for="telefon">Telèfon:</label>
                <input id="telefon" v-model="alumneEdit.telefon" type="text" />

                <label for="curs">Curs:</label>
                <select id="curs" v-model="selectedCurs">
                    <option v-for="curs in cursos" :key="curs.id" :value="curs.id">
                        {{ curs.name }}
                    </option>
                </select>

                <label for="torn">Torn:</label>
                <select id="torn" v-model="selectedTorn">
                    <option v-for="torn in torns" :key="torn.id" :value="torn.id">
                        {{ torn.torn }}
                    </option>
                </select>

                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getAlumneById, updateAlumne, getCursos, getTorns } from '../services/communictationManager.js';

const router = useRouter();
const route = useRoute();

const alumne = ref(null);
const alumneEdit = ref({});
const cursos = ref([]);
const torns = ref([]);
const selectedCurs = ref(null);
const selectedTorn = ref(null);
const errorMessage = ref('');

onMounted(async () => {
    const id = route.params.id;
    try {
        const response = await getAlumneById(id);
        if (response.success) {
            alumne.value = response.alumne;
            alumneEdit.value = { ...response.alumne };
            selectedCurs.value = response.alumne.curs.id;
            selectedTorn.value = response.alumne.torn.id;

            cursos.value = await getCursos();
            torns.value = await getTorns();
        } else {
            errorMessage.value = "Error cargando datos del alumno.";
        }
    } catch (error) {
        errorMessage.value = "Error cargando datos del alumno.";
    }
});

const guardarCambios = async () => {
    try {
        alumneEdit.value.curs = cursos.value.find(c => c.id === selectedCurs.value);
        alumneEdit.value.torn = torns.value.find(t => t.id === selectedTorn.value);

        await updateAlumne(alumneEdit.value.id, {
            ...alumneEdit.value,
            curs_id: selectedCurs.value,
            torn_id: selectedTorn.value,
        });

        alert('Datos guardados correctamente');
        router.push('/admin/alumnes');
    } catch (error) {
        console.error('Error al guardar los cambios:', error);
        alert('Hubo un error al guardar los cambios');
    }
};
</script>