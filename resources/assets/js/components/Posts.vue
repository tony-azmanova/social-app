<template>
  <div id="all-posts">
    <div class="col-md-12">
      <Post v-for="post in posts" :key="post.id" :post="post" />
    </div>
  </div>
</template>

<script>
import Post from "./Post";
import store from "../store";
import { mapState } from "vuex";

export default {
  components: {
    Post
  },
  data: function() {
    return {
      comments: []
    };
  },
  computed: {
    ...mapState({
      posts: state => state.posts.all.posts
    })
  },
  created: function() {
    this.$on("commentsUpdated", function(event) {
      this.comments = event;
    });
  }
};
</script>