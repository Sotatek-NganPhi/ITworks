<template>
  <div>
    <form class="form-horizontal" style="margin-bottom: 70px">
      <template>
        <validation-form ref="jobEdit">
          <div>
            <span class="glyphicon glyphicon-triangle-bottom"></span>
            <span>{{$t('job_edit.group_1')}}</span>
          </div>

          <form-group :label="getDisplayName('id')"
                      :is-required="isFieldRequired('id')">
            <input class="form-control" type="text" data-vv-name="id"
                   v-model="record.id" disabled/>
          </form-group>
          <form-group :label="getDisplayName('companies.name')"
                      :is-required="isFieldRequired('companies.name')">
            <select v-model="record.company" class="form-control" data-vv-name="company">
              <option value="">---</option>
              <option :value="company.id" v-for="company in companies" :key="company.id">
                {{company.name}}
              </option>
            </select>
          </form-group>

          <form-group :label="getDisplayName('post_start_date')"
                      :is-required="isFieldRequired('post_start_date')">
            <date-picker v-model="record.post_start_date"
                         format="YYYY-MM-DD" locale="en" data-vv-name="post_start_date"></date-picker>
          </form-group>

          <form-group :label="getDisplayName('post_end_date')"
                      :is-required="isFieldRequired('post_end_date')">
            <date-picker v-model="record.post_end_date"
                         format="YYYY-MM-DD" locale="en" data-vv-name="post_end_date"></date-picker>
          </form-group>
          <div>
            <span class="glyphicon glyphicon-triangle-bottom"></span>
            <span>{{$t('job_edit.group_2')}}</span>
          </div>
          <form-group :label="getDisplayName('description')"
                      :is-required="isFieldRequired('description')">
            <textarea class="form-control" data-vv-name="description"
                      cols="150" v-model="record.description"></textarea>
          </form-group>
          <div>
            <span class="glyphicon glyphicon-triangle-bottom"></span>
            <span>{{$t('job_edit.group_3')}}</span>
          </div>

          <!-- <form-group :label="getDisplayName('company_name')"
                      :is-required="isFieldRequired('company_name')">
            <textarea class="form-control" data-vv-name="company_name"
                      cols="150" v-model="record.company_name"></textarea>
          </form-group> -->

          <form-group :label="getDisplayName('salary')" :is-required="isFieldRequired('salary')">
            <textarea class="form-control" data-vv-name="salary" v-model="record.salary"></textarea>
          </form-group>

          <form-group :label="getDisplayName('application_condition')"
                      :is-required="isFieldRequired('application_condition')">
            <textarea class="form-control" data-vv-name="application_condition"
                      v-model="record.application_condition"></textarea>
          </form-group>
          <form-group :label="getDisplayName('message')"
                      :is-required="isFieldRequired('message')">
            <textarea class="form-control" data-vv-name="message"
                      cols="150" v-model="record.message"></textarea>
          </form-group> 

          <form-group :label="getDisplayName('interns_start_time')"
                      :is-required="isFieldRequired('interns_start_time')">
            <textarea class="form-control" data-vv-name="interns_start_time"
                      v-model="record.interns_start_time"></textarea>
          </form-group>
          <form-group :label="getDisplayName('images')">
            <file-upload v-model="record.main_image" accept="image/*"></file-upload>
          </form-group>
          <div>
            <span class="glyphicon glyphicon-triangle-bottom"></span>
            <span>{{$t('job_edit.group_5')}}</span>
          </div>

          <form-group :label="getDisplayName('email_receive_applicant')"
                      :is-required="isFieldRequired('email_receive_applicant')">
            <input class="form-control"
                   data-vv-name="email_receive_applicant"
                   type="text" v-model="record.email_receive_applicant"/>
          </form-group>
        </validation-form>
      </template>
    </form>
    <div class="col-sm-12">
      <div class="text-center btn-control">
        <button type="button" class="btn btn-primary btn-sm" @click="showModal()">
          <span class="glyphicon glyphicon-ok"></span> {{$t("common_action.ok")}}
        </button>
        <button type="button" class="btn btn-default btn-sm" @click="cancel()">
          <span class="glyphicon glyphicon-remove"></span> {{$t("common_action.cancel")}}
        </button>
      </div>
    </div>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="updateChange" :message="$t('message.before_update')">
    </confirmation-dialog>
  </div>
</template>

