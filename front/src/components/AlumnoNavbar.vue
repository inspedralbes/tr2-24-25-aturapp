<template>
    <nav class="navbar" v-if="isLogged && isAlumne">
        <ul id="items" class="no-style d-flex align-center h-full no-margin j-around">
            <li v-for="icon in icons" :key="icon.alt" :class="{ active: route.path.includes(icon.alt) }"
                @click="navigateTo(icon.alt)">
                <img :src="icon.src" :width="icon.width" />
            </li>
        </ul>
    </nav>
</template>

<script setup>
import { useRouter, useRoute } from 'vue-router';

// Navegación y Rutas
const router = useRouter();
const route = useRoute();

// Íconos para el navbar de alumno
const icons = [
    { src: "/assets/svg/home.svg", alt: "home", width: "40px" },
    { src: "/assets/svg/chat.svg", alt: "chat", width: "35px" },
    { src: "/assets/svg/map.svg", alt: "mapa", width: "40px" },
    { src: "/assets/svg/user.svg", alt: "perfil", width: "35px" },
];

function navigateTo(nameIcon) {
    router.push(`/${nameIcon}`);
}
</script>

<style scoped></style>