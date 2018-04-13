<template>
  <ul class="pagination">
    <page :page="page - 1" prev="true" :disabled="page === 1" @click="onClick"></page>

    <page :page="1" :active="page === 1" @click="onClick"></page>
    <page v-if="page > 4" :hellip="true"></page>

    <template v-if="page < 5">
      <page v-for="part in firstPartition"
        key="key"
        :page="part.key"
        :active="page === part.key"
        @click="onClick">
      </page>
    </template>

    <template v-if="(page > 4) && (pages - page > 4)">
      <page :page="page - 1" @click="onClick"></page>
      <page :page="page" active="true" @click="onClick"></page>
      <page :page="page + 1" v-if="page < pages" @click="onClick"></page>
      <page :page="page + 2" v-if="pages - page === 3" @click="onClick"></page>
    </template>

    <template v-if="pages - page < 5">
      <page v-for="part in lastPartition"
        key="key"
        :page="part.key"
        :active="page === part.key"
        @click="onClick"></page>
    </template>

    <page v-if="pages - page > 4" :hellip="true"></page>
    <page :page="pages" v-if="pages >= page" :active="page === pages" @click="onClick"></page>

    <page :page="page + 1" next="true" :disabled="page === pages" @click="onClick"></page>
  </ul>
</template>

<script>
  import _ from 'lodash';
  import Page from './Page.vue';

  export default {
    data() {
      return {
        width: 10,
      }
    },
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
      firstPartition() {
        return this._pages.slice(1, 5);
      },
      lastPartition() {
        return _.takeRight(this._pages, 5).slice(0, 4);
      },
    },
  }
</script>
<style scoped>
  ul.pagination li{
    cursor: pointer;
  }
</style>
