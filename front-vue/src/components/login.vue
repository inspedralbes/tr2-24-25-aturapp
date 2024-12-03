<template>
    <form @submit.prevent="handleSubmit">
        <input type="text" placeholder="Escribe tu nombre" v-model="name" />
        <button type="submit">Iniciar</button>
    </form>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            name: "", // Almacena el nombre ingresado por el usuario
        };
    },
    methods: {
        handleSubmit() {
            alert(`Nombre login: ${this.name}`);
        },
    },
};
</script>

<style scoped>
form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 300px;
    margin: 0 auto;
}

input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>