<template>
  <div class="vue-datepicker" :class="wrapperClass">
    <div class='input-group date'>
      <div class="vue-datepicker__input-outer">
        <input type="text" class="form-control vue-datepicker__input"
          :class="inputClass"
          :name="name"
          :id="id"
          @click="showDatetimePicker()"
          :value="formattedValue"
          :placeholder="placeholder"
          :disabled="disabledPicker"
          :required="required"
          readonly />
        <span
          v-if="!!selectedDate && !isOpening"
          class="form-control-clear glyphicon glyphicon-remove vue-datepicker__input-clear"
          @click="clear()">
        </span>
      </div>
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-calendar" @click="showDatetimePicker()"></span>
      </span>
    </div>
    <div v-show="isOpening" class="vue-datepicker__panel-outer">
      <div class="vue-datepicker__panel">
        <day-picker
          v-show="isDayPicking"
          ref="dayPicker"
          :currentDate="currentDate"
          :selectedDate="selectedDate"
          :showMonthPicker="showMonthPicker"
          :locale="locale"
          @changedSelectedDate="changedSelectedDate"
          @changedCurrentDate="changedCurrentDate">
        </day-picker>
        <month-picker
          v-show="isMonthPicking"
          ref="monthPicker"
          :currentDate="currentDate"
          :selectedDate="selectedDate"
          :showYearPicker="showYearPicker"
          :showDayPicker="showDayPicker"
          @changedCurrentDate="changedCurrentDate">
        </month-picker>
        <year-picker
          v-show="isYearPicking"
          ref="yearPicker"
          :currentDate="currentDate"
          :selectedDate="selectedDate"
          :showMonthPicker="showMonthPicker"
          @changedCurrentDate="changedCurrentDate">
        </year-picker>
        <time-picker
          v-show="isTimePicking"
          ref="timePicker"
          :currentDate="currentDate"
          :selectedDate="selectedDate"
          :showDayPicker="showDayPicker"
          :locale="locale"
          @changedSelectedDate="changedSelectedDate">
        </time-picker>
        <span class="picker-selector glyphicon glyphicon-time" aria-hidden="true"
          v-show="isDayPicking"
          @click="showTimePicker">
        </span>
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment';
  import TimePicker from './TimePicker.vue';
  import DayPicker from './DayPicker.vue';
  import MonthPicker from './MonthPicker.vue';
  import YearPicker from './YearPicker.vue';

  export default {
    data() {
      return {
        currentDate: moment().unix(),
        selectedDate: null,
        isTimePicking: false,
        isDayPicking: false,
        isMonthPicking: false,
        isYearPicking: false,
      };
    },
    components: {
      'time-picker': TimePicker,
      'day-picker': DayPicker,
      'month-picker': MonthPicker,
      'year-picker': YearPicker,
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
      format: {
        value: String,
        default: 'YYYY-MM-DD HH:mm:ss',
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
    watch: {
      value() {
        this.init();
      },
      formattedValue(value) {
        this.$emit('input', this.formattedValue);
      },
    },
    computed: {
      formattedValue() {
        if (!this.selectedDate) {
          return null;
        }
        return moment.unix(this.selectedDate).format(this.format);
      },
      isOpening() {
        return this.isDayPicking || this.isMonthPicking || this.isYearPicking || this.isTimePicking;
      },
    },
    methods: {
      close() {
        this.isDayPicking = false;
        this.isMonthPicking = false;
        this.isYearPicking = false;
        this.isTimePicking = false;
        this.$emit('closed');
      },
      showDatetimePicker() {
        if (this.isOpening) {
          return this.close();
        }

        this.currentDate = this.selectedDate || moment().unix();
        return this.showDayPicker();
      },
      showDayPicker() {
        this.close();
        this.isDayPicking = true;
      },
      showMonthPicker() {
        this.close();
        this.isMonthPicking = true;
      },
      showYearPicker() {
        this.close();
        this.isYearPicking = true;
      },
      showTimePicker() {
        this.close();
        this.isTimePicking = true;
      },
      changedSelectedDate(timestamp) {
        this.currentDate = timestamp;
        this.selectedDate = timestamp;
        if (this.isDayPicking) {
          this.close();
        }
      },
      changedCurrentDate(timestamp) {
        this.currentDate = timestamp;
      },
      clear() {
        this.selectedDate = null;
        this.currentDate = moment().unix();
      },
      init() {
        moment.locale(this.locale);
        if (this.value) {
          this.selectedDate = moment(this.value).unix();
        } else {
          this.selectedDate = "";
        }
      },
    },
    mounted() {
      this.init();
      document.addEventListener('click', (e) => {
        if (this.$el && !this.$el.contains(e.target)) {
          this.close();
        }
      }, false);
    },
  };
</script>

<style>

.vue-datepicker {
  position: relative;
  text-align: left;
  box-sizing: border-box;
}

.vue-datepicker__input {
  background: none !important;
  border-bottom-left-radius: 4px !important;
  border-top-left-radius: 4px !important;
  padding-right: 35px;
}

.vue-datepicker span {
  border-radius: 4px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
}

.vue-datepicker__panel-outer {
  position: absolute;
  z-index: 100;
  background: #fff;
  border-radius: 4px;
  border: 1px solid #ccc;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  background-clip: padding-box;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);

}

.vue-datepicker__panel {
  width: 300px;
  margin: 2px;
}

.vue-datepicker__panel header {
  display: block;
  line-height: 40px;
}

.vue-datepicker__panel header,
.vue-datepicker__panel .cell.day-header {
  font-weight: bold;
}

.vue-datepicker__panel header span {
  display: inline-block;
  text-align: center;
  width: 71.42857142857143%;
  float: left;
}

.vue-datepicker__panel header .prev,
.vue-datepicker__panel header .next {
  width: 14.285714285714286%;
}

.vue-datepicker__panel header .prev:not(.disabled),
.vue-datepicker__panel header .next:not(.disabled),
.vue-datepicker__panel header .up:not(.disabled),
.vue-datepicker__panel .picker-selector:not(.disabled) {
  cursor: pointer;
}


.vue-datepicker__panel header .prev:not(.disabled):hover,
.vue-datepicker__panel header .next:not(.disabled):hover,
.vue-datepicker__panel header .up:not(.disabled):hover,
.vue-datepicker__panel .picker-selector:not(.disabled):hover {
  background: #eee;
}

.vue-datepicker__panel .cell:not(.blank):not(.disabled).day:hover,
.vue-datepicker__panel .cell:not(.blank):not(.disabled).month:hover,
.vue-datepicker__panel .cell:not(.blank):not(.disabled).year:hover {
  background: #d9f2f9
}

.vue-datepicker__panel .disabled {
  color: #ddd;
  cursor: default;
}

.vue-datepicker__panel .cell {
  display: inline-block;
  padding: 0 5px;
  width: 14.285%;
  height: 40px;
  line-height: 40px;
  text-align: center;
  vertical-align: middle;
  border: 1px solid transparent;
}

.vue-datepicker__panel .cell:not(.blank):not(.disabled).day,
.vue-datepicker__panel .cell:not(.blank):not(.disabled).month,
.vue-datepicker__panel .cell:not(.blank):not(.disabled).year {
  cursor: pointer;
}

.vue-datepicker__panel .today {
  border: 1px solid #4bd;
}

.vue-datepicker__panel .cell.selected {
  background: #4bd;
}

.vue-datepicker__panel .cell.selected:hover {
  background: #4bd !important;
}

.vue-datepicker__panel .cell.day-header {
  white-space: no-wrap;
  cursor: inherit;
}

.vue-datepicker__panel .cell.day-header:hover {
  background: inherit;
}

.vue-datepicker__panel .month,
.vue-datepicker__panel .year {
  width: 33.333%;
}

.vue-datepicker__panel .picker-selector {
  width: 100%;
  height: 40px;
  line-height: 40px;
  text-align: center;
}

.vue-datepicker__panel-button {
  cursor: pointer;
  font-style: normal;
}

.vue-datepicker__input-outer {
  position: relative;
}
.vue-datepicker__input-clear {
  top: 0;
  right: 0;
  z-index: 2;
  cursor: pointer;
  display: block;
  width: 35px;
  height: 35px;
  line-height: 35px;
  text-align: center;
  position: absolute;
  pointer-events: auto;
}
</style>
