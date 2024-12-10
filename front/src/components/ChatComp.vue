<template>
    <div>
        <ul id="misstages" class="mostrar">
            <li v-for="(msg, index) in messages" :key="index">{{ msg }}</li>>
        </ul>
        <input v-model="missatge" autocomplete="off" />
        <button @click="sendMessage"></button>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { io } from 'socket.io-client';

const socket = io('http://localhost:9001');

const messages = ref([]);
const input = ref('');

function sendMessage(){
  if (input.value) {
    socket.emit('sendMessage', input.value); // Emitir mensaje al servidor
    input.value = ''; // Limpiar el campo de entrada
  }
};
  
onMounted(() => {
  socket.on('storeMessage', (msg) => {
    messages.value.push(msg); // Agregar mensaje recibido a la lista
  });
});

onUnmounted(() => {
  socket.off();
});
</script>

<style scoped></style>