<script>

  import _ from 'lodash';
  import Multiselect from 'vue-multiselect';
  import Utils from '../../../js/common/Utils';
  import rf from '../../../js/lib/RequestFactory';
  import {user} from '../../../js/app/manage/main';
  import {jobNavigators as subNavigators} from '../../../js/app/manage/routes';
  import FileUpload from '../../../components/common/FileUpload.vue';

  let defaultJob = {
    post_end_date: '',
    post_start_date: '',
    description: '',
    companies: '0',
    company_name: '',
    max_applicant: '',
    salary: '',
    application_condition: '',
    message: '',
    email_receive_applicant: '',
  };

  export default {
    components: {
      Multiselect,
      FileUpload
    },

    data() {
      return {
        user,
        subNavigators,
        record: {},
        oldRecord: {},
        companies: [],
        agencies: [],
        masterdata: Utils.getMasterdataSkel(),
        isShowModal: false
      };
    },

    computed: {

      filteredWards() {
        let selectedPrefectureIds = _.map(this.selectedPrefectures, 'id');
        return _.chain(this.masterdata.wards)
            .filter(ward => {
              return _.includes(selectedPrefectureIds, ward.prefecture_id);
            })
            .value();
      },

      selectedWards: {
        get () {
          let keyedWards = _.keyBy(this.masterdata.wards, 'id');
          let selectedPrefectureIds = _.map(this.selectedPrefectures, 'id');
          return _.chain(this.record.wards)
              .filter(wardId => {
                let ward = keyedWards[wardId];
                return _.includes(selectedPrefectureIds, ward.prefecture_id);
              })
              .map(wardId => {
                return keyedWards[wardId];
              })
              .filter(ward => {
                return _.includes(selectedPrefectureIds, ward.prefecture_id);
              })
              .value();
        },
        set (newValue) {
          this.record.wards = _.chain(newValue)
              .map('id')
              .uniq()
              .value();
        }
      },
    },

    methods: {
      getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'jobs', fieldName);
      },

      isFieldRequired(fieldName) {
        return Utils.isFieldRequired(this.masterdata, 'jobs', fieldName);
      },

      getReferenceValues(fieldName) {
        let result = {};
        let refValues = Utils.getReferenceValues(this.masterdata, 'jobs', fieldName);
        for (let key in refValues) {
          result[key] = refValues[key].value;
        }

        return result;
      },

      showModal() {
        this.isShowModal = true;
      },

      updateChange() {
        this.isShowModal = false;
        const jobPromise = (this.record && this.record.id)
            ? rf.getRequest('JobRequest').updateOne(this.record.id, this.record)
            : rf.getRequest('JobRequest').createANewOne(this.record);

        jobPromise.then(res => {
          Utils.growl('request.request_success');
          if (!this.record.id) {
            this.$router.push({
              path: '/job/list',
            });
          }
          this.$refs.jobEdit.$emit('FORM_ERRORS_CLEAR');
        })
        .catch(({ validationErrors }) => {
          if (validationErrors) {
            this.$refs.jobEdit.$emit('REJECT_FORM', validationErrors);
          }
        });
      },

      resetChange() {
        if (!this.oldRecord.id) {
          this.localReset();
          return;
        }

        rf.getRequest('JobRequest').getOne(this.oldRecord.id).then(res => {
          this.oldRecord = res;
          this.localReset();
        });
      },

      cancel() {
        this.$router.push({
          path: '/job/list',
        });
      },

      localReset() {
        this.record = JSON.parse(JSON.stringify(this.oldRecord));

        let keyedStations = _.keyBy(this.masterdata.stations, 'id');
        let keyedLineStations = _.keyBy(this.masterdata.line_stations, 'id');
        this.selectedRoutes = _.map(this.record.routes, lineStationId => {
          let lineStation = keyedLineStations[lineStationId];
          return {
            id: lineStationId,
            prefecture_id: keyedStations[lineStation.station_id].prefecture_id,
            station_id: lineStation.station_id,
            line_id: lineStation.line_id,
          };
        });

        this.selectedPrefectures = _.map(this.record.prefectures, prefId =>
            _.find(this.masterdata.prefectures, pref => pref.id === prefId));
        this.selectedCategoryLevel3 = _.map(this.record.categoryLevel3s, prefId =>
            _.find(this.masterdata.category_level3s, pref => pref.id === prefId));
      },
      where: function (table, name, val) {
        return _.filter(table, function (row) {
          return row[name] == val;
        });
      }
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);

      let id = this.$route.query.id;

      const jobPromise = id
          ? rf.getRequest('JobRequest').getOne(id)
          : Promise.resolve(defaultJob);

      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
      // TODO: Implement search box input type to prevent fetching too much data
      const companiesPromise = rf.getRequest('CompanyRequest').getList({limit: 1000});

      let tasks = [
        jobPromise,
        masterdataPromise,
        companiesPromise,
      ];

      Promise.all(tasks).then(([job, masterdata, companies]) => {
        this.oldRecord = job;
        this.companies = companies.data;
        this.masterdata = masterdata;
        this.agencies = masterdata.referral_agencies;

        let keyedStations = _.keyBy(this.masterdata.stations, 'id');
        this.stationsKeyedByRailwayLine = _.groupBy(this.masterdata.line_stations, 'line_id');
        for (let lineId in this.stationsKeyedByRailwayLine) {
          let stationIds = _.map(this.stationsKeyedByRailwayLine[lineId], 'station_id');
          this.stationsKeyedByRailwayLine[lineId] = _.map(stationIds, stationId => keyedStations[stationId]);
        }

        this.railwayLinesKeyedByPrefecture = {};
        _.each(this.masterdata.railway_lines, line => {
          let prefectureIds = _.chain(this.stationsKeyedByRailwayLine[line.id])
              .map('prefecture_id')
              .uniq()
              .value();
          _.each(prefectureIds, prefectureId => {
            if (!this.railwayLinesKeyedByPrefecture[prefectureId]) {
              this.railwayLinesKeyedByPrefecture[prefectureId] = [];
            }
            this.railwayLinesKeyedByPrefecture[prefectureId].push(line);
          });
        });
        this.resetChange();
      });
    }
  }
</script>

<style scoped>
  .div-inline {
    display: inline-block;
  }

  .row {
    padding-bottom: 5px;
  }

  .btn-control {
    position: fixed;
    padding: 20px;
    left: 0px;
    bottom: 0px;
    width: 100%;
    height: auto;
    background: rgb(245, 248, 250);
    z-index: 2;
  }

  .form-control-multiselect{
    height: auto;
    padding: initial;
  }
</style>

<style lang="sass">
  @import "../../../sass/_merit.scss"
</style>