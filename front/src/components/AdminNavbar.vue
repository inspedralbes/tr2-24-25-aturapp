<template>
    <div class="d-flex j-center">
        <ul class="d-flex no-style j-around no-margin" style="color: red; width: 600px;">
            <li style="cursor: pointer;" @click="navigateTo('')">INICI</li>
            <li style="cursor: pointer;" @click="navigateTo('/heatmap')">HEATMAP</li>
            <li style="cursor: pointer;" @click="navigateTo('/usuaris')">ALUMNES</li>
            <li style="cursor: pointer;" @click="navigateTo('/alertes')">ALERTES</li>
            <li style="cursor: pointer;" @click="navigateTo('/sociograma')">SOCIOGRAMA</li>
        </ul>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

function navigateTo(path) {
    router.push(`/admin${path}`);
}
</script>

<style scoped></style>