<template>
    <div class="d-flex j-center">
        <div class="container">
            <div id="alert-container">
                <h2>Alertas del sector: {{ sector }}</h2>
                <div id="alert-list">

                    <div class="alert-card" v-for="alerta in alertes" @click="openAlert()">
                        <h3 class="alert-title">Alerta #{{ alerta.id }}</h3>
                        <div class="alert-footer">
                            <span class="alert-user">Reportado por: {{ alerta.alumne_name }}</span>
                            <span class="alert-date">{{ alerta.fecha }}</span>
                        </div>
                    </div>

                </div>
            </div>
    
            <div class="show-container">
                
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const BASE_URL = 'http://localhost:8000';
const router = useRouter();
const route = useRoute();
const id_sector = route.query.id;
const alertes = ref();
const sector = ref()
const infoAlerta = ref();

async function getAlertsSector() {
    try {
        const response = await fetch(`${BASE_URL}/api/getAlertsSector`, {
            method: 'POST',
            headers: {
                "Content-type": "application/json",
            },
            body: JSON.stringify({
                sector_id: id_sector,
                // Meter otros valores (Fechas, Horarios)
            })
        });

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

onMounted(async () => {
   alertes.value = await getAlertsSector();
   
   sector.value = formatText(alertes.value[0].sector_name);
});

</script>

<style scoped>
/* Contenedor principal */
.container {
    display: flex;
    width: 100%;
    height: 100vh;
    /* Ocupa toda la altura de la pantalla */
    padding: 20px;
    gap: 20px;
}

/* Contenedor de alertas */
#alert-container {
    flex: 1;
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 8px;
    overflow-y: auto;
    max-height: 420px;
}

/* Título */
#alert-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    font-size: 24px;
    font-weight: bold;
}

/* Lista de alertas */
#alert-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Tarjetas de alerta */
.alert-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    padding: 15px;
    cursor: pointer;
    border: 1px solid #ddd;
    transition: box-shadow 0.3s, transform 0.2s;
}

/* Hover sobre la tarjeta */
.alert-card:hover {
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

/* Títulos de las alertas */
.alert-title {
    margin: 0;
    font-size: 18px;
    color: #333;
    font-weight: bold;
}

/* Pie de la tarjeta */
.alert-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    color: #555;
    margin-top: 10px;
}

/* Usuario que reportó */
.alert-user {
    font-style: italic;
}

/* Hora de la alerta */
.alert-time {
    font-weight: bold;
    color: #555;
}

/* Fecha de la alerta */
.alert-date {
    font-size: 12px;
    color: #777;
}

/* Contenedor de estadísticas (lado derecho) */
.show-container {
    display: flex;
    flex: 1.5;
    border-radius: 16px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
}
</style>