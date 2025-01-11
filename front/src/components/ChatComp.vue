<template>
  <div id="chat-container">
    <div id="encabezado">
      <h2>Jo no soc complice</h2>
      <!-- <img src="/assets/svg/escribiendo.svg" alt="escribiendo"/> -->
    </div>
    <div id="contenidor-missatges">
      <ul id="missatges" class="mostrar">
        <li v-for="(msg, index) in messages" :key="index" :class="{ propio: msg.emisor === user.id }">
          {{ msg.texto }}
        </li>
        <li id="escribiendo" :style="{ display: escribiendo.value ? 'block' : 'none' }">
          <img :src="escribiendoSvg" alt="Escribiendo">
        </li>
      </ul>
    </div>
    <!-- <input v-model="input" autocomplete="off" />
    <button @click="sendMessage">Enviar</button> -->
    <div class="input-container">
      <textarea v-model="input" rows="1" placeholder="Jo no soc complice..."
        @keydown.enter="agregarMensajeUsuario"></textarea>
      <!-- <input v-model="input" autocomplete="off" placeholder="Jo no soc complice..." /> -->
      <!-- <svg @click="sendMessage" width="35px" height="35px" viewBox="-3 0 32 32" version="1.1" -->
      <svg @click="agregarMensajeUsuario" width="35px" height="35px" viewBox="-3 0 32 32" version="1.1"
        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g id="icomoon-ignore">
        </g>
        <path
          d="M26.221 16c0-7.243-5.871-13.113-13.113-13.113s-13.113 5.87-13.113 13.113c0 7.242 5.871 13.113 13.113 13.113s13.113-5.871 13.113-13.113zM1.045 16c0-6.652 5.412-12.064 12.064-12.064s12.064 5.412 12.064 12.064c0 6.652-5.411 12.064-12.064 12.064-6.652 0-12.064-5.412-12.064-12.064z"
          fill="#000000">

        </path>
        <path d="M18.746 15.204l0.742-0.742-6.379-6.379-6.378 6.379 0.742 0.742 5.112-5.112v12.727h1.049v-12.727z"
          fill="#000000">

        </path>
      </svg>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue';
import { useCounterStore } from '../stores/counter';
import { guardarMissatgeBBDD } from '@/services/communictationManager.js';
import escribiendoSvg from '@/assets/svg/escribiendo.svg';

import socket from '@/services/socket.js';

const store = useCounterStore();
let user = store.userData.user;

const msjAutomaticos = reactive(['¿En que curso has visto el incidente?', '¿Como definirias el incidente?', '¿Donde ha ocurrido el incidente?', '¿Cuando ha ocurrido el incidente?', 'Proporciona informacion sobre las personas involucradas(relaciones, cursos)', 'Redacta la informacion que quieras compartir:']);
const messages = reactive([]);
const input = ref('');
let pausaMensaje = ref(false);
let escribiendo = reactive({ value: false, usuarioEscritor: '' });//para cuando escriba professor, falta pensarlo
let chatEnEspera = ref(false);

const agregarMensajeUsuario = (event) => {
  event.preventDefault();
  if (input.value.trim().length > 0 && !pausaMensaje.value) {
    messages.push({ texto: input.value, emisor: user.id });
    input.value = '';
    deslizarHastaAbajo();
    if (msjAutomaticos.length > 0) {
      enviarMensajeAutomatico();
    } else {
      agregarMensajeBot('En el menor tiempo posible, un miembro del equipo se pondrá en contacto contigo para solucionar la situacion. Gracias por tu colaboración.');
      chatEnEspera.value = true;
    }
  }
};

const deslizarHastaAbajo = () => {
  const contenedor = document.getElementById('contenidor-missatges');
  contenedor.scrollTop = contenedor.scrollHeight;
};

const agregarMensajeBot = (texto) => {
  messages.push({ texto, emisor: 0 });
};

const enviarMensajeAutomatico = () => {
  pausaMensaje.value = true;
  escribiendo.value = true;
  
  setTimeout(() => {
    agregarMensajeBot(msjAutomaticos.shift());
    pausaMensaje.value = false;
    escribiendo.value = false;
  }, 1000);
};

const actualizarMensaje = (msg) => {
  messages.push(msg);
};

function sendMessage() {
  if (input.value) {
    socket.emit('sendMessage', input.value);
    // guardarMissatgeBBDD(input.value);
    input.value = '';
  }
};

onMounted(() => {
  agregarMensajeBot('¿Estás seguro de que deseas publicar una alerta? En caso de uso indebido, se podrá bloquear el acceso al sistema. Para continuar, contesta las siguientes preguntas: ');
  enviarMensajeAutomatico();

  socket.on('storeMessage', (msg) => {
    messages.push(msg);
  });
});

onUnmounted(() => {
  socket.off();
});
</script>
<style scoped>
#encabezado {
  background-color: #c24513;
  color: white;
  padding: 10px;
  text-align: center;
}

#missatges {
  list-style-type: none;
  margin: 0;
  padding: 0 10px 0 0;
  display: flex;
  flex-direction: column;
}

#missatges .propio {
  align-self: flex-end;
  background-color: #4caf50;
  color: white;
  padding: 10px;
  border-radius: 5px;
  max-width: 70%;
}

#missatges li {
  align-self: flex-start;
  background-color: #e0e0e0;
  color: #333;
  padding: 10px;
  border-radius: 5px;
  max-width: 70%;
  margin: 5px 0;
}

#chat-container {
  margin: 20px;
  padding: 10px;
  width: 96vw;
  height: 85vh;
  background-color: white;
  border: 1px solid black;
  position: relative;
}

#contenidor-missatges {
  max-height: 65vh;
  overflow-y: auto
}

.input-container {
  position: absolute;
  bottom: 5%;
  right: 5%;
  width: 90%;
}

.input-container textarea {
  width: 100%;
  box-sizing: border-box;
  font-size: 14px;
  padding: 10px 60px 10px 10px;
  border-radius: 45px;
  resize: none;
}

.input-container svg {
  position: absolute;
  top: 50%;
  right: 15px;
  transform: translateY(-50%);
  cursor: pointer;
}

#escribiendo {
  display: none;
}
</style>