<script setup>
import { ref, onMounted } from 'vue';
import * as d3 from 'd3';  // Asegúrate de importar D3

const data = ref([]);
const clases = ref([]);
const selectedClass = ref(''); // La clase seleccionada por el usuario

// Fetch datos desde la API
fetch('http://localhost:8000/api/analisis')
    .then(response => response.json())
    .then(json => {
        data.value = json;
        // Obtenemos las clases únicas basadas en el campo 'Curs alumne emisor' de los emisores
        const uniqueClasses = [...new Set(json.map(item => item['Curs alumne emisor'].relacion))];
        clases.value = uniqueClasses;
        // Llamamos a la función que genera el sociograma después de obtener los datos
        crearSociograma();
    })
    .catch(error => {
        console.error('Error al obtener los datos:', error);
    });

// Función para crear el sociograma
const crearSociograma = () => {
    // Extraemos los nodos y enlaces de los datos, filtrados por la clase seleccionada
    const nodos = [];
    const enlaces = [];

    // Filtramos los datos por la clase seleccionada
    const filteredData = selectedClass.value 
        ? data.value.filter(item => item['Curs alumne emisor'].relacion === selectedClass.value)
        : data.value;

    filteredData.forEach(item => {
        const alumnoEmisor = item['Alumne emisor'];
        const alumnos = [item['resposta 1'], item['resposta 2'], item['resposta 3']];

        // Aseguramos que el alumno emisor no esté duplicado en los nodos
        if (!nodos.find(nodo => nodo.id === alumnoEmisor.id)) {
            nodos.push({ id: alumnoEmisor.id, name: alumnoEmisor.relacion });
        }

        alumnos.forEach(alumno => {
            if (alumno.id !== alumnoEmisor.id) { // Solo si la respuesta no es el emisor
                if (!nodos.find(nodo => nodo.id === alumno.id)) {
                    nodos.push({ id: alumno.id, name: alumno.relacion });
                }
                // Añadimos enlaces entre el emisor y las respuestas
                enlaces.push({ source: alumnoEmisor.id, target: alumno.id, weight: 3 });
            }
        });
    });

    // Tamaño del SVG
    const width = 600;
    const height = 400;

    // Crear el SVG donde se dibujará el gráfico
    const svg = d3.select("#sociograma")
        .attr("width", width)
        .attr("height", height);

    // Crear el simulador de fuerzas
    const simulation = d3.forceSimulation(nodos)
        .force("link", d3.forceLink(enlaces).id(d => d.id).distance(100))
        .force("charge", d3.forceManyBody().strength(-100))
        .force("center", d3.forceCenter(width / 2, height / 2));

    // Dibujar los enlaces
    const link = svg.append("g")
        .selectAll(".link")
        .data(enlaces)
        .enter().append("line")
        .attr("class", "link")
        .attr("stroke", "#999")
        .attr("stroke-width", d => d.weight)
        .attr("stroke-opacity", 0.6);

    // Dibujar los nodos
    const node = svg.append("g")
        .selectAll(".node")
        .data(nodos)
        .enter().append("circle")
        .attr("class", "node")
        .attr("r", 10)
        .attr("fill", "steelblue")
        .call(d3.drag()
            .on("start", dragstarted)
            .on("drag", dragged)
            .on("end", dragended));

    // Añadir etiquetas a los nodos
    const labels = svg.append("g")
        .selectAll(".label")
        .data(nodos)
        .enter().append("text")
        .attr("class", "label")
        .attr("dx", 12)
        .attr("dy", ".35em")
        .text(d => d.name);

    // Actualizar las posiciones en cada tick de la simulación
    simulation.on("tick", () => {
        link
            .attr("x1", d => d.source.x)
            .attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x)
            .attr("y2", d => d.target.y);

        node
            .attr("cx", d => d.x)
            .attr("cy", d => d.y);

        labels
            .attr("x", d => d.x)
            .attr("y", d => d.y);
    });

    // === Arrastrar Nodos ================
    function dragstarted(event, d) {
        if (!event.active) simulation.alphaTarget(0.3).restart();
        d.fx = d.x;
        d.fy = d.y;
    }

    function dragged(event, d) {
        d.fx = event.x;
        d.fy = event.y;
    }

    function dragended(event, d) {
        if (!event.active) simulation.alphaTarget(0);
        d.fx = null;
        d.fy = null;
    }
};

// Función para actualizar el sociograma cuando se selecciona una clase
const actualizarSociograma = () => {
    crearSociograma();
};
</script>

<template>
    <div>
        <h1>Sociograma</h1>
        
        <div>
            <label for="clase">Selecciona una clase:</label>
            <select id="clase" v-model="selectedClass" @change="actualizarSociograma">
                <option value="">Todas las clases</option>
                <option v-for="clase in clases" :key="clase" :value="clase">{{ clase }}</option>
            </select>
        </div>

        <p v-if="!data || !data.length">Cargando datos...</p>
        <svg id="sociograma"></svg>
    </div>
</template>

<style scoped>
.node {
    cursor: pointer;
}

.link {
    stroke: #999;
    stroke-opacity: 0.6;
}

.node:hover {
    fill: orange;
}

.link:hover {
    stroke: orange;
}

svg{
    border: 2px solid black;
}

.label {
    font-size: 12px;
    fill: black;
    pointer-events: none;
}
</style>
