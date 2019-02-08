<template>
     <div v-if="friend" class="row user-info">
        <div class="col-4 pt-4 pb-4">
          <img class="card-img-top img-thumbnail avatar-image"  :src="friend.avatar.thumbnail" v-on:click="showImageUpload()">    
        </div>
        <div class="col-5 pt-5 pb-5">
          <p>User info:</p>
          <p>{{ friend.formated_full_name }} </p>
          <p>{{ friend.email }}</p>
          <p>Member since: {{ friend.memberSince }}</p>
        </div>
    </div>
</template>
<script>
import store from "../store";
import { mapState, mapGetters } from "vuex";
import _ from "lodash";

export default {
  props: {
    friend: {
      type: Object,
      required: true
    }
  }
};
</script>
