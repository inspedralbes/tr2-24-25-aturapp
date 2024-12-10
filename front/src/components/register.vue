<template>
    <h1>Registrat</h1>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <form @submit.prevent="handleSubmit">
        <input type="text" v-model="name" placeholder="Nom" />
        <input type="text" v-model="surname" placeholder="Cognom" />
        <input type="text" v-model="email" placeholder="Correu Electrònic" />
        <p>Selecciona el teu curs</p>
        <select v-model="grade">
            <option v-for="curso in cursos" :key="curso.id" :value="curso.id">
                {{ curso.name }}
            </option>
        </select>
        <input type="text" v-model="dni" placeholder="DNI" />
        <div class="password-container">
            <input :type="passwordType" v-model="password" placeholder="Contrasenya" />
            <i :class="passwordIcon" @click="togglePassword"></i>
        </div>
        <div class="password-container">
            <input :type="confirmPasswordType" v-model="confirmPassword" placeholder="Confirma la Contrasenya" />
            <i :class="confirmPasswordIcon" @click="toggleConfirmPassword"></i>
        </div>
        <button type="submit">Registrarse</button>
    </form>
</template>

<script>
    const BASE_URL = "http://localhost:8000";
    export default {
        name: "Register",
        data() {
            return {
                name: "",
                surname: "",
                email: "",
                grade: "",
                dni: "",
                password: "",
                confirmPassword: "",
                cursos: [],
                passwordType: "password",
                confirmPasswordType: "password",
                passwordIcon: "fa fa-eye",
                confirmPasswordIcon: "fa fa-eye",
            };
        },
        methods: {
            async fetchCursos() {
                try {
                    const response = await fetch(`${BASE_URL}/api/cursos`);

                    if (!response.ok) {
                        throw new Error("Error al obtener los cursos");
                    }

                    const data = await response.json();
                    this.cursos = data;
                } catch (error) {
                    console.error("Error al obtener los cursos:", error);
                }
            },
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
                    dni: this.dni,
                    password: this.password,
                    password_confirmation: this.confirmPassword,
                };

                try {
                    const response = await fetch(`${BASE_URL}/api/register`, {
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
                    console.error(error);
                    alert("Error al registrar l'usuari");
                }
            },
            togglePassword() {
                this.passwordType = this.passwordType === "password" ? "text" : "password";
                this.passwordIcon = this.passwordType === "password" ? "fa fa-eye" : "fa fa-eye-slash";
            },
            toggleConfirmPassword() {
                this.confirmPasswordType = this.confirmPasswordType === "password" ? "text" : "password";
                this.confirmPasswordIcon = this.confirmPasswordType === "password" ? "fa fa-eye" : "fa fa-eye-slash";
            }
        },
        mounted() {
            this.fetchCursos();
        },
    };
</script>

<style scoped>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f7f7;
    }

    h1 {
        margin-top: 30px;
        color: #ff4d4d;
        text-align: center;
    }

    p {
        font-size: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        width: 100%;
    }

    input, select {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #ff4d4d;
        background-color: #fff;
    }

    input::placeholder, select::placeholder {
        color: #aaa;
    }

    button {
        padding: 14px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        background-color: #ff4d4d;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #e60000;
    }

    button:focus {
        outline: none;
    }

    .password-container {
        display: flex;
        align-items: center;
        background: #f9f9f9;
        border: 1px solid #ddd;
    }

    .password-container input {
        border: 0;
        width: 90%;
        border: 1px solid white;
        background: #f9f9f9;
        padding: 12px;
    }

    .password-container input:focus{
        border: 1px solid red;
    }

    .password-container i {
        width: 10%;
        text-align: center;
        padding: 12px 0;
        cursor: pointer;
        background-color: #f9f9f9;
    }

    @media (max-width: 600px) {
        form {
            width: 90%;
            margin: 20px auto;
        }
        input, select {
            padding: 10px;
            font-size: 14px;
        }
        button {
            font-size: 14px;
            padding: 12px;
        }
    }
</style>