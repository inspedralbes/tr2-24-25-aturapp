<template>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <br>
  <h1>LOGIN</h1>
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
        <button 
          type="button" 
          @click="togglePasswordVisibility" 
          class="toggle-password-button">
          {{ passwordVisible ? '👁️' : '👁️' }}
        </button>
      </div>
  
      <button type="submit" class="submit-button">Iniciar Sesión</button>
    </form>

    <p v-if="loggedIn" class="welcome-message">Bienvenido, {{ email }}!</p>
    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
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
      errorMessage: "", 
    };
  },
  methods: {
    async handleSubmit() {
      if (!this.email.trim() || !this.password.trim()) {
        this.errorMessage = "Por favor, ingresa tu email y contraseña.";
        return;
      }

      try {
        const response = await fetch("https://api.example.com/auth/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        });

        const data = await response.json();

        if (!response.ok) {
          this.errorMessage = data.message || "Error en el inicio de sesión.";
          return;
        }

        localStorage.setItem("token", data.token);
        this.loggedIn = true;
        this.errorMessage = "";
      } catch (error) {
        this.errorMessage = "Ocurrió un error al intentar iniciar sesión.";
        console.error("Error en la solicitud:", error);
      }
    },
    togglePasswordVisibility() {
      this.passwordVisible = !this.passwordVisible;
    },
  },
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

h1 {
  color: #ff4d4d;
  text-align: center;
}

body {
  font-family: 'Arial', sans-serif;
  background-color: #f7f7f7;
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

.input-field {
  width: 100%;
  padding: 12px;
  font-size: 16px;
  border: 1px solid #ddd;
  background-color: #f9f9f9;
  transition: all 0.3s ease;
}

.input-field:focus {
  outline: none;
  border-color: #ff4d4d;
  background-color: #fff;
}

.input-field::placeholder {
  color: #aaa;
}

.submit-button {
  padding: 14px;
  font-size: 16px;
  font-weight: bold;
  color: white;
  background-color: #ff4d4d;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.submit-button:hover {
  background-color: #e60000;
}

.submit-button:focus {
  outline: none;
}

.password-container {
  display: flex;
  align-items: center;
}

.toggle-password-button {
  margin-left: 10px;
  padding: 5px 10px;
  font-size: 14px;
  background-color: #ff4d4d;
  color: white;
  border: none;
  cursor: pointer;
}

.toggle-password-button:hover {
  background-color: #e60000;
}

.error-message {
  color: red;
  text-align: center;
  margin-top: 10px;
}

@media (max-width: 600px) {
  form {
    width: 90%;
    margin: 20px auto;
  }
  
  .input-field {
    padding: 10px;
    font-size: 14px;
  }

  .submit-button {
    font-size: 14px;
    padding: 12px;
  }

  .toggle-password-button {
    font-size: 12px;
    padding: 5px;
  }
}
</style>
