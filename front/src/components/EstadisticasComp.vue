<template>
    <ul>
        <li class="activo">
            Cantidad de alertas recibidas (1 dia, 1 semana, 1 mes, total)<br>
            Alertas recibidas: {{ count(alertas_recibidas) }}
        </li>

        <li>Frecuencia de las alertas (promedio de tiempo entre alerta y alerta)</li>
        <li>Ranking de alumnos observadores (esto se conseguirá cuando se realiza la incidencia y se marca el rol de
            cada alumno implicado)</li>
        <li>Zona con mayores casos/incidentes (mostrará el nombre del sector y cantidad de casos reportados)</li>
        <li>Gráficos que mostrarán horarios-casos (gráfico queso), dias-casos (gráfico lineal), total-casos (se
            mostrarán ) </li>
    </ul>

</template>

<script setup>
import { ref, onMounted } from 'vue';
const BASE_URL = 'http://localhost:8000';
const time = ref('total');
const quant = ref('0');
const alertas_recibidas = ref();

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
        return result;
    } catch (error) {

    }
}

function count(array) {
    return array ? array.length : 0; // Verifica que el array no sea null o undefined
}

onMounted(async () => {
    alertas_recibidas.value = await getAlerts(time.value, quant.value);
    console.log(alertas_recibidas.value);
});
</script>

<style scoped>
.activo {
    font-weight: bold;
    margin-bottom: 100px;
}
</style>