<template>
    <button class="btn" v-bind:class="{'btn-dark': !userHasReacted, 'btn-success': userHasReacted }" v-on:click="addLike(element)" >Like</button>
</template>

<script>
import Post from "./Post.vue";
import _ from "lodash";
import { mapState, mapActions } from "vuex";
import store from "../store";

export default {
  props: {
    userHasReacted: {
      type: Boolean
    },
    likesCount: {
      type: Number
    },
    element: {
      type: Object
    },
    elementType: {
      type: String
    }
  },

  methods: {
    addLike(element) {
      console.log("Likesss addet on ", this.elementType);
      this.$http
        .post("/"+this.elementType+"s/react", { reactionType: this.elementType, element: element })
        .then(response => {
          this.$store.dispatch("posts/stateChanged", {
            element: element,
            response: response
          });
        });
    }
  }
};
</script>