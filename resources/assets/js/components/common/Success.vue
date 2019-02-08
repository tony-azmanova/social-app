<template>
    <div v-if="success.message" :class="classFadeOut" class="alert alert-success" role="alert">
        {{success.message}}
    </div>
</template>
<script>
import store from "../../store";
import { mapState } from "vuex";

export default {
  data: function() {
    return {
      classFadeOut: "animated fadeIn"
    };
  },
  updated() {
    this.removeSuccess();
  },
  computed: {
    ...mapState({
      success: state => state.flashMessages.all.success
    })
  },
  methods: {
    removeSuccess() {
      setTimeout(() => {
        this.classFadeOut = "animated fadeOut slideInUp";
        this.$store.dispatch("flashMessages/removeSuccess");
      }, 5000);
    }
  }
};
</script>

