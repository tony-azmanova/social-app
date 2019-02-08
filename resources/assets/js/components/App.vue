<template>
  <div>
    <TopNavigation/>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <router-view :key="$route.fullPath"></router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import store from "../store";

export default {
  props: {
    authuserid: {}
  },
  created() {
    this.$store.dispatch("users/setAuthUserId", this.authuserid);
  }
};
</script>
<style scoped>
.container {
  padding: 3%;
  align-self: flex-start;
}
</style>
