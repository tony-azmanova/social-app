<template>
    <div class="card-group">
        <div class="row">
            <GalleryItem v-for="image in images" :image="image" :key="image.id"></GalleryItem>
        </div>
    </div>
</template>
<script>
import store from "../../store";
import { mapState } from "vuex";
import GalleryItem from "./GalleryItem";

export default {
  components: {
    GalleryItem
  },
  computed: {
    ...mapState({
      images: state => state.galleries.images
    })
  }
};
</script>

