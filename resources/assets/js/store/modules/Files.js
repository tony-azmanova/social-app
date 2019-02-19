const state = {
    all: {},
    uploadedFile: [],
    resetFileInput: false,
};

const getters = {};

const mutations = {
    SET_FILES(state, files) {
        state.all = files;
    },
    RESET_FILE_INPUT(state, hasResetForm) {
        state.resetFileInput = hasResetForm;
    }
};

const actions = {
    setFiles({ commit }, files) {
        commit('SET_FILES', files);
    },
    resetFileInput({ commit }, hasResetForm) {
        commit('RESET_FILE_INPUT', hasResetForm);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};