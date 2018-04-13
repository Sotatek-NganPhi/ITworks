<template>
    <validation-form ref="specialForm">
        <form-group :label="getDisplayName('name')" :is-required="isFieldRequired('name')">
            <input class="form-control" name="getDisplayName('name')" type="text"
                  data-vv-name="name" v-model="promotion.name"/>
        </form-group>

        <form-group :label="getDisplayName('regions')" :is-required="isFieldRequired('regions')">
                <label class="checkbox-inline" v-for="region in regions">
                    <input type="checkbox"  name="getDisplayName('region.name')"  v-model="promotion.regions" :value="region.id"
                           data-vv-name="regions" @click="regionsChange"/>{{ region.name }}
                </label>
        </form-group>

        <form-group :label="getDisplayName('image')" :is-required="isFieldRequired('image')">
            <file-upload data-vv-name="image"
                         v-model="promotion.image" accept="image/*"></file-upload>
        </form-group>

        <form-group :label="getDisplayName('start_date')" :is-required="isFieldRequired('start_date')">
            <date-picker v-model="promotion.start_date" data-vv-name="start_date"
            format="YYYY-MM-DD" locale="ja" required></date-picker>
        </form-group>

        <form-group :label="getDisplayName('end_date')" :is-required="isFieldRequired('end_date')">
            <date-picker v-model="promotion.end_date"  data-vv-name="end_date"
                         format="YYYY-MM-DD" locale="ja" required></date-picker>
        </form-group>

        <form-group :label="getDisplayName('is_active')" :is-required="isFieldRequired('is_active')">
            <radio-group inline="true"  data-vv-name="is_active"
                         v-model="promotion.is_active" :options="activeOptions"/>
        </form-group>

        <form-group :label="getDisplayName('jobs')" :is-required="isFieldRequired('jobs')">
            <multiselect
                    v-model="selectedJobs"
                    :placeholder= "$t('common_action.pick')"
                    label="work_no"
                    track-by="id"
                    :options="jobList"
                    :multiple="true"
                    :close-on-select="false"
                    :clear-on-select="false"
                    :hide-selected="true"
                    @search-change="searchChange"
                    data-vv-name="jobs"
            ></multiselect>
        </form-group>

        <div class="text-center section-space">
            <button type="button" class="btn btn-primary btn-sm button-space" @click="showModal()">
                <span class="glyphicon glyphicon-ok"></span> {{ $t("common_action.ok") }}
            </button>
            <button type="button" class="btn btn-default btn-sm" @click="resetChange()">
                <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.cancel") }}
            </button>
        </div>
        <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                             @ConfirmationDialog:OK="updateChange"
                             :message="$t('message.before_update')">
        </confirmation-dialog>
    </validation-form>
</template>

<script>

  import _ from 'lodash';
  import Multiselect from 'vue-multiselect';
  import rf from '../../../js/lib/RequestFactory';
  import {user} from '../../../js/app/manage/main';
  import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
  import FileUpload from '../../../components/common/FileUpload.vue';
  import Utils from '../../../js/common/Utils';

  export default {
    components: {
      Multiselect,
      FileUpload
    },
    data() {
      return {
        user,
        subNavigators,
        masterdata: {},
        promotion: {
          is_active: 1,
          regions: [],
          jobs: [],
          start_date: '',
          end_date: '',
        },
        selectedJobs: [],
        oldPromotion: {},
        regions: [],
        jobList: [],
        activeOptions: Utils.getYesNoOptions(),
        isQuerySearch: false,
        isShowModal: false,
      }
    },
    methods: {
      regionsChange() {
        this.searchChange('');
        this.updateSelectedJobs();
      },
      searchChange(searchQuery) {
        if (this.isQuerySearch) return;
        this.isQuerySearch = true;
        rf.getRequest('JobRequest').getJobsQualified({
          'regionIds[]': this.promotion.regions,
          'query': searchQuery
        }).then(res => {
          this.jobList = res;
          this.isQuerySearch = false;
        });
      },
      showModal() {
        this.isShowModal = true;
      },
      updateSelectedJobs() {
        let self = this;
        this.selectedJobs = _.filter(this.selectedJobs, function (job) {
          let intersect = _.intersection(self.promotion.regions, job.regions);
          return intersect.length > 0;
        });
      },
      getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'special_promotions', fieldName);
      },
      isFieldRequired(fieldName) {
        return Utils.isFieldRequired(this.masterdata, 'special_promotions', fieldName);
      },
      resetChange() {
        this.$router.push({
          path: '/special/list',
        });
      },
      localReset() {
        this.promotion = JSON.parse(JSON.stringify(this.oldPromotion));
        rf.getRequest('JobRequest').getJobsWithIds(this.promotion.jobs).then(res => {
          this.selectedJobs = res;
        });
      },
      updateChange() {
        this.isShowModal = false;
        this.promotion.jobs = _.map(this.selectedJobs, 'id');

        const promotionPromise = (this.promotion && this.promotion.id)
            ? rf.getRequest('SpecialPromotionRequest').updateOne(this.promotion.id, this.promotion)
            : rf.getRequest('SpecialPromotionRequest').createANewOne(this.promotion);
        promotionPromise.then(res => {
          window.Utils.growl('request.request_success');
          if (!this.promotion.id) {
            this.$router.push({
              path: '/special/list',
            });
          }
          this.$refs.specialForm.$emit('REJECT_FORM', null);
        }).catch(({validationErrors}) => {
          if (validationErrors) {
            this.$refs.specialForm.$emit('REJECT_FORM', validationErrors);
          }
        });
      },
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      let id = this.$route.query.id;
      const promotionPromise = id
          ? rf.getRequest('SpecialPromotionRequest').getOne(id)
          : Promise.resolve(this.promotion)

      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();

      Promise.all([promotionPromise, masterdataPromise]).then(([promotion, masterdata]) => {
        this.oldPromotion = promotion;
        this.regions = masterdata.regions;
        this.masterdata = masterdata;
        rf.getRequest('JobRequest').getJobsQualified({'regionIds[]': promotion.regions, 'query': ''}).then(res => {
          this.jobList = res;
          this.localReset();
        });
      });
    }
  }
</script>

<style scoped>
  .section-space {
    padding-top: 30px;
  }

  .button-space {
    margin-right: 20px;
  }

  .upload-section {
    margin-top: 10px;
  }

  .checkbox-inline {
    margin-right: 15px;
  }

  .multiselect {
    z-index: 2;
  }
</style>
