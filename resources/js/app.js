// Load static files
import.meta.glob(["../images/**"]);

import Alpine from 'alpinejs';
import axios from 'axios';

window.Alpine = Alpine;

Alpine.start();

// Atur Axios secara global jika ingin digunakan di semua file
window.axios = axios;

// Konfigurasi CSRF token agar Axios menyertakannya dalam request
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}