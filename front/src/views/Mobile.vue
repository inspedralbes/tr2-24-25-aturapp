<script setup>
import { ref } from "vue";
import HomeComp from "../components/HomeComp.vue"
import ChatComp from "../components/ChatComp.vue"
// import MapComp from "../components/MapComp.vue"
import UserComp from "../components/UserComp.vue"


const activeIcon = ref('home');

// Método para manejar el clic
const handleClick = (nameIcon) => {
    activeIcon.value = nameIcon;
};
</script>

<template>
    <HomeComp v-if="activeIcon == 'home'" />
    <ChatComp v-if="activeIcon == 'chat'" />
    <!-- <MapComp v-if="activeIcon == 'map'" /> -->
    <UserComp v-if="activeIcon == 'user'" />
    <nav class="navbar">
        <ul id="items" class="no-style d-flex align-center h-full no-margin j-around">
            <li v-for="icon in icons" :key="icon.alt" :class="{ active: activeIcon === icon.alt }"
                @click="handleClick(icon.alt)">
                <img :src="icon.src" :width="icon.width" />
            </li>
        </ul>
    </nav>
</template>

<script>
const icons = [
    { src: "/assets/svg/home.svg", alt: "home", width: "40px" },
    { src: "/assets/svg/chat.svg", alt: "chat", width: "35px" },
    // { src: "/assets/svg/map.svg", alt: "map", width: "40px" },
    { src: "/assets/svg/user.svg", alt: "user", width: "35px" },
];
</script>

<style>
</style>