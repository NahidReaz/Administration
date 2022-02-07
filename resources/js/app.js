/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;



/*Vue Form*/
import Form from 'vform'
import {HasError, AlertError} from 'vform/src/components/bootstrap5'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


/*Validation*/
import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user);

/*Notification*/
import Swal from 'sweetalert2';
window.Swal = Swal;
window.Toast = Toast;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

/*Vue Progresbar*/
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
  })


/*Vue Router and Functionalities*/
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import routes from './routes';

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active'
  })
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/*Vue Filter and Moment JS*/
import moment from 'moment';
Vue.filter('myDate',function(created){
    return moment(created).format('MMMM Do YYYY, h:mm:ss a');
});

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
window.Fire = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


var app = new Vue({
    el: '#app',
    router,

    data:{
        search: ''
    },

    methods:{
        searchit(){
            Fire.$emit('searching');
        }
    }
});
