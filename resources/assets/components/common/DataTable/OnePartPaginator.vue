<template>
  <ul class="pagination">
    <page :page="page - 1" prev="true" @click="onClick"></page>
    <page v-for="_page in _pages" key="key" :page="_page.key" :active="page === _page.key" @click="onClick"/>
    <page :page="page + 1" next="true" :disabled="page === pages" @click="onClick"></page>
  </ul>
</template>

<script>
  import Page from './Page.vue';

  export default {
    props: {
      page: {
        type: Number,
        default: 1,
      },
      pages: {
        type: Number,
      },
    },
    components: { page: Page },
    methods: {
      onClick: function (event) {
        if (event !== this.page) {
          this.$emit('change', event)
        }
      }
    },
    computed: {
      _pages() {
        return Array.from(Array(this.pages), (value, key) => { return { key: key + 1 } });
      },
    },
  }
</script>
