<template>
    <div class="reset-password">
        <h2>Establecer Nueva Contraseña</h2>
        <form @submit.prevent="resetPassword">
            <div>
                <label for="password">Nueva Contraseña</label>
                <input type="password" id="password" v-model="password" required
                    placeholder="Ingresa tu nueva contraseña" />
            </div>
            <div>
                <label for="password_confirmation">Confirma Contraseña</label>
                <input type="password" id="password_confirmation" v-model="passwordConfirmation" required
                    placeholder="Confirma tu nueva contraseña" />
            </div>
            <button type="submit">Restablecer Contraseña</button>
            <p v-if="message" class="success">{{ message }}</p>
            <p v-if="error" class="error">{{ error }}</p>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            token: "",
            email: "",
            password: "",
            passwordConfirmation: "",
            message: null,
            error: null,
        };
    },
    mounted() {
        this.token = this.$route.query.token || "";
        this.email = this.$route.query.email || "";
    },
    methods: {
        async resetPassword() {
            try {
                this.message = null;
                this.error = null;

                const response = await fetch("http://localhost:8000/api/password/reset", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        token: this.token,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.passwordConfirmation,
                    }),
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || "Ocurrió un error.");
                }

                const data = await response.json();
                this.message = data.message;
            } catch (err) {
                this.error = err.message;
            }
        },
    },
};
</script>

<style scoped>
.success {
    color: green;
}

.error {
    color: red;
}
</style>