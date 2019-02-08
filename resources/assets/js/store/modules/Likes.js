const state = {
    all: [],
};

// getters
const getters = {};

// mutations
const mutations = {

    ADD_LIKE(state, rootState) {
        rootState.posts.currentElement.reactions++;
        rootState.posts.currentElement.userHasReacted = true;
    },
    REMOVE_LIKE(state, rootState) {
        rootState.posts.currentElement.reactions--;
        rootState.posts.currentElement.userHasReacted = false;
    }
};

// actions
const actions = {
    addReaction({ state, commit, rootState }, payload) {
        if (payload.response.body.createdReaction) {
            return commit('ADD_LIKE', rootState);
        }
        return commit('REMOVE_LIKE', rootState);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};