<script>

  if ((~window.navigator.userAgent.indexOf('MSIE')) ||
      (~window.navigator.userAgent.indexOf('Trident/')) ||
      (~window.navigator.userAgent.indexOf('Edge/'))) {
    window.Promise = require('es6-promise').Promise;
  }

  import _ from 'lodash';
  import rf from '../../js/lib/RequestFactory';

  export default {
    data: function () {
      return {
        isLoading: true,
        masterdata: {},
      }
    },
    computed: {
      keyRegion: {
        // getter
        get: function () {
          let keyRegion = "";
          let url = window.location.pathname;
          let pathName = url.split("/");
          let keyRegions = _.map(this.masterdata.regions, 'key');
          for (let i = 0; i < pathName.length; i++) {
            if (_.includes(keyRegions, pathName[i])) {
              keyRegion = pathName[i];
              break;
            }
          }
          return keyRegion || this.getParam(url, 'region');
        },
      },
    },
    methods: {
      pluck: function (table, attr) {
        return _.map(table, attr);
      },

      find: function (table, attr, val) {
        return _.find(table, function (row) {
          return row[attr] == val;
        });
      },

      where: function (table, attr, val) {
        return _.filter(table, function (row) {
          return row[attr] == val;
        });
      },

      whereIn: function (table, attr, vals) {
        return _.filter(table, function (row) {
          return _.includes(vals, row[attr]);
        });
      },

      getMasterdata: function () {

        rf.getRequest('MasterdataRequest').getAll().then(res => {
          this.masterdata = res;
          if (this.keyRegion) {
            this.region = this.find(this.masterdata.regions, "key", this.keyRegion);
            this.prefectures = this.where(this.masterdata.prefectures, "region_id", this.region.id);
          }
          this.isLoading = !this.isLoading;
        });
      },

      getParam: function (url, param) {
        var reg = new RegExp(param + "=([^&]+)");
        var val = reg.exec(url);
        if (val == null)
          return "";
        return reg.exec(url)[1];
      },

      isEmpty: function (data) {
        return data == null || data == "";
      },
    },
    created: function () {
      this.getMasterdata();
    }
  }
</script>
