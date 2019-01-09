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
              <span class="flex mb-2">
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
      <pagination :page="pageObj" @postPage="getPostByPage"></pagination>
      
    </template>
  </div>
</template>
<script>
import Pagination from '@/js/components/Pagination';

export default {
  components: {Pagination},
  data() {
    return {
      pageObj: {
        current: 1,
        last: null,
        type: 'postList'
      }
    };
  },
  computed: {
    posts() {
      var posts = this.$store.getters.posts;
      this.pageObj.current = posts.current_page;
      this.pageObj.last = posts.last_page;
      return posts;
    },
    user() {
      return this.$store.getters.currentUser;
    }
  },
  methods: {
    limitShowText(string, length) {
      return string.substring(0, length) + "...";
    },
    deletePost(post_id) {
      this.$Progress.start();
      axios.delete(`/api/posts/${post_id}`).then(response => {
        this.$store.dispatch("getPosts");
        this.$store.dispatch("getChannels");
        this.$Progress.finish();
      });
    },
    getPostByPage(page) {
      this.$Progress.start();
      this.pageObj.current = page;
      this.$store.dispatch("getPosts", page);
      this.$Progress.finish();
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
}
</style>
