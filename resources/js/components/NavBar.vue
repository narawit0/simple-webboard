<template>
  <nav class="navbar navbar-expand-lg mb-4">
    <div class="container">
      <router-link class="navbar-brand" to="/">Webboard</router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <template v-if="user">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              ><font-awesome-icon icon="user" />  {{ user.name }}</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <router-link class="dropdown-item" to="/new-post">New Post</router-link>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Setting</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" @click.prevent="logout">Logout</a>
              </div>
            </li>
          </template>
          <template v-else>
            <li class="nav-item">
              <router-link class="nav-link" to="/register">Register</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/login">login</router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
export default {
  methods: {
    logout() {
      this.$Progress.start();
      this.$store.commit('logout');
      this.$router.push('/');
      this.$Progress.finish();
    }
  },
  computed: {
    user() {
      return this.$store.getters.currentUser;
    }
  }
};
</script>
<style lang="scss" scoped>
@import '@/sass/_variables.scss';
  .navbar {
    background-image: linear-gradient(to right, $primary-color, $secondary-color);

    &-brand {
      color: $color-white;
    }

    .nav-link {
      color: $color-white;
    }
  }
</style>


