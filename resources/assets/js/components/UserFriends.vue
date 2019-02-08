<template>
    <div>
        <h2>Here are all your friends!</h2>
        <InfoMessages></InfoMessages>
         <div class="card-group">
            <div class="row">
                <UserFriend v-for="friend in friends" :friend="friend" :key="friend.id"></UserFriend>
            </div>
        </div>
    </div>
</template>
<script>
import store from "../store";
import { mapState } from "vuex";
import UserFriend from "./UserFriend";

export default {
  components: {
    UserFriend
  },
  computed: {
    ...mapState({
      friends: state => state.friends.all
    })
  },
  beforeMount() {
    this.$store.dispatch("friends/fetchFriends");
  }
};
</script>

