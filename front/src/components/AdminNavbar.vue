<template>
    <ul class="d-flex no-style j-around no-margin" style="color: red">
        <li @click="navigateTo('')">INICI</li>
        <li @click="navigateTo('/heatmap')">HEATMAP</li>
        <li @click="navigateTo('/alumnes')">ALUMNES</li>
        <li @click="navigateTo('/alertes')">ALERTES</li>
        <li @click="navigateTo('/sociograma')">SOCIOGRAMA</li>
        <li>Incidencia</li>
    </ul>

</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

function navigateTo(path) {
    router.push(`/admin${path}`);
}
</script>

<style scoped>
    li{
        color: red;
    }
</style>