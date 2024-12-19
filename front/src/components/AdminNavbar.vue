<template>
    <div class="d-flex j-center">
        <ul class="d-flex no-style j-around no-margin" style="color: red; width: 600px;">
            <li style="cursor: pointer;" @click="router.push('/admin')">INICI</li>
            <li style="cursor: pointer;" @click="router.push('/admin/heatmap')">HEATMAP</li>
            <li style="cursor: pointer;" @click="router.push('/admin/usuaris')">ALUMNES</li>
            <li style="cursor: pointer;" @click="router.push('/admin/alertes')">ALERTES</li>
            <li style="cursor: pointer;" @click="router.push('/admin/sociograma')">SOCIOGRAMA</li>
        </ul>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();
</script>

<style scoped></style>