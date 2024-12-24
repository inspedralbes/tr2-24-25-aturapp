<template>
    <ul class="no-style">
        <li><button @click="getAlerts('dia', 0)">Hoy</button></li>
        <li><button @click="getAlerts('semana', 0)">Setmana</button></li>
        <li><button @click="getAlerts('mes', 0)">Mes</button></li>
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
    <button @click="choiseChart('horario')">Horario</button>
    <button @click="choiseChart('dia')" :class="{'isUnclickable': time === 'dia'}">Dia</button>
    <button @click="choiseChart('total')" :class="{'isUnclickable': time != 'total'}">Total</button>
    <div style="width: 1000px; height: 500px;">
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

const tipo = ref('pie');
const etiquetas = ref();
const datos = ref([12, 19, 3, 5, 2]);

const chartCanvas = ref();
Chart.register(...registerables);
let grafico = null;

async function getAlerts(tiempo, cantidad) {
    time.value = tiempo;
    quant.value = cantidad;
    try {
        const response = await fetch(`${BASE_URL}/api/getAlertsFilter`, {
            method: 'POST',
            headers: {
                "Content-type": "application/json",
            },
            body: JSON.stringify({
                time: time.value,
                quant: quant.value
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

function getQuantitat(caso, alertas) {
    const datos = ref();
    switch (caso) {
        case 'horario':
            datos.value = [0, 0, 0, 0, 0, 0, 0, 0];
            etiquetas.value = ['8:00-9:00', '9:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00', "Fora d'horari"];
            tipo.value = 'pie';
            const horaris = [];
            for (let index = 8; index <= 15; index++) {
                const horario = new Date();
                horario.setHours(index, 0, 0, 0);
                horaris.push(horario);
            }
            alertas.forEach(alerta => {
                const alertaHora = new Date(alerta.created_at);
                const alertaTotalMinutos = alertaHora.getHours() * 60 + alertaHora.getMinutes();

                for (let i = 0; i < horaris.length - 1; i++) {
                    const inicioRango = horaris[i].getHours() * 60;
                    const finRango = horaris[i + 1].getHours() * 60;

                    if (alertaTotalMinutos >= inicioRango && alertaTotalMinutos < finRango) {
                        datos.value[i] += 1;
                        return;
                    }
                }

                datos.value[7] += 1;
            });
            break;
        case 'dia':
            datos.value = [0, 0, 0, 0, 0];
            etiquetas.value = ['Dilluns', 'Dimarts', 'Dimecres', 'Dijous', 'Divendres'];
            tipo.value = 'bar';
            alertas.forEach((alerta) => {
                const dia = new Date(alerta.created_at).getDay();
                if (dia >= 1 && dia <= etiquetas.value.length) {
                    datos.value[dia] += 1;
                }
            })
            console.log(datos.value);
            break;
        case 'total':
            datos.value = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            etiquetas.value = ['Gener', 'Febrer', 'Març', 'Abril', 'Maig', 'Juny', 'Juliol', 'Agost', 'Setembre', 'Octubre', 'Novembre', 'Desembre'];
            tipo.value = 'line';
            alertas.forEach((alerta) => {
                const mes = new Date(alerta.created_at).getMonth();
                datos.value[mes] += 1;
            })
            console.log(datos.value);
            break;
        // default:
        //     break;
    }

    return datos.value;
}

function formatHora(isoDate) {
    const date = new Date(isoDate);
    return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
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
    if(grafico){
        grafico.destroy();
    }
    grafico = new Chart(chartCanvas.value, {
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

function choiseChart(type){
    datos.value = getQuantitat(type, alertas_recibidas.value);
    createChart(tipo.value, etiquetas.value, datos.value);
}

onMounted(async () => {
    await getAlerts(time.value, quant.value);
    rankingSectores.value = await getAllAlertes();
    console.log(rankingSectores.value);
    datos.value = getQuantitat('total', alertas_recibidas.value);
    createChart(tipo.value, etiquetas.value, datos.value);
});
</script>

<style scoped>
.activo {
    font-weight: bold;
    margin-bottom: 100px;
}

button{
    cursor: pointer;
}

.isUnclickable{
    cursor: not-allowed; /* Cambia el cursor para indicar que no se puede hacer clic */
    pointer-events: none;
    background-color: #e0e0e0fd;
    border: 2px solid #c4c4c4;
}
</style>