<script setup>
  import { RouterLink, RouterView } from 'vue-router';
</script>

<template>
  <div>
    <RouterLink to="/home">Home</RouterLink>
    <RouterLink to="/about">About</RouterLink>
  </div>
  <RouterView />
</template>

<style scoped>
  div{
    bottom: 0;
    position: fixed
  }
</style>