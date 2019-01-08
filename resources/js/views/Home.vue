<template>
  <div>
    <div class="container">
      <div class="row">
        <div class="col-md-3 left">
            <channel></channel>
        </div>
        <div class="col-md-9 right">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Channel from '@/js/components/Channel';

export default {
    mounted() {
        this.$store.dispatch("getPosts", 1);
    },
    components: { Channel }
};
</script>
<style lang="scss" scoped>
@import "@/sass/_variables.scss";

</style>

