import Vue from 'vue';
import SearchPanel from '../../../components/home/SearchPanel.vue';
import _ from 'lodash';
import $ from 'jquery';
import queryString from 'querystring';

Vue.component('search-panel', SearchPanel);

var app = new Vue({
  el: '#search',

  data: {
    urlRoot: window.location.pathname,
    isFindMore: false,
    hideBtnExpand: true,
    limit: 10,
    lineSelected: [],
    allStation: {},
    allStationKeyByLine: {},
    allLine: {},
    stations: [],
    stationSelected: [],
    prefectureId: 0
  },

  watch: {
    limit(val) {
      if (this.getLimitDefault() === val) {
        return;
      }
      if (window.location.search === "") {
        window.location.href = window.location.href + "?limit=" + val;
      } else {
        if (window.location.search.includes('limit')) {
          window.location.href = window.location.href.replace("limit=" + this.getLimitDefault(), "limit=" + val);
        } else {
          window.location.href = window.location.href + "&limit=" + val;
        }
      }
    },

    lineSelected(lineIds){
      if(!lineIds) {
        return;
      }


      lineIds = _.map(lineIds, (lineId) => {return parseInt(lineId)});

      let stations = [];
      this.stations = _.forEach(lineIds, (lineId) => {
        stations = _.concat(stations, this.allStationKeyByLine[lineId]);
      });

      this.stations = _.sortBy(_.unionBy(stations, (station) => {
        return station.name
      }), 'id');

      this.stationSelected = _.filter(this.stationSelected, (stationId) => {
        return _.includes(_.map(this.stations, 'id'), stationId);
      });
    }
  },

  methods: {
    showSearchPanel: function () {
      this.isFindMore = !this.isFindMore;
    },

    getLimitDefault: function () {
      const url = window.location.href;
      let reg = new RegExp("limit=([^&]+)");
      let params = reg.exec(url);
      if (params === null) {
        return 10;
      }
      return parseInt(reg.exec(url)[1]);
    },

    searchJob(params) {
      window.location.href = this.buildUrlSearchJob(params);
    },

    buildUrlSearchJob(params) {
      let url = this.urlRoot;
      let queryLine = {};
      let queryStation = {};

      if (this.lineSelected.length === 1) {
        if (url.slice(-1) !== '/') {
          url = url + '/';
        }
        url = url + this.findLineNameById(this.lineSelected[0]);

        if (this.stationSelected.length > 0) {
          if (this.stationSelected.length === 1) {
            url = url + '/stations/';
            url = url + this.findStationNameById(this.stationSelected[0]);
          } else {
            if (url.slice(-1) !== '?') {
              url = url + '?';
            }
            _.forEach(this.stationSelected, (stationId, index) => {
              queryStation["station" + (index + 1)] = this.findStationNameById(stationId);
            });

            url = url + queryString.stringify(Object.assign(queryStation));
          }
        }
        if (params) {
          if (url.includes('?')) {
            url = url + '&' + queryString.stringify(Object.assign(params));
          } else {
            url = url + '?' + queryString.stringify(Object.assign(params));
          }
        }
      } else {

        if (url.slice(-1) !== '?') {
          url = url + '?';
        }

        _.forEach(this.lineSelected, (lineId, index) => {
          queryLine["line" + (index + 1)] = this.findLineNameById(lineId);
        });
        if (this.stationSelected.length === 1) {
          queryStation['station'] = this.findStationNameById(this.stationSelected[0]);
        } else {
          _.forEach(this.stationSelected, (stationId, index) => {
            queryStation["station" + (index + 1)] = this.findStationNameById(stationId);
          });
        }
        url = url + queryString.stringify(Object.assign(queryLine, queryStation, params || {}));
      }
      return url;
    },

    setLineSelected() {
      let matchLine = window.location.pathname.match(/lines\/(\w)*/);
      let lineSelected = [];
      if (matchLine) {
        if (matchLine[0].split('/')[1] !== "") {
          const lineName = matchLine[0].split('/')[1];
          if (parseInt(this.findLineIdByName(lineName))) {
            lineSelected = _.concat(lineSelected, parseInt(this.findLineIdByName(lineName)));
          }
        }
      } else {
        const queryParams = queryString.parse(window.location.search);
        _.forEach(queryParams, (value, key) => {
          if (key.includes('line')) {
            if (parseInt(this.findLineIdByName(value))) {
              lineSelected = _.concat(lineSelected, parseInt(this.findLineIdByName(value)));
            }
          }
        });
      }

      this.lineSelected = _.uniq(lineSelected);
      if (this.lineSelected.length === 1) {
        this.urlRoot = this.urlRoot.split('lines/')[0] + 'lines';
      }

    },

    setStationSelected() {
      let matchStation = window.location.pathname.match(/stations\/(\w)*/);
      let stationSelected = [];
      if (matchStation) {
        if (matchStation[0].split('/')[1] !== "") {
          const stationName = matchStation[0].split('/')[1];
          if (parseInt(this.findStationIdByName(stationName))) {
            stationSelected = _.concat(stationSelected, parseInt(this.findStationIdByName(stationName)));
          }
        }
      } else {
        const queryParams = queryString.parse(window.location.search);
        _.forEach(queryParams, (value, key) => {
          if (key.includes('station')) {
            if (parseInt(this.findStationIdByName(value))) {
              stationSelected = _.concat(stationSelected, parseInt(this.findStationIdByName(value)));
            }
          }
        });
      }
      this.stationSelected = _.uniq(stationSelected);
    },

    findLineIdByName(lineName) {
      const line = _.find(this.allLine, (l) => {
        return l.name_en === lineName;
      });
      if (line) {
        return line['id'];
      }
    },

    findLineNameById(lineId) {
      const line = _.find(this.allLine, (l) => {
        return parseInt(l.id) === parseInt(lineId);
      });
      if (line) {
        return line['name_en'];
      }
    },

    findStationIdByName(stationName) {
      const station = _.find(this.allStation, (s) => {
        return s.name_en === stationName &&
            parseInt(s.prefecture_id) === parseInt(this.prefectureId) &&
            _.includes(this.lineSelected, s.line_id);
      });
      if (station) {
        return station['id'];
      }
    },

    findStationNameById(stationId) {
      const station = _.find(this.allStation, (s) => {
        return parseInt(s.id) === parseInt(stationId);
      });
      if (station) {
        return station['name_en'];
      }
    }
  },

  mounted() {
    this.prefectureId = $("input[name='prefecture_id']").val();
    this.allStation = JSON.parse($("input[name='allStation']").val());
    this.allLine = JSON.parse($("input[name='allLine']").val());
    this.allStationKeyByLine = _.groupBy(this.allStation, 'line_id');
    this.limit = this.getLimitDefault();
    this.setLineSelected();
    this.setStationSelected();
  }
});

export default app;