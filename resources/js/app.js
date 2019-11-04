/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const _ = require('lodash');

window.Vue = require('vue');
Vue.use(require('vue-chat-scroll'));


import Vue from 'vue';
import Gravatar from 'vue-gravatar';
 // để dùng gravatar trong vue
Vue.component('v-gravatar', Gravatar);

import VTooltip from 'v-tooltip'
 
Vue.use(VTooltip)//để dùng v-tooltip hỗ trợ linh hoạt các popup và những tùy chỉnh khác

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const VueUploadComponent = require('vue-upload-component')
Vue.component('file-upload', VueUploadComponent)//Vue-upload-component

Vue.component('chat-component', require('./components/ChatComponent.vue').default);
Vue.component('message-component', require('./components/MessageComponent.vue').default);
Vue.component('input-component', require('./components/InputComponent.vue').default);
Vue.component('dropdown', require('./components/DropDown.vue').default);
Vue.component('friend-dropdown', require('./components/FriendDropDown.vue').default);
Vue.component('group-dropdown', require('./components/GroupDropDown.vue').default);
Vue.component('group-component', require('./components/GroupComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
