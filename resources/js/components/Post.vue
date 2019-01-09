<template>
  <div>
    <div class="card mb-2">
      <div class="card-body">
        <div class="flex">
          <h5 class="card-title">
            <router-link :to="`/posts/${post.id}`">{{ post.title }}</router-link>
            <span
              class="time-passed"
            >{{ post.created_at | moment('timezone', 'Asia/Bangkok', "from", "now") }}</span>
          </h5>
          <router-link
            :to="`/posts/channels/${postChannel.title}`"
            class="btn btn-outline-primary btn-sm mb-2"
          >{{ postChannel.title }}</router-link>
        </div>
        <p class="card-text">{{ post.body }}</p>
      </div>
    </div>

    <hr>

    <div class="comments" v-if="comments.data">
      <div class="card mb-4" v-for="comment in comments.data" :key="comment.id">
        <div v-if="edit && comment.id == current_comment" class="card-body">
          <form @submit.prevent="updateComment(comment.id)">
            <div class="form-group">
              <textarea
                cols="30"
                rows="3"
                v-model="updateBody"
                class="form-control"
                :class="[error.length ? 'is-invalid' : '']"
                placeholder="What's on your mind"
                v-text="comment.body"
                required
              ></textarea>
              <div class="invalid-feedback">Please enter a message in the textarea.</div>
            </div>
            <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
            <button class="btn btn-outline-danger btn-sm" @click.prevent="toggleEditForm">Close</button>
          </form>
        </div>
        <div v-else class="card-body">
          <p class="card-text">{{ comment.body }}</p>
          <span class="author">
            By : {{ comment.user.name }}
            <span
              class="time-passed"
            >{{ comment.created_at | moment("from", "now") }}</span>
          </span>
        </div>
        <div class="card-footer">
          <button class="btn btn-dark btn-sm" @click="toggleEditForm(comment.id)">Edit</button>
          <button class="btn btn-danger btn-sm" @click="deleteComment(comment.id)">Delete</button>
        </div>
      </div>
    </div>

    <pagination :page="pageObj"></pagination>

    <form @submit.prevent="createComment(post.id)">
      <div class="form-group">
        <textarea
          cols="30"
          rows="5"
          v-model="form.body"
          class="form-control"
          :class="[error.length ? 'is-invalid' : '']"
          placeholder="What's on your mind"
          required
        ></textarea>
        <div class="invalid-feedback">Please enter a message in the textarea.</div>
      </div>
      <button type="submit" class="btn btn-primary mr-auto">Send</button>
    </form>
  </div>
</template>
<script>
import Pagination from '@/js/components/Pagination';

export default {
  props: ["id"],
  components: { Pagination },
  data() {
    return {
      post: [],
      postChannel: "",
      comments: [],
      current_comment: 1,
      form: {
        body: ""
      },
      updateBody: "",
      pageObj: {
        current: 1,
        last: null,
        type: 'commentList',
        post_id: this.id
      },
      error: [],
      edit: false
    };
  },
  mounted() {
    this.getPostById();
  },
  watch: {
    $route(to, form) {
      this.$route.query.page
        ? (this.pageObj.current = this.$route.query.page)
        : 1;
      this.getPostById(this.pageObj.current);
    },
    "pageObj.last"() {
      this.chanePage();
    }
  },
  methods: {
    getPostById(page = 1) {
      this.$Progress.start();
      this.pageObj.current = page;
      axios.get(`/api/posts/${this.id}?page=${page}`).then(response => {
        this.$Progress.finish();
        this.post = response.data.post;
        this.postChannel = response.data.post.channel;
        this.comments = response.data.comments;
        this.pageObj.last = this.comments.last_page;
      });
    },
    createComment(post_id) {
      this.error = [];
      this.$Progress.start();
      axios
        .post(`/api/posts/${post_id}/comments`, this.form)
        .then(response => {
          this.form.body = "";
          this.getPostById();
          this.$Progress.finish();
        })
        .catch(error => {
          this.$Progress.fail();
          this.error = this.catchValidate(error);
        });
    },
    updateComment(comment_id) {
      this.$store.dispatch("checkIfTokenExpired");
      if (!this.updateBody) {
        this.$Progress.start();
        this.toggleEditForm();
        this.$Progress.finish();
      } else {
        var form = {
          body: this.updateBody
        };
        this.$Progress.start();
        axios.put(`/api/comments/${comment_id}`, form).then(response => {
          this.getPostById(this.$route.query.page);
          this.toggleEditForm();
          this.$Progress.finish();
        });
      }
    },
    deleteComment(comment_id) {
      this.$Progress.start();
      axios.delete(`/api/comments/${comment_id}`).then(response => {
        this.$store.dispatch("getPosts");
        this.getPostById(this.pageObj.current);
        this.$Progress.finish();
      });
    },
    chanePage() {
      if (this.pageObj.last <= this.pageObj.current) {
        this.$router.push(`/posts/${this.post.id}?page=${this.pageObj.last}`);
      }
    },
    toggleEditForm(comment_id) {
      this.current_comment = comment_id;
      this.edit = !this.edit;
    }
  }
};
</script>
<style lang="scss" scoped>
@import "@/sass/_variables.scss";
.time-passed {
  color: $color-grey-1;
  font-size: 1rem;
}

.author {
  color: $primary-color;
}

.flex {
  display: flex;
  justify-content: space-between;
}
</style>

