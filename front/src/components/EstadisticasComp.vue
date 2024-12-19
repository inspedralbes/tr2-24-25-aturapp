<template>
    <ul>
        <li class="activo">
            Cantidad de alertas recibidas (1 dia, 1 semana, 1 mes, total)<br>
            
        </li>
        
        <li>Frecuencia de las alertas (promedio de tiempo entre alerta y alerta)</li>
        <li>Ranking de alumnos observadores (esto se conseguirá cuando se realiza la incidencia y se marca el rol de cada alumno implicado)</li>
        <li>Zona con mayores casos/incidentes (mostrará el nombre del sector y cantidad de casos reportados)</li>
        <li>Gráficos que mostrarán horarios-casos (gráfico queso), dias-casos (gráfico lineal), total-casos (se mostrarán ) </li>
    </ul>

</template>

<script setup>
import { ref, onMounted } from 'vue';

</script>

<style scoped>
    .activo{
        font-weight: bold;
        margin-bottom: 100px;
    }
</style>