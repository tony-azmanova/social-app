<template>
    <div v-if="image">
        <div class="card" style="width: 18rem; height: 32rem;">
            <label class="image-checkbox" :class="[isChecked ? activeClass : '']">
                <input type="checkbox" :checked="isChecked" @change="onChange(image, $event)" v-model="checkedImages" :value="image.info.id"/>
                <img class="card-img-top img-thumbnail" :src="image.thumbnail" alt="Card image cap">
            </label>   
            <div class="card-body">
                <p>{{ image.name }}</p>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <button class="btn btn-danger" @click="deleteImage(image.info.id)" >Delete</button>
                  <Modal v-if="showModal" @cancel="showModal = false" @confirm="confirmed(image.info.id)"></Modal>
            </div>
        </div>
    </div>
</template>
<script>
import store from "../../store";
import { mapState } from "vuex";

export default {
  props: {
    image: {
      type: [Object, Array],
      required: true
    }
  },
  data: function() {
    return {
      checkedImages: [],
      isChecked: false,
      activeClass: 'image-checkbox-checked',
      showModal: false,
      hasConfirmed: false,
    };
  },
  computed: {
    ...mapState({
      selectedImagesCount: state => state.galleries.selectedImages.lenght,
    })
  },
  methods: {
    deleteImage(imageId){
      if (!this.hasConfirmed) {
       return this.showModal = true;
      }
      console.log("delete image"); //REMOVE_ME
      this.$http
      .delete('/files/' + imageId)
      .then(
        response => {
          this.$store.dispatch("galleries/removeFromUserImages", imageId);
          this.$store.dispatch("flashMessages/setSuccess", response.data.message);
        },
        response => {
          this.$store.dispatch("flashMessages/setErrors", response.data.errors);
          console.log("Wooops, Something Went Wrong!");
        }
      );
    },
    confirmed(imageId){
      this.hasConfirmed = true;
      this.showModal = false;
      this.deleteImage(imageId);
    },
    onChange(image,$event) {
      if (!this.isChecked){
        this.$store.dispatch('galleries/addToSelectedImages', image.info.id);
        return this.isChecked = !this.isChecked;
      }

      this.$store.dispatch('galleries/removeFromSelectedImages', image.info.id);
      this.isChecked = !this.isChecked;
    }
  }
};
</script>


