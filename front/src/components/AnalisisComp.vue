<script setup>
import { ref } from 'vue';
import * as d3 from 'd3';

const data = ref([]);
const clases = ref([]);
const selectedClass = ref('');

fetch('http://localhost:8000/api/analisis')
    .then(response => response.json())
    .then(json => {
        data.value = json;
        const uniqueClasses = [...new Set(json.map(item => item['Curs alumne emisor'].relacion))];
        clases.value = uniqueClasses;

        crearSociograma();
    })
    .catch(error => {
        console.error('Error al obtener los datos:', error);
    });

const crearSociograma = () => {
    const nodos = [];
    const enlaces = [];

    const filteredData = selectedClass.value
        ? data.value.filter(item => item['Curs alumne emisor'].relacion === selectedClass.value)
        : data.value;

    filteredData.forEach(item => {
        const alumnoEmisor = item['Alumne emisor'];
        const alumnos = [item['resposta 1'], item['resposta 2'], item['resposta 3']];
        const esPositiva = [1, 4, 7, 12].includes(item['pregunta'].id);
        const color = esPositiva ? 'green' : 'red';

        if (!nodos.find(nodo => nodo.id === alumnoEmisor.id)) {
            nodos.push({ id: alumnoEmisor.id, name: alumnoEmisor.relacion });
        }

        alumnos.forEach(alumno => {
            if (alumno.id !== alumnoEmisor.id) {
                if (!nodos.find(nodo => nodo.id === alumno.id)) {
                    nodos.push({ id: alumno.id, name: alumno.relacion });
                }
                enlaces.push({ source: alumnoEmisor.id, target: alumno.id, weight: 2, color });
            }
        });
    });

    const width = 600;
    const height = 400;

    const svg = d3.select("#sociograma")
        .attr("width", width)
        .attr("height", height);

    svg.selectAll("*").remove();

    const simulation = d3.forceSimulation(nodos)
        .force("link", d3.forceLink(enlaces).id(d => d.id).distance(100))
        .force("charge", d3.forceManyBody().strength(-100))
        .force("center", d3.forceCenter(width / 2, height / 2));

    const link = svg.append("g")
        .selectAll(".link")
        .data(enlaces)
        .enter().append("line")
        .attr("class", "link")
        .attr("stroke", d => d.color)
        .attr("stroke-width", d => d.weight)
        .attr("stroke-opacity", 0.6);

    const node = svg.append("g")
        .selectAll(".node")
        .data(nodos)
        .enter().append("circle")
        .attr("class", "node")
        .attr("r", 5)
        .attr("fill", "steelblue")
        .call(d3.drag()
            .on("start", dragstarted)
            .on("drag", dragged)
            .on("end", dragended));

    const labels = svg.append("g")
        .selectAll(".label")
        .data(nodos)
        .enter().append("text")
        .attr("class", "label")
        .attr("dx", 12)
        .attr("dy", ".35em")
        .text(d => d.name);

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

const actualizarSociograma = () => {
    crearSociograma();
};
</script>

<template>
    <div>
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
svg {
    background: rgb(183, 182, 182);
}
</style>
