import Vue from 'vue';
import SearchPanel from '../../../components/home/SearchPanel.vue';
import Masterdata from '../../../components/home/Masterdata.vue';

Vue.component('search-panel', SearchPanel);

var app = new Vue({
  el: '#search',
  extends: Masterdata,
  data: {
    url: window.location.href,
    unspecified: false,
    isFindMore: false,
    hideBtnExpand: true,
    limit: 10,
  },
  computed: {
    isUnspecified: function () {
      return (this.isEmpty(this.prefecture_id) &&
          this.isEmpty(this.line_id) &&
          this.isEmpty(this.ward_id) &&
          this.isEmpty(this.station_id) &&
          this.isEmpty(this.employment_mode_id) &&
          this.isEmpty(this.category_id) &&
          (!this.merits || this.merits.length === 0) &&
          this.isEmpty(this.free_word))
    },
  },
  watch: {
    limit: function(val) {
      let limitPage = this.getLimitPage();
      if(limitPage === val) {
        return;
      }
      if (~this.url.indexOf('limit')) {
        window.location.href = this.url.replace("limit=" + limitPage, "limit=" + val);
      }else {
        window.location.href = this.url + "&limit=" + val;
      }

    }
  },
  methods: {
    showSearchPanel: function () {
      this.isFindMore = !this.isFindMore;
    },

    getLimitPage: function () {
      let reg = new RegExp("limit=([^&]+)");
      let params = reg.exec(this.url);
      if (params === null) {
        return 10;
      }
      return parseInt(reg.exec(this.url)[1]);
    }
  },
  mounted(){
    this.prefecture_id = $("#prefecture_id").val() || "";
    this.category_id = $("#category_id").val() || "";
    this.line_id = $("#line_id").val() || "";
    this.ward_id = $("#ward_id").val()              || "";
    this.station_id = $("#station_id").val() || "";
    this.employment_mode_id = $("#employment_mode_id").val() || "";
    this.free_word = $("#free_word").val() || "";
    this.merits = ($("#merits").val() ? $("#merits").val().split(",") : null)|| "";
    this.limit = this.getLimitPage();
  }
});

export default app;