<template>
    <div class="d-flex align-center j-between mx-20" style="height: 140px;position: relative">
    <h2>Heatmap</h2>
    <div id="filtros">[[FILTROS]]</div>
    <div id="leyenda">
        <p>Llegenda</p>
        <ul class="no-style">
            <li class="d-flex align-center">
                <div class="color mx-10" style="background-color: #ffdfdf;"></div>
                < 2 cas
            </li>
            <li class="d-flex align-center">
                <div class="color mx-10" style="background-color: #ff8686;"></div>
                < 4 cas
            </li>
            <li class="d-flex align-center">
                <div class="color mx-10" style="background-color: #ff4545;"></div>
                > 4 cas
            </li>
        </ul>
    </div>
</div>
    <div class="planoContainer">
        <div id="heatmap-planta0" v-if="plantaInput == 'planta0'"></div>
        <div id="heatmap-planta1" v-if="plantaInput == 'planta1'"></div>
        <div id="heatmap-planta2" v-if="plantaInput == 'planta2'"></div>
        <div id="heatmap-planta3" class="d-flex j-center" v-if="plantaInput == 'planta3'">
            <svg width="90%" viewBox="0 0 1864 414" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path v-for="(sector, index) in sectors3" :key="index" :id="sector.id" :d="sector.d" :stroke="'black'"
                    :fill="sector.color" :stroke-width="5" @click="navigateToSector(sector.idbd)"
                    :style="{ cursor: sector.hasAlerts ? 'pointer' : 'not-allowed', pointerEvents: sector.hasAlerts ? 'auto' : 'none' }" />
                <g v-html="paths3"></g>
            </svg>

            <div v-for="(color, index) in arrayColors" :key="index"
                :style="{ backgroundColor: color, width: '100px', height: '100px' }"></div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { paths3 } from '@/assets/planos/paths3h';
import { getAllAlertes } from '@/services/communictationManager.js';

const router = useRouter();

const plantaInput = ref('planta3');

const arrayColors = ref([]);

