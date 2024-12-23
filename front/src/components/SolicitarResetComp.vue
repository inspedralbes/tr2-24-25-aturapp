<template>
    <div>
        <h1>Solicitar restablecimiento de contraseña</h1>
        <form @submit.prevent="submitRequest">
            <input type="email" v-model="email" placeholder="Correo electrónico" required />
            <button type="submit">Enviar enlace</button>
        </form>
        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            message: '',
        };
    },
    methods: {
        async submitRequest() {
            const url = 'http://localhost:8000/api/password/solicitar';  // Asegúrate de que la URL sea correcta
            const data = { email: this.email };

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                });

                if (!response.ok) {
                    throw new Error('Error al enviar el enlace');
                }

                const result = await response.json();
                this.message = result.message || 'Enlace enviado correctamente';
            } catch (error) {
                this.message = error.message || 'Hubo un error';
            }
        }

    },
};
</script>