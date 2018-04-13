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
    allWard: {},
    wardSelected: [],
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
      let queryWard = {};

      if (this.wardSelected.length === 1) {
        if (url.slice(-1) !== '/') {
          url = url + '/';
        }
        url = url + this.findWardNameById(this.wardSelected[0]);
        if (params) {
          url = url + '?' + queryString.stringify(Object.assign(params));
        }
      } else {
        if (url.slice(-1) !== '?') {
          url = url + '?';
        }

        _.forEach(this.wardSelected, (wardId, index) => {
          queryWard["ward" + (index + 1)] = this.findWardNameById(wardId);
        });

        url = url + queryString.stringify(Object.assign(queryWard, params || {}));
      }
      return url;
    },

    setWardSelected() {
      let matchWard = window.location.pathname.match(/wards\/(\w)*/);
      if (matchWard) {
        if (matchWard[0].split('/')[1] !== "") {
          const wardName = matchWard[0].split('/')[1];
          if (parseInt(this.findWardIdByName(wardName))) {
            this.wardSelected = _.concat(this.wardSelected, parseInt(this.findWardIdByName(wardName)));
          }
        }
      } else {
        const queryParams = queryString.parse(window.location.search);
        _.forEach(queryParams, (value, key) => {
          if (key.includes('ward')) {
            if (parseInt(this.findWardIdByName(value))) {
              this.wardSelected = _.concat(this.wardSelected, parseInt(this.findWardIdByName(value)));
            }
          }
        });
      }
      this.wardSelected = _.uniq(this.wardSelected);
      if (this.wardSelected.length === 1) {
        this.urlRoot = this.urlRoot.split('wards/')[0] + 'wards';
      }
    },

    findWardIdByName(wardName) {
      const ward = _.find(this.allWard, (w) => {
        return w.name_en === wardName;
      });
      if (ward) {
        return ward['id'];
      }
    },

    findWardNameById(wardId) {
      const ward = _.find(this.allWard, (w) => {
        return parseInt(w.id) === parseInt(wardId) && parseInt(w.prefecture_id) === parseInt(this.prefectureId);
      });
      if (ward) {
        return ward['name_en'];
      }
    }
  },

  mounted() {
    this.prefectureId = $("input[name='prefecture_id']").val();
    this.allWard = JSON.parse($("input[name='allWard']").val());
    this.limit = this.getLimitDefault();
    this.setWardSelected();
    window.$ = $;
  }
});

export default app;