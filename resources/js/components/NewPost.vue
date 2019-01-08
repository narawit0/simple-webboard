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
                <select  class="form-control" v-model="form.channel_id">
                  <option value="">Choose One...</option>
                  <option v-for="channel in channels" :key="channel.id" :value="channel.id">{{ channel.title }}</option>
                </select>
              </div>
              <div class="form-group">
                <label for="name">Title</label>
                <input type="text" v-model="form.title" class="form-control">
              </div>

              <div class="form-group">
                <label for="email">Body</label>
                <textarea v-model="form.body" id cols="30" rows="10" class="form-control"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Create</button>
            </form>
          </div>
        </div>
  </div>
</template>
<script>
export default {
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
        this.create();
      }
    },
    create() {
      this.$Progress.start()
      axios.post("/api/posts", this.form)
        .then(response => {
          this.$Progress.finish()
          // Dispatch getChannels for update posts count of each channel
          this.$store.dispatch('getChannels');
          this.$router.push('/');
        })
        .catch(error => {
          this.$Progress.fail()
          this.erros = [];
          this.errors = this.catchValidate(error);
        });
    }
  }
};
</script>

