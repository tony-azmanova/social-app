<template>
    <div class="card">
        <div class="card-header">Register</div>
        <Errors />
        <Success />
        <form autocomplete="off" v-on:submit.prevent="onSubmit">
            <div class="form-group row">
                <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" v-model="firstName" >
                </div>
            </div>
            <div class="form-group row">
                <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" v-model="lastName" >
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                <div class="col-md-6">
                <input type="email" class="form-control" v-model="email">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                    <input type="password" class="form-control" name="password" v-model="password" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                <div class="col-md-6">
                    <input type="password" class="form-control" v-model="passwordConfirmation" >
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
  data: function() {
    return {
      firstName: "",
      lastName: "",
      email: "",
      password: "",
      passwordConfirmation: "",
    };
  },

  methods: {
    onSubmit() {
      console.log("register");
      this.$http
        .post("/register", {
          first_name: this.firstName,
          last_name: this.lastName,
          email: this.email,
          password: this.password,
          password_confirmation: this.passwordConfirmation
        })
        .then(
          response => {
            this.$router.go("/semi-spa/walls");
            this.$store.dispatch("flashMessages/setSuccess", response.data.message);
          },
          response => {
            this.$store.dispatch("flashMessages/setErrors", response.data.errors);
            console.log("Wooops, Something Went Wrong!");
          }
        );
    }
  }
};
</script>
