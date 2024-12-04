<template>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h1>ATURAPP</h1>
    <div class="login-container">
      <form @submit.prevent="handleSubmit" class="login-form">
        <input 
          type="email" 
          placeholder="Escriu el teu email" 
          v-model="email" 
          class="input-field"
        />
    
        <div class="password-container">
          <input 
            :type="passwordVisible ? 'text' : 'password'" 
            placeholder="Escriu la teva contrasenya" 
            v-model="password" 
            class="input-field" 
          />
          <span @click="togglePasswordVisibility" class="eye-icon"> 
            {{ passwordVisible ? '👁️' : '👁️' }}
          </span>
        </div>
  
        <button type="submit" class="submit-button">Iniciar Sesión</button>
      </form>

      <p v-if="loggedIn" class="welcome-message">Bienvenido, {{ email }}!</p>
    </div>
  </template>
  
  <script>  
  export default {
    name: "Login",
    data() {
      return {
        email: "",
        password: "",
        loggedIn: false,
        passwordVisible: false,  
      };
    },
    methods: {
      handleSubmit() {
        if (!this.email.trim() || !this.password.trim()) {
          alert("Por favor, ingresa tu email y contraseña.");
          return;
        }
  
        localStorage.setItem("email", this.email);
        localStorage.setItem("password", this.password);
        this.loggedIn = true;
      },
      togglePasswordVisibility() {
        this.passwordVisible = !this.passwordVisible;
      }
    },
    created() {
      const savedEmail = localStorage.getItem("email");
      const savedPassword = localStorage.getItem("password");
  
      if (savedEmail && savedPassword) {
        this.email = savedEmail;
        this.password = savedPassword;
        this.loggedIn = true;
      }
    },
  };
  </script>
  
  <style scoped>
  h1 {
    text-align: center;
    color: red;
    font-size: 1.8em; 
  }
  
  .login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column; 
    height: 100vh;
    padding: 10px; 
    background-color: #f5f5f5;
  }
  
  .login-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px; 
  }
  
  .input-field {
    padding: 10px;
    font-size: 1em; 
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s ease;
  }
  
  .input-field:focus {
    border-color: #ff4d4d;
    outline: none;
  }
  
  .password-container {
    position: relative;
  }
  
  .eye-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 18px;
  }
  
  .submit-button {
    padding: 10px;
    background-color: red;
    color: white;
    border: 2px solid black;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s ease;
  }
  
  .submit-button:hover {
    background-color: #d60c0c;
  }
  
  .welcome-message {
    text-align: center;
    font-size: 1.2em;
    color: green;
    margin-top: 20px;
    font-weight: bold;
  }
  
  @media (min-width: 768px) {
    .login-form {
      padding: 30px;
      gap: 20px;
    }
  
    .submit-button {
      font-size: 1.1em;
    }
  }
  </style>
  
  