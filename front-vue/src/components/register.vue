<template>
    <br>
    <h1>Registrate</h1>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <form @submit.prevent="handleSubmit">
        <input type="text" v-model="name" placeholder="Nom" />
        <input type="text" v-model="surname" placeholder="Cognom" />
        <input type="text" v-model="email" placeholder="Correu Electrònic" />
        <select v-model="grade">
            <option value="1">1r ESO</option>
            <option value="2">2n ESO</option>
        </select>
        <input type="text" v-model="dni" placeholder="DNI" />
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
                dni: "",
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
                    dni: this.dni,
                    password: this.password,
                    password_confirmation: this.confirmPassword,
                };

                try {
                    const response = await fetch("http://localhost:8000/api/register", {
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
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    h1{
        color: #ff4d4d;
        text-align: center;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f7f7f7;
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

    input,
    select {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }

    input:focus,
    select:focus {
        outline: none;
        border-color: #ff4d4d;  /* Color rojo */
        background-color: #fff;
    }

    input::placeholder,
    select::placeholder {
        color: #aaa;
    }

    button {
        padding: 14px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        background-color: #ff4d4d;  /* Color rojo */
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #e60000;  /* Rojo más intenso en hover */
    }

    button:focus {
        outline: none;
    }

    @media (max-width: 600px) {
        form {
            width: 90%;
            margin: 20px auto;
        }
        
        input,
        select {
            padding: 10px;
            font-size: 14px;
        }

        button {
            font-size: 14px;
            padding: 12px;
        }
    }
</style>
