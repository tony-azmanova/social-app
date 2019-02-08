import Vue from 'vue';

const state = {
    all: {}
};

// getters
const getters = {};

// mutations
const mutations = {
    SET_FRIENDS(state, friends) {
        state.all = friends;
    },
    REMOVE_FRIENDS(state) {
        state.all = {};
    },
};

// actions
const actions = {
    fetchFriends({ commit, dispatch }) {
        Vue.http.get("/friends")
            .then((response) => {
                    commit('SET_FRIENDS', response.body.data);
                },
                response => {
                    dispatch("infoMessages/setInfoMessageTemporary", false, { root: true });
                    dispatch("infoMessages/setInfoMessages", [response.body.message], { root: true });
                    console.log("Wooops, Something Went Wrong!");
                }
            );
    },
    removeFriends({ commit }) {
        commit('REMOVE_FRIENDS');
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};