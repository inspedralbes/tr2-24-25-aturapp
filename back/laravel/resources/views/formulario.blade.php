<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Incidencia Escolar</title>
</head>
<body>

<h1>Formulario de Incidencia Escolar</h1>
<form action="{{ route('pdf.generate') }}" method="POST">
    @csrf
    <label for="alumne">Alumno/a involucrado/a (abusador/a):</label>
    <input type="text" id="alumne" name="alumne" required>

    <label for="profesor">Profesor/a que abre la incidencia:</label>
    <input type="text" id="profesor" name="profesor" required>

    <label for="tipo-incidencia">Tipo de incidencia:</label>
    <select id="tipo-incidencia" name="tipo-incidencia" required>
        <option value="disrupcion">Disrupción</option>
        <option value="violencia">Violencia</option>
        <option value="bullying">Bullying</option>
        <option value="otro">Otro</option>
    </select>

    <label for="descripcion">Descripción detallada de los hechos:</label>
    <textarea id="descripcion" name="descripcion" rows="5" required></textarea>

    <label for="medidas">Medidas tomadas:</label>
    <textarea id="medidas" name="medidas" rows="3" required></textarea>

    <label for="contacto">¿Se contactó a los familiares?</label>
    <label for="contacto-si">Sí</label>
    <input type="checkbox" id="contacto-si" name="contacto" value="si" required>
    <label for="contacto-no">No</label>
    <input type="checkbox" id="contacto-no" name="contacto" value="no" required>

    <button type="submit">Descargar en PDF</button>
</form>

</body>
</html>
