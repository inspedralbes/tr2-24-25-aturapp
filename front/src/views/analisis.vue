<script setup>
    import { useRouter } from "vue-router";

    import AnalisisComp from "../components/AnalisisComp.vue";
</script>

<template>
    <div id="container">
        <div id="content">
            <AnalisisComp />
        </div>
        <div id="menu">
            <button>
                Veure índex de marginalitat
            </button>
        </div>
    </div>
</template>

<style scoped>
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
    width: 20%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    border-left: 2px solid red;
}
</style>
