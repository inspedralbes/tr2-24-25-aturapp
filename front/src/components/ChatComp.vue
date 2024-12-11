<template>
  <div>
    <ul id="missatges" class="mostrar">
      <li v-for="(msg, index) in messages" :key="index">{{ msg }}</li>
    </ul>
    <input v-model="input" autocomplete="off" />
    <button @click="sendMessage">Enviar</button>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import socket from '@/services/socket.js';

const messages = ref([]);
const input = ref('');

function sendMessage() {
  if (input.value) {
    socket.emit('sendMessage', input.value);
    input.value = '';
  }
};

onMounted(() => {
  socket.on('storeMessage', (msg) => {
    messages.value.push(msg);
  });
});

onUnmounted(() => {
  socket.off();
});
</script>
<style scoped>
#missatges {
  list-style-type: none;
  padding: 0;
}

#missatges li {
  background: #f4f4f4;
  margin: 5px 0;
  padding: 10px;
  border-radius: 4px;
}

input {
  width: calc(100% - 22px);
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  padding: 10px 20px;
  background-color: #007BFF;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}

#missatges {
  list-style-type: none;
  margin: 0;
  padding: 0;
}
</style>