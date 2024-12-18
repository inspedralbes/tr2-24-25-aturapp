<script setup>
import { ref } from 'vue';

const nombresFrecuencia = ref({});  // Objeto para almacenar las frecuencias de los nombres
const nombresMasDichos = ref([]);   // Array para almacenar los nombres más mencionados
const nombresMenosDichos = ref([]); // Array para almacenar los nombres menos mencionados

fetch('http://127.0.0.1:8000/api/analisis')
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta de la red');
        }
        return response.json();
    })
    .then(data => {
        // Procesar los datos para contar las frecuencias de los nombres
        const frecuencia = {};

        // Recorremos todas las respuestas para contar las menciones de los nombres
        data.forEach(item => {
            ['resposta 1', 'resposta 2', 'resposta 3'].forEach(respostaKey => {
                const nombre = item[respostaKey].relacion;
                if (frecuencia[nombre]) {
                    frecuencia[nombre]++;
                } else {
                    frecuencia[nombre] = 1;
                }
            });
        });

        // Guardamos la frecuencia en la variable reactiva
        nombresFrecuencia.value = frecuencia;

        // Convertimos el objeto de frecuencias en un array para ordenarlos
        const listaDeNombres = Object.entries(frecuencia).map(([nombre, frecuencia]) => ({
            nombre,
            frecuencia
        }));

        // Ordenamos los nombres por frecuencia (de mayor a menor y viceversa)
        listaDeNombres.sort((a, b) => b.frecuencia - a.frecuencia);

        // Los más mencionados
        nombresMasDichos.value = listaDeNombres.slice(0, 5); // Tomamos los 5 primeros más mencionados

        // Los menos mencionados
        nombresMenosDichos.value = listaDeNombres.slice(-5); // Tomamos los 5 últimos menos mencionados
    })
    .catch(error => {
        console.error('Hubo un problema con la solicitud Fetch:', error);
    });
</script>

<template>
    <div>
        <ul>
            <li v-for="(nombre, index) in nombresMasDichos" :key="index">
                {{ nombre.nombre }}: {{ nombre.frecuencia }} veces
            </li>
        </ul>
    </div>
</template>

<style scoped></style>
