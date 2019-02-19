const state = {
    all: [],
};

const getters = {};

const mutations = {

    ADD_LIKE(state, rootState) {
        rootState.posts.all.currentElement.reactions++;
        rootState.posts.all.currentElement.userHasReacted = true;
    },
    REMOVE_LIKE(state, rootState) {
        rootState.posts.all.currentElement.reactions--;
        rootState.posts.all.currentElement.userHasReacted = false;
    }
};

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