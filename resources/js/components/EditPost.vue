<template>
  <div class="container">
    <div class="card">
      <div class="card-header">Create Post</div>
      <div class="card-body">
        <div class="alert alert-danger" role="alert" v-if="errors.length">
          <li v-for="error in errors" :key="error">{{ error }}</li>
        </div>
        <form @submit.prevent="checkForm">
          <div class="form-group">
            <select class="form-control" v-model="form.channel_id">
              <option value>Choose One...</option>
              <option
                v-for="channel in channels"
                :key="channel.id"
                :value="channel.id"
              >{{ channel.title }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" v-model="form.title" class="form-control">
          </div>

          <div class="form-group">
            <label for="body">Body</label>
            <textarea v-model="form.body" name="body" cols="30" rows="10" class="form-control"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["id"],
  data() {
    return {
      form: {
        channel_id: "",
        title: "",
        body: ""
      },
      errors: []
    };
  },
  mounted() {
    this.getPostById();
  },
  computed: {
    channels() {
      return this.$store.state.channels;
    }
  },
  methods: {
    checkForm() {
      this.errors = [];

      this.errors = this.checkFieldIsEmpty(this.form);

      if (!this.errors.length) {
        this.updatePost();
      }
    },
    getPostById() {
      axios.get(`/api/posts/${this.id}`).then(response => {
        var post = response.data.post;
        this.form.channel_id = post.channel_id;
        this.form.title = post.title;
        this.form.body = post.body;
      }).catch(error => {
          this.$router.push('/page-not-found');
      })
    },
    updatePost() {
      this.$Progress.start();
      axios
        .put(`/api/posts/${this.id}`, this.form)
        .then(response => {
          this.getPostById();
          this.$store.dispatch("getChannels");
          this.$Progress.finish();
        })
        .catch(error => {
          this.$Progress.fail();
          this.erros = [];
          this.errors = this.catchValidate(error);
        });
    }
  }
};
</script>

