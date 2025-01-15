<template>
    <div class="d-flex align-center j-between mx-20" style="height: 140px;position: relative">
        <h2>Heatmap</h2>
        <div id="leyenda">
            <p>Llegenda</p>
            <ul class="no-style">
                <li class="d-flex align-center">
                    <div class="color mx-10" style="background-color: #ffdfdf;"></div>
                    < 2 cas </li>
                <li class="d-flex align-center">
                    <div class="color mx-10" style="background-color: #ff8686;"></div>
                    < 4 cas </li>
                <li class="d-flex align-center">
                    <div class="color mx-10" style="background-color: #ff4545;"></div>
                    > 4 cas
                </li>
            </ul>
        </div>
    </div>
    <div class="planoContainer">
        <div id="heatmap-planta0">
            <p>Planta Baixa</p>
            <svg width="90%" viewBox="0 0 1864 405" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path v-for="(sector, index) in sectors0" :key="index" :id="sector.id" :d="sector.d" :stroke="'black'"
                    :fill="sector.color" :stroke-width="5" @click="navigateToSector(sector.idbd)"
                    :style="{ cursor: sector.hasAlerts ? 'pointer' : 'not-allowed', pointerEvents: sector.hasAlerts ? 'auto' : 'none' }" />
                <g v-html="planta0h"></g>
            </svg>

        </div>
        <div id="heatmap-planta1">
            <p>Planta 1</p>
            <svg width="90%" viewBox="0 0 1864 407" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path v-for="(sector, index) in sectors1" :key="index" :id="sector.id" :d="sector.d" :stroke="'black'"
                    :fill="sector.color" :stroke-width="5" @click="navigateToSector(sector.idbd)"
                    :style="{ cursor: sector.hasAlerts ? 'pointer' : 'not-allowed', pointerEvents: sector.hasAlerts ? 'auto' : 'none' }" />
                <g v-html="planta1h"></g>
            </svg>

        </div>
        <div id="heatmap-planta2">
            <p>Planta 2</p>
            <svg width="90%" viewBox="0 0 1864 414" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path v-for="(sector, index) in sectors2" :key="index" :id="sector.id" :d="sector.d" :stroke="'black'"
                    :fill="sector.color" :stroke-width="5" @click="navigateToSector(sector.idbd)"
                    :style="{ cursor: sector.hasAlerts ? 'pointer' : 'not-allowed', pointerEvents: sector.hasAlerts ? 'auto' : 'none' }" />
                <g v-html="planta2h"></g>
            </svg>
        </div>
        <div id="heatmap-planta3">
            <p>Planta 3</p>
            <svg width="90%" viewBox="0 0 1864 414" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path v-for="(sector, index) in sectors3" :key="index" :id="sector.id" :d="sector.d" :stroke="'black'"
                    :fill="sector.color" :stroke-width="5" @click="navigateToSector(sector.idbd)"
                    :style="{ cursor: sector.hasAlerts ? 'pointer' : 'not-allowed', pointerEvents: sector.hasAlerts ? 'auto' : 'none' }" />
                <g v-html="planta3h"></g>
            </svg>

            <div v-for="(color, index) in arrayColors" :key="index"
                :style="{ backgroundColor: color, width: '100px', height: '100px' }"></div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { planta0h, planta1h, planta2h, planta3h } from '@/assets/planos/paths';

const router = useRouter();

// const plantaInput = ref('planta3');

const arrayColors = ref([]);

