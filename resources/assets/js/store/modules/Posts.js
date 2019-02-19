import Vue from "vue";

const state = {
    all: {
        posts: [],
        currentElement: {},
        comments: [],
    },
};

const getters = {};

const mutations = {
    SET_POSTS(state, posts) {
        state.all.posts = posts;
    },
    SET_COMMENTS(state, comments) {
        state.all.comments = comments;
    },
    SET_CURRENT_ELEMENT(state, element) {
        state.all.currentElement = element;
    },
    SET_NEW_POST(state, post) {
        state.all.posts.unshift(post);
    },
    SET_NEW_COMMENT(state, comment) {
        state.all.comments.push(comment);
    },
};

const actions = {
    setComments({ commit }, comments) {
        commit("SET_COMMENTS", comments);
    },
    stateChanged({ commit, dispatch }, payload) {
        commit("SET_CURRENT_ELEMENT", payload.element);
        dispatch("likes/addReaction", { element: payload.element, response: payload.response }, { root: true });
    },
    getPost({ commit }, payload) {
        commit("SET_CURRENT_ELEMENT", payload);
    },
    fetchPosts({ commit, dispatch }, userId) {
        Vue.http.get("/userWall/" + userId).then((response) => {
                commit("SET_POSTS", response.data.data);
            },
            response => {
                commit("SET_POSTS", []);
                dispatch("infoMessages/setInfoMessageTemporary", false, { root: true });
                dispatch("infoMessages/setInfoMessages", [response.body.message], { root: true });
                console.log("Wooops, Something Went Wrong!");
            }
        );
    },
    fetchPostsMainWall({ commit, dispatch }) {
        Vue.http.get("/userWall").then((response) => {
                commit("SET_POSTS", response.data.data);
            },
            response => {
                commit("SET_POSTS", []);
                dispatch("infoMessages/setInfoMessageTemporary", true, { root: true });
                dispatch("infoMessages/setInfoMessages", [response.body.message], { root: true });
                console.log("Wooops, Something Went Wrong!");
            }
        );
    },
    setNewPost({ commit }, post) {
        commit("SET_NEW_POST", post);
    },
    setNewComment({ commit }, comment) {
        commit("SET_NEW_COMMENT", comment);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};