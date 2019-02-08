<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
            <div class="container">
                <router-link  class="navbar-brand" :to="{ name: 'Home'}">Home</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul v-if="authUserId" class="navbar-nav mr-auto">
                        <router-link class="nav-link" :to="{ name: 'Wall', params: { mainWall: true }}">Wall</router-link>
                        <router-link class="nav-link" :to="{ name: 'UploadFiles'}">
                            <a>Upload file</a>
                        </router-link>
                        
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Galleries<span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <router-link class="dropdown-item" :to="{ name: 'Galleries'}">
                                    <a>List of all galleries</a>
                                </router-link>
                                <router-link class="dropdown-item" :to="{ name: 'NewGallery'}">
                                    <a>New gallery</a>
                                </router-link>
                            </div>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <router-link v-if="!authUserId" class="nav-link" :to="{ name: 'Login' }">
                            <a>Login</a>
                        </router-link>
                        <router-link v-if="!authUserId" class="nav-link" :to="{ name: 'Register' }">
                            <a>Register</a>
                        </router-link>

                        <li v-if="authUserId" class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ user.first_name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <router-link class="dropdown-item" :to="{ name: 'Profile', params: { userId: authUserId }}">
                                    <a>Profile</a>
                                </router-link>
                                <router-link class="dropdown-item" :to="{ name: 'UserWall', params: { userId: authUserId }}">
                                    <a>My wall</a>
                                </router-link>
                                <router-link class="dropdown-item" :to="{ name: 'Notifications'}">
                                    <a>Notifications</a>
                                </router-link>
                                <router-link class="dropdown-item" :to="{ name: 'UserFriends'}">
                                    <a>My friends</a>
                                </router-link>
                                <a class="dropdown-item" @click="logout()">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav> 
    </div>
</template>

<script>
import store from "../store";
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      authUserId: state => state.users.authUserId,
      user: state => state.users.userData
    })
  },
  methods: {
    logout() {
        this.$store.dispatch("users/logout").then(() => {
            this.$router.push("/login");
        });
    }
  }
};
</script>
