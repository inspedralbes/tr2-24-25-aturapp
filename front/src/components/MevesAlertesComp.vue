<template>
    <div class="d-flex align-center j-center cabezal">
        <div id="contentHeaderProfile" class="d-flex align-center f-column" style="z-index: 20;">
            <p class="no-margin">Meves alertes</p>
        </div>
    </div>
    <ul class="no-margin d-flex j-center">
        <!-- v-for="alert in mevesAlertas" :key="alert.id" -->
        <li class="itemAlert" @click="alertita">
            <div class="contentItem">
                <p>Comedor (Planta 0)</p>
                <p>12/08/24</p>
                <p>Pendiente</p>
                <button class="btn-editar">Editar</button>
            </div>
        </li>
    </ul>
</template>

<script setup>
const BASE_URL = "http://localhost:9000";
const usuari_id = {
    id: 1
}

// const response = await fetch(`${BASE_URL}/api/cursos`);

// const response = await fetch(`${BASE_URL}/api/cursos`, {
//     method: "POST",
//     headers: {
//         "Content-Type": "application/json",
//     },
//     body: JSON.stringify(usuari_id)
// });
</script>

<style scoped>
.cabezal {
    background-color: #a03939;
    height: 60px;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
}

.cabezal p {
    color: white;
    font-weight: bold;
}

.itemAlert {
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