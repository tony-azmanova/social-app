<template>
    <div :class="classFadeOut" >
        <div v-for="error in errors" :key="error.id" class="alert alert-danger" role="alert">
            {{error[0]}}
        </div>
    </div>
</template>
<script>
import store from "../../store";
import { mapState } from "vuex";

export default {
  data: function() {
    return {
      classFadeOut: "animated fadeIn",
    };
  },
  computed: {
    ...mapState({
      errors: state => state.flashMessages.all.errors
    })
  },
  created(){
    this.removeErrors();
  },
  methods: {
    removeErrors() {
      setTimeout(() => {
        this.classFadeOut = "animated fadeOut slideInUp";
      }, 3000)
    }
  }
};
</script>
