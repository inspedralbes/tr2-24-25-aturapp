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

    <div id="llistatAlumnes">
        <p v-for="alumne in alumnesFiltrats" :key="alumne.id">
            Nom: {{ alumne.nom }}           <br>
            Cognom: {{ alumne.cognoms }}    <br>
            Email: {{ alumne.email }}       <br><br>
            <button @click="verDetall(alumne.id)">Més informació</button>
            <br>
            <button @click="ModificarAlumne(alumne.id)">Modificar Alumne</button>
        </p>
    </div>
</template>

<script setup>
    import { ref, computed, onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import { getAlumnes } from '../services/communictationManager';
    import ModificarAlumneComp from './ModificarAlumneComp.vue';

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
        return [...new Set(alumnes.value.map(alumne => alumne.curs?.name))];
    });

    const tornsUnics = computed(() => {
        return [...new Set(alumnes.value.map(alumne => alumne.torn?.torn))];
    });

    const alumnesFiltrats = computed(() => {
        return alumnes.value.filter(alumne => {
            const cumpleCurs = selectedCurs.value === '' || alumne.curs?.name === selectedCurs.value;
            const cumpleTorn = selectedTorn.value === '' || alumne.torn?.torn === selectedTorn.value;
            return cumpleCurs && cumpleTorn;
        });
    });

    const ModificarAlumne = (id) => {
        router.push(`/admin/modificar-alumne/${id}`);
    };

    const verDetall = (id) => {
        router.push(`/admin/alumnes/${id}`);
    };
</script>

<style scoped>
    #filtre {
        margin: 50px auto;
        display: flex;
        justify-content: flex-start;
        gap: 1rem;
    }

    #filtre select {
        padding: 0.5rem;
        font-size: 1rem;
        border: 2px solid #ff0000;
        background-color: #ffffff;
        color: #333;
        outline: none;
        transition: all 0.3s ease;
    }

    #filtre select:focus {
        border-color: #cc0000;
    }

    #llistatAlumnes {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        padding: 1rem;
        margin: 20px auto;
    }

    #llistatAlumnes p {
        background-color: #ffffff;
        border: 1px solid #ff0000;
        padding: 1rem;
        width: calc(33% - 2rem);
        transition: transform 0.3s ease;
    }

    #llistatAlumnes p:hover {
        transform: translateY(-5px);
    }

    #llistatAlumnes button {
        padding: 0.5rem 1rem;
        margin-top: 0.5rem;
        font-size: 1rem;
        color: #ffffff;
        background-color: #ff0000;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #llistatAlumnes button:hover {
        background-color: #cc0000;
    }
</style>