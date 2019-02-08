<template>
  <div class="container">
    <div class="card-header col-md-12">
      <router-link :to="{ name: 'SinglePost', params: { id:post.id } }">
        <h4>{{ post.title }}</h4>
      </router-link>
    </div>
    <div class="card-body col-md-12">
      <UserInfo v-if="post.user" :user="post.user"></UserInfo>
      <p>{{ post.content }}</p>
      <Likes :userHasReacted="post.userHasReacted" :likesCount="post.reactions" :element="post" :elementType="elementType"/>
      <div class="mt-3">
        <button class="btn btn-dark comment-button" v-on:click="getComments">Show comments</button>
      </div>
      <p>User Likes Are: {{ post.reactions }} </p>
      <Comments v-if="showComments" :postId="post.id"/>
      <span> posted on: {{ post.created_at }}</span>
    </div>
  </div>
</template>

<script>
  import Comments from "./Comments.vue";
  import store from "../store";
  
  export default {
    props: {
      post: {
        type: Object,
        required: true
      },
    },
    data: function() {
      return {
        loading: true,
        elementType: 'post',
        showComments: false,
      };
    },
    beforeUpdate() {
      this.loading = false
    },
    methods: {
      getComments() {
        this.$http.get("/comments/post/" + this.post.id).then(
          response => {
            if (response.body.success === true) {
              this.showComments = !this.showComments
              this.$store.dispatch("posts/setComments", response.body.data);
            }
          },
          response => {
            console.log("Wooops, Something Went Wrong!");
          }
        );
      },
    }
  };
</script>
<style scoped>
  .container 
  {
    border-style: solid;
    border-width: 1px;
    width: 100%;
    border-color: #7098b6;
    margin: 15pt;
    box-shadow: 2px 2px 10px 2px #afc6d8;

  }
</style>

