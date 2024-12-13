<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const BASE_URL = "http://localhost:8000";
const route = useRoute();
const router = useRouter();
const alerta = ref('');
const id = route.query.id;
const data_user = JSON.parse(localStorage.getItem('userData'));
const user_id = data_user.user.id
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
#containButtons {
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
    background-color: #a83d3a;
    border: 1px solid grey;
    background-color: white;
    padding: 10px 30px;
    font-size: 20px;
    font-weight: bold;
    color: grey;
    border-radius: 10px;
}

#textDesc {
    width: 300px;
    height: 200px;
    border: 1px solid #a83d3a;
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
    font-size: 20px;
}

#containAlerta>p:first-child {
    font-size: 19px;
    margin-top: 15px;
}
</style>