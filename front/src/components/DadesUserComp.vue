<template>
    <div class="d-flex align-center j-center cabezal">
        <div class="d-flex align-center f-column" style="z-index: 20;">
            <img class="icon-arrow" src="../../public/assets/svg/arrow.svg" alt="back" width="40px"
                @click="navigateTo('perfil')">
            <p class="no-margin">informació general</p>
        </div>
    </div>
    <div class="d-flex align-center f-column contentProfile" style="z-index: 20;">
        <div id="profileImage">
            <img src="../../public/assets/svg/noimage.svg" alt="profile">
            <div id="contain-edit-btn">
                <button id="edit-btn" class="d-flex j-center align-center">
                    <img src="../../public/assets/svg/pencil.svg" alt="edit">
                </button>
            </div>
        </div>
        <div id="infoProfile" class="mt-20">
            <p class="no-margin">Nom: </p>
            <input type="text" v-model="nom" name="nom" id="nom">
            <p class="no-margin">Cognom: </p>
            <input type="text" v-model="cognom" name="cognom" id="cognom">
            <p class="no-margin">Telèfon: </p>
            <input type="number" v-model="telefon" name="telefon" id="telefon">
            <p class="no-margin">DNI / NIE: </p>
            <input type="text" v-model="dni" name="nom" id="nom">
        </div>
        <div id="containButtons" class="d-flex align-center j-around">
            <input class="btn-confirm" type="button" value="Guardar" @click="editarPerfil">
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useCounterStore } from '../stores/counter';
import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router';

const router = useRouter();
const store = useCounterStore();
const user = store.userData.user;
const nom = user.nom;
const cognom = user.cognom;
// const telefon = user.telefon
const dni = user.dni;

function navigateTo(nameRoute) {
    router.push(`/${nameRoute}`)
};
</script>

<style>
#contain-edit-btn {
    position: absolute;
    bottom: 0px;
    right: -10px;
}

#edit-btn {
    background-color: white;
    height: 40px;
    width: 40px;
    padding: 0;
    margin: 0;
    border-radius: 40px;
    border: 1px solid grey;
}

#edit-btn img {
    padding: 0;
    margin: 0;
    height: 35px;
    width: 35px;
}

.contentProfile {
    margin-top: 55px;
}

.contentProfile img {
    height: 120px;
    width: 120px;
    object-fit: cover;
    border-radius: 50%;
}

.contentProfile #profileImage {
    position: relative;
    width: 120px;
    height: 120px;
    background-color: white;
    border: 1px solid grey;
    border-radius: 90px;
    display: flex;
    justify-content: center;
    align-items: center;
    /* overflow: hidden; */
    margin-top: 20px;
}

#infoProfile{
    width: 300px;
}

#infoProfile p{
    font-weight: bold;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    box-sizing: border-box;
    font-size: 16px;
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    transition: all 0.3s ease;
}

input:focus {
    outline: none;
    border-color: #ff4d4d;
    background-color: #fff;
}

input::placeholder {
    color: #aaa;
}
</style>