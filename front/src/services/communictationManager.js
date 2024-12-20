const laravel = { URL: "http://localhost:8000/api" }


// === GUARDAR MISATGES ==================================
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

// === OBTINDRE TOTS ELS ALUMENS ===========================
export async function getAlumnes() {
    const URL = `${laravel.URL}/get-alumnes`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    });

    if (!response.ok) {
        const textResponse = await response.text();
        console.error("Error en la solicitud:", response.status, textResponse);
        throw new Error(`Error ${response.status}: ${response.statusText}`);
    }

    const data = await response.json();
    
    if (Array.isArray(data)) {
        return data;
    }       
}

// === OBRIR INFO D' ALUMNE ================================
export const getAlumneById = async (id) => {
    const URL = `${laravel.URL}/alumnes/${id}`;
    const response = await fetch(URL);
    if (!response.ok) throw new Error('Error al obtener el alumno');
    return await response.json();
};

// === INCIDENCIA RELACIONADA AMB ALUMNE ===================
export const alertasAlumne = async (id) => {
    const URL = `${laravel.URL}/user/${id}/alerts`;
    const response = await fetch(URL);
    if (!response.ok) throw new Error ('No s\'han trobat alertes d\'aquest usuari');
    return await response.json();
}

// === ACTUALIZAR DATOS DE UN ALUMNO ========================
export const updateAlumne = async (id, data) => {
    const URL = `${laravel.URL}/alumnes/${id}`;
    const response = await fetch(URL, {
        method: 'POST', // Usamos POST como especificaste
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });

    if (!response.ok) {
        const error = await response.text();
        console.error('Error al actualizar el alumno:', error);
        throw new Error(`Error al actualizar el alumno: ${error}`);
    }

    return await response.json();
};


// === OBTENER CURSOS =====================
export const getCursos = async () => {
    const URL = `${laravel.URL}/cursos`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });
    if (!response.ok) throw new Error('No s\'han pogut trobar els cursos');
    return await response.json();
};

// === OBTENER TORNS =====================
export const getTorns = async () => {
    const URL = `${laravel.URL}/torns`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });
    if (!response.ok) throw new Error('No s\'han pogut trobar els torns');
    return await response.json();
};