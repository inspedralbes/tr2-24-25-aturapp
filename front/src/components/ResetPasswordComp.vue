<template>
    <div>
        <h1>Restablecer contraseña</h1>
        <form @submit.prevent="submitReset">
            <input type="email" v-model="email" placeholder="Correo electrónico" required />
            <input type="hidden" v-model="token" />
            <input type="password" v-model="password" placeholder="Nueva contraseña" required />
            <input type="password" v-model="password_confirmation" placeholder="Confirmar contraseña" required />
            <button type="submit">Actualizar contraseña</button>
        </form>
        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script>
import { useRoute } from 'vue-router';

export default {
    data() {
        return {
            email: '',
            token: '',
            password: '',
            password_confirmation: '',
            message: '',
        };
    },
    mounted() {
        const route = useRoute();
        this.token = route.query.token;
        this.email = route.query.email;
    },
    methods: {
        async submitReset() {
            const url = 'http://localhost/api/password/reset';
            const data = {
                email: this.email,
                token: this.token,
                password: this.password,
                password_confirmation: this.password_confirmation,
            };

            // Usamos fetch para enviar la solicitud
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                });

                if (!response.ok) {
                    throw new Error('Error al restablecer la contraseña');
                }

                const result = await response.json();
                this.message = result.message || 'Contraseña actualizada correctamente';
            } catch (error) {
                this.message = error.message || 'Hubo un error';
            }
        },
    },
};
</script>