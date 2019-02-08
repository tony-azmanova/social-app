<template>
    <div v-if="user" class="userInfo col-sm">
        <img v-if="user.avatar" class="avatar" :src="user.avatar.thumbnail">
        <div class="userName">
            <router-link :to="{ name: 'UserWall' , params: { userId: user.id }}">{{user.formated_full_name}}</router-link>
        </div>
    </div>
</template>
<script>
export default {
  props: {
    user: {
      type: Object
    }
  },
  data: function() {
    return {
      url: "",
      loading: true
    };
  },
  mounted() {
    this.loading = false;
  },
  methods: {}
};
</script>
<style scoped>
.avatar {
  vertical-align: middle;
  width: 50px;
  height: 50px;
  border-radius: 50%;
}
.userInfo {
  display: flex;
  justify-content: left;
  margin-top: 1%;
  padding: 1%;
}
.userName {
  padding-left: 5%;
}
</style>

