const laravel = { URL: "http://localhost:8000/api" }

// ======= CHAT ====================
export async function guardarMissatgeBBDD(msg) {
    const URL = `${laravel.URL}/missatge`;
    const response = await fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id_emisor: 'process', missatge: msg }),
    });
    const data = await response.json();

    return data;
}

// ======= ANALITZAR PREGUNTES =====
export async function fetchAnalisisData() {
    try {
        const response = await fetch(`${laravel.URL}/analisis`);
        if (!response.ok) {
            throw new Error(`Error en la solicitud: ${response.statusText} (HTTP ${response.status})`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error al obtener los datos:', error);
        throw error;
    }
}