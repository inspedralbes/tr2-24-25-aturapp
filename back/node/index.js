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


const alumnos = new Map();
const profesores = new Map();

app.get('/', (req, res) => {
  res.send('Todo OK');
});


io.on('connection', (socket) => {
  console.log('a user connected');
  socket.emit('obtenerRol');
  socket.on('rol', (data) => {
    if (data.rol == 1) {
      alumnos.set(socket, { data, profesorAsignado: null });
    } else {
      profesores.set(socket, { data, alumnoAsignado: null });
    }
  });
  socket.on('disconnect', () => {
    if (alumnos.has(socket)) {
      alumnos.delete(socket);
    } else if (profesores.has(socket)) {
      profesores.delete(socket);
    }
    console.log('user disconnected');
  });
  socket.on('busquedaContacto', (data) => {
    let chatAceptado = false;

    profesores.forEach((value, profSocket) => {
      if (value.alumnoAsignado === null) {
        profSocket.emit('peticionChat', data);
      }
    });

    const timer = setTimeout(() => {
      if (!chatAceptado) {
        socket.emit('sinRespuesta', {
          mensaje: 'No se encontró un profesor disponible. Se te contactará los mas pronto posible mediante mail, puedes seguir añadiendo informacion en el chat.',
        });
      }
    }, 3 * 60 * 1000);

    socket.on('chatAceptado', (id) => {
      if (chatAceptado) return;
      chatAceptado = true;
      const profSocket = getProfesorSocketById(id);
      if (profSocket) {
        profesores.get(profSocket).alumnoAsignado = socket;
        alumnos.get(socket).profesorAsignado = profSocket;
        socket.emit('connexionChats');
        socket.on('compartirChat', (mensajes) => {
          profSocket.emit('cargarChat', mensajes);
        });
        clearTimeout(timer);
      } else {
        console.log('Error al buscar el socket del profesor mediante id');
      }
    });
  });

  socket.on('sendMessage', (msg) => {
    if (alumnos.has(socket)) {
      const profesorSocket = alumnos.get(socket).profesorAsignado;
      if (profesorSocket) {
        profesorSocket.emit('storeMessage', msg);
      }
    }else if (profesores.has(socket)) {
      const alumnoSocket = profesores.get(socket).alumnoAsignado;
      if (alumnoSocket) {
        alumnoSocket.emit('storeMessage', msg);
      }
    }
    console.log('message: ' + msg);
    io.emit('storeMessage', msg);
  });
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