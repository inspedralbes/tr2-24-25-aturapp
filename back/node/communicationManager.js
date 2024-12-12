const laravel = { URL: "http://localhost:8000/api" }

export async function guardarMissatgeBBDD(msg) {
    const URL = `${laravel.URL}/missatge`;
    const response = await fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ missatge: msg }),
    });
    const data = await response.json();

    return data;
}