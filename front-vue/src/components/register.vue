<template>
    <form @submit.prevent="handleSubmit">
        <input type="text" v-model="name" placeholder="Nom" />
        <input type="text" v-model="surname" placeholder="Cognom" />
        <input type="text" v-model="email" placeholder="Correu Electrònic" />
        <select v-model="grade">
            <option value="1r ESO">1r ESO</option>
            <option value="2n ESO">2n ESO</option>
        </select>
        <input type="password" v-model="password" placeholder="Contrasenya" />
        <input type="password" v-model="confirmPassword" placeholder="Confirma la Contrasenya" />
        <button type="submit">Registrarse</button>
    </form>
</template>

<script>
    export default {
        name: "Register",
        data() {
            return {
                name: "",
                surname: "",
                email: "",
                grade: "",
                password: "",
                confirmPassword: "",
            };
        },
        methods: {
            async handleSubmit() {
                const DominisValids = ["@inspedralbes.cat", "@xtec.cat"];

                if (!DominisValids.some(domain => this.email.endsWith(domain))) {
                    alert("Correu Invalid");
                    return;
                }

                if (this.password !== this.confirmPassword) {
                    alert("Les contrasenyes no coincideixen");
                    return;
                }

                const userData = {
                    name: this.name,
                    surname: this.surname,
                    email: this.email,
                    grade: this.grade,
                    password: this.password,
                };

                try {
                    const response = await fetch("https://your-api-endpoint.com/register", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(userData),
                    });

                    if (!response.ok) {
                        throw new Error("Error en la solicitud");
                    }

                    const result = await response.json();
                    alert("Usuari registrat amb èxit: " + result.message);
                } catch (error) {
                    console.error("Error:", error);
                    alert("Error al registrar l'usuari");
                }
            },
        },
    };
</script>

<style scoped>
    * {
        transition: 0.2s;
    }
    input, select {
        outline: 0;
        width: 100%;
        padding: 5px 10px;
        margin: 5px auto;
        border: 1px solid black;
    }
    form {
        display: flex;
        margin: 0 auto;
        max-width: 300px;
        flex-direction: column;
    }
</style>