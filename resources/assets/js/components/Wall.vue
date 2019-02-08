<template>
    <div>
        <Search></Search>
        <div v-if="loading" style="font-size: 16pt; color: #ff0000; ">Loading...</div>
        <Errors></Errors>
        <Success></Success>
        <InfoMessages></InfoMessages>
        <AddFriend v-if="!isCurrentUser && !friendshipStatus && userId" :receiverId="userId"></AddFriend>
        <PostForm v-if="isCurrentUser"/>
        <Posts></Posts>
    </div>
</template>

<script>
import store from '../store';
import { mapState, mapGetters } from 'vuex';
import Search from './UserSearch';
import PostForm from './PostForm';
import Posts from './Posts';
import AddFriend from './AddFriend';
import InfoMessages from './common/InfoMessages';

export default {
  components: {
    Search,
    PostForm,
    Posts,
    InfoMessages,
    AddFriend,
  },
  props: {
    userId: {
      type: [Number, String],
      required: true
    },
    mainWall: {
      type: Boolean,
      default: true
    }
  },
  data: function() {
    return {
      loading: true,
      isCurrentUser: false,
      friendshipStatus: false,
    };
  },
  computed: {
    ...mapGetters({
      checkIsCurrentUser: 'users/isCurrentUser',
    })
  },
  beforeMount() {
    if(this.mainWall) {
      return this.$store.dispatch("posts/fetchPostsMainWall");
    }
    return this.$store.dispatch("posts/fetchPosts", this.userId); 
  },
  mounted() {
    this.isCurrentUser = this.checkIsCurrentUser(this.userId);
    if(!this.isCurrentUser) {
      this.checkFriedshipStatus(this.userId);
    }
  },
  beforeUpdate() {
    this.loading = false;
    if(this.mainWall) {
      return this.$store.dispatch("posts/fetchPostsMainWall");
    }
  },
  methods: {
    checkFriedshipStatus(id){
      this.$http
        .get("/friends/status/" + id).then(
          response => {
            this.$store.dispatch("infoMessages/setInfoMessageTemporary", true);
            this.$store.dispatch("infoMessages/setInfoMessages", [response.body.data.message]);
            this.friendshipStatus = response.body.data.friendshipStatus;
            this.loading = false;
          },
          response => {
            this.loading = false;
            this.$store.dispatch("flashMessages/setErrors", {"noStatusFound":[response.data.message]});
            console.log("Wooops, Something Went Wrong!");
          }
        );
    },
  }
};
</script>