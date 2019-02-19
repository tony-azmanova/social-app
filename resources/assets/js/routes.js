import SinglePost from './components/SinglePost.vue';
import MainWall from './components/MainWall.vue';
import UserWall from './components/UserWall.vue';
import Profile from './components/profile/Profile.vue';
import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';
import Galleries from './components/gallery/Galleries.vue';
import SingleGallery from './components/gallery/SingleGallery.vue';
import NewGallery from './components/gallery/NewGallery.vue';
import UploadFiles from './components/files/Upload.vue';
import Notifications from './components/common/Notifications.vue';
import UserFriends from './components/UserFriends.vue';
import Home from './components/Home.vue';

export const routes = [{
        path: '/',
        component: Home,
        name: 'Home',
        alias: '/semi-spa/home'
    },
    {
        path: '/login',
        component: Login,
        name: 'Login'
    },
    {
        path: '/register',
        component: Register,
        name: 'Register'
    },
    {
        path: '/semi-spa/walls/',
        component: MainWall,
        name: 'Wall',
        props: true
    },
    {
        path: '/semi-spa/user-wall/:userId?',
        component: UserWall,
        name: 'UserWall',
        props: true
    },
    {
        path: '/semi-spa/posts/:id',
        component: SinglePost,
        name: 'SinglePost',
        props: true
    },
    {
        path: '/semi-spa/my-profile',
        component: Profile,
        name: 'Profile',
        props: true
    },
    {
        path: '/semi-spa/galleries',
        component: Galleries,
        name: 'Galleries'
    },
    {
        path: '/semi-spa/galleries/new',
        component: NewGallery,
        name: 'NewGallery'
    },
    {
        path: '/semi-spa/galleries/:id',
        component: SingleGallery,
        name: 'SingleGallery',
        props: true
    },
    {
        path: '/semi-spa/files/upload',
        component: UploadFiles,
        name: 'UploadFiles'
    },
    {
        path: '/semi-spa/notifications',
        component: Notifications,
        name: 'Notifications'
    },
    {
        path: '/semi-spa/my-friends',
        component: UserFriends,
        name: 'UserFriends'
    },
];