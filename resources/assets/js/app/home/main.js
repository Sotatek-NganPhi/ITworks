import Vue from 'vue';
import _ from 'lodash';
import axios from 'axios';
import SearchPanel from '../../../components/home/SearchPanel.vue';
import $ from 'jquery';

if ((~window.navigator.userAgent.indexOf('MSIE')) ||
    (~window.navigator.userAgent.indexOf('Trident/')) ||
    (~window.navigator.userAgent.indexOf('Edge/'))) {
  window.Promise = require('es6-promise').Promise;
}
window._ = _;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  alert('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.component('search-panel', SearchPanel);
var app = new Vue({
  el: '#home',
  data: {
    enableAdvanced: false,
    unspecified: false,
    hideBtnExpand: true,
  },
  computed: {
    keyRegion: {
      // getter
      get: function () {
        let keyRegion = "";
        let pathName = window.location.pathname.split("/");
        for (let i = 0; i< pathName.length; i++){
          if(_.includes(["hanoi ", "hochiminh", "mienbac", "mientrung", "miennam"], pathName[i])){
            keyRegion = pathName[i];
            break;
          }
        }
        return keyRegion || "";
      },
    },
  },
  methods: {
    toggleSearchAdvanced: function () {
      this.enableAdvanced = !this.enableAdvanced;
    },
    playVideo: function (event) {
      $(event.target).parent().hide();
      $(event.target).parent().next().show();
      $(event.target).parent().next()[0].src += "?autoplay=1";
    }
  },
  created() {
    $(".video").show();
    $(".thumbnail-section").css("height", $(".video-frame").height());
    $(".thumbnail-section").css("width", $(".video-frame").width());
  }
});

export default app;