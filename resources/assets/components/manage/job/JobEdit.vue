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

          <form-group :label="getDisplayName('work_no')"
                      :is-required="isFieldRequired('work_no')">
            <input class="form-control" type="text" data-vv-name="work_no" v-model="record.work_no"
                   disabled/>
          </form-group>

          <form-group :label="getDisplayName('agencies.name')"
                      :is-required="isFieldRequired('agencies.name')">
            <select v-model="record.agency_id" class="form-control" data-vv-name="agency_id">
              <option value="0">---</option>
              <option :value="agency.id" v-for="agency in agencies" :key="agency.id">
                {{agency.name}}
              </option>
            </select>
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
                         format="YYYY-MM-DD" locale="ja" data-vv-name="post_start_date"></date-picker>
          </form-group>

          <form-group :label="getDisplayName('post_end_date')"
                      :is-required="isFieldRequired('post_end_date')">
            <date-picker v-model="record.post_end_date"
                         format="YYYY-MM-DD" locale="ja" data-vv-name="post_end_date"></date-picker>
          </form-group>

          <form-group :label="getDisplayName('original_state')"
                      :is-required="isFieldRequired('original_state')">
            <radio-group inline="true"
                         data-vv-name="original_state" v-model="record.original_state"
                         :options="getReferenceValues('original_state')"></radio-group>
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

          <form-group :label="getDisplayName('seniors_hometown')"
                      :is-required="isFieldRequired('seniors_hometown')">
            <textarea class="form-control" data-vv-name="seniors_hometown"
                      v-model="record.seniors_hometown"></textarea>
          </form-group>

          <div>
            <span class="glyphicon glyphicon-triangle-bottom"></span>
            <span>{{$t('job_edit.group_3')}}</span>
          </div>

          <form-group :label="getDisplayName('company_name')"
                      :is-required="isFieldRequired('company_name')">
            <textarea class="form-control" data-vv-name="company_name"
                      cols="150" v-model="record.company_name"></textarea>
          </form-group>

          <form-group :label="getDisplayName('salary')" :is-required="isFieldRequired('salary')">
            <textarea class="form-control" data-vv-name="salary" v-model="record.salary"></textarea>
          </form-group>

          <form-group :label="getDisplayName('application_condition')"
                      :is-required="isFieldRequired('application_condition')">
            <textarea class="form-control" data-vv-name="application_condition"
                      v-model="record.application_condition"></textarea>
          </form-group>

          <form-group :label="getDisplayName('employment_modes.name')"
                      :is-required="isFieldRequired('employment_modes.name')">
            <label class="checkbox-inline" v-for="employment_mode in masterdata.employment_modes"
                   :key="employment_mode.id">
              <input type="checkbox" v-model="record.employmentModes"
                     :value="employment_mode.id"/>{{ employment_mode.description }}
            </label>
            <input hidden data-vv-name="employmentModes" v-model="record.employmentModes"/>
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

          <form-group :label="getDisplayName('option_1')"
                      :is-required="isFieldRequired('option_1')">
          <textarea class="form-control"
                    data-vv-name="option_1" cols="150"
                    v-model="record.option_1"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_2')"
                      :is-required="isFieldRequired('option_2')">
          <textarea class="form-control"
                    data-vv-name="option_2" cols="150"
                    v-model="record.option_2"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_3')"
                      :is-required="isFieldRequired('option_3')">
          <textarea class="form-control"
                    data-vv-name="option_3" cols="150"
                    v-model="record.option_3"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_4')"
                      :is-required="isFieldRequired('option_4')">
          <textarea class="form-control"
                    data-vv-name="option_4" cols="150"
                    v-model="record.option_4"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_5')"
                      :is-required="isFieldRequired('option_5')">
          <textarea class="form-control"
                    data-vv-name="option_5" cols="150"
                    v-model="record.option_5"></textarea>
          </form-group> 

          <form-group :label="getDisplayName('option_6')"
                      :is-required="isFieldRequired('option_6')">
          <textarea class="form-control"
                    data-vv-name="option_6" cols="150"
                    v-model="record.option_6"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_7')"
                      :is-required="isFieldRequired('option_7')">
          <textarea class="form-control"
                    data-vv-name="option_7" cols="150"
                    v-model="record.option_7"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_8')"
                      :is-required="isFieldRequired('option_8')">
          <textarea class="form-control"
                    data-vv-name="option_8" cols="150"
                    v-model="record.option_8"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_9')"
                      :is-required="isFieldRequired('option_9')">
          <textarea class="form-control"
                    data-vv-name="option_9" cols="150"
                    v-model="record.option_9"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_10')"
                      :is-required="isFieldRequired('option_10')">
          <textarea class="form-control"
                    data-vv-name="option_10" cols="150"
                    v-model="record.option_10"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_11')"
                      :is-required="isFieldRequired('option_11')">
          <textarea class="form-control"
                    data-vv-name="option_11" cols="150"
                    v-model="record.option_11"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_12')"
                      :is-required="isFieldRequired('option_12')">
          <textarea class="form-control"
                    data-vv-name="option_12" cols="150"
                    v-model="record.option_12"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_13')"
                      :is-required="isFieldRequired('option_13')">
          <textarea class="form-control"
                    data-vv-name="option_13" cols="150"
                    v-model="record.option_13"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_14')"
                      :is-required="isFieldRequired('option_14')">
          <textarea class="form-control"
                    data-vv-name="option_14" cols="150"
                    v-model="record.option_14"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_15')"
                      :is-required="isFieldRequired('option_15')">
          <textarea class="form-control"
                    data-vv-name="option_15" cols="150"
                    v-model="record.option_15"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_16')"
                      :is-required="isFieldRequired('option_16')">
          <textarea class="form-control"
                    data-vv-name="option_16" cols="150"
                    v-model="record.option_16"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_17')"
                      :is-required="isFieldRequired('option_17')">
          <textarea class="form-control"
                    data-vv-name="option_17" cols="150"
                    v-model="record.option_17"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_18')"
                      :is-required="isFieldRequired('option_18')">
          <textarea class="form-control"
                    data-vv-name="option_18" cols="150"
                    v-model="record.option_18"></textarea>
          </form-group>

          <form-group :label="getDisplayName('option_19')"
                      :is-required="isFieldRequired('option_19')">
          <textarea class="form-control"
                    data-vv-name="option_19" cols="150"
                    v-model="record.option_19">

          </textarea>
          </form-group>

          <form-group :label="getDisplayName('option_20')"
                      :is-required="isFieldRequired('option_20')">
          <textarea class="form-control"
                    data-vv-name="option_20" cols="150"
                    v-model="record.option_20">

          </textarea>
          </form-group>

          <div>
            <span class="glyphicon glyphicon-triangle-bottom"></span>
            <span>{{$t('job_edit.group_4')}}</span>
          </div>

          <form-group :label="getDisplayName('images')">
            <file-upload v-model="record.main_image" accept="image/*"></file-upload>
            <file-upload v-model="record.sub_image1" accept="image/*"></file-upload>
            <file-upload v-model="record.sub_image2" accept="image/*"></file-upload>
            <file-upload v-model="record.sub_image3" accept="image/*"></file-upload>
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

          <form-group :label="getDisplayName('email_company')"
                      :is-required="isFieldRequired('email_company')">
            <input class="form-control"
                   data-vv-name="email_company"
                   v-model="record.email_company"/>
          </form-group>

          <form-group :label="getDisplayName('sales_person_mail')"
                      :is-required="isFieldRequired('sales_person_mail')">
            <input class="form-control"
                   data-vv-name="sales_person_mail" type="text"
                   v-model="record.sales_person_mail"/>
          </form-group>

          <form-group :label="getDisplayName('remarks')"
                      :is-required="isFieldRequired('remarks')">
            <input class="form-control"
                   data-vv-name="remarks" type="text"
                   v-model="record.remarks"/>
          </form-group>

          <form-group :label="getDisplayName('automatic_reply_mail_status')"
                      :is-required="isFieldRequired('automatic_reply_mail_status')">
            <label class="radio-inline">
              <input type="radio" value="1"
                     v-model="record.automatic_reply_mail_status">{{$t('job_list.use')}}
            </label>
            <label class="radio-inline">
              <input type="radio" value="0" v-model="record.automatic_reply_mail_status">
              {{$t('job_list.not_use')}}
            </label>
            <textarea class="form-control" :disabled="record.automatic_reply_mail_status == 0"
                      v-model="record.automatic_reply_mail_content">
          </textarea>
            <input hidden type="text"
                   v-model="record.automatic_reply_mail_content"
                   data-vv-name="automatic_reply_mail_content"/>
          </form-group>

          <div>
            <span class="glyphicon glyphicon-triangle-bottom"></span>
            <span>{{$t('job_edit.group_6')}}</span>
          </div>

          <form-group :label="getDisplayName('category_level3s.name')"
                      :is-required="isFieldRequired('category_level3s.name')">
            <div class="form-control-multiselect form-control">
              <multiselect
                      v-model="selectedCategoryLevel3"
                      :placeholder= "$t('common_action.pick')"
                      label="name"
                      track-by="id"
                      :options="masterdata.category_level3s"
                      :multiple="true"
                      :close-on-select="false"
                      :clear-on-select="false"
                      :hide-selected="true"
                      data-vv-name="categoryLevel3s"
              ></multiselect>
            </div>
          </form-group>

          <form-group :label="getDisplayName('prefectures.name')"
                      :is-required="isFieldRequired('prefectures.name')">
            <div class="form-control-multiselect form-control">
              <multiselect
                      v-model="selectedPrefectures"
                      :placeholder="$t('common_action.pick')"
                      label="name"
                      track-by="id"
                      :options="masterdata.prefectures"
                      :multiple="true"
                      :close-on-select="false"
                      :clear-on-select="false"
                      :hide-selected="true"
                      data-vv-name="prefectures"
              ></multiselect>
            </div>
          </form-group>

          <form-group :label="getDisplayName('wards.name')"
                      :is-required="isFieldRequired('wards.name')">
            <div class="form-control-multiselect form-control">
              <multiselect
                      v-model="selectedWards"
                      :placeholder="$t('common_action.pick')"
                      label="name"
                      track-by="id"
                      :options="filteredWards"
                      :multiple="true"
                      :close-on-select="false"
                      :clear-on-select="false"
                      :hide-selected="true"
                      data-vv-name="wards"
              ></multiselect>
            </div>
          </form-group>

          <form-group :label="$t('job_edit.routes')">
            <div class="text-center row">
              <button type="button" class="btn btn-success btn-sm" @click="addNewRoute()">
                <span class="glyphicon glyphicon-plus"></span> {{$t("job_list.add_new_route")}}
              </button>
            </div>
            <div v-for="route in selectedRoutes" class="row" :key="route.id">
              <div class="col-sm-4">
                <select class="form-control div-inline" v-model="route.prefecture_id">
                  <option v-for="prefecture in masterdata.prefectures"
                          :key="prefecture.id" :value="prefecture.id">
                    {{ prefecture.name }}
                  </option>
                </select>
              </div>
              <div class="col-sm-4">
                <select class="form-control div-inline" v-model="route.line_id">
                  <option v-for="line in railwayLinesKeyedByPrefecture[route.prefecture_id]" :key="line.id"
                          :value="line.id">{{ line.name }}
                  </option>
                </select>
              </div>
              <div class="col-sm-3">
                <select class="form-control div-inline" v-model="route.station_id">
                  <option v-for="station in where(stationsKeyedByRailwayLine[route.line_id], 'prefecture_id', route.prefecture_id)" :key="station.id"
                          :value="station.id">{{ station.name }}
                  </option>
                </select>
              </div>
              <div class="col-sm-1">
                <button type="button" class="btn btn-danger btn-sm" @click="removeRoute(route)">
                  <span class="glyphicon glyphicon-remove"></span> {{$t("common_action.delete")}}
                </button>
              </div>
            </div>
          </form-group>

          <form-group :label="$t('job_edit.salary')">
            <label class="checkbox-inline" v-for="salary in masterdata.salaries" :key="salary.id">
              <input type="checkbox" v-model="record.salaries"
                     :value="salary.id"/>{{ salary.description }}
            </label>
          </form-group>

          <form-group :label="$t('job_edit.working_days')">
            <label class="checkbox-inline" v-for="working_day in masterdata.working_days"
                   :key="working_day.id">
              <input type="checkbox" v-model="record.workingDays"
                     :value="working_day.id"/>{{ working_day.name }}
            </label>
          </form-group>

          <form-group :label="$t('job_edit.working_hours')">
            <label class="checkbox-inline" v-for="working_hour in masterdata.working_hours"
                   :key="working_hour.id">
              <input type="checkbox" v-model="record.workingHours"
                     :value="working_hour.id"/>{{ working_hour.name }}
            </label>
          </form-group>

          <form-group :label="$t('job_edit.working_shifts')">
            <label class="checkbox-inline" v-for="working_shift in masterdata.working_shifts"
                   :key="working_shift.id">
              <input type="checkbox" v-model="record.workingShifts"
                     :value="working_shift.id"/>{{ working_shift.name }}
            </label>
          </form-group>

          <form-group :label="$t('job_edit.working_periods')">
            <label class="checkbox-inline" v-for="working_period in masterdata.working_periods"
                   :key="working_period.id">
              <input type="checkbox" v-model="record.workingPeriods"
                     :value="working_period.id"/>{{ working_period.name}}
            </label>
          </form-group>

          <form-group :label="$t('job_edit.current_situation')">
            <label class="checkbox-inline" v-for="item in masterdata.current_situations" :key="item.id">
              <input type="checkbox" v-model="record.currentSituations"
                     :value="item.id"/>{{ item.name }}
            </label>
          </form-group>

          <form-group :label="$t('job_edit.merit')">
            <div class="merit">
              <div v-for="merit in masterdata.merit_groups" class="group-merit" :key="merit.id">
                <p class="category">
                  <span class="glyphicon glyphicon-triangle-bottom"></span>{{merit.name}}</p>
                <ul>
                  <li v-for="item in where(masterdata.merits, 'merit_group_id', merit.id)" :key="item.id">
                    <label><input type="checkbox"
                                  :value="item.id" v-model="record.merits">{{ item.name }}</label>
                  </li>
                </ul>
              </div>
            </div>
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
    salaries: [],
    employmentModes: [],
    workingShifts: [],
    workingDays: [],
    workingHours: [],
    workingPeriods: [],
    prefectures: [],
    wards: [],
    currentSituations: [],
    merits: [],
    automatic_reply_mail_status: '0',
    original_state: '0',
    post_end_date: '',
    post_start_date: '',
    description: '',
    companies: '0',
    company_name: '',
    max_applicant: '',
    work_main: '',
    working_hours: '',
    seniors_hometown: '',
    salary: '',
    application_condition: '',
    message: '',
    interns_start_time: '',
    holiday_vacation: '',
    interview_place: '',
    receptionist: '',
    option_1: '',
    option_2: '',
    option_3: '',
    option_4: '',
    option_5: '',
    option_6: '',
    option_7: '',
    option_8: '',
    option_9: '',
    option_10: '',
    option_11: '',
    option_12: '',
    option_13: '',
    option_14: '',
    option_15: '',
    option_16: '',
    option_17: '',
    option_18: '',
    option_19: '',
    option_20: '',
    main_image: '',
    main_caption: '',
    sub_image1: '',
    sub_image2: '',
    sub_image3: '',
    sub_image4: '',
    sub_caption1: '',
    sub_caption2: '',
    sub_caption3: '',
    sub_caption4: '',
    email_receive_applicant: '',
    email_company: '',
    sales_person_mail: '',
    remarks: '',
    automatic_reply_mail_content: '',
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
        selectedPrefectures: [],
        selectedCategoryLevel3: [],
        selectedRoutes: [],
        railwayLinesKeyedByPrefecture: {},
        stationsKeyedByRailwayLine: {},
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
        this.record.prefectures = _.map(this.selectedPrefectures, 'id');
        this.record.wards = _.map(this.selectedWards, 'id');
        this.record.categoryLevel3s = _.map(this.selectedCategoryLevel3, 'id');

        // TODO: make this hack less ugly...
        this.record.routes = _.chain(this.selectedRoutes)
            .map(route => {
              let lineStation = _.find(this.masterdata.line_stations, e => {
                return parseInt(e.line_id) === parseInt(route.line_id) &&
                    parseInt(e.station_id) === parseInt(route.station_id);
              });
              return lineStation ? lineStation.id : null;
            })
            .compact()
            .uniq()
            .value();

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

      addNewRoute() {
        this.selectedRoutes.unshift({
          id: 0,
          prefecture_id: 0,
          line_id: 0,
          station_id: 0,
        });
      },

      removeRoute(route) {
        this.selectedRoutes.splice(this.selectedRoutes.indexOf(route), 1);
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