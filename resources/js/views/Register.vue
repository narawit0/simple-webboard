<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Register</div>
          <div class="card-body">
            <div class="alert alert-danger" role="alert" v-if="errors.length">
              <li v-for="error in errors" :key="error">{{ error }}</li>
            </div>
            <form @submit.prevent="checkForm">
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" v-model="form.name" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" v-model="form.email" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" v-model="form.password" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" v-model="form.confirm_password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Routes from '@/js/routes.js'
// import {catchValidate, checkFieldIsEmpty} from '@/js/helpers/validateError.js';

export default {
  data() {
    return {
      form : {
        name: "",
        email: "",
        password: "",
        confirm_password: ""
      },
      errors: []
    };
  },
  methods: {
    checkForm() {
      this.errors = [];

      this.errors = this.checkFieldIsEmpty(this.form);

      if(!this.errors.length) {
        this.regist();
      }
    },
    regist() {
      axios.post("/api/auth/register", this.form).then(response => {
            Routes.push('login');
      }).catch(error => {
          this.errors = [];
          this.errors = this.catchValidate(error);
      });
    }
  }
};
</script>
