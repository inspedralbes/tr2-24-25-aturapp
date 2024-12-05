<template>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <br><br><br><br><br><br><br><br>
  <h1>LOGIN</h1>
  <div class="login-container">
    <form @submit.prevent="handleSubmit" class="login-form">
      <input 
        type="email" 
        placeholder="Escriu el teu email" 
        v-model="email" 
        class="input-field"
        required
      />
      
      <div class="password-container">
        <input 
          :type="passwordVisible ? 'text' : 'password'" 
          placeholder="Escriu la teva contrasenya" 
          v-model="password" 
          class="input-field" 
          required
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
    data() {
      return {
        email: '',
        password: '',
        passwordVisible: false,
        loggedIn: false,
        errorMessage: ''
      };
    },
    methods: {
      togglePasswordVisibility() {
        this.passwordVisible = !this.passwordVisible;
      },
      async handleSubmit() {
        const loginData = {
          email: this.email,
          password: this.password
        };

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
            this.loggedIn = true;
            this.errorMessage = '';
            console.log('Respuesta del servidor:', data);
          } else {
            const data = await response.json();
            this.errorMessage = data.message || 'Credenciales incorrectas';
            this.loggedIn = false;
          }
        } catch (error) {
          this.errorMessage = 'Hubo un problema al conectar con el servidor';
          this.loggedIn = false;
          console.error('Error al realizar la solicitud:', error);
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