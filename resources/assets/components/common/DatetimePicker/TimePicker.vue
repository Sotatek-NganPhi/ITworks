<template>
  <div>
    <div class="header">
      <span>{{localization.hour}}</span>
      <span>{{localization.minute}}</span>
      <span>{{localization.second}}</span>
    </div>
    <div class="select-list">
      <ul>
        <li v-for="hour in hours"
          @click="selectTime(hour, 'hours')"
          :class="{ 'selected': isSelected(hour, 'hours') }">
          {{hour}}
        </li>
      </ul>
      <ul>
        <li v-for="minute in minutes"
          @click="selectTime(minute, 'minutes')"
          :class="{ 'selected': isSelected(minute, 'minutes') }">
          {{minute}}
        </li>
      </ul>
      <ul>
        <li v-for="second in seconds"
          @click="selectTime(second, 'seconds')"
          :class="{ 'selected': isSelected(second, 'seconds') }">
          {{second}}
        </li>
      </ul>
    </div>
    <span @click="showDayPicker" class="picker-selector glyphicon glyphicon-calendar" aria-hidden="true"></span>
  </div>
</template>

<script>
  import _ from 'lodash';
  import moment from 'moment';

  const LOCALIZATION = {
    en: {
      hour: 'Hour',
      minute: 'Minute',
      second: 'Second',
    },
    ja: {
      hour: 'Hour',
      minute: 'Minute',
      second: 'Second',
    },
    ch: {
      hour: 'Hour',
      minute: 'Minute',
      second: 'Second',
    },
  };

  const HOURS_OF_DAY = 24;
  const MINUTES_OF_HOUR = 60;
  const SECONDS_OF_MINUTE = 60;

  export default {
    data() {
      return {
        selectedTime: null,
        localization: null,
        hours: _.range(0, HOURS_OF_DAY),
        minutes: _.range(0, MINUTES_OF_HOUR),
        seconds: _.range(0, SECONDS_OF_MINUTE),
      };
    },
    computed: {
      selectedMoment() {
        return this.selectedDate ? moment.unix(this.selectedDate) : moment.unix(this.currentDate);
      },
    },
    props: ['currentDate', 'selectedDate', 'showDayPicker', 'locale'],
    methods: {
      isSelected(value, type) {
        return this.selectedMoment[type]() === value;
      },
      selectTime(value, type) {
        this.selectedMoment[type](value);
        this.$emit('changedSelectedDate', this.selectedMoment.unix());
        this.$forceUpdate();
      },
    },
    created() {
      this.localization = LOCALIZATION[this.locale] || LOCALIZATION.en;
    },
  };
</script>
<style type="text/css" scoped>

.select-list {
  width: 100%;
  height: 10em;
  overflow: hidden;
  display: flex;
  flex-flow: row nowrap;
  align-items: stretch;
  justify-content: space-between;
}

.select-list ul {
  padding: 0;
  margin: 0;
  list-style: none;
  flex: 1;
  overflow-x: hidden;
  overflow-y: auto;
}

.select-list li {
  border-radius: 4px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
}

.select-list ul li {
  text-align: center;
  padding: 0.3em 0;
}

.select-list ul li:hover {
  background: #d9f2f9;
  cursor: pointer;
}

.header {
  width: 100%;
  height: 40px !important;
  cursor: default;
  font-weight: bold;
  text-align: center;
  vertical-align: middle;
  line-height: 40px;
}
.header span {
  width: 32%;
  background: none;
  display: inline-block;
}
.header span:hover {
  background: none;
}

.selected {
  background: #4bd;
}

.selected:hover {
  background: #4bd !important;
}

</style>
