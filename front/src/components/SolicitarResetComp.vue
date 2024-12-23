<template>
    <div class="request-reset">
        <h2>Restablecer Contraseña</h2>
        <form @submit.prevent="requestResetLink">
            <div>
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" v-model="email" required placeholder="Ingresa tu correo" />
            </div>
            <button type="submit">Enviar Enlace</button>
            <p v-if="message" class="success">{{ message }}</p>
            <p v-if="error" class="error">{{ error }}</p>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            message: null,
            error: null,
        };
    },
    methods: {
        async requestResetLink() {
            try {
                this.message = null;
                this.error = null;

                const response = await fetch("http://localhost:8000/api/password/email", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ email: this.email }),
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