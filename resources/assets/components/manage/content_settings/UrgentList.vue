<template>
  <div>
    <form class="form-horizontal">

      <form-group :label="this.getDisplayName('region')">
        <select class="form-control" type="text" v-model="selectedRegionId">
          <option v-for="region in masterdata.regions" :key="region.id" :value="region.id">{{ region.name }}</option>
        </select>
      </form-group>

      <div class="form-group">
        <label class="col-sm-2 control-label">{{this.getDisplayName('urgentJobs')}}</label>
        <div class="col-sm-10">
          <multiselect
            v-model="selectedJobs"
            :placeholder= "$t('common_action.pick')"
            label="work_no"
            track-by="id"
            :options="allJobs"
            :multiple="true"
            :close-on-select="false"
            :hide-selected="true"
          ></multiselect>
        </div>
      </div>

      <br>
      <br>

    </form>

    <div class="text-center">
      <button type="button" class="btn btn-primary btn-sm" @click="updateChange()">
        <span class="glyphicon glyphicon-ok"></span> {{ $t("common_action.ok") }}
      </button>
      <button type="button" class="btn btn-default btn-sm" @click="resetChange()">
        <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.cancel  ") }}
      </button>
    </div>
  </div>
</template>

<script>

import _ from 'lodash';
import async from 'async';
import Multiselect from 'vue-multiselect';
import Utils from '../../../js/common/Utils';
import rf from '../../../js/lib/RequestFactory';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
import constant from '../../../js/common/Const.js';


let masterdata = {
  regions:[],
};

export default {
  components: {
    Multiselect
  },

  data() {
    return {
      constant,
      subNavigators,
      masterdata,
      allJobs: [],
      selectedRegionId: 0,
      jobUrgentValid: 1,
      selectedJobIds: [],
      oldSelectedJobIds: [],
    };
  },

  watch: {
    selectedRegionId (value) {
      if (!value) return;
      this.fetchData();
    },

  },

  computed: {
    selectedJobs: {
      get() {
        return _.chain(this.allJobs)
                .filter(job => _.includes(this.selectedJobIds, job.id))
                .value();
      },
      set(value) {
        this.selectedJobIds = _.map(value, 'id');
      }
    }
  },

  methods: {
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'urgents', fieldName);
    },

    fetchData() {
      // TODO: using search box instead of fetching too much records
      const allJobsPromise = rf.getRequest('JobRequest').getUrgentJobs(this.selectedRegionId);
      allJobsPromise.then(jobs => {
        this.allJobs = jobs;
        this.resetChange();
      });

      this.$router.push({
        path: '/urgent/list',
        query: {
          regionId: this.selectedRegionId
        }
      });
    },

    updateChange() {
      let addUrgentJobIds = _.difference(this.selectedJobIds, this.oldSelectedJobIds);
      let delUrgentJobIds = _.difference(this.oldSelectedJobIds, this.selectedJobIds);
      let params = {
        region_id: this.selectedRegionId,
        add_job_ids: addUrgentJobIds,
        del_job_ids: delUrgentJobIds
      };

      rf.getRequest('JobRequest')
        .updateUrgentJobs(params)
        .then(res => {
          this.fetchData();
          window.Utils.growl('request.request_success');
        })
        .catch(({ err }) => {
          if (err) {
            window.EventBus.$emit('EVENT_COMMON_ERROR', err);
          }
        });
    },

    resetChange() {
      this.oldSelectedJobIds = _.chain(this.allJobs)
                                .filter(job => {
                                  return (parseInt(job.platform_urgent) === parseInt(this.jobUrgentValid));
                                })
                                .map('id')
                                .value();
      this.selectedJobIds = JSON.parse(JSON.stringify(this.oldSelectedJobIds));
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    masterdataPromise.then((masterdata) => {
      this.masterdata = masterdata;
      let regionId = this.$route.query.regionId;
      if (regionId) {
        this.selectedRegionId = parseInt(regionId);
      }

      this.resetChange();
    });
  }
}
</script>

<style scoped>
  .div-inline{
    display:inline-block;
  }

  .row {
    padding-bottom: 5px;
  }
</style>