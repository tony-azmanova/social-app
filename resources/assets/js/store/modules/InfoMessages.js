import Vue from 'vue';

const state = {
    all: {},
    temporary: true,
};

// getters
const getters = {};

// mutations
const mutations = {
    SET_INFO_MESSAGES(state, infoMessages) {
        state.all = infoMessages;
    },
    REMOVE_INFO_MESSAGES(state) {
        state.all = {};
    },
    SET_INFO_MESSAGE_TEMPORARY(state, isTemporary) {
        state.temporary = isTemporary;
    }
};

// actions
const actions = {
    setInfoMessages({ commit, dispatch }, infoMessage) {
        commit('REMOVE_INFO_MESSAGES');
        commit('SET_INFO_MESSAGES', infoMessage);
        if (state.temporary) {
            dispatch('removeInfoMessages');
        }
    },
    removeInfoMessages({ commit }) {
        if (Object.keys(state.all).length > 0) {
            setTimeout(() => {
                commit('REMOVE_INFO_MESSAGES');
            }, 5000);
        }
    },
    setInfoMessageTemporary({ commit }, isTemporary) {
        commit('SET_INFO_MESSAGE_TEMPORARY', isTemporary);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};