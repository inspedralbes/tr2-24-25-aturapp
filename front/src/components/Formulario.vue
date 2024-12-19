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
            <input type="radio" id="contacto-si" name="contacto" value="si" v-model="form.contacto" required>
            <label for="contacto-no">No</label>
            <input type="radio" id="contacto-no" name="contacto" value="no" v-model="form.contacto" required>

            <div style="display: flex; justify-content: space-between;">
                <button type="submit">Descargar en PDF</button>
                <button type="button" @click="borrarDatos">Borrar datos</button>
            </div>
        </form>
    </div>
</template>

<script>
import jsPDF from "jspdf";

export default {
    data() {
        return {
            form: {
                alumne: "",
                profesor: "",
                tipoIncidencia: "",
                descripcion: "",
                medidas: "",
                contacto: "" 
            }
        };
    },
    methods: {
        imprimir() {
            const doc = new jsPDF();
            const contacto = this.form.contacto === "si" ? "Sí" : "No";

            doc.setFont("helvetica", "bold");
            doc.setFontSize(16);
            doc.text("Formulario de Incidencia Escolar", 105, 20, null, null, "center");

            doc.setFont("helvetica", "normal");
            doc.setFontSize(12);

            doc.text("Alumno/a involucrado/a (abusador/a):", 10, 40);
            doc.text(this.form.alumne, 10, 45);

            doc.text("Profesor/a que abre la incidencia:", 10, 55);
            doc.text(this.form.profesor, 10, 60);

            doc.text("Tipo de incidencia:", 10, 70);
            doc.text(this.form.tipoIncidencia, 10, 75);

            doc.text("Descripción detallada de los hechos:", 10, 85);
            doc.text(this.form.descripcion, 10, 90, { maxWidth: 190 });

            doc.text("Medidas tomadas:", 10, 110);
            doc.text(this.form.medidas, 10, 115, { maxWidth: 190 });

            doc.text("¿Se contactó a los familiares?:", 10, 135);
            doc.text(contacto, 10, 140);

            doc.setDrawColor(0, 0, 0);
            doc.line(10, 30, 200, 30);

            doc.save("Formulario_Incidencia.pdf");
        },
        borrarDatos() {
            this.form.alumne = "";
            this.form.profesor = "";
            this.form.tipoIncidencia = "";
            this.form.descripcion = "";
            this.form.medidas = "";
            this.form.contacto = "";
        }
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
