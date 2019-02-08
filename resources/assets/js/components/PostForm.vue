<template>
    <div class="form-post">
        <form v-on:submit.prevent="onSubmit">
            <div class="form-group">
                <input type="text" class="form-control form-post-title" v-model="postTitle" placeholder="Post title">
                <textarea class="form-control mt-3" rows="3" placeholder="Post something..." v-model="postContent"></textarea>
            </div>
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">Post</button>
            </span>
        </form>
  </div>
</template>

<script>
import store from "../store";
import { mapState } from "vuex";

export default {
  data: function() {
    return {
      postTitle: "",
      postContent: ""
    };
  },
  methods: {
    onSubmit() {
      console.log("posting:");
      this.$http
        .post("/posts", {
          postTitle: this.postTitle,
          postContent: this.postContent
        })
        .then(
          response => {
            this.$store.dispatch("posts/setNewPost", response.data.data);
            this.$store.dispatch("flashMessages/setSuccess", response.data.message);
            this.postTitle = "";
            this.postContent = "";
          },
          response => {
            this.$store.dispatch("flashMessages/setErrors", response.data.errors);
            console.log("Wooops, Something Went Wrong!");
          }
        );
    }
  }
};
</script>
<style scoped>
  .form-post {
      border-style: solid;
      border-width: 1px;
      width: 100%;
      border-color: #7098b6;
      margin: 2%;
      padding-left: 4%;
      padding-bottom: 2%;
      padding-right: 4%;
      -webkit-box-shadow: 2px 2px 10px 2px #afc6d8;
      box-shadow: 2px 2px 10px 2px #afc6d8;
  }
  .form-post-title {
    margin-top: 2%;
  }
</style>

