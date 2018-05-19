<template>
  <label class="__checkbox">
    <input @click="onChange" type="checkbox" v-model="isChecked">
    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
  </label>
</template>

<script>
  export default {
    data() {
      return {
        isChecked: false,
      }
    },
    props: ['value'],
    methods: {
      onChange() {
        this.$parent.$emit('DataTable:toggleItem', this.value.id);
      },
    },
    created () {
      this.$parent.$on('DataTable:selectedItemChange', items => {
        this.isChecked = !!(this.value.id && ~items.indexOf(this.value.id));
      });
    },
  };
</script>
