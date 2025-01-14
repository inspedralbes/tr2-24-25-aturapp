<template>
  <div id="chat-container">
    <div id="encabezado">
      <h2>Jo no soc complice</h2>
    </div>
    <div id="contenedor-mensajes">
      <ul id="missatges" class="mostrar">
        <li v-for="(msg, index) in messages" :key="msg.id" :id="msg.id" :class="{ propio: msg.emisor === user.id || (msg.emisor === 0 && user.rol ===2), servidor: msg.emisor === -1 }">
          <template v-if="msg.editando">
            <input class="editorMsj" v-model="msjEditado" />
            <div class="operacionesMsj">
              <button @click="actualizarMensaje(msg)">Guardar</button>
              <button @click="cancelarEdicion(msg)">Cancelar</button>
            </div>
          </template>
          <template v-else>
            {{ msg.texto }}
          </template>
          <template v-if="msg.editado && !msg.editando">
            <div class="msjEditado">editado</div>
          </template>
          <button class="botonEditar" @click="editarMensaje(msg)"><img :src="botonEditar" alt="editar"></button>
        </li>
        <li id="escribiendo" :style="{ display: escribiendo.value ? 'block' : 'none' }">
          <img :src="escribiendoSvg" alt="Escribiendo">
        </li>
      </ul>
    </div>
    <div class="input-container">
      <textarea v-model="input" rows="1" placeholder="Jo no soc complice..."
        @keydown.enter="agregarMensajeUsuario"></textarea>
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
import { ref, reactive, onMounted, onUnmounted, nextTick } from 'vue';
import { useCounterStore } from '../stores/counter';
import { guardarChatBBDD, guardarMissatgeBBDD } from '@/services/communictationManager.js';
import escribiendoSvg from '@/assets/svg/escribiendo.svg';
import botonEditar from '@/assets/svg/botonEditar.svg';
import { v4 as uuidv4 } from 'uuid';
import Swal from 'sweetalert2';

import socket from '@/services/socket.js';

const store = useCounterStore();
let user = store.userData.user;

const msjAutomaticos = reactive(['Has visto o has sufrido el incidente?', '¿En que curso ha sucedido el incidente?', '¿Como definirias el incidente?', '¿Donde ha ocurrido el incidente?', '¿Cuando ha ocurrido el incidente?', 'Proporciona informacion sobre las personas involucradas(relaciones, cursos)', 'En el menor tiempo posible, un miembro del equipo se pondrá en contacto contigo para solucionar la situacion. Gracias por tu colaboración. Redacta la informacion que quieras añadir.']);
const messages = reactive([]);
const input = ref('');
let msjEditado = ref('');
let pausaMensaje = ref(false);
let escribiendo = reactive({ value: false});
let chatEnEspera = ref(false);
let chatConBot = ref(true);

const agregarMensajeUsuario = (event) => {
  event.preventDefault();
  if (input.value.trim().length > 0 && !pausaMensaje.value) {
    messages.push({ id: uuidv4(), texto: input.value, emisor: user.id, editando: false, editado: false });
    input.value = '';
    
    if (chatConBot.value) {
      if (msjAutomaticos.length > 1) {
        enviarMensajeAutomatico();
      } else if (msjAutomaticos.length === 1) {
        enviarMensajeAutomatico();
        chatEnEspera.value = true;
        busquedaContacto();
        // guardarChatBBDD();//hay que hacer
      }      
    }else{
      socket.emit('sendMessage', messages[messages.length - 1]);
      //guardar en la base de datos cada mensaje enviado
    }
    deslizarHastaAbajo();
  }
};

const deslizarHastaAbajo = () => {
  nextTick(() => {
    const contenedor = document.getElementById('contenedor-mensajes');
    contenedor.scrollTop = contenedor.scrollHeight;
  });
};