const sectors0 = ref([
    { id: "wc0", idbd: 85, d: "M1783 217.344L1863 226L1863.5 98L1783 92V217.344Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-ausias0", idbd: 86, d: "M1082 151.5L931.5 137.5V352.5L1061 355.5L1074.5 197L1082 151.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-ausias0", idbd: 87, d: "M1729 211.5V259L1074.5 197.5L1082 151.5L1729 211.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-bosca0", idbd: 88, d: "M931.5 352.5L802 355.5L788.5 197L781 151.5L843.5 145.5L931.5 137.5V352.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-bosca0", idbd: 89, d: "M134.5 212V259L788.5 197.5L781 151.5L134.5 212Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-13", idbd: 90, d: "M1582 198L1729 211.5L1733 65.5L1587.5 53L1582 198Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-11", idbd: 91, d: "M1587.5 52.5L1454 39L1446 185L1581.5 198L1587.5 52.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-12", idbd: 92, d: "M1579 245L1444.5 232.5L1435 380.5L1573 392L1579 245Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-14", idbd: 93, d: "M1729 258.959L1579 245L1573 392L1726.5 404L1729 258.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-10", idbd: 94, d: "M1169 14.5L1034 2L1021.5 146L1157.5 158.5L1169 14.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-ausias0", idbd: 95, d: "M1787.5 396.5L1860.5 403.5L1863 226L1729 211.5V259L1787.5 265V396.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-01", idbd: 96, d: "M282 198L134.5 212L130.5 65.5L276 53L282 198Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-03", idbd: 97, d: "M276 53L409.5 39L417.5 185.5L282 198L276 53Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-05", idbd: 98, d: "M409.5 39L545 26.5L557 172.5L417.5 185.5L409.5 39Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-04", idbd: 99, d: "M284.5 245L419 232.5L428.5 380.5L290.5 392L284.5 245Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-06", idbd: 100, d: "M419 232.5L498 225L506.5 372L428.5 380.5L419 232.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-07", idbd: 101, d: "M498 225L640.5 211.5L650.5 358.5L506.5 372L498 225Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-09", idbd: 102, d: "M640.5 211.5L788.5 197.5L801 345L650.5 358.5L640.5 211.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-02", idbd: 103, d: "M134.5 258.959L284.5 245L290.5 392L137 404L134.5 258.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pb-08", idbd: 104, d: "M695 13.5L830 1L842 145.5L706 158.5L695 13.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-bosca0", idbd: 105, d: "M76 396.5L3 403.5L0.5 226L134.5 212V259L76 265V396.5Z", color: "white", hasAlerts: false, alerts: [] },
]);
const sectors1 = ref([
    { id: "ala-ausias1", idbd: 60, d: "M1021.5 148L931.5 139.5V354.5L1003 357.5L1021.5 148Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-ausias1", idbd: 61, d: "M1729 213.5V261L1018 194.5L1022 148L1729 213.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "sem-castella-ausias1", idbd: 62, d: "M1109 9.13043L1096.5 155L1022 148.304L1036 1L1109 9.13043Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf5", idbd: 63, d: "M1582 200L1729 213.5L1733 67.5L1587.5 55L1582 200Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-09", idbd: 64, d: "M1587.5 54.5L1454 41L1446 187L1581.5 200L1587.5 54.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf3", idbd: 65, d: "M1579 247.5L1444.5 234.5L1435 382.5L1573 394L1579 247.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf2", idbd: 66, d: "M1444.5 234.5L1308.5 222L1300 368.5L1435 382.5L1444.5 234.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf1", idbd: 67, d: "M1308.5 222L1166 208.5L1156 355L1300 368.5L1308.5 222Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-08", idbd: 68, d: "M1166 208.5L1017.5 194.5L1004.5 341.5L1156 355L1166 208.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-inf4", idbd: 69, d: "M1729 260.959L1579 248L1573 394L1726.5 406L1729 260.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "sala-multifuncional-2", idbd: 70, d: "M1454 41L1244 22L1232.5 167.5L1446 187L1454 41Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-informatica-i-fol", idbd: 71, d: "M1244 22L1109 9.5L1097 154.5L1233 167.5L1244 22Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-ausias1", idbd: 72, d: "M1787.5 398.5L1860.5 405.5L1863 228L1729 214V261L1787.5 267V398.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-bosca1", idbd: 73, d: "M842 148L932 139.5V354.5L860.5 357.5L842 148Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-bosca1", idbd: 74, d: "M134.5 213.5V261L845.5 194.5L841.5 148L134.5 213.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "sem-castella-bosca1", idbd: 75, d: "M754.5 9.13043L767 155L841.5 148.304L827.5 1L754.5 9.13043Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-01", idbd: 76, d: "M281.5 200L134.5 213.5L130.5 67.5L276 55L281.5 200Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-03", idbd: 77, d: "M276 54.5L409.5 41L417.5 187L282 200L276 54.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-04", idbd: 78, d: "M284.5 247.5L419 234.5L428.5 382.5L290.5 394L284.5 247.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-06", idbd: 79, d: "M555 222L697.5 208.5L707.5 355L563.5 368.5L555 222Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-07", idbd: 80, d: "M697.5 208.5L846 194.5L859 341.5L707.5 355L697.5 208.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-02", idbd: 81, d: "M134.5 260.959L284.5 248L290.5 394L137 406L134.5 260.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "biblioteca", idbd: 82, d: "M409.5 41L619.5 22L631 167.5L417.5 187L409.5 41Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p1-05", idbd: 83, d: "M619.5 22L754.5 9.5L766.5 154.5L630.5 167.5L619.5 22Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-bosca1", idbd: 84, d: "M76 398.5L3 405.5L0.5 228L134.5 214V261L76 267V398.5Z", color: "white", hasAlerts: false, alerts: [] },
]);
const sectors2 = ref([
    { id: "lavabo-homes2", idbd: 29, d: "M1784 216.5L1864 225L1864.5 97L1784 91V216.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-ausias2", idbd: 30, d: "M1022.5 145L932.5 136.5V351.5L1004 354.5L1022.5 145Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratorio-fisica-2", idbd: 31, d: "M1264 214.5L1253 365L1079 351L1092 198.5L1264 214.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratorio-quimica-2", idbd: 32, d: "M1445.5 231.5L1436 379L1253 365L1264 214.5L1445.5 231.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-ausias2", idbd: 33, d: "M1730 210.5V258L1018.5 191.5L1022.5 145L1730 210.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "magatzem-ausias", idbd: 34, d: "M1092 198.5L1079 351L1005 345.5L1018.5 191.5L1092 198.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-inf7", idbd: 35, d: "M1582.5 197L1730 210.5L1734 64.5L1588.5 52L1582.5 197Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-09", idbd: 36, d: "M1588.5 52L1455 38L1447.5 184.5L1582.5 197L1588.5 52Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-10", idbd: 37, d: "M1580 244L1445.5 231.5L1436 379L1574 391L1580 244Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-11", idbd: 38, d: "M1730 257.959L1580 244L1574 391L1727.5 403L1730 257.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-08", idbd: 39, d: "M1455 38L1314.5 25L1307 171.5L1447.5 184.5L1455 38Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-socials-humanitats", idbd: 40, d: "M1314.5 25L1245 19L1235 164.5L1307 171.5L1314.5 25Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-expressio", idbd: 41, d: "M1245 19L1183 13L1170 158.5L1235 164.5L1245 19Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-07", idbd: 42, d: "M1183 13L1032.67 1L1023 144.939L1170 158.5L1183 13Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-ausias2", idbd: 43, d: "M1788.5 395.5L1861.5 402.5L1864 225L1730 211V258L1788.5 264V395.5Z", color: "white", hasAlerts: false, alerts: [] },
    // { id: "wc2", idbd: 44, d: "M81.5 216.5L1.5 225L1 97L81.5 91V216.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "ala-bosca2", idbd: 45, d: "M843 145L933 136.5V351.5L861.5 354.5L843 145Z", color: "white", hasAlerts: false, alerts: [] },
    // { id: "dept-socials", idbd: 46, d: "M135.5 211L81.5 216.5V155.5L134 150.5L135.5 211Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratori-quimica-1", idbd: 47, d: "M601.5 214.5L612.5 365L786.5 351L773.5 198.5L601.5 214.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "laboratori-fisica-1", idbd: 48, d: "M420.5 231.5L429.5 379L612.5 365L601.5 214.5L511 223L420.5 231.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "pasillo-bosca2", idbd: 49, d: "M135.5 210.5V258L847 191.5L843 145L135.5 210.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "magatzem-bosca", idbd: 50, d: "M773.5 198.5L786.5 351L860.5 345.5L847 191.5L773.5 198.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-01", idbd: 51, d: "M283 197L135.5 210.5L131.5 64.5L277 52L283 197Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-03", idbd: 52, d: "M277 52L410.5 38L418 184.5L283 197L277 52Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-orientacio", idbd: 53, d: "M545.5 25.5L618 19L630.5 164.5L558.5 171.5L545.5 25.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-02", idbd: 54, d: "M135.5 257.959L285.5 244L291.5 391L138 403L135.5 257.959Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-05", idbd: 55, d: "M410.5 38L545.5 25.5L558.5 171.5L418 184.5L410.5 38Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "dept-fisica-i-quimica", idbd: 56, d: "M618 19L682.5 13L695.5 158.5L630.5 164.5L618 19Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-06", idbd: 57, d: "M682.5 13L832.831 1L842.5 144.939L695.5 158.5L682.5 13Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "fin-ala-bosca2", idbd: 58, d: "M77 395.5L4 402.5L1.5 225L135.5 211V258L77 264V395.5Z", color: "white", hasAlerts: false, alerts: [] },
    { id: "p2-04", idbd: 59, d: "M285.5 244L420 231.5L429.5 379L291.5 391L285.5 244Z", color: "white", hasAlerts: false, alerts: [] },
]);
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

async function getAllAlertes() {
    try {
        const response = await fetch(`http://aturapp.daw.inspedralbes.cat/laravel/public/api/getAllAlerts`);

        if (!response.ok) {
            throw new Error("Error en la solicitud");
        }

        const result = await response.json();
        return result;
    } catch (error) {
        console.error(error);
    }
}

async function paintAlerts() {
    const allAlerts = await getAllAlertes();

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

onMounted(async () => {
    console.log(await paintAlerts());

    setInterval(async () => {
        // await paintAlerts();
    }, 8000);
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
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    padding: 20px;
}

.planoContainer div {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 1px solid black;
    padding: 20px;
    /* height: 250px; */
}

.planoContainer div p {
    font-weight: bold;
    margin: 0 0 20px 0;
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

ul>li {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    /* Centra los elementos dentro de cada item */
}
</style>