import { io } from 'socket.io-client';
import Swal from 'sweetalert2';

// const socket = io('http://localhost:8001', {
const socket = io('http://localhost:3000', {
    reconnection: true,
    reconnectionAttempts: 10,
    reconnectionDelay: 1000,
    reconnectionDelayMax: 5000,
    randomizationFactor: 0.5
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

export default socket;