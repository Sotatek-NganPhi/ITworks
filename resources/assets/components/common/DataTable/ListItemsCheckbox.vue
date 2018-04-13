<template>
  <label class="__checkbox">
    <input @click="onChange" type="checkbox" v-model="isSelected">
    <span class="glyphicon" :class="isSelectedAll ? 'glyphicon-ok' : 'glyphicon-minus' " aria-hidden="true"></span>
  </label>
</template>

<script>
  export default {
    data() {
      return {
        isSelected: false,
        isSelectedAll: false,
      }
    },
    methods: {
      onChange() {
        this.$parent.$emit('DataTable:toggleListItems');
      },
    },
    created () {
      this.$parent.$on('DataTable:selectedItemChange', (items, size) => {
        this.isSelected = !!items.length > 0;
        this.isSelectedAll = items.length >= size;
      });
    },
    beforeDestroy () {
      this.$parent.$off('DataTable:selectedItemChange');
    },
  };
</script>
