<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

const BASE_URL = "http://localhost:8000";
const route = useRoute();
const alerta = ref('');
const id = route.query.id;

async function getAlert() {
    try {
        const response = await fetch(`${BASE_URL}/api/show/${id}`);

        if (!response.ok) {
            throw new Error("Error en la solicitud");
        }
        const result = await response.json();
        alerta.value = result;
        console.log(alerta.value);
    } catch (error) {
        console.error(error);
    }
}

function formatFecha(isoDate) {
    console.log(isoDate)
    const date = new Date(isoDate);
    return new Intl.DateTimeFormat('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }).format(date);
}

function formatHora(isoDate) {
    const date = new Date(isoDate);
    return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
}


function formatText(text) {
    text = text || "";

    if (text.includes("-inf")) {
        return text.toUpperCase();
    }

    return text
        .split('-') // Divide el texto en palabras separadas por "-"
        .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Capitaliza la primera letra de cada palabra
        .join(' '); // Une las palabras con un espacio
}

onMounted(() => {
    getAlert();
})
</script>

<template>
    <div class="d-flex j-center align-center f-column" v-if="alerta != ''">
        <p> {{ formatText(alerta.sector) }} ({{ alerta.planta }})</p>
        <p> {{ formatFecha(alerta.created_at) }} - {{ formatHora(alerta.created_at) }}</p>
        <p> {{ alerta.estado }} </p>
        <textarea class="containDesc" name="descripcion"></textarea>
        <input class="btn-confirm" type="button" value="Confirmar" @click="enviarAlerta">

    </div>
</template>

<style scoped>
.btn-confirm {
    position: fixed;
    bottom: 80px;
    left: 0;
    right: 0;
    margin: auto;
    width: 180px;
    height: 45px;
    background-color: #a83d3a;
    outline: none;
    border: none;
    padding: 10px 30px;
    font-size: 20px;
    font-weight: bold;
    color: white;
    border-radius: 10px;
}

.containDesc{
    width: 300px;
    height: 200px;
    border: 1px solid #a83d3a;
    font-family: sans-serif;
    font-size: 50px;
}
</style>