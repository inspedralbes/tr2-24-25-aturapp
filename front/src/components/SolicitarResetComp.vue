<template>
    <div>
        <h2>Solicitar restablecimiento de contraseña</h2>
        <input v-model="email" type="email" placeholder="Introduce tu correo" />
        <button @click="sendRequest">Enviar solicitud</button>
        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '', 
            message: null,
        };
    },
    methods: {
        async sendRequest() {
            try {
                const response = await fetch('http://localhost:8000/api/password/reset/email', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: this.email,
                    }),
                });

                if (response.ok) {
                    const data = await response.json();
                    this.message = data.message; 
                } else {
                    const data = await response.json();
                    this.message = data.message; 
                }
            } catch (error) {
                console.error('Error al hacer la solicitud', error);
                this.message = 'Hubo un error al enviar el correo.';
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

input {
    margin-bottom: 10px;
}
</style>