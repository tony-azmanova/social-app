<template>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <Errors></Errors>
                <Success></Success>
                <form autocomplete="off" v-on:submit.prevent="onSubmit">
                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                        <div class="col-md-6">
                            <input type="email" id="email" class="form-control" v-model="email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                        <div class="col-md-6">
                            <input type="password" id="password" class="form-control" v-model="password" required>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>           
</template>

<script>
export default {
  data: function() {
    return {
      email: "",
      password: "",
    };
  },

  methods: {
    onSubmit() {
      console.log("login");
      this.$http
        .post("/login", {
          email: this.email,
          password: this.password
        })
        .then(
          response => {
            this.$router.go("/semi-spa/walls");
            this.$store.dispatch("flashMessages/setSuccess", response.data.message);
          },
          response => {
            this.$store.dispatch("flashMessages/setErrors", {
              loginError: [response.data.message]
            });
            console.log("Wooops, Something Went Wrong!");
          }
        );
    }
  }
};
</script>
