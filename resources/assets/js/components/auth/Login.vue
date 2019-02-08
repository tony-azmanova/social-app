<template>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <div class="alert alert-danger" v-if="error">
                    <p>{{error}}</p>
                </div>
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
                            <a class="btn btn-link" href="">Forgot Your Password?</a>
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
      error: "",
      success: false
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
            this.error = "";
            this.success = true;
          },
          response => {
            this.error = response.data.message;
            console.log("Wooops, Something Went Wrong!");
          }
        );
    }
  }
};
</script>
