<template>
    <div class="row user-info">
        <div class="col-4 pt-4 pb-4">
          <img class="card-img-top img-thumbnail avatar-image"  :src="user.avatar.thumbnail" v-on:click="showImageUpload()">    
        </div>
        <div class="col-5 pt-5 pb-5">
          <p>User info:</p>
          <p>{{ user.formated_full_name }} </p>
          <p>{{ user.email }}</p>
          <p>Member since: {{ user.memberSince }}</p>
        </div>
    </div>
</template>
<script>
export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  methods: {
    showImageUpload() {
      this.$parent.$emit("showImageUploadForm");
    }
  }
};
</script>

