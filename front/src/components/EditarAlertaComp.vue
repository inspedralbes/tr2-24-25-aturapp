<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const BASE_URL = "http://localhost:8000";
const route = useRoute();
const router = useRouter();
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
    } catch (error) {
        console.error(error);
    }
}

function navigateTo(nameIcon) {
  router.push(`/${nameIcon}`)
};

function formatFecha(isoDate) {
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
    <div class="d-flex align-center j-center cabezal">
        <div id="contentHeaderProfile" class="d-flex align-center f-column" style="z-index: 20;">
            <p class="no-margin">Editar alerta</p>
        </div>
    </div>
    <div id="containAlerta" class="d-flex align-center f-column mt-60" v-if="alerta != ''">
        <p> {{ formatText(alerta.sector) }} ({{ alerta.planta }})</p>
        <p> {{ formatFecha(alerta.created_at) }} - {{ formatHora(alerta.created_at) }}  |  
            Estat: {{ alerta.estado }}
        </p>
        <div id="containDesc">
            <p>Descripció:</p>
            <textarea name="descripcion" placeholder="Dona'ns més informació">{{ alerta.descripcion }}</textarea>
        </div>
        <div class="containButtons d-flex align-center j-around">
            <input class="btn-cancel" type="button" value="Cancelar" @click="navigateTo('perfil/alertes')">
            <input class="btn-confirm" type="button" value="Guardar" @click="enviarAlerta">
        </div>

    </div>
</template>

<style scoped>
.containButtons{
    position: fixed;
    bottom: 80px;
    left: 0;
    right: 0;
    margin: auto;
}

.btn-confirm {
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

.btn-cancel {
    width: 180px;
    height: 45px;
    border: 1px solid grey;
    outline: none;
    background-color: white;
    padding: 10px 30px;
    font-size: 20px;
    font-weight: bold;
    color: grey;
    border-radius: 10px;
}

#containDesc p{
    margin: 20px 0px 5px 0px;
    font-size: 18px;
}

#containDesc textarea{
    width: 300px;
    height: 200px;
    border: 1px solid #a83d3a;
    font-family: sans-serif;
    font-size: 18px;
    padding: 5px;
    box-sizing: border-box;
}

.containDesc:focus {
    outline: none;
}

.cabezal {
    position: fixed;
    background-color: #a03939;
    height: 60px;
    width: 100%;
    top: 0;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    z-index: 10;
}

.cabezal p {
    color: white;
    font-weight: bold;
}

#containAlerta>p:first-child {
    margin: 20px 0px 5px 0px;
    font-size: 25px;
}

#containAlerta p:nth-child(2) {
    margin: 5px 0px 5px 0px;
}
</style>