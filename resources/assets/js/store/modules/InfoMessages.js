import Vue from 'vue';

const state = {
    all: {},
    temporary: true,
};

const getters = {};

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

const actions = {
    setInfoMessages({ commit, dispatch }, infoMessage) {
        commit('SET_INFO_MESSAGES', infoMessage);
        if (state.temporary) {
            dispatch('removeInfoMessages');
        }
    },
    removeInfoMessages({ commit }) {
        let hasErrors = Object.keys(state.all) ? Object.keys(state.all).length : 0;
        if (hasErrors > 0) {
            setTimeout(() => {
                commit('REMOVE_INFO_MESSAGES', {});
            }, 3000);
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