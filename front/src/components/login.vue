<template>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <h1>LOGIN</h1>
  <div class="login-container">
    <form @submit.prevent="handleSubmit" class="login-form">

      <input type="text" required v-model="email" placeholder="Correu Electrònic" />

      <div class="password-container">
        <input :type="passwordType" class="input-field" required v-model="password" placeholder="Contrasenya" />
        <i :class="passwordIcon" @click="togglePassword"></i>
      </div>
  
      <button type="submit" class="submit-button">Iniciar Sesión</button>
    </form>

    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
  </div>
</template>

<script>
  import { useCounterStore } from '@/stores/counter';

  export default {
    data() {
      return {
        email: '',
        password: '',
        passwordType: 'password', 
        passwordIcon: 'fa fa-eye',
        passwordVisible: false,
        errorMessage: ''
      };
    },
    computed: {
      Iniciado() {
        const store = useCounterStore();
        return store.Iniciado;
      }
    },
    methods: {
      togglePassword() {
        this.passwordType = this.passwordType === 'password' ? 'text' : 'password';
        this.passwordIcon = this.passwordType === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash';
      },
      async handleSubmit() {
        const loginData = {
          email: this.email,
          password: this.password
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
            console.log("Has iniciat sessió correctament");
            location.href=("/");
          } else {
            const data = await response.json();
            this.errorMessage = data.message || 'Credenciales incorrectas';
            counterStore.clearUserData();
          }
        } catch (error) {
          this.errorMessage = 'Hubo un problema al conectar con el servidor';
          counterStore.clearUserData();
        }
      }
    }
  };
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

  input, select {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      border: 1px solid #ddd;
      background-color: #f9f9f9;
      transition: all 0.3s ease;
  }

  input:focus, select:focus {
      outline: none;
      border-color: #ff4d4d;
      background-color: #fff;
  }

  input::placeholder, select::placeholder {
      color: #aaa;
  }

  button {
      padding: 14px;
      font-size: 16px;
      font-weight: bold;
      color: white;
      background-color: #ff4d4d;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
  }

  button:hover {
      background-color: #e60000;
  }

  button:focus {
      outline: none;
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

  .password-container input:focus{
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
      input, select {
          padding: 10px;
          font-size: 14px;
      }
      button {
          font-size: 14px;
          padding: 12px;
      }
  }
</style>