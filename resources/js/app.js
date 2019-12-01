/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('usuario-component', require('./components/UsuarioComponent.vue').default);
Vue.component('metodospago-component', require('./components/MetodosPagoComponent.vue').default);
Vue.component('proyecto-component',require('./components/ProyectosComponent.vue').default);
Vue.component('proyectocliente-component',require('./components/ProyectosClienteComponent.vue').default);
Vue.component('proyectomanager-component',require('./components/ProyectosManagerComponent.vue').default);
Vue.component('proyectoprogramador-component',require('./components/ProyectosProgramadorComponent.vue').default);
Vue.component('proyectointegrantes-component',require('./components/ProyectoIntegrantesComponent.vue').default);
Vue.component('proyectotodos-component',require('./components/ProyectoTodosComponent.vue').default);
Vue.component('aretiros-component',require('./components/AceptarPeticionComponent.vue').default);
Vue.component('retiros-component',require('./components/PeticionComponent.vue').default);
Vue.component('mretiros-component',require('./components/PeticionComponentManager.vue').default);
Vue.component('hitos-component',require('./components/HitosComponent.vue').default);
Vue.component('tareas-component',require('./components/TareasComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        menu: 0,
    }
});
