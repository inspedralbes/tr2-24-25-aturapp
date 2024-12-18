<script setup>
    import { useRouter } from "vue-router";

    import AnalisisComp from "../components/AnalisisComp.vue";
    import MarginalitatComp from "../components/MarginalitatComp.vue";
</script>

<template>
    <div id="container">
        <div id="content">
            <AnalisisComp />
            <!---<MarginalitatComp />-->
        </div>
        <div id="menu">
            <button>
                Veure índex de marginalitat
            </button>
        </div>
    </div>
</template>

<style>
*{
    transition: 0.3s;
}
body {
    margin: 0;
}
#container {
    margin: 0;
    padding: 0;
    display: flex;
    height: 100vh;
}

#content {
    flex: 1;
    padding: 16px;
}

#menu {
    height: 100vh;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    background-color: rgb(255, 39, 39);
}

button {
    border: 0;
    width: 100%;
    padding: 15px 30px 15px 15px;
    background: 0;
    font-size: 15px;
    text-align: left;
}

button:hover{
    cursor: pointer;
    background: white;
}
</style>