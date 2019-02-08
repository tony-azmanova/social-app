<template>
    <div>
        <div v-if="loading" style="font-size: 16pt; color: #ff0000; ">Loading...</div>
        <div  v-if="!loading" class="searchResults col-md-12">
            <p>Here is what we found: </p>
            <UserInfo v-for="user in users" :key="user.id" :user="user"></UserInfo>
        </div>
    </div>        
</template>

<script>
export default {
  props: {
    users: {
      type: Array
    }
  },
  data: function() {
    return {
      loading: true
    };
  },
  mounted() {
    this.loading = false;
  }
};
</script>
<style scoped>
.searchResults {
  text-align: center;
  border-style: solid;
  border-color: #33658a;
  margin: 1%;
}
</style>

