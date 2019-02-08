import Vue from 'vue';
import _ from "lodash";

const state = {
    all: [],
    userData: [],
    authUserId: '',
};

// getters
const getters = {
    isCurrentUser: (state) => (userId) => {
        return (state.authUserId === userId);
    },
};

// mutations
const mutations = {
    SET_AUTH_USER_ID(state, userId) {
        state.authUserId = userId;
    },
    SET_USER_AVATAR(state, avatar) {
        state.userData.avatar = avatar;
    },
    FETCH_USER_DATA(state, user) {
        state.userData = user;
    },
};

// actions
const actions = {
    setAuthUserId({ commit, dispatch }, userId) {
        commit('SET_AUTH_USER_ID', userId);
        dispatch('fetchUser', userId);
    },
    setUserAvatar({ commit }, payload) {
        commit('SET_USER_AVATAR', payload);
    },
    fetchUser({ commit }, userId) {
        if (!_.isNull(userId) || (userId !== state.authUserId)) {
            Vue.http.get("/users/" + userId).then((response) => {
                commit('FETCH_USER_DATA', response.data.data);
            });
        }
    },
    logout({ commit }) {
        Vue.http.post('/logout').then((response) => {
            commit('SET_AUTH_USER_ID', '');
            Vue.http.headers.common['X-CSRF-TOKEN'] = response.data.data;
        });
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};