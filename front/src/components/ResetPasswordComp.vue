<template>
    <div>
        <h1>Restablecer Contraseña</h1>
        <form @submit.prevent="resetPassword">
            <input
                type="password"
                v-model="password"
                placeholder="Nueva contraseña"
                required
            />
            <input
                type="password"
                v-model="passwordConfirmation"
                placeholder="Confirma la nueva contraseña"
                required
            />
            <button type="submit">Restablecer Contraseña</button>
        </form>
        <p v-if="message">{{ message }}</p>
    </div>
</template>

<script>
    export default {
        props: {
            token: String,
            email: String,
        },
        data() {
            return {
                password: '',
                passwordConfirmation: '',
                message: '',
            };
        },
        methods: {
            async resetPassword() {
                const url = 'http://localhost:8000/api/password/reset';
                const data = {
                    email: this.email,
                    token: this.token,
                    password: this.password,
                    password_confirmation: this.passwordConfirmation,
                };

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
                    this.message = result.message || 'Contraseña restablecida correctamente';
                } catch (error) {
                    this.message = error.message || 'Hubo un error al restablecer la contraseña';
                }
            },
        },
    };
</script>