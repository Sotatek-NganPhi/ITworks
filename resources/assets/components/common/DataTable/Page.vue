<template>
  <li :class="_class">
    <span v-if="_disabled">{{ _label }}</span>
    <a v-else @click.prevent="onClick" :aria-label="getAriaLabel()">{{ _label }}</a>
  </li>
</template>

<script>
  export default {
    computed: {
      _class: function () {
        return {
          active: this.active,
          hellip: this.hellip,
          disabled: this._disabled,
        }
      },
      _disabled: function () {
          return this.disabled || this.hellip || (this.prev && this.p === 0)
      },
      _label: function () {
        if (this.hellip) {
          return '…'
        }
        if (this.prev) {
          return '«'
        }
        if (this.next) {
          return '»'
        }
        if (this.label) {
          return this.label
        }
        return this.page
      }
    },
    props: [ 'page', 'disabled', 'active', 'label', 'next', 'prev', 'hellip' ],
    methods: {
      onClick: function () {
        this.$emit('click', this.page)
      },
      getAriaLabel: function () {
        if (this.prev) {
          return 'Previous'
        }
        if (this.next) {
          return 'Next'
        }
      },
    },
  }
</script>
<style scoped>
  li.disabled > span {
    cursor: default !important
  }
</style>