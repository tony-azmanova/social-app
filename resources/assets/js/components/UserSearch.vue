<template>
    <div class="userSearch">
        <form v-on:submit.prevent="onSubmit">
            <div class="input-group col-md-12">
                <input type="text" class="form-control" name="searchTerm" placeholder="Search for user..." v-model="searchTerm">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit">Find</button>
                </span>
            </div>
        </form>
        <SearchResults v-show="searchResults.data" :users='searchResults.data'></SearchResults>
    </div>
</template>

<script>
import store from "../store";

export default {
  data: function() {
    return {
      searchTerm: "",
      searchResults: []
    };
  },

  methods: {
    onSubmit() {
      console.log("Search:", this.searchTerm);
      if (this.searchTerm.length >= 2) {
        this.$http
          .get("/users/search", {
            params: {
              searchTerm: this.searchTerm
            }
          })
          .then(
            response => {
              this.searchResults = response.data;
              this.searchTerm = "";
            },
            response => {
              this.$store.dispatch("flashMessages/setErrors", {"noUsersFound":[response.data.message]});
              console.log("Wooops, Something Went Wrong!");
            }
          );
      }
    }
  }
};
</script>
<style scoped>
.userSearch {
  margin: 2%;
  width: 100%;
}
</style>

