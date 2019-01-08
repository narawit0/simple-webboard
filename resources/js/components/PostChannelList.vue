<template>
  <div>
    <template v-if="posts">
      <div class="card mb-2" v-for="post in posts.data" :key="post.id">
        <div class="card-body">
          <div class="row">
            <div class="col-md-10 card-body--left">
              <h5 class="card-title">
                <router-link :to="`/posts/${post.id}`">{{ post.title }}</router-link>
              </h5>
              <p class="card-text">{{ limitShowText(post.body, 150) }}</p>
              <a href="#" class="card-link">By {{ post.user.name }}</a>
            </div>
            <div class="col-md-2 card-body--right">
              <router-link
                :to="`/posts/channels/${post.channel.title}`"
                class="btn btn-outline-primary btn-sm mb-2"
              >{{ post.channel.title }}</router-link>
              <span class="flex">
                <font-awesome-icon icon="comment-alt"/>
                <span>{{ post.comments_count }}</span>
              </span>
            </div>
          </div>
        </div>
        <div class="card-footer" v-if="user && user.id == post.user_id">
          <router-link class="btn btn-dark btn-sm" :to="`/posts/${post.id}/edit`">Edit</router-link>
          <button class="btn btn-danger btn-sm" @click="deletePost(post.id)">Delete</button>
        </div>
      </div>
      <nav>
        <ul class="pagination justify-content-center">
          <template v-if="pageObj.last > 1">
            <li
              class="page-item"
              :class="[ n == pageObj.current ? 'active' : '']"
              v-for="n in pageObj.last"
              :key="n"
            >
              <a class="page-link" @click.prevent="getPostsByChannel(n)">{{ n }}</a>
            </li>
          </template>
        </ul>
      </nav>
    </template>
  </div>
</template>
<script>
export default {
  props: ["channel"],
  data() {
    return {
      posts: [],
      pageObj: {
        current: 1,
        last: null
      }
    };
  },
  mounted() {
    this.getPostsByChannel();
  },
  computed: {
    user() {
      return this.$store.getters.currentUser;
    }
  },
  watch: {
    $route(to, form) {
      this.getPostsByChannel();
    }
  },
  methods: {
    getPostsByChannel(page = 1) {
      this.$Progress.start();
      this.pageObj.current = page;
      axios
        .get(`/api/posts/channels/${this.channel}?page=${page}`)
        .then(response => {
          this.pageObj.last = response.data.posts.last_page;
          this.posts = response.data.posts;
          this.$Progress.finish();
        });
    },
    limitShowText(string, length) {
      return string.substring(0, length) + "...";
    },
    deletePost(post_id) {
      this.$Progress.start();
      axios.delete(`/api/posts/${post_id}`).then(response => {
        this.getPostsByChannel();
        this.$store.dispatch("getPosts");
        this.$store.dispatch("getChannels");
        this.$Progress.finish();
      });
    }
  }
};
</script>
<style lang="scss" scoped>
@import "@/sass/_variables.scss";
.card {
  :hover {
    background-color: $color-grey-2;
  }
}
.card-body {
  &--right {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
}

.flex {
  display: flex;
  align-items: center;
  width: 30%;
  justify-content: space-between;
  color: $color-grey-1;

  span {
    transform: translateY(-2px);
  }

  svg {
  }
}
</style>
