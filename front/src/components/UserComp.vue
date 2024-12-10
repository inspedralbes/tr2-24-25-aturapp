<script setup>
import { RouterLink, RouterView, useRouter, useRoute } from 'vue-router';

const router = useRouter();
function navigateTo(nameRoute) {
  router.push(`/${nameRoute}`)
};
</script>

<template>
    <div id="headerProfile" class="d-flex f-column bg-red">
        <div id="bg-circle"></div>
        <div id="contentHeaderProfile" class="d-flex align-center f-column" style="z-index: 20;">
            <p class="no-margin">Perfil</p>
            <div id="profileImage">
                <img src="../../public/assets/svg/noimage.svg" alt="profile">
            </div>
            <p>Agustín Enzo Noviello</p>
        </div>
    </div>
    <div id="containItems" class="d-flex align-center f-column">
        <button @click="navigateTo('perfil/dades')">
            <p>Informació general</p>
        </button>
        <button @click="navigateTo('perfil/alertes')">
            <p>Meves alertes</p>
        </button>
        <button @click="navigateTo('soport')">
            <p>Soport de l'aplicació</p>
        </button>
        <button>
            <p>Tancar sessió</p>
        </button>
    </div>
</template>

<style scoped>
.bg-red {
    background-color: #a03939;
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

#headerProfile {
    position: fixed;
    top: 0;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    height: 200px;
    width: 100%;
    overflow: hidden;
}

#bg-circle {
    position: absolute;
    background-color: rgb(168, 61, 58);
    height: 400px;
    width: 400px;
    border-radius: 300px;
    left: -220px;
    top: -230px;
}

#containItems {
    margin-top: 200px;
    overflow-y: scroll;
    padding-bottom: 10px;
    margin-bottom: 70px;
}

#containItems button {
    height: 60px;
    width: 350px;
    box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
    margin-top: 10px;
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