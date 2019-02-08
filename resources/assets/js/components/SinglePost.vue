<template>
  <div>
    <Post :post="post" />
  </div>
</template>

<script>
import Post from './Post';
import { mapState, mapActions, mapGetters } from "vuex";
import store from "../store";

export default {
  components: {
    Post,
  },
  props: {
    id: {
      type: [Number, String],
      required: true
    }
  },
  data: function() {
    return {
      post: {}
    };
  },
  created() {
    this.getPost(this.id);
  },
  methods: {
    async getPost(id) {
      try {
        let response = await this.$http.get("/posts/" + id);
        this.$store.dispatch("posts/getPost", response.body.data);
        this.post = response.body.data;
      } catch (ex) {
        this.$store.dispatch("flashMessages/setErrors", {"somthingIsWrong":[ ex.statusText]});
        return;
      }
    }
  }
};
</script>