const sectors0 = [];
const sectors1 = [];
const sectors2 = [];
const sectors3 = ref([
    { id: "lavabo-alumnat", idbd: 1, d: "M81 212.5L0.5 219V91.5L81 85.5V212.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "lavabo-dones", idbd: 2, d: "M1783 218.5L1863 227L1863.5 99L1783 93V218.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-ausias", idbd: 3, d: "M1021.5 147L931.5 138.5V353.5L1003 356.5L1021.5 147Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-bosca", idbd: 4, d: "M844 146.5L931 138.5V353.5H859.5L844 146.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-catala", idbd: 5, d: "M1729 260L1724 413L1616 402L1621.5 250.5L1729 260Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-matematiques", idbd: 6, d: "M1479 236.5L1472.5 387L1328.5 373.5L1337 222.5L1479 236.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-inf9", idbd: 7, d: "M1300 219.5L1291 370L1148.5 359L1159 206L1300 219.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-ausias", idbd: 8, d: "M1729 212.5V260L1018 193.5L1022 147L1729 212.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-inf7", idbd: 9, d: "M1159 206L1148.5 359L1004 347.5L1018 193.5L1159 206Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-08", idbd: 10, d: "M704.5 204.5L715.5 353.5L858.5 346L847 192L704.5 204.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-06", idbd: 11, d: "M528.5 219.5L536 371L715.5 353.5L704.5 204.5L528.5 219.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-04", idbd: 12, d: "M385.5 231.5L391 383L536 371L528.5 219.5L385.5 231.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "lab-ciencies-naturals", idbd: 13, d: "M242 244L247 395L391 383L385.5 231.5L242 244Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-ciencies-naturals", idbd: 14, d: "M139 253L143 404.5L247 395L242 244L139 253Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-bosca", idbd: 15, d: "M137.5 206L139 253L847.5 192L844 146.5L137.5 206Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-01", idbd: 16, d: "M133.5 59.5L137.5 206L277.5 194L268.5 46L133.5 59.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-02", idbd: 17, d: "M268.5 46L277.5 194L421 182L412.5 35.5L268.5 46Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-03", idbd: 18, d: "M412.5 35.5L421 182L562 170L554.5 24L412.5 35.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-05", idbd: 19, d: "M554.5 24L562 170L703.5 158L695 14L554.5 24Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-07", idbd: 20, d: "M695 14L703.5 158L843.5 146.5L832.5 1.5L695 14Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "lab-ciencies-naturals-2", idbd: 21, d: "M1621.5 250.5L1616 402L1472.5 387L1479 236.5L1621.5 250.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-inf11", idbd: 22, d: "M1581.5 200L1729 212.5L1733 66.5L1587.5 54L1581.5 200Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-inf10", idbd: 23, d: "M1587.5 53.5L1454 40L1446.5 187L1581.5 200L1587.5 53.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-ll-estrangeres", idbd: 24, d: "M1453.5 39.5L1313.5 27L1306 174L1446 187L1453.5 39.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-tecnologia", idbd: 25, d: "M1313.5 26.5L1244 21L1233.5 167L1306 174L1313.5 26.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p3-inf3", idbd: 26, d: "M1244 21L1035.5 3.5L1022 147L1233.5 167L1244 21Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-bosca", idbd: 27, d: "M76.5 390L3.5 397L1 219.5L137 206L139 253L76.5 258.5V390Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-ausias", idbd: 28, d: "M1787.5 397.5L1860.5 404.5L1863 227L1729 213V260L1787.5 266V397.5Z", color: "white", hasAlerts: false, alerts: [] },
]);

async function paintAlerts() {
    const allAlerts = await getAllAlertes();
    // sectors3.value[1].color = 'red';

    allAlerts.forEach((alerta) => {
        sectors3.value.forEach(sector => {
            if (sector.id == alerta.nombre) {
                sector.hasAlerts = true;
                sector.alerts = alerta.detalles;

                // LOGICA DEL COLOR --------------------
                if (alerta.total < 2) {
                    return sector.color = '#ffdfdf'
                } else if (alerta.total < 4) {
                    return sector.color = '#ff8686'
                } else {
                    return sector.color = '#ff4545'
                }
                // -------------------------------------
            }
        });
    });

    const alertsColors = allAlerts.map(alerta => {
        const sector = sectors3.value.find(sector => sector.id === alerta.nombre);
        return {
            id_sector: alerta.id_sector,
            sector: alerta.nombre,
            total: alerta.total,
            color: sector ? sector.color : white,
            // detalles: alerta.detalles,
        };
    });

    return alertsColors;
}

function navigateToSector(id) {
    // PASAR EL ID DEL SECTOR Y FILTROS CON PARAMS
    router.push(`/admin/heatmap/sector?id=${id}`);
}

// function transformaValors(arrayContador) {
//     function normalize(value, min, max) {
//         return max === min ? 0.5 : (value - min) / (max - min);
//     }

//     function getColor(valueNormalized) {
//         const r = Math.floor(255 * valueNormalized);
//         const g = 0;
//         const b = 0;
//         return `rgb(${r}, ${g}, ${b})`;
//     }

//     const nonZeroValues = arrayContador.filter(value => value > 0);
//     const minValue = nonZeroValues.length ? Math.min(...nonZeroValues) : 0;
//     const maxValue = nonZeroValues.length ? Math.max(...nonZeroValues) : 0;

//     return arrayContador.map(value => {
//         if (value === 0) {
//             return `rgb(255, 255, 255)`;
//         }
//         const normalized = normalize(value, minValue, maxValue);
//         return getColor(normalized);
//     });

//     return arrayColors;
// }

onMounted(async () => {
    // arrayColors.value = transformaValors([0, 10, 100, 100, 0]);
    console.log(await paintAlerts());

    // setInterval(async () => {
    //     // await paintAlerts();
    // }, 5000);
});

</script>

<style scoped>
.testColors {
    color: #ffdfdf;
    color: #ff8686;
    color: #ff4545;
}

.planoContainer {
    overflow: hidden;
    padding-bottom: 70px;
    margin-bottom: 20px;
}

.heatmap-layer {
    width: 414px;
    height: 1864px;
    position: relative;
}

.color {
    height: 15px;
    width: 15px;
}

#leyenda {
    z-index: -1;
    width: 200px;
    height: 170px;
    border: 1px solid black;
    margin: 0;
}

#leyenda>p:first-child {
    text-align: center;
}

ul > li {
    margin-bottom: 20px;
    display: flex;
    align-items: center; /* Centra los elementos dentro de cada item */
}

#filtros {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>