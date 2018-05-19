import Vue from 'vue';
import rf from '../../../js/lib/RequestFactory';
import _ from 'lodash';

if ((~window.navigator.userAgent.indexOf('MSIE')) ||
    (~window.navigator.userAgent.indexOf('Trident/')) ||
    (~window.navigator.userAgent.indexOf('Edge/'))) {
  window.Promise = require('es6-promise').Promise;
}

var app = new Vue({
  el: '#candidate_resume',
  data: {
    candidate: {},
    masterdata: {},
    application: {},
    is_reviewing: false,
    check_failed: false,
  },
  methods: {
    checkValue: function(value, type) {
      if (type == 'number') {
        var phoneNumber = value.split('-');
        var not_valid = false;
        _.each(phoneNumber, function (item) {
          if (isNaN(item) || item == '' || item == null) {
            not_valid = true;
            return false;
          }
        });
        return not_valid;
      } else if (type == 'text') {
        return value == '' || value == null;
      }
    },
    review: function() {
      this.is_reviewing = true;
      if (this.checkValue(this.candidate.resume_prefectures_id, 'text') ||
          this.checkValue(this.candidate.address, 'text') ||
          this.checkValue(this.candidate.phone_number, 'text') ||
          this.checkValue(this.candidate.resume_pr, 'text') ||
          this.checkValue(this.candidate.final_academic_school, 'text')) {
        this.check_failed = true;
        return
      }
      this.check_failed = false;
    },
    endReview: function() {
      this.is_reviewing = false;
    },
    submit: function () {
      if (this.check_failed) return;
      rf.getRequest('UserCandidateRequest')
        .updateCandidate(this.candidate)
        .then(res => {
          $( "#resume-form" ).hide();
          $( "#resume-updated" ).show();
        })
        .catch(err => {
          console.error(err);
        });
    }
  },
  computed: {
    prefecture: function () {
      var prefecture = _.find(this.masterdata.prefectures, ['id', this.candidate.resume_prefectures_id]);
      if (prefecture) {
        return prefecture.name;
      }
    }
  },
  created() {
    $( "#resume-updated").hide();
    this.candidate = window.candidate;
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();

    Promise.all([masterdataPromise]).then(([masterdata]) => {
      this.masterdata = masterdata;
    });
  }
});

export default app;
