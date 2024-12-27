<template>
    <div>
        <h2>Restablecer Contraseña</h2>
        <form @submit.prevent="resetPassword">
            <input v-model="password" type="password" placeholder="Nueva Contraseña" />
            <input v-model="password_confirmation" type="password" placeholder="Confirmar Contraseña" />
            <button type="submit">Restablecer Contraseña</button>
            <p v-if="error">{{ error }}</p>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            password: '',
            password_confirmation: '',
            error: null,
            token: this.$route.params.token,
        };
    },
    mounted() {
        console.log('Token desde la URL:', this.token); 
    },
    methods: {
        async resetPassword() {
            if (!this.token) {
                this.error = 'No se ha encontrado un token válido.';
                return;
            }

            if (this.password !== this.password_confirmation) {
                this.error = 'Las contraseñas no coinciden.';
                return;
            }

            const requestData = {
                token: this.token,
                password: this.password,
                password_confirmation: this.password_confirmation,
            };
            console.log('Datos enviados al backend:', requestData);

            try {
                const response = await fetch('http://localhost:8000/api/password/reset', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(requestData), 
                });

                const data = await response.json();
                if (!response.ok) {
                    console.log('Error:', data);
                    this.error = data.message || 'Hubo un error al restablecer la contraseña.';
                } else {
                    this.message = 'Contraseña restablecida con éxito.';
                    this.$router.push('/login');
                }
            } catch (error) {
                console.error('Error al enviar solicitud', error);
                this.error = 'Hubo un error al restablecer la contraseña.';
            }
        }
    },
};
</script>

<style scoped>
form {
    display: flex;
    flex-direction: column;
}

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
