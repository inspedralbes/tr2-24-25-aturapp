<script setup>
import { ref, onMounted } from 'vue';
import { useCounterStore } from '../stores/counter';
import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router';

const store = useCounterStore();
const BASE_URL = "http://localhost:8000/api";
const user = store.userData.user;
const token = store.userData.token;
const fotoPerfil = ref(user.foto);

const router = useRouter();
function navigateTo(nameRoute) {
    router.push(`/${nameRoute}`)
};

const data = store.userData;

const UserInfo = {
    'nom': data.user.nom,
    'cognom': data.user.cognom,
    'email': data.user.email,
    'dni': data.user.dni,
}

function cerrarSesion() {
    store.clearUserData();
    location.href = "/login";
}

const obtenerFotoPerfil = async () => {
    try {
        const response = await fetch(`${BASE_URL}/getPhoto/${user.id}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
            }
        });

        if(!response.ok){
            throw new Error(`Error al obtener la foto: ${response.statusText}`);
        }
        const data = await response.json();
        
        fotoPerfil.value = data.foto || '';
    } catch (error) {
        console.error('Error al obtener la foto de perfil:', error);
    }
};

onMounted (() => {
    if(!user.foto){
        obtenerFotoPerfil();
    }
})
</script>

<template>
    <div class="containHeader">
        <div id="headerProfile" class="d-flex f-column bg-red">
            <div id="contentHeaderProfile" class="d-flex align-center f-column" style="z-index: 20">
                <p class="no-margin">Perfil</p>
                <div id="profileImage">
                    <img :src="fotoPerfil || '../../public/assets/svg/noimage.svg'" alt="photo">
                </div>
                <p>{{ UserInfo.nom }} {{ UserInfo.cognom }}</p>
            </div>
        </div>
    </div>
    <div id="containItems" class="d-flex align-center f-column">
        <button @click="navigateTo('perfil/dades')">
            <p>Informació general</p>
        </button>
        <button @click="navigateTo('perfil/alertes')">
            <p>Les meves alertes</p>
        </button>
        <button @click="navigateTo('soport')">
            <p>Soport de l'aplicació</p>
        </button>
        <button @click="cerrarSesion">
            <p>Tancar sessió</p>
        </button>
    </div>
</template>

<style scoped>
.bg-red {
    background-color: #ff4b45;
}

#contentHeaderProfile p:first-child {
    color: white;
    margin-top: 10px;
    text-align: center;
    font-weight: bold;
}

#contentHeaderProfile p:last-child {
    color: white;
    margin-top: 20px;
    text-align: center;
    font-size: 20px;
}

#contentHeaderProfile img {
    height: 70px
}

#contentHeaderProfile #profileImage {
    width: 90px;
    height: 90px;
    background-color: white;
    border-radius: 90px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    margin-top: 20px;
}

#profileImage img{
    width: 100%;
    height: 100%;
}

.containHeader{
    padding: 10px;
}

#headerProfile {
    border-radius: 10px;
    width: 100%;
    overflow: hidden;
    box-shadow: -5px -5px 9px rgba(255, 39, 39, 0.45), 5px 5px 9px rgba(255, 0, 0, 0.374);

}

#containItems {
    overflow-y: scroll;
    padding-bottom: 10px;
    margin-bottom: 70px;
}

#containItems button {
    height: 60px;
    width: 350px;
    box-shadow: -5px -5px 9px rgba(198, 198, 198, 0.45), 5px 5px 9px rgba(94, 104, 121, 0.263);
    margin-top: 15px;
    border-radius: 10px;
    display: flex;
    align-items: center;

    border: none;
    background-color: white;
}

#containItems button:last-child p {
    color: rgb(145, 27, 27);
}

#containItems button p {
    margin: 0px 20px;
    color: #474747;
    font-size: 15px;
}
</style>