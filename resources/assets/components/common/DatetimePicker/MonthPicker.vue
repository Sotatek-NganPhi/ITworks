<template>
  <div>
    <header>
      <span @click="backYear" class="prev cell glyphicon glyphicon-chevron-left btn-link" aria-hidden="true"></span>
      <span @click="showYearPicker" class="up"><a>{{ currentMoment.format('YYYY') }}</a></span>
      <span @click="nextYear" class="next cell glyphicon glyphicon-chevron-right btn-link" aria-hidden="true"></span>
    </header>
    <span class="cell month"
      v-for="month in months"
      v-bind:class="{ 'selected': month.isSelected, 'today': month.isThisMonth }"
      @click.stop="selectMonth(month)">{{ month.name }}
    </span>
  </div>
</template>

<script>
  import _ from 'lodash';
  import moment from 'moment';

  const MONTHS_OF_YEAR = 12;
  const MONTH_PICKER_STEP = 1;

  export default {
    data() {
      return {
      };
    },
    computed: {
      currentMoment() {
        return moment.unix(this.currentDate);
      },
      selectedMoment() {
        return this.selectedDate ? moment.unix(this.selectedDate) : null;
      },
      months() {
        const today = moment();
        const iteratorDate = moment(this.currentMoment.format());

        return _.range(0, MONTHS_OF_YEAR).map((month) => {
          iteratorDate.month(month);
          return {
            month,
            name: moment.months(month),
            isSelected: this.isSelectedMonth(iteratorDate),
            isThisMonth: iteratorDate.isSame(today, 'month'),
          };
        });
      },
    },
    props: ['currentDate', 'selectedDate', 'showYearPicker', 'showDayPicker'],
    methods: {
      selectMonth(month) {
        this.currentMoment.month(month.month);
        this.$emit('changedCurrentDate', this.currentMoment.unix());
        this.showDayPicker();
      },
      backYear() {
        this.currentMoment.subtract(MONTH_PICKER_STEP, 'year');
        this.$emit('changedCurrentDate', this.currentMoment.unix());
      },
      nextYear() {
        this.currentMoment.add(MONTH_PICKER_STEP, 'year');
        this.$emit('changedCurrentDate', this.currentMoment.unix());
      },
      isSelectedMonth(date) {
        if (!this.selectedMoment) {
          return false;
        }
        return date.isSame(this.selectedMoment, 'month');
      },
    },
  };
</script>
