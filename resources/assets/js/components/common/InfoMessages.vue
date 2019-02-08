<template>
    <div class="infoMessage">
        <div v-for="infoMessage in infoMessages" :key="infoMessage.id" class="alert alert-info" role="alert">
            <strong> {{ infoMessage }} </strong>
        </div> 
    </div>
</template>
<script>
import store from "../../store";
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      infoMessages: state => state.infoMessages.all
    })
  }
};
</script>
<style scoped>
  .infoMessage {
    width: 100%;
    margin: 2%;
  }
</style>


