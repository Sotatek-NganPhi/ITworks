<template>
  <div>
    <header>
      <span @click="backMonth" class="prev cell glyphicon glyphicon-chevron-left btn-link" aria-hidden="true"></span>
      <span @click="showMonthPicker" class="up">
        <a> {{ currentMoment.format('MMM') }} {{ currentMoment.format('YYYY') }} </a>
      </span>
      <span @click="nextMonth" class="next cell glyphicon glyphicon-chevron-right btn-link" aria-hidden="true"></span>
    </header>
    <span class="cell day-header" v-for="dayOfWeek in weekdays">{{ dayOfWeek }}</span>
    <span class="cell day blank" v-for="blank in blankDays"></span
    ><span class="cell day"
      v-for="day in days"
      :class="{ 'selected':day.isSelected, 'today': day.isToday }"
      @click="selectDate(day)">{{ day.date }}
    </span>
  </div>
</template>

<script>
  import _ from 'lodash';
  import moment from 'moment';

  const DAY_PICKER_STEP = 1;

  export default {
    computed: {
      currentMoment() {
        return moment.unix(this.currentDate);
      },
      selectedMoment() {
        return this.selectedDate ? moment.unix(this.selectedDate) : null;
      },
      weekdays() {
        moment.locale(this.locale);
        return moment.weekdaysShort();
      },
      blankDays() {
        const firstDayOfMonth = moment(this.currentMoment.format('YYYY-MM'));
        return firstDayOfMonth.weekday();
      },
      days() {
        const today = moment();
        const daysInMonth = this.currentMoment.daysInMonth();
        const iteratorDate = moment(this.currentMoment.format('YYYY-MM'));

        return _.range(1, daysInMonth + 1).map((dayInMonth) => {
          iteratorDate.date(dayInMonth);
          return {
            date: iteratorDate.date(),
            isSelected: this.isSelectedDate(iteratorDate),
            isToday: iteratorDate.isSame(today, 'day'),
          };
        });
      },
    },
    props: ['currentDate', 'selectedDate', 'showMonthPicker', 'locale'],
    methods: {
      selectDate(day) {
        this.currentMoment.date(day.date);
        this.$emit('changedSelectedDate', this.currentMoment.unix());
      },
      backMonth() {
        this.currentMoment.subtract(DAY_PICKER_STEP, 'month');
        this.$emit('changedCurrentDate', this.currentMoment.unix());
      },
      nextMonth() {
        this.currentMoment.add(DAY_PICKER_STEP, 'month');
        this.$emit('changedCurrentDate', this.currentMoment.unix());
      },
      isSelectedDate(date) {
        if (!this.selectedMoment) {
          return false;
        }
        return date.isSame(this.selectedMoment, 'day');
      },
    },
  };
</script>
