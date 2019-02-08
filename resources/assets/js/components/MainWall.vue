<template>
  <div>
    <Wall :userId="userId"></Wall>
  </div>
</template>
<script>
import store from "../store";
import { mapState } from "vuex";

export default {
    computed: {
      ...mapState({
        userId: state => state.users.authUserId,
      })
    },
};
</script>
