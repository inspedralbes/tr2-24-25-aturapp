<template>
    <form @submit.prevent="handleSubmit">
        <input type="text" placeholder="Correu Electrònic" v-model="email" />
        <select name="" id="">
            <option value="">1r ESO</option>
            <option value="">2n ESO</option>
        </select>
        <button type="submit">Registrarse</button>
    </form>
</template>

<script>
export default {
    name: "Register",
    data() {
        return {
            email: "",
        };
    },
    methods: {
        handleSubmit() {
            const DominisValids = ["@inspedralbes.cat", "@xtec.cat"];
            if (DominisValids.some(domain => this.email.endsWith(domain))) {
                alert(`Correu Valid`);
            } else {
                alert("Correu Invalid");
            }
        },
    },
};
</script>


<style scoped>
    *{
        transition: 0.2s;
    }
    input, select{
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
    button{
        padding: 7px;
        color: red;
        cursor: pointer;
        font-size: 15px;
        border: 2px solid red;
        background: rgb(255, 255, 255);
    }
    button:hover{
        color: white;
        background: red;
    }
</style>