<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useCounterStore } from '@/stores/counter';
import { getAlert, editarAlerta } from '@/services/communictationManager.js'

const BASE_URL = "http://localhost:8000";
const store = useCounterStore();
const route = useRoute();
const router = useRouter();
const alerta = ref('');
const data = store.userData;
const user_id = data.user.id;
const id = route.query.id;

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

async function guardarEdicio() {
    const res = await editarAlerta(id, user_id, alerta.value.descripcion);
    
    if (res.success) {
        alert('Alerta editada amb èxit');
        router.push(`/perfil/alertes`);
    } else {
        alert(`Ha ocorregut un error (${res.message || 'Error desconegut'})`);
    }
}

onMounted(async () => {
    alerta.value = await getAlert(id);
})
</script>

<template>
    <div class="d-flex align-center j-center cabezal">
        <div id="contentHeaderProfile" class="d-flex align-center f-column" style="z-index: 20;">
            <p class="no-margin">Editar alerta</p>
        </div>
    </div>
    <div id="containAlerta" class="d-flex j-center align-center f-column mt-60" v-if="alerta && Object.keys(alerta).length > 0">
        <p class="no-margin"> {{ formatText(alerta.sector) }} ({{ alerta.planta }})</p>
        <p> {{ formatFecha(alerta.created_at) }} - {{ formatHora(alerta.created_at) }}h | Estado: {{ alerta.estado }}
        </p>
        <div id="containDesc">
            <p class="no-margin">Descripció:</p>
            <textarea v-model="alerta.descripcion" id="textDesc" name="descripcion"
                placeholder="Dona'ns més informació"></textarea>
        </div>
        <div id="containButtons" class="d-flex align-center j-around">
            <input class="btn-cancel" type="button" value="Cancelar" @click="router.push(`/perfil/alertes`)">
            <input class="btn-confirm" type="button" value="Guardar" @click="guardarEdicio">
        </div>
    </div>
</template>

<style scoped>
#textDesc {
    width: 300px;
    height: 200px;
    border: 1px solid #a83d3a;
    border-radius: 10px;
    font-family: sans-serif;
    font-size: 18px;
    box-sizing: border-box;
    padding: 10px;
}

textarea:focus {
    outline: none;
}

#containDesc p:first-child {
    font-size: 18px;
    margin: 10px 0 5px 0;
}

#containAlerta>p:first-child {
    font-size: 19px;
    margin-top: 15px;
}

#containButtons{
    margin-bottom: 15px;
}
</style>