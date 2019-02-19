import Vue from 'vue';

const state = {
    all: {}
};

const getters = {};

const mutations = {
    SET_NOTIFICATIONS(state, notifications) {
        state.all = notifications;
    },
    REMOVE_NOTIFICATIONS(state) {
        state.all = {};
    },
};

const actions = {
    setNotifications({ commit, dispatch }) {
        Vue.http.get("/notifications")
            .then((response) => {
                    commit('SET_NOTIFICATIONS', response.body.data);
                },
                response => {
                    dispatch("infoMessages/setInfoMessageTemporary", true, { root: true });
                    dispatch("infoMessages/setInfoMessages", [response.body.message], { root: true });
                    console.log("Wooops, Something Went Wrong!");
                }
            );
    },
    removeNotifications({ commit }) {
        commit('REMOVE_NOTIFICATIONS');
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};