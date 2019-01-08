<template>
  <div>
    <div class="list-group">
      <router-link
        :to="`/posts/channels/${channel.title}`"
        v-for="channel in channels"
        :key="channel.id"
        class="list-group-item d-sm-flex justify-content-between align-items-start"
      >
        {{ channel.title }}
        <span class="badge badge-primary badge-pill">{{ channel.posts_count }}</span>
      </router-link>
    </div>
  </div>
</template>
<script>
export default {
    mounted() {
        this.$store.dispatch('getChannels');
    },
    computed: {
        channels() {
            return this.$store.getters.channels;
        }
    }
}
</script>

