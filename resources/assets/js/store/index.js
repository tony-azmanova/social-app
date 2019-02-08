import Vue from 'vue';
import Vuex from 'vuex';
import users from './modules/Users';
import likes from './modules/Likes';
import posts from './modules/Posts';
import flashMessages from './modules/FlashMessages';
import galleries from './modules/Galleries';
import notifications from './modules/Notifications';
import files from './modules/Files';
import infoMessages from './modules/InfoMessages';
import friends from './modules/Friends';

Vue.use(Vuex);
Vue.config.debug = true;

export default new Vuex.Store({
    modules: {
        users,
        likes,
        posts,
        flashMessages,
        notifications,
        galleries,
        files,
        infoMessages,
        friends,
    }
});