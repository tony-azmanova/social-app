<template>
    <div>
        <h2>This is the section where you can see all your unread notifications</h2>
        <InfoMessages></InfoMessages>
        <notification v-for="notification in notifications" :notification="notification" :key="notification.id"></notification>
    </div>
</template>
<script>
import store from "../../store";
import { mapState } from "vuex";
import Notification from "./Notification";
import InfoMessages from "./InfoMessages";

export default {
  components: {
    Notification,
    InfoMessages,
  },
  computed: {
    ...mapState({
      notifications: state => state.notifications.all,
    })
  },
  beforeMount() {
    this.$store.dispatch("notifications/setNotifications");
  }
};
</script>

