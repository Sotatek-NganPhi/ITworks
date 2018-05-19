import Vue from 'vue';
import _ from 'lodash';
import jQuery from 'jquery';
import rf from '../../../js/lib/RequestFactory';
if ((~window.navigator.userAgent.indexOf('MSIE')) ||
    (~window.navigator.userAgent.indexOf('Trident/')) ||
    (~window.navigator.userAgent.indexOf('Edge/'))) {
  window.Promise = require('es6-promise').Promise;
}
window.jQuery = jQuery;
window._ = _;

var app = new Vue({
  el: "#job_detail",
  data: {
    rowLimit: 3,
    similarCategoryJob: [],
    historyJob: [],
    similarCategoryHistoryJob: [],


  },
  methods: {
    joinList: function (list, name) {
      return _.map(list, name).join(', ');
    },
    limit: function(arr) {
      return arr.slice(0, Number(this.rowLimit));
    },
    goToJob: function (id) {
      window.open('/job/' + id);
    },

    getRecentJobIds() {
      const recentJobIds = JSON.parse(localStorage.getItem("recentViewedJobIds"));
      if (recentJobIds && recentJobIds.length > 0) {
        return recentJobIds.join(',');
      }
      return [];
    }
  },
  created() {
    const jobIds = this.getRecentJobIds();
    rf.getRequest('UserCandidateRequest').getJobReference({
      job_id: $("input[name='job_id']").val(),
      history: jobIds,
    })
      .then(res => {
        this.similarCategoryJob = res.similar_category;
        this.historyJob = res.history;
        this.similarCategoryHistoryJob = res.similar_category_history;
        Vue.nextTick(() => {
          window.$('.big-slider').slick({
            infinite: true,
            slidesToShow: 6,
            slidesToScroll: 1,
            variableWidth: true
          });
          window.$('.small-slider').slick({
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            variableWidth: true
          });
        })
      });
  },
});

export default app;