<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <div class="alert alert-danger" v-if="errors.length">
                <li v-for="error in errors" :key="error">{{ error }}</li>
            </div>

            <div class="alert alert-danger" v-if="authError">{{ authError }}</div>
            <form @submit.prevent="checkForm" novalidate="true">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" v-model="form.email" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" v-model="form.password" class="form-control" required>
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
import { login } from "@/js/helpers/auth";
import {checkFieldIsEmpty} from '@/js/helpers/validateError';
export default {
  data() {
    return {
      form: {
        email: "",
        password: ""
      },
      errors: []
    };
  },
  computed: {
      authError() {
          return this.$store.getters.authError;
      }
  },
  methods: {
    checkForm() {
        this.errors = [];

        this.errors = this.checkFieldIsEmpty(this.form);

        if(this.form.email && !this.validEmail(this.form.email)) {
            this.errors.push('Valid Email required');
        }

        if (!this.errors.length) {
            this.authenticate();
        }
    },
    authenticate() {
      this.$store.dispatch("login");

      login(this.form)
        .then(res => {
            this.$store.commit("loginSuccess", res);
            this.$router.push('/');
        })
        .catch(err => {
            this.$store.commit("loginFailed", err);
        });
    },
    validEmail: function (email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }
  }
};
</script>

