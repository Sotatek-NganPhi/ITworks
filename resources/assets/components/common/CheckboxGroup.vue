<template>
  <div>
    <label :class="inline ? 'checkbox-inline' : 'checkbox'" v-for="option in _options">
      <input @click="onChange(option.value)" type="checkbox" :name="name || defaultName" :value="option" :checked="isChecked(option.value)">
      {{ option.key }}
    </label>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        defaultName: '',
      }
    },
    computed: {
      _options() {
        if (!this.options) return [];
        if (!Array.isArray(this.options)) {
          return Object.keys(this.options).map(key => ({key, value: this.options[key]}));
        }

        return this.options.map((option, index) => {
          const value = this.tracker ? option[this.tracker] : option.id;
          const key = this.label ? option[this.label] : index;
          return { key, value };
        });
      },
    },
    props: ['options', 'value', 'name', 'inline', 'tracker', 'label'],
    methods: {
      onChange(option) {
        const index = this.value.indexOf(option);
        !~index ? this.value.push(option) : this.value.splice(index, 1);
        this.$emit('input', this.value);
        this.$emit('change', this.value);
      },
      isChecked(option) {
        return ~this.value.indexOf(option);
      },
    },
    created() {
      this.defaultName = `__checkbox_group_${this._uid}`;
    }
  };
</script>
