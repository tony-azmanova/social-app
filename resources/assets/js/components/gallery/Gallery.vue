<template>
    <div class="card" style="width: 18rem;">
        <img class="card-img-top img-thumbnail" :src="galleryLastImage" alt="Card image cap">
        <div class="card-body">
            <router-link :to="{ name: 'SingleGallery', params: { id:gallery.id } }">
              <h5 class="card-title">{{ gallery.name }}</h5>
            </router-link>
            <p>Total images in gallery: {{ galleryImagesCount }}</p>
            <router-link class="btn btn-primary" :to="{ name: 'SingleGallery', params: { id:gallery.id } }">
              <a>View Gallery</a>
            </router-link>
        </div>
    </div>
</template>
<script>
import store from "../../store";
import { mapState, mapGetters } from "vuex";
import _ from "lodash";

export default {
  props: {
    gallery: {
      type: Object,
      required: true
    }
  },
  data: function() {
    return {
      galleryImagesCount: '',
      galleryLastImage: '',
    };
  },
  computed: {
    ...mapGetters({
      getGalleryImagesCount: 'galleries/countImagesInGallery',
      fingLatestImageInGallery: 'galleries/fingLatestImageInGallery',
    })
  },
  beforeMount(){
    this.galleryImagesCount = this.getGalleryImagesCount(this.gallery);
    this.galleryLastImage = this.fingLatestImageInGallery(this.gallery);
  },
  beforeUpdate(){
    this.galleryImagesCount = this.getGalleryImagesCount(this.gallery);
    this.galleryLastImage = this.fingLatestImageInGallery(this.gallery);
  }
};
</script>
