const express = require('express');
const { createServer } = require('node:http');
const { Server } = require('socket.io');
const { join } = require('node:path');

const app = express();
const server = createServer(app);
const io = new Server(server, {
  cors: {
    // origin: 'http://localhost',
    origin: 'http://localhost:5173',
    methods: ['GET', 'POST']
  }
});

const test = [];
const alumnos = new Map();
const profesores = new Map();
const alumnosEsperando = [];

app.get('/', (req, res) => {
  res.send('Todo OK');
});


io.on('connection', (socket) => {
  // socket.emit('obtenerRol');
  socket.on('connexion', (data) => {
    
    if (data.rol == 1 && !alumnos.has(socket)) {
      alumnos.set(socket, { data, profesorAsignado: null });
    } else if (data.rol == 2 && !profesores.has(socket)) {
      profesores.set(socket, { data, alumnoAsignado: null });
      //si hay algun alumno esperando, salte noti
    }
    // if (alumnos.has(socket)) {
    //   console.log(`user-alumno: ${alumnos.get(socket).data.id} connectat`);
    // } else if (profesores.has(socket)) {
    //   console.log(`user-profesor: ${profesores.get(socket).data.id} connectat`);
    // }
    console.log('Alumnos:', Array.from(alumnos.values()));
    console.log('Profesores:', Array.from(profesores.values()));
  });
  socket.on('disconnect', () => {
    if (alumnos.has(socket)) {
      alumnos.delete(socket);
    } else if (profesores.has(socket)) {
      profesores.delete(socket);
    }
    // console.log('user disconnected');
    // console.log('Alumnos:', Array.from(alumnos.values()));
    // console.log('Profesores:', Array.from(profesores.values()));
  });
  socket.on('busquedaContacto', (data) => {
    let chatAceptado = false;

    alumnosEsperando.push(socket);
    profesores.forEach((value, profSocket) => {
      if (value.alumnoAsignado === null) {
        console.log("peticionChat::emit");
        profSocket.emit('peticionChat', data);
      }
    });

    const horaInicio = Date.now();
    const timer = setTimeout(() => {
      if (!chatAceptado) {
        console.log("chatAceptado::emit");

        socket.emit('sinRespuesta', {
          mensaje: 'No se encontró un profesor disponible. Se te contactará los mas pronto posible mediante mail, puedes seguir añadiendo informacion en el chat.',
        });
      }
    }, 3 * 60 * 1000);

    // alumnosEsperando.set(socket, { timer, horaInicio });

    socket.once('chatAceptado', (id) => {
      if (chatAceptado) return;
      chatAceptado = true;
      const profSocket = getProfesorSocketById(id);
      if (profSocket) {
        profesores.get(profSocket).alumnoAsignado = socket;
        alumnos.get(socket).profesorAsignado = profSocket;
        socket.emit('connexionChats');
        socket.once('compartirChat', (mensajes) => {
          profSocket.emit('cargarChat', mensajes);
        });
        clearTimeout(timer);
        usuariosEnEspera.has();
      } else {
        console.log('Error al buscar el socket del profesor mediante id');
      }
    });
  });

  socket.on('sendMessage', (msg) => {
    let socketAfiliado = null;
    if (alumnos.has(socket)) {
      socketAfiliado = alumnos.get(socket).profesorAsignado;
    } else if (profesores.has(socket)) {
      socketAfiliado = profesores.get(socket).alumnoAsignado;
    }
    socketAfiliado.emit('storeMessage', msg);
    console.log('message: ' + msg);
  });

  socket.on('test')
});

function getProfesorSocketById(profesorId) {
  for (const [socket, info] of profesores.entries()) {
    if (info.data.id === profesorId) {
      return socket;
    }
  }
  return null;
}

server.listen(3000, () => {
  console.log('server running at http://localhost:3000');
});