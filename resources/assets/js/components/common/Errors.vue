<template>
    <div>
        <div v-for="error in errors" :key="error.id" class="alert alert-danger" role="alert">
            {{error[0]}}
        </div>
    </div>
</template>
<script>
import store from "../../store";
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      errors: state => state.flashMessages.all.errors
    })
  }
};
</script>
