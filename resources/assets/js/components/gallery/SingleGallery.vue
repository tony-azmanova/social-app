<template>
    <div>
        <div v-if="loading" style="font-size: 16pt; color: #ff0000; ">Loading...</div>
        <div v-if="!loading">
            <Errors></Errors>
            <div v-if="!gallery.images" class="no-images-found">
                <p>Go and add some images to gallery</p>
                <router-link class="btn btn-primary" :to="{ name: 'NewGallery'}"><a>Add/Create new gallery</a></router-link>
            </div>
            <div class="card-group">
                <div class="row">
                    <GalleryItem v-for="image in gallery.images" :image="image" :key="image.id"></GalleryItem>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import store from "../../store";
import { mapState, mapGetters } from "vuex";
import GalleryItem from "./GalleryItem";

export default {
  components: {
    GalleryItem
  },
  props: {
    id: {
      type: [Number, String],
      required: true
    }
  },
  data: function() {
    return {
      gallery: {},
      loading: true
    };
  },
  created() {
    this.showGallery(this.id);
  },
  methods: {
    showGallery(id) {
      this.$http
        .get("/galleries/" + id).then(
          response => {
            this.$store.dispatch("galleries/setCurrentGallery", response.body.data);
            this.gallery = response.body.data
            this.loading = false;
            this.$store.dispatch("flashMessages/setSuccess", response.data.message);
          },
          response => {
            this.$store.dispatch("flashMessages/setErrors", {"noImagesFound":[response.data.message]});
            this.loading = false;
            console.log("Wooops, Something Went Wrong!");
          }
        );
    }
  }
};
</script>
<style scoped>
  .no-images-found {
    text-align: center;
    border-style: solid;
    border-width: 1px;
    width: 100%;
    border-color: #7098b6;
    margin-top: 1%;
    padding: 1%;
    box-shadow: 2px 2px 10px 2px #afc6d8;
  }
</style>

