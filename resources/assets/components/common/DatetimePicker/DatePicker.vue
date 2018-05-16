<template>
  <div class="form-inline" :class="wrapperClass">
      <label> {{ placeholder }} </label>
      <select :disabled="disabledPicker" :required="required" class="form-control" v-model="month">
        <option value=""> {{ monthPlaceholder }} </option>
        <option :value="key" v-for="(month, key) in months">{{ month }}</option>
      </select>
      <select :disabled="disabledPicker" :required="required" class="form-control" v-model="day">
        <option value=""> {{ dayPlaceholder }} </option>
        <option :value="day" v-for="day in days">{{ day }}</option>
      </select>
      <input
        :disabled="disabledPicker"
        :required="required"
        type="text" class="form-control"
        :placeholder="yearPlaceholder"
        v-model="year"
        maxlength="4">
      <input type="hidden" :name="name" :id="id" :value="formattedValue">
  </div>
</template>

<script>
  import _ from 'lodash';
  import moment from 'moment';
  const MAXIMUM_MONTH_DAY = 31;
  const DEFAULT_LOCALE = 'en';
  moment.locale(DEFAULT_LOCALE);

  export default {
    data() {
      return {
        months: moment.months(),
        days: [...Array(MAXIMUM_MONTH_DAY).keys()].map(key => key + 1),
        month: '',
        day: '',
        year: '',
        dayPlaceholder: '--Ngày--',
        monthPlaceholder: '--Tháng--',
        yearPlaceholder: 'Năm',
      };
    },
    watch: {
      value() {
        this.init();
      },
      formattedValue(value) {
        this.$emit('input', value);
      },
    },
    props: {
      value: {
        validator(val) {
          return val === null || val instanceof Date || typeof val === 'string';
        },
      },
      name: {
        value: String,
      },
      id: {
        value: String,
      },
      locale: {
        value: String,
        default: 'en',
      },
      placeholder: {
        type: String,
      },
      inputClass: {
        type: String,
      },
      wrapperClass: {
        type: String,
      },
      disabledPicker: {
        type: Boolean,
        default: false,
      },
      required: {
        type: Boolean,
        default: false,
      },
    },
    computed: {
      formattedValue() {
        if (!this.month && !this.day && !this.year) {
          return '';
        }
        const day = _.padStart(this.day, 2, '0');
        const month = _.padStart(this.month + 1, 2, '0');
        const year = this.year;
        return `${year}-${month}-${day}`
      },
    },
    methods: {
      init() {
        const selectedDate = moment(this.value);
        if(this.value === this.formattedValue) return;
        if (this.value && selectedDate.isValid()) {
          this.day = selectedDate.date();
          this.month = selectedDate.month();
          this.year = selectedDate.year().toString();
        } else {
          this.day = '';
          this.month = '';
          this.year = '';
        }
      },
    },
    created() {
      this.init();
    }
  };
</script>

<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
</style>
