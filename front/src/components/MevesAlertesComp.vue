<template>
    <div class="d-flex align-center j-center cabezal">
        <div id="contentHeaderProfile" class="d-flex align-center f-column" style="z-index: 20;">
            <p class="no-margin">Meves alertes</p>
        </div>
    </div>
    <ul id="containAlertes" class="no-margin d-flex j-center f-column align-center">
        <li v-for="alert in alertes" :key="alert.id" class="itemAlert" @click="alertita">
            <div class="contentItem">
                <p>{{ alert.sector }} (Planta 0)</p>
                <p>{{ alert.created_at }}</p>
                <p>{{ alert.estado }}</p>
                <button class="btn-editar">Editar</button>
            </div>
        </li>
    </ul>
</template>

<script setup>
import { ref, onMounted } from 'vue';
const BASE_URL = "http://localhost:8000";
const usuari_id = 1

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

        console.log(alertes.value);
    } catch (error) {
        console.error(error);
    }
}

onMounted(() => {
    getAlertas();
})

</script>

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