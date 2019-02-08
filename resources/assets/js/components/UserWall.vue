<template>
    <div>
        <Wall v-if="allPosts" :userId="userId" :mainWall="mainWall"></Wall>
    </div>
</template>
<script>
import store from "../store";
import { mapState } from "vuex";

export default {
  props: {
    userId: {}
  },
  data: function() {
    return {
      mainWall: false
    };
  },
  computed: {
    ...mapState({
      allPosts: state => state.posts.all,
    }),
  },
};
</script>
