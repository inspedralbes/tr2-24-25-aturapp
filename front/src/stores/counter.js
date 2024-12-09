import { defineStore } from 'pinia';

export const useCounterStore = defineStore('counter', {
  state: () => ({
    userData: JSON.parse(localStorage.getItem('userData')) || null,
    Iniciado: JSON.parse(localStorage.getItem('loggedIn')) || false,
  }),
  actions: {
    setUserData(data) {
      this.userData = data;
      this.Iniciado = true;

      localStorage.setItem('userData', JSON.stringify(data));
      localStorage.setItem('loggedIn', JSON.stringify(true));
    },
    clearUserData() {
      this.userData = null;
      this.Iniciado = false;

      localStorage.removeItem('userData');
      localStorage.removeItem('loggedIn');
    }
  }
});