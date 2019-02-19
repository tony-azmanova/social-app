import Vue from 'vue';

const state = {
    all: {
        errors: {},
        success: {
            message: ''
        },
        info: {},
        notifications: {},
    },
    successStatus: false,
};

const getters = {};

const mutations = {
    SET_ERRORS(state, errors) {
        state.all.errors = errors;
    },
    REMOVE_ERRORS(state) {
        state.all.errors = {};
    },
    SET_SUCCESS(state, successMessage) {
        state.all.success.message = successMessage;
    },
    REMOVE_SUCCESS(state) {
        state.all.success = {};
    },
    SET_SUCCESS_STATUS(state, successStatus) {
        state.successStatus = successStatus;
    },
    REMOVE_SUCCESS_STATUS(state, successStatus) {
        state.successStatus = successStatus;
    },
};

const actions = {
    setErrors({ commit, dispatch }, errors) {
        commit('SET_ERRORS', errors);
        commit('SET_SUCCESS_STATUS', false);
        dispatch("removeErrors");
    },
    removeErrors({ commit }) {
        let hasErrors = Object.keys(state.all.errors) ? Object.keys(state.all.errors).length : 0;
        if (hasErrors > 0) {
            setTimeout(() => {
                commit('REMOVE_ERRORS', {});
            }, 3000);
        }
    },
    setSuccess({ commit, dispatch }, successMessage) {
        commit('SET_SUCCESS_STATUS', true);
        commit('SET_SUCCESS', successMessage);
        dispatch("removeSuccess");
    },
    removeSuccess({ commit }) {
        let hasSuccess = Object.keys(state.all.success) ? Object.keys(state.all.success).length : 0;
        if (hasSuccess > 0) {
            setTimeout(() => {
                commit('REMOVE_SUCCESS', {});
            }, 3000);
        }
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};