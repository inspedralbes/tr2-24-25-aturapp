import { io } from 'socket.io-client';
// import Swal from 'sweetalert2';

// const socket = io('http://localhost:8001', {
const socket = io('http://localhost:3000', {
    reconnection: true,
    reconnectionAttempts: 10,
    reconnectionDelay: 1000,
    reconnectionDelayMax: 5000,
    randomizationFactor: 0.5
});

export default socket;