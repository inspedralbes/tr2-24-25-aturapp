<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useCounterStore } from '@/stores/counter';

const BASE_URL = "http://localhost:8000";
const store = useCounterStore();
const data = store.userData;
const usuari_id = data.user.id;
const router = useRouter();
const alertes = ref([]);

async function getAlertas() {
    try {
        const response = await fetch(`${BASE_URL}/api/alertes`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: usuari_id }),
        });

        if (!response.ok) {
            throw new Error("Error en la solicitud");
        }

        const result = await response.json();
        
        alertes.value = result;
    } catch (error) {
        console.error(error);
    }
}

function formatFecha(isoDate) {
    const date = new Date(isoDate);
    return new Intl.DateTimeFormat('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }).format(date);
}

function formatText(text) {
    text = text || '';
    if (text.includes("-inf")) {
        return text.toUpperCase();
    }

    return text
        .split('-') // Divide el texto en palabras separadas por "-"
        .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Capitaliza la primera letra de cada palabra
        .join(' '); // Une las palabras con un espacio
}

function navigateTo(nameIcon) {
  router.push(`/${nameIcon}`)
};

onMounted(() => {
    if(usuari_id != undefined){
        getAlertas();
    }
})

</script>

<template>
    <div class="d-flex align-center j-center cabezal">
        <div id="contentHeaderProfile" class="d-flex align-center f-column" style="z-index: 20;">
            <p class="no-margin">Les meves alertes</p>
        </div>
    </div>
    <ul id="containAlertes" class="no-margin d-flex j-center f-column align-center">
        <li v-for="alert in alertes" :key="alert.id" class="itemAlert">
            <div class="contentItem">
                <p>{{ formatText(alert.sector) }} ({{ alert.planta }})</p>
                <p>{{ formatFecha(alert.created_at) }}</p>
                <p>Estat: {{ alert.estado }}</p>
                <button class="btn-editar" @click="navigateTo(`perfil/alertes/editar?id=${alert.id}`)">Editar</button>
            </div>
        </li>
    </ul>
</template>

<style scoped>
#containAlertes{
    margin-top: 60px;
    margin-bottom: 80px;
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

.itemAlert {
    background-color: white;
    height: 80px;
    width: 350px;
    box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
    margin-top: 10px;
    border-radius: 10px;
    position: relative;
    list-style: none;
}

.contentItem {
    margin-top: 10px;
    margin-left: 20px;
    height: 50px;
    display: flex;
    flex-direction: column;
}

.contentItem p {
    margin: 0;
    color: #313131;
    font-size: 15px;
}

.contentItem p:nth-child(2) {
    margin-top: 3px;
    font-size: 13px;
}

.contentItem p:nth-child(3) {
    margin-top: 8px;
    font-size: 13px;
}

.contentItem .btn-editar {
    position: absolute;
    background-color: #a03939;
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    top: 25px;
    right: 30px;
    border: none;
}
</style>