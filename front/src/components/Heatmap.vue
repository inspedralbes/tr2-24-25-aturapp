<template>
    <h1>Heatmap</h1>
    <div class="planoContainer">
        <div id="heatmap-planta0" v-if="plantaInput == 'planta0'"></div>
        <div id="heatmap-planta1" v-if="plantaInput == 'planta1'"></div>
        <div id="heatmap-planta2" v-if="plantaInput == 'planta2'"></div>
        <div id="heatmap-planta3" v-if="plantaInput == 'planta3'">
            <div id="heatmapContainer" ref="heatmapContainer" class="heatmap-layer">
                <svg width="414" height="1864" viewBox="0 0 414 1864" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path v-for="(sector, index) in sectors3" :key="index" :id="sector.id" :d="sector.d"
                        :stroke="'black'" :fill="sector.color" :stroke-width="5" />
                </svg>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import h337 from "heatmap.js";
import "../../public/plugins/svg-area-heatmap"; // Importa el plugin SvgAreaHeatmap

const BASE_URL = 'http://localhost:8000';

const heatmapContainer = ref(null); // Referencia al contenedor del heatmap

const sectorIds = [
    "lavabo-alumnat",
    "lavabo-dones",
    "ala-ausias",
    "ala-bosca",
    "dept-catala",
    "dept-matematiques",
    "p3-inf9",
    "pasillo-ausias",
    "p3-inf7",
    "p3-08",
    "p3-06",
    "p3-04",
    "lab-ciencies-naturals",
    "dept-ciencies-naturals",
    "pasillo-bosca",
    "p3-01",
    "p3-02",
    "p3-03",
    "p3-05",
    "p3-07",
    "lab-ciencies-naturals-2",
    "p3-inf11",
    "p3-inf10",
    "dept-ll-estangeres",
    "dept-tecnologia",
    "p3-inf3",
    "fin-ala-bosca",
    "fin-ala-ausias",
];

onMounted(() => {


    setInterval(() => {

    }, 5000); // Actualiza cada 5 segundos
});

</script>

<style scoped>
.planoContainer {
    height: 100%;
    overflow: hidden;
    padding-bottom: 70px;
    margin-bottom: 20px;
}

.heatmap-layer {
    width: 99%;
    height: 100%;
    /* background-color: cyan; */
    border: 2px solid cyan;
}

svg {
    opacity: 0.4;
}
</style>