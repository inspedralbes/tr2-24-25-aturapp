<template>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <h1>LOGIN</h1>
  <div id="containLogin" class="d-flex f-column align-center j-center">
    <form @submit.prevent="handleSubmit">
      <input type="text" required v-model="email" placeholder="Correu Electrònic" />

      <div class="password-container">
        <input :type="passwordType" class="input-field" required v-model="password" placeholder="Contrasenya" />
        <i :class="passwordIcon" @click="togglePassword"></i>
      </div>

      <button type="submit" class="submit-button">Iniciar Sesión</button>
    </form>
    <div class="d-flex j-center align-center no-margin">
      <button class="btn-register" @click="router.push(`/register`)">Registrarse</button>
    </div>
    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>

    <div v-if="Iniciado">
      <p><strong>Bienvenido, {{ userData.name }}</strong></p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue';
import { useCounterStore } from '../stores/counter';
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const passwordType = ref("password");
const passwordIcon = ref("fa fa-eye");
// const passwordVisible = false;
const errorMessage = ref('');

const router = useRouter();
const counterStore = useCounterStore();

const Iniciado = computed(() => counterStore.Iniciado);
const userData = computed(() => counterStore.userData);

function togglePassword() {
  passwordType.value = passwordType.value === 'password' ? 'text' : 'password';
  passwordIcon.value = passwordType.value === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash';
}

async function handleSubmit() {
  const loginData = {
    email: email.value,
    password: password.value
  };
  const counterStore = useCounterStore();

  try {
    const response = await fetch('http://localhost:8000/api/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(loginData)
    });

    if (response.ok) {
      const data = await response.json();
      counterStore.setUserData(data);

      await nextTick();

      location.href = "/home";
    } else {
      const data = await response.json();
      errorMessage.value = data.message || 'Credenciales incorrectas';
      counterStore.clearUserData();
    }
  } catch (error) {
    errorMessage.value = 'Hubo un problema al conectar con el servidor';
    console.error(error);
    counterStore.clearUserData();
  }
}
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Arial', sans-serif;
  background-color: #f7f7f7;
}

h1 {
  margin-top: 30px;
  color: #ff4d4d;
  text-align: center;
}

p {
  font-size: 20px;
}

form {
  display: flex;
  flex-direction: column;
  gap: 15px;
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  background-color: #fff;
  width: 100%;
}

input,
select {
  width: 100%;
  padding: 12px;
  font-size: 16px;
  border: 1px solid #ddd;
  background-color: #f9f9f9;
  transition: all 0.3s ease;
}

input:focus,
select:focus {
  outline: none;
  border-color: #ff4d4d;
  background-color: #fff;
}

input::placeholder,
select::placeholder {
  color: #aaa;
}

button {
  padding: 14px;
  font-size: 16px;
  font-weight: bold;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:focus {
  outline: none;
}

.submit-button {
  color: white;
  background-color: #ff4d4d;
}

.submit-button:hover {
  background-color: #e60000;
}

.password-container {
  display: flex;
  align-items: center;
  background: #f9f9f9;
  border: 1px solid #ddd;
}

.password-container input {
  border: 0;
  width: 90%;
  border: 1px solid rgba(255, 255, 255, 0);
  background: #f9f9f9;
  padding: 12px;
}

.password-container input:focus {
  border: 1px solid red;
}

.password-container i {
  width: 10%;
  text-align: center;
  padding: 12px 0;
  cursor: pointer;
  background-color: #f9f9f9;
}

@media (max-width: 600px) {
  form {
    width: 90%;
    margin: 20px auto;
  }

  input,
  select {
    padding: 10px;
    font-size: 14px;
  }

  button {
    font-size: 14px;
    padding: 12px;
  }
}

#containLogin {
  margin-top: 20px;
}

#containLogin form {
  margin: 0;
  padding: 0;
  width: 320px;
}

.btn-register {
  margin-top: 10px;
  width: 320px;
  background-color: white;
  border: 1px solid #e60000;
  color: #e60000;
}
</style>
