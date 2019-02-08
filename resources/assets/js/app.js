/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
import store from "../js/store";
import VueRouter from 'vue-router';
import { routes } from './routes';
import 'animate.css/animate.min.css';

Vue.use(require('vue-resource'));
Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('App', require('./components/App.vue').default);
Vue.component('Wall', require('./components/Wall.vue').default);
Vue.component('Comments', require('./components/Comments.vue').default);
Vue.component('SinglePost', require('./components/SinglePost.vue').default);
Vue.component('Likes', require('./components/Likes.vue').default);
Vue.component('SearchResults', require('./components/SearchResults.vue').default);
Vue.component('UserInfo', require('./components/UserInfo.vue').default);
Vue.component('Errors', require('./components/common/Errors.vue').default);
Vue.component('Success', require('./components/common/Success.vue').default);
Vue.component('Profile', require('./components/profile/Profile.vue').default);
Vue.component('TopNavigation', require('./components/TopNavigation.vue').default);
Vue.component('Notifications', require('./components/common/Notifications.vue').default);
Vue.component('InfoMessages', require('./components/common/InfoMessages.vue').default);
Vue.component('UserWall', require('./components/UserWall.vue').default);
Vue.component('MainWall', require('./components/MainWall.vue').default);
Vue.component('Galleries', require('./components/gallery/Galleries.vue').default);
Vue.component('NewGallery', require('./components/gallery/NewGallery.vue').default);
Vue.component('Modal', require('./components/common/Modal.vue').default);
Vue.component('UserFriends', require('./components/UserFriends.vue').default);

const app = new Vue({
    el: '#app-main',
    store,
    router,
});