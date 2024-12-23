<template>
    <ul class="no-style">
        <li><button @click="getAlerts('day', 0)">Hoy</button></li>
        <li><button @click="getAlerts('week', 0)">Setmana</button></li>
        <li><button @click="getAlerts('month', 0)">Mes</button></li>
        <li><button @click="getAlerts('total', 0)">Todo</button></li>
    </ul>
    <ul>
        <li>
            Cantidad de alertas recibidas (1 dia, 1 semana, 1 mes, total)<br>
            Alertas recibidas: {{ count(alertas_recibidas) }}
        </li>

        <li>
            Poder tener un porcentaje de casos de bullying solucionados (Se debe marcar como resuelto el caso y la
            víctima la debe marcar también como resuelta para que cuente)<br>
            <!-- {{ porcentajeExito() }} -->
        </li>
        <li>
            Ranking con mayores casos/incidentes (mostrará el nombre del sector y cantidad de casos reportados)<br>
            <ul>
                <li v-for="index in 3">
                    {{ formatText(rankingSectores[index - 1]?.nombre) }}
                </li>
            </ul>
        </li>
        <li class="activo">
            Gráficos que mostrarán horarios-casos (gráfico queso), dias-casos (gráfico de barras), total-casos (grafico
            lineal)<br>
        </li>
    </ul>
    <div>
        <canvas ref="chartCanvas"></canvas>
    </div>

</template>

<script setup>
import { Chart, registerables } from "chart.js";
import { ref, onMounted } from 'vue';
const BASE_URL = 'http://localhost:8000';
const time = ref('total');
const quant = ref('0');
const alertas_recibidas = ref();
const rankingSectores = ref([]);

const chartCanvas = ref();
Chart.register(...registerables);

async function getAlerts(tiempo, cantidad) {
    try {
        const response = await fetch(`${BASE_URL}/api/getAlertsFilter`, {
            method: 'POST',
            headers: {
                "Content-type": "application/json",
            },
            body: JSON.stringify({
                time: tiempo,
                quant: cantidad
            })
        });

        if (!response.ok) {
            throw new Error("Error en la solicitud");
        }

        const result = await response.json();
        alertas_recibidas.value = result;
        console.log(alertas_recibidas.value);
    } catch (error) {

    }
}

async function getAllAlertes() {
    try {
        const response = await fetch(`${BASE_URL}/api/getAllAlerts`);

        if (!response.ok) {
            throw new Error("Error en la solicitud");
        }

        const result = await response.json();
        return result;
    } catch (error) {
        console.error(error);
    }
}

function formatText(text) {
    text = text || "";

    if (text.includes("-inf")) {
        return text.toUpperCase();
    }

    return text
        .split('-') // Divide el texto en palabras separadas por "-"
        .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Capitaliza la primera letra de cada palabra
        .join(' '); // Une las palabras con un espacio
}

function count(array) {
    return array ? array.length : 0; // Verifica que el array no sea null o undefined
}

function createChart(tipo, etiquetas, datos) {
    new Chart(chartCanvas.value, {
        type: tipo,
        data: {
            labels: etiquetas,
            datasets: [{
                label: "# of alerts",
                data: datos,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}



onMounted(async () => {
    await getAlerts(time.value, quant.value);
    rankingSectores.value = await getAllAlertes();
    console.log(rankingSectores.value);
    createChart('bar', ['Dilluns', 'Dimarts', 'Dimecres', 'Dijous', 'Divendres'], [12, 19, 3, 5, 2])
});
</script>

<style scoped>
.activo {
    font-weight: bold;
    margin-bottom: 100px;
}
</style>