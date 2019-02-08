<template>
    <div>
        <h1>This will be the galleries listing</h1>
        <InfoMessages></InfoMessages>
        <div class="card-group">
            <div class="row">
                <Gallery v-for="gallery in galleries" :gallery="gallery" :key="gallery.id"></Gallery>
            </div>
        </div>    
    </div>
</template>
<script>
import store from "../../store";
import { mapState } from "vuex";
import Gallery from "../gallery/Gallery";

export default {
  components: {
    Gallery
  },
  computed: {
    ...mapState({
      galleries: state => state.galleries.all
    })
  },
  beforeMount() {
    this.$store.dispatch("galleries/fetchGalleries");
  }
};
</script>