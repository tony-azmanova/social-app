<template>
    <div>
        <Errors></Errors>
        <div v-if="notification" class="alert alert-info">
            {{notification.data.message}}
            <button class="btn btn-success" @click="friendshipAccept(notification.id)">Accept</button>
            <button class="btn btn-danger" @click="friendshipCanceled(notification.id)">Cancel</button>
        </div>
    </div>
</template>
<script>
export default {
  props: {
    notification: {
      type: Object,
      required: true,
      
    },
  },
  methods: {
    friendshipAccept(notificationId) {
      console.log("Accsept friendship", notificationId); //REMOVE_ME
      this.$http.post("/users/friend/accept/" + notificationId).then(
        response => {
          this.$store.dispatch("infoMessages/setInfoMessages", [response.body.message]);
          this.$store.dispatch("notifications/removeNotifications");
          this.$store.dispatch("flashMessages/setSuccess", response.data.message);
        },
        response => {
          this.$store.dispatch("flashMessages/setErrors", {
            noStatusFound: [response.data.message]
          });
          console.log("Wooops, Something Went Wrong!");
        }
      );
    },
    friendshipCanceled(notificationId) {
      console.log("canseled friendship", notificationId); //REMOVE_ME
      this.$http.post("/users/friend/cancel/" + notificationId).then(
        response => {
          this.$store.dispatch("notifications/removeNotifications");
          this.$store.dispatch("infoMessages/setInfoMessages", [response.body.message]);
          this.$store.dispatch("flashMessages/setSuccess", response.data.message);
        },
        response => {
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
