<template>
    <nav>
      <ul class="pagination justify-content-center">
        <template v-if="page.last > 1">
          <li
            class="page-item"
            :class="[ n == page.current ? 'active' : '']"
            v-for="n in page.last"
            :key="n"
          >
          <template v-if="page.type == 'postList'">
              <a class="page-link" @click="$emit('postPage', n)">{{ n }}</a>
          </template>
          <template v-else-if="page.type == 'channelList'">
              <a class="page-link" @click="$emit('channelPage', n)">{{ n }} test</a>
          </template>
          <template v-else-if="page.type == 'commentList'">
              <router-link class="page-link" :to="`/posts/${page.post_id}?page=${n}`">{{ n }}</router-link>
          </template>
          </li>
        </template>
      </ul>
    </nav>
</template>
<script>
export default {
    props: ['page']
}
</script>

