<template>
  <div>
      <h1>New gallery</h1>
      <InfoMessages></InfoMessages>
      <GalleryItems></GalleryItems>
      <NewGalleryForm></NewGalleryForm>
  </div>

</template>
<script>
import store from "../../store";
import { mapState } from "vuex";
import GalleryItems from "./GalleryItems";
import NewGalleryForm from "./NewGalleryForm";

export default {
  components: {
    GalleryItems,
    NewGalleryForm
  },
  beforeMount() {
    this.$store.dispatch("galleries/fetchUserUploadedImages");
    this.$store.dispatch("galleries/fetchGalleries");
  }
};
</script>



