<template>
    <div v-if="galleries.images" class="newGallery">
        <Errors></Errors>
        <Success></Success>
        <div class="countSelected" >Selected images : {{ selectedImagesCount }}</div>
        <form v-on:submit.prevent="onAddToGallery">
          <select @change="gallerySelector()" v-model="selectGallery">
              <option value="" disabled selected>Select gallery</option>
              <option  id="new-gallery" :value="addNewGallery">Add new Gallery</option>
              <option v-for="gallery in galleries" :gallery="gallery" :value="gallery.id" :key="gallery.id">{{gallery.name}}</option>
          </select>
          <button class="btn btn-primary" id="add-to-gallery-submit" type="submit">Add To Gallery</button>
        </form>
        <form v-if="showElement" v-on:submit.prevent="onAddNewGallery">
          <input v-model="galleryName" type="text" class="form-control" id="galleryName" name="galleryName" value="" placeholder="Gallery name">
          <button class="btn btn-primary" id="new-gallery-submit" type="submit">Add New Gallery</button>
        </form>
    </div>
</template>

<script>
import store from "../../store";
import { mapState, mapGetters } from "vuex";

export default {
  data: function() {
    return {
      galleryName: "",
      addNewGallery: "addNewGallery",
      selectGallery: "",
      showElement: false
    };
  },
  computed: {
    ...mapState({
      galleries: state => state.galleries.all
    }),
    ...mapGetters({
      selectedImages: "galleries/filterOnlyUniqueIds",
      selectedImagesCount: "galleries/countSelectedImages"
    })
  },
  methods: {
    gallerySelector() {
      this.$store.dispatch("galleries/setSelectedGallery", this.selectGallery);

      return (this.showElement =
        this.selectGallery === this.addNewGallery ? !this.showElement : false);
    },
    onAddNewGallery() {
      console.log("Addding New Gallery Name", this.galleryName);
      this.$http
        .post("/galleries", {
          galleryName: this.galleryName
        })
        .then(
          response => {
            this.$store.dispatch("galleries/setNewGallery", {
              name: this.galleryName,
              id: response.data.data.id,
              user_id: response.data.data.userId
            });

            this.selectGallery = response.data.data.id;
            this.galleryName = "";
            this.showElement = false;
            this.$store.dispatch(
              "flashMessages/setSuccess",
              response.data.message
            );
          },
          response => {
            this.$store.dispatch(
              "flashMessages/setErrors",
              response.data.errors
            );
            console.log("Wooops, Something Went Wrong!");
          }
        );
    },
    onAddToGallery() {
      console.log("Add Images to gallery :");
      this.$http
        .post("/galleries/addToGallery", {
          galleryId: this.selectGallery,
          images: this.selectedImages
        })
        .then(
          response => {
            this.$store.dispatch("galleries/clearSelectedImages");
            this.$store.dispatch(
              "flashMessages/setSuccess",
              response.data.message
            );
            this.selectGallery = "";
          },
          response => {
            this.$store.dispatch(
              "flashMessages/setErrors",
              response.data.errors
            );
            console.log("Wooops, Something Went Wrong!");
          }
        );
    }
  }
};
</script>
