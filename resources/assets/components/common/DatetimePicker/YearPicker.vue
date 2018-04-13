<template>
  <div>
    <header>
      <span @click="backDecade" class="prev cell glyphicon glyphicon-chevron-left btn-link" aria-hidden="true"></span>
      <span>{{ `${decade}\'s` }}</span>
      <span @click="nextDecade" class="next cell glyphicon glyphicon-chevron-right btn-link" aria-hidden="true"></span>
    </header>
    <span
      class="cell year"
      v-for="year in years"
      :class="{ 'selected': year.isSelected, 'today': year.isThisYear }"
      @click.stop="selectYear(year)">{{ year.year }}</span>
  </div>
</template>

<script>
  import _ from 'lodash';
  import moment from 'moment';

  const YEAR_PICKER_STEP = 10;
  const YEARS_OF_DECADE = 10;
  const MIN_MOMENT_JS_YEAR = -270000;
  const MAX_MOMENT_JS_YEAR = 270000;

  export default {
    data() {
      return {
      };
    },
    computed: {
      decade() {
        return Math.floor(this.currentMoment.year() / 10) * 10;
      },
      currentMoment() {
        return moment.unix(this.currentDate);
      },
      selectedMoment() {
        return this.selectedDate ? moment.unix(this.selectedDate) : null;
      },
      years() {
        const today = moment();
        return _.range(0, YEARS_OF_DECADE).map((yearOfDecade) => {
          const year = this.decade + yearOfDecade;
          return {
            year,
            isSelected: this.isSelectedYear(yearOfDecade),
            isThisYear: year === today.year(),
          };
        });
      },
    },
    props: ['currentDate', 'selectedDate', 'showMonthPicker'],
    methods: {
      selectYear(year) {
        this.currentMoment.year(year.year);
        this.$emit('changedCurrentDate', this.currentMoment.unix());
        this.showMonthPicker();
      },
      backDecade() {
        if (this.currentMoment.year() - YEAR_PICKER_STEP <= MIN_MOMENT_JS_YEAR) {
          return;
        }
        this.currentMoment.subtract(YEAR_PICKER_STEP, 'year');
        this.$emit('changedCurrentDate', this.currentMoment.unix());
      },
      nextDecade() {
        if (this.currentMoment.year() + YEAR_PICKER_STEP >= MAX_MOMENT_JS_YEAR) {
          return;
        }
        this.currentMoment.add(YEAR_PICKER_STEP, 'year');
        this.$emit('changedCurrentDate', this.currentMoment.unix());
      },
      isSelectedYear(year) {
        if (!this.selectedMoment) {
          return false;
        }
        return this.decade + year === this.selectedMoment.year();
      },
    },
  };
</script>
