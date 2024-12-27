<template>
    <div>
        <input v-model="email" type="email" placeholder="Introduce tu correo" />
        <button @click="sendRequest">Enviar solicitud</button>
        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '', // Aquí guardaremos el correo introducido por el usuario
            message: null,
        };
    },
    methods: {
        async sendRequest() {
            try {
                // Realizamos la solicitud POST usando fetch
                const response = await fetch('http://localhost:8000/api/send-email', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: this.email, // El correo que se envía
                    }),
                });

                // Verificamos si la respuesta es exitosa
                if (response.ok) {
                    const data = await response.json();
                    this.message = data.message; // Mostramos el mensaje de éxito
                } else {
                    this.message = 'Hubo un error al enviar el correo';
                }
            } catch (error) {
                console.error('Error al hacer la solicitud', error);
                this.message = 'Hubo un error al enviar el correo';
            }
        },
    },
};
</script>

<style scoped>
button {
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}
</style>