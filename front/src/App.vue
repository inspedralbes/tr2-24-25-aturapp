<script setup>
import { RouterLink, RouterView } from 'vue-router';
</script>

<template>
  <RouterView />
</template>

<style>
body {
  margin: 0;
  box-sizing: border-box;
  font-family: Arial, Helvetica, sans-serif;
}

/* ------------------------------------------ */

.no-style {
  list-style: none;
  text-decoration: none;
}

.no-margin {
  margin: 0;
  padding: 0;
}

.d-flex {
  display: flex;
}

.j-center {
  justify-content: center;
}

.j-right {
  justify-content: right;
}

.j-left {
  justify-content: left;
}

.j-between {
  justify-content: space-between;
}

.j-around {
  justify-content: space-around;
}

.align-center {
  align-items: center;
  align-content: center;
}

.mx-10 {
  margin-left: 10px;
  margin-right: 10px;
}

.mx-20 {
  margin-left: 20px;
  margin-right: 20px;
}

.py-10 {
  padding-top: 10px;
  padding-bottom: 10px;
}

.py-20 {
  padding-top: 20px;
  padding-bottom: 20px;
}

.py-30 {
  padding-top: 30px;
  padding-bottom: 30px;
}

.py-40 {
  padding-top: 40px;
  padding-bottom: 40px;
}

.w-full {
  width: 100%;
}

.h-full {
  height: 100%;
}

/* ------------------------------------------ */

.navbar {
  height: 70px;
  position: fixed;
  background-color: white;
  box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
  bottom: 0;
  right: 0;
  left: 0;
  overflow: hidden;
}

#items>li {
  height: 100%;
  display: flex;
  align-items: center;
}

.active {
  border-top: 3px solid red;

}
</style>