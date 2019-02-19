import Vue from 'vue';
import _ from "lodash";

const state = {
    all: [],
    images: [],
    selectedImages: [],
    selectedGallery: [],
    currentGallery: [],
};

const NO_IMAGE_FOUND_PATH = '/storage/files/images/default/no_image_found.png';

const getters = {
    filterOnlyUniqueIds: (state) => {
        return _.uniq(state.selectedImages, 'id');
    },
    countSelectedImages: (state, getters) => {
        return getters.filterOnlyUniqueIds.length;
    },
    findSelectedImageById: (state) => (id) => {
        return state.selectedImages.find(image => image.id === id);
    },
    countImagesInGallery: (state) => (gallery) => {
        return gallery.images === null ? 0 : gallery.images.length;
    },
    fingLatestImageInGallery: (state) => (gallery) => {
        return gallery.images === null ? NO_IMAGE_FOUND_PATH : _.last(gallery.images).thumbnail;
    },
    findGalleryById: (state) => (id) => {
        return state.all.find(gallery => gallery.id === id);
    },
};

const mutations = {
    SET_GALLERIES(state, galleries) {
        state.all = galleries;
    },
    SET_USER_IMAGES(state, images) {
        state.images = images;
    },
    SET_NEW_GALLERY(state, gallery) {
        state.all.push(gallery);
    },
    ADD_TO_SELECTED_IMAGES(state, imageId) {
        state.selectedImages.push(imageId);
    },
    REMOVE_FROM_SELECTED_IMAGES(state, imageId) {
        state.selectedImages.splice(state.selectedImages.indexOf(imageId), 1);
    },
    REMOVE_FROM_USER_IMAGES(state, imageId) {
        let index = state.images.map(image => image.info.id).indexOf(imageId);
        state.images.splice(index, 1);
    },
    CLEAR_SELECTED_IMAGES(state) {
        state.selectedImages = [];
    },
    SET_SELECTED_GALLERY(state, gallery) {
        state.selectedGallery = gallery;
    },
    SET_CURRENT_GALLERY(state, gallery) {
        state.currentGallery = gallery;
    },
};

const actions = {
    setNewGallery({ commit }, gallery) {
        commit('SET_NEW_GALLERY', gallery);
    },
    fetchGalleries({ commit, dispatch }) {
        Vue.http.get("/galleries").then((response) => {
                commit('SET_GALLERIES', response.data.data);
            },
            response => {
                dispatch("infoMessages/setInfoMessageTemporary", true, { root: true });
                dispatch("infoMessages/setInfoMessages", [response.body.message], { root: true });
                console.log("Wooops, Something Went Wrong!");
            });
    },
    fetchUserUploadedImages({ commit, dispatch }) {
        Vue.http.get("/galleries/create").then((response) => {
                commit('SET_USER_IMAGES', response.data.data);
            },
            response => {
                dispatch("infoMessages/setInfoMessageTemporary", true, { root: true });
                dispatch("infoMessages/setInfoMessages", [response.body.message], { root: true });
                console.log("Wooops, Something Went Wrong!");
            }
        );
    },
    addToSelectedImages({ commit }, imageId) {
        commit('ADD_TO_SELECTED_IMAGES', imageId);
    },
    removeFromSelectedImages({ commit }, imageId) {
        commit('REMOVE_FROM_SELECTED_IMAGES', imageId);
    },
    removeFromUserImages({ commit }, imageId) {
        commit('REMOVE_FROM_SELECTED_IMAGES', imageId);
        commit('REMOVE_FROM_USER_IMAGES', imageId);
    },
    setSelectedGallery({ commit }, gallery) {
        commit('SET_SELECTED_GALLERY', gallery);
    },
    clearSelectedImages({ commit }) {
        commit('CLEAR_SELECTED_IMAGES');
    },
    setCurrentGallery({ commit }, gallery) {
        commit('SET_CURRENT_GALLERY', gallery);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};