const express = require('express');
const { createServer } = require('node:http');
const { Server } = require('socket.io');
const { join } = require('node:path');

const app = express();
const server = createServer(app);
const io = new Server(server, {
  cors: {
    origin: 'http://localhost:8000',
    methods: ['GET', 'POST']
  }
});

app.get('/', (req, res) => {
  res.sendFile(join(__dirname, 'index.html'));
});


io.on('connection', (socket) => {
  console.log('a user connected');
  socket.on('disconnect', () => {
    console.log('user disconnected');
  });
  socket.on('sendMessage', (msg) => {
    console.log('message: ' + msg);//añadir usuario: msg
    io.emit('storeMessage', msg);
  });
});
server.listen(3000, () => {
  console.log('server running at http://localhost:3000');
});