const agregarMensajeBot = (texto) => {
  messages.push({ id: uuidv4(), texto, emisor: 0, editando: null, editado: null });
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

const editarMensaje = (msg) => {
  msg.editando = true;
  msjEditado.value = msg.texto;
};

const actualizarMensaje = (msg) => {
  msg.texto = msjEditado.value;
  msg.editado = true;
  msg.editando = false;
};

const cancelarEdicion = (msg) => {
  msg.editando = false;
};

const busquedaContacto = () => {
  socket.emit('busquedaContacto', user);
};

onMounted(() => {
  agregarMensajeBot('¿Estás seguro de que deseas publicar una alerta? En caso de uso indebido, se podrá bloquear el acceso al sistema. Para continuar, contesta las siguientes preguntas: ');
  enviarMensajeAutomatico();

  socket.on('storeMessage', (msg) => {
    messages.push(msg);
    //
  });

  socket.on('obtenerRol', () => {
    console.log('servidor solicita rol del usuario' + user.id);
    socket.emit('rol', { id: user.id, rol: user.rol });
  });

  socket.on('peticionChat', () => {
    Swal.fire({
      title: "Un alumno esta intentando iniciar un chat, quieres aceptarlo?",
      width: 600,
      showDenyButton: true,
      confirmButtonText: "Aceptar",
      denyButtonText: `Rechazar`
    }).then((result) => {
      const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
      });
      if (result.isConfirmed) {
        Toast.fire({
          icon: "success",
          title: "Chat aceptado"
        });
        socket.emit('chatAceptado', user.id);
      } else if (result.isDenied) {
        Toast.fire({
          icon: "error",
          title: "Chat rechazado"
        });
      }
    });
  });

  socket.on('sinRespuesta', (res) => {
    //añadir proceso de guardar en la seccion de no respondidos de los admin con mis datos para que me puedan contactar
    alert('error');//esto va
    console.log(res);
  });

  socket.on('connexionChats', () => {
    chatEnEspera.value = false;
    chatConBot.value = false;
    messages.push({ id: uuidv4(), texto: "chat iniciado", emisor: -1, editando: null, editado: null });
    socket.emit('compartirChat', messages); 
  });

  socket.on('cargarChat', (mensajes) => {
    chatEnEspera.value = false;
    chatConBot.value = false;
    messages.splice(0, messages.length, ...mensajes);
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

/* quitar cosas que sobran */
#missatges li.servidor {
  background-color: #f0f0f0; /* Gris claro */
  color: #333; /* Texto oscuro para contraste */
  width: 100%; /* Ocupa todo el ancho disponible */
  padding: 10px; /* Espaciado interior */
  border-radius: 8px; /* Bordes redondeados */
  margin: 5px 0; /* Margen entre los mensajes */
  box-sizing: border-box; /* Asegura que el padding y el border no afecten al ancho */
  text-align: center; /* Alinea el texto horizontalmente en el centro */
  display: flex; /* Utiliza flexbox para alinear el contenido */
  justify-content: center; /* Centra el contenido horizontalmente */
  align-items: center; /* Centra el contenido verticalmente (si hay más de una línea de texto) */
  align-self: center; /* Centra el mensaje en el contenedor */
}

#missatges .propio {
  position: relative;
  align-self: flex-end;
  background-color: #4caf50;
  color: white;
  padding: 10px;
  border-radius: 5px;
  max-width: 70%;
}

#missatges .propio .botonEditar {
  padding: 5px;
  background-color: white;
  max-width: 70%;
}

#missatges .propio:hover .botonEditar {
  display: block;
}

#missatges .botonEditar {
  display: none;
  position: absolute;
  top: 50%;
  left: -35px;
  transform: translateY(-50%);
  background-color: #f5f5f5;
  border: 0;
  cursor: pointer;
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

.editorMsj {
  all: unset;
  background: transparent;
  border: none;
  font-family: inherit;
  font-size: inherit;
  line-height: inherit;
  padding: 0;
  margin: 0;
  width: 100%;
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

#contenedor-mensajes {
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

.operacionesMsj {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}

.operacionesMsj button {
  padding: 5px 15px;
  border: none;
  cursor: pointer;
  font-size: 14px;
  font-weight: bold;
  border-radius: 10px;
  transition: background-color 0.3s ease;
}

.operacionesMsj button:hover {
  opacity: 0.8;
}

.operacionesMsj button:active {
  transform: scale(0.98);
}

.operacionesMsj button:nth-child(1) {
  background-color: white;
  color: black;
}

.operacionesMsj button:nth-child(1):hover {
  background-color: #e0e0e0;
}

.operacionesMsj button:nth-child(2) {
  background-color: black;
  color: white;
}

.operacionesMsj button:nth-child(2):hover {
  background-color: #333;
}

.msjEditado {
  font-size: 12px;
  color: black;
  font-style: italic;
  margin-top: 4px;
}
</style>