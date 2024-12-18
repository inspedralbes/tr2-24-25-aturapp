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
            Email: {{ alumne.email }}       <br>
            <button @click="verDetall(alumne.id)">Més informació</button>
        </p>
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

    const verDetall = (id) => {
        router.push(`/admin/alumnes/${id}`);
    };
</script>

<style scoped>
    #llistatAlumnes p{
        width: 30%;
        margin: 20px auto;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    p {
        padding: 15px;
        margin: 10px 0;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
    }

    button {
        background-color: #ff2600;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #a04545;
    }

    .error-message {
        color: red;
        font-weight: bold;
        margin-top: 10px;
    }

    select::after {
        content: '▼';
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }
</style>