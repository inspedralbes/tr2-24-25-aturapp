<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useCounterStore } from '@/stores/counter';

const BASE_URL = "http://localhost:8000";
const store = useCounterStore();
const route = useRoute();
const router = useRouter();
const alerta = ref('');
const id = route.query.id;
const data = store.userData;
const user_id = data.user.id
const alertaDescripcio = ref('');

function navigateTo(nameIcon) {
    router.push(`/${nameIcon}`)
};

async function getAlert() {
    try {
        const response = await fetch(`${BASE_URL}/api/show/${id}`);

        if (!response.ok) {
            throw new Error("Error en la solicitud");
        }
        const result = await response.json();
        alerta.value = result;
        alertaDescripcio.value = alerta.value.descripcion;
    } catch (error) {
        console.error(error);
    }
}

async function editarAlerta() {
    try {
        const response = await fetch(`${BASE_URL}/api/update`, {
            method: 'POST',
            headers: {
                "Content-type": "application/json",
            },
            body: JSON.stringify({
                alerta_id: id,
                alumne_id: user_id,
                descripcio: alertaDescripcio.value,
            })
        });

        if (!response.ok) {
            throw new Error("Error en la solicitud");
        }

        const result = await response.json();

        if (result.success) {
            alert('Alerta editada amb èxit')
        } else {
            alert(`Ha ocorregut un error (${result.message || 'Error desconegut'})`)
        }
    } catch (error) {
        console.error(error);
    }
}

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
    <div id="containAlerta" class="d-flex j-center align-center f-column mt-60" v-if="alerta != ''">
        <p class="no-margin"> {{ formatText(alerta.sector) }} ({{ alerta.planta }})</p>
        <p> {{ formatFecha(alerta.created_at) }} - {{ formatHora(alerta.created_at) }}h | Estado: {{ alerta.estado }}
        </p>
        <div id="containDesc">
            <p class="no-margin">Descripció:</p>
            <textarea v-model="alertaDescripcio" id="textDesc" name="descripcion"
                placeholder="Dona'ns més informació"></textarea>
        </div>
        <div id="containButtons" class="d-flex align-center j-around">
            <input class="btn-cancel" type="button" value="Cancelar" @click="navigateTo('perfil/alertes')">
            <input class="btn-confirm" type="button" value="Guardar" @click="editarAlerta">
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
</style>