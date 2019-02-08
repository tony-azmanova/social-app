<template>
    <button v-if="!hasSended" v-on:click="addFriend(receiverId)" class="btn btn-primary">Add friend </button>
</template>
<script>
export default {
  props: {
    receiverId: {
      type: [String, Number],
      required: true
    }
  },
  data: function() {
    return {
      hasSended: false,
    };
  },
  methods: {
    addFriend(receiverId) {
      console.log("Adding friend"); //REMOVE_ME
      this.$http.get("/users/" + receiverId + "/addFriend/").then(
        response => {
          this.$store.dispatch("infoMessages/setInfoMessages", [
            response.body.data.message
          ]);
          this.$store.dispatch("flashMessages/setSuccess", response.data.message);
          this.hasSended = true;
        },
        response => {
          this.loading = false;
          this.$store.dispatch("flashMessages/setErrors", {
            noStatusFound: [response.data.message]
          });
          console.log("Wooops, Something Went Wrong!");
        }
      );
    }
  }
};
</script>
