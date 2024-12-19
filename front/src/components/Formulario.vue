<template>
    <div>
        <h1>Formulario de Incidencia Escolar</h1>
        <form @submit.prevent="imprimir">
            <label for="alumne">Alumno/a involucrado/a (abusador/a):</label>
            <input type="text" id="alumne" name="alumne" v-model="form.alumne" required>

            <label for="profesor">Profesor/a que abre la incidencia:</label>
            <input type="text" id="profesor" name="profesor" v-model="form.profesor" required>

            <label for="tipo-incidencia">Tipo de incidencia:</label>
            <select id="tipo-incidencia" name="tipo-incidencia" v-model="form.tipoIncidencia" required>
                <option value="disrupcion">Disrupción</option>
                <option value="violencia">Violencia</option>
                <option value="bullying">Bullying</option>
                <option value="otro">Otro</option>
            </select>

            <label for="descripcion">Descripción detallada de los hechos:</label>
            <textarea id="descripcion" name="descripcion" v-model="form.descripcion" rows="5" required></textarea>

            <label for="medidas">Medidas tomadas:</label>
            <textarea id="medidas" name="medidas" v-model="form.medidas" rows="3" required></textarea>

            <label for="contacto">¿Se contactó a los familiares?</label>
            <label for="contacto-si">Sí</label>
            <input type="checkbox" id="contacto-si" name="contacto" value="si" v-model="form.contactoSi" required>
            <label for="contacto-no">No</label>
            <input type="checkbox" id="contacto-no" name="contacto" value="no" v-model="form.contactoNo" required>

            <button type="submit">Descargar en PDF</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({
    alumne: '',
    profesor: '',
    tipoIncidencia: '',
    descripcion: '',
    medidas: '',
    contactoSi: false,
    contactoNo: false,
});

const imprimir = async () => {
    const data = {
        alumne: form.value.alumne,
        profesor: form.value.profesor,
        tipoIncidencia: form.value.tipoIncidencia,
        descripcion: form.value.descripcion,
        medidas: form.value.medidas,
        contacto: form.value.contactoSi ? 'si' : 'no',
    };

    try {
        const response = await fetch('http://localhost:8000/pdf/generate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            const result = await response.json();
            const link = document.createElement('a');
            link.href = `data:application/pdf;base64,${result.content}`;
            link.download = result.filename;
            link.click();
        } else {
            console.error('Error generating PDF');
            alert('Hubo un error al generar el PDF.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Ocurrió un error al enviar la solicitud.');
    }
};
</script>


<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    h1 {
        text-align: center;
    }

    form {
        max-width: 600px;
        margin: auto;
    }
    label {
        font-weight: bold;
        display: block;
        margin-top: 15px;
    }
    textarea, input, select {
        width: 100%;
        margin-bottom: 15px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #45a049;
    }
</style>
