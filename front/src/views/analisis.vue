<script setup>
    import { useRouter } from "vue-router";

    import AnalisisComp from "../components/AnalisisComp.vue";
</script>

<template>
    <AnalisisComp/>
    <div id="menu">
        <button>
            Veure índex de marginalitat
        </button>
    </div>
</template>

<style scoped>
#menu{
    top: 30px;
    right: 30px;
    position: fixed;
}
</style>