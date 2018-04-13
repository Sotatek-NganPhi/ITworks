<template>
  <div>
    <label :class="inline ? 'radio-inline' : 'radio'" v-for="option in _options">
      <input @click="onChange(option.value)" type="radio" :name="name || defaultName" :value="option.value" :checked="isChecked(option.value)">
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
        this.$emit('input', option);
        this.$emit('change', option);
      },
      isChecked(option) {
        return this.value == option;
      },
    },
    created() {
      this.defaultName = `__radio_group_${this._uid}`;
    }
  };
</script>
