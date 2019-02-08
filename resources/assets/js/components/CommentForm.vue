<template>
    <div class="container mb-3">
        <Errors/>
        <Success/>
        <form v-on:submit.prevent="onSubmit">
        <div class="form-group">
           <label for="commentTitle">Title:</label>
           <input type="text" class="form-control" v-model="commentTitle">

           <label for="commentContent">Comment:</label>
           <textarea class="form-control" v-model="commentContent" rows="3"></textarea>

           <button class="btn btn-primary mt-3" type="submit">Comment</button>
        </div>
    </form>
</div>
</template>

<script>
import store from "../store";

export default {
  props: {
    postId: {
      type: Number
    }
  },
  data: function() {
    return {
      commentTitle: "",
      commentContent: ""
    };
  },

  methods: {
    onSubmit() {
      console.log("adding comment");
      this.$http
        .post("/posts/" + this.postId + "/comment", {
          commentTitle: this.commentTitle,
          commentContent: this.commentContent
        })
        .then(
          response => {
            this.$store.dispatch("posts/setNewComment", response.data.data);
            this.$store.dispatch(
              "flashMessages/setSuccess",
              response.data.message
            );
            this.commentTitle = "";
            this.commentContent = "";
          },
          response => {
            this.$store.dispatch(
              "flashMessages/setErrors",
              response.data.errors
            );
            console.log("Wooops, Something Went Wrong!");
          }
        );
    }
  }
};
</script>