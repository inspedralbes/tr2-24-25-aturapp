const laravel = { URL: "http://localhost:8000/api" }

// === GUARDAR MISATGES ===================================
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

// === OBRIR INFO D'ALUMNE =================================
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

// === OBTENER ROLES ======================
export const getRoles = async () => {
    const URL = `${laravel.URL}/rol`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });
    if (!response.ok) throw new Error('No s\' han pogut trobar els rols');
    return await response.json();
}

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

// === OBTENER COMPAÑEROS CLASE ===========
export const getCompanysClase = async (courseId) => {
    const URL = `${laravel.URL}/companys-clase/${courseId}`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });

    if (!response.ok) {
        const error = await response.text();
        console.error('Error al obtener los compañeros de clase:', error);
        throw new Error(`Error al obtener los compañeros de clase: ${response.statusText}`);
    }

    return await response.json();
};

// === OBTENER PREGUNTAS ==================
export const getPreguntas = async () => {
    const URL = `${laravel.URL}/preguntas`;
    const response = await fetch(URL, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });

    if (!response.ok) {
        const error = await response.text();
        throw new Error(`Error al obtener las preguntas: ${response.statusText}`);
    }

    return await response.json();
};

// === PUBLICAR RESPUESTAS ENQUESTA =======
export const publicarRespostas = async (data) => {
    try {
        const URL = `${laravel.URL}/publicar-respostas`;
        const response = await fetch(URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ respuestas: data }),
        });

        if (response.ok) {
            return { success: true };
        } else {
            const errorData = await response.json();
            return { success: false, message: errorData.message || 'Error al enviar las respuestas' };
        }
    } catch (error) {
        return { success: false, message: 'Error de conexión' };
    }
};

// === SOLICITAR CAMBIAR PASSWORD =========
export const sendPasswordResetEmail = async (email) => {
    try {
        const response = await fetch(`${laravel.URL}/password/reset/email`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email }),
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Error al enviar el correo');
        }

        return await response.json();
    } catch (error) {
        throw error;
    }
};

// === CAMBIAR PASSWORD ===================
export const resetPassword = async (token, password, password_confirmation) => {
    try {
        const response = await fetch(`${laravel.URL}/password/reset`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ token, password, password_confirmation }),
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Error al restablecer la contraseña');
        }

        return await response.json();
    } catch (error) {
        throw error;
    }
};

// === GET DADES SOCIOGRAMA ===============
export const getAnalisisData = async () => {
    try {
        const response = await fetch('http://localhost:8000/api/analisis');
        return await response.json();
    } catch (error) {
        console.error('Error al obtener los datos de análisis:', error);
        throw error;
    }
};

// === ANALISIS SOCIOGRAMA ================
export const getCompanysClaseSociograma = async (selectedClass) => {
    try {
        const response = await fetch(`http://localhost:8000/api/companys-clase/${selectedClass}`);
        return await response.json();
    } catch (error) {
        console.error('Error al obtener las compañías de clase:', error);
        throw error;
    }
};

// === PERFIL DADES ALUMNE ================
// === DadesUserComp.vue ==================
export const editarPerfilUser = async (payload) => {
    const URL = `${laravel.URL}/editaruser`;
    try {
        const response = await fetch(URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Error al editar el perfil:', errorText);
            throw new Error(`Error ${response.status}: ${response.statusText}`);
        }

        return await response.json();
    } catch (error) {
        console.error('Error a l\'hora d\'actualitzar l\'usuari: ', error);
        throw error;
    }
};