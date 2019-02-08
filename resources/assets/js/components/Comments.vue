<template>
  <div id="all-comment">
    <h5>This is all comments section</h5>
    <CommentForm :postId="postId"/>
    <div class="col-md-12 comment-section" >
      <div class="alert alert-info alert-info-comments" style="display: none"></div>
      <Comment v-for="comment in comments" :key="comment.id" :comment="comment" />
    </div>
  </div>
</template>


<script>

import store from "../store";
import { mapState } from 'vuex';
import Comment from './Comment';
import CommentForm from './CommentForm';

export default {
  components: {
    Comment,
    CommentForm,
  },
  props: {
    postId: {
      type: Number
    }
  },
  computed: {
    ...mapState({
      comments: state => state.posts.comments
    })
  },
};

</script>