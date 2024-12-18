import { useRoute, useRouter } from 'vue-router';

const laravel = { URL: "http://localhost:8000/api" };

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

export async function getAlert(id) {
    try {
        const URL = `${laravel.URL}/show/${id}`;
        const response = await fetch(URL, {
            method: 'GET',
            headers: {
                "Content-type": "application/json",
            }
        });
        if (!response.ok) {
            throw new Error("Error en la solicitud");
        }
        const data = await response.json();

        return data;
        // alerta.value = result;
        // alertaDescripcio.value = alerta.value.descripcion;
    } catch (error) {
        console.error(error);
    }
}

export async function editarAlerta(id, user_id, descripcio) {
    try {
        const URL = `${laravel.URL}/update`;
        const response = await fetch(URL, {
            method: 'POST',
            headers: {
                "Content-type": "application/json",
            },
            body: JSON.stringify({
                alerta_id: id,
                alumne_id: user_id,
                descripcio: descripcio,
            })
        });

        if (!response.ok) {
            throw new Error("Error en la solicitud");
        }

        const data = await response.json();
        
        return data;
    } catch (error) {
        console.error(error);
    }
}