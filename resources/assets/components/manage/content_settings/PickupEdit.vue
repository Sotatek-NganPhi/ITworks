<template>
  <div>
    <validation-form ref="pickupForm" >
      <form-group :label="getDisplayName('items')" :is-required="isFieldRequired('match_condition')">
        <radio-group inline="true" data-vv-name="match_condition" v-model="matchCondition" :options="itemsToUseOptions"/>
      </form-group>

      <form-group :label="getDisplayName('merits')" :is-required="isFieldRequired('merits')"  v-show="isMeritCondition">
        <multiselect
                v-model="selectedMerits"
                placeholder="Pick some"
                label="name"
                track-by="id"
                :options="meritList"
                :multiple="true"
                :close-on-select="false"
                :clear-on-select="false"
                :hide-selected="true"
                data-vv-name = "merits"
        ></multiselect>
      </form-group>

      <form-group :label="getDisplayName('category_level3s')" :is-required="isFieldRequired('category_level3s')" v-show="isCategoryCondition">
        <select class="form-control" v-model="selectedCategoryLevel3Id">
          <option v-for="item in masterdata.category_level3s" :key="item.id" :value="item.id" data-vv-name="category_level3s">{{ item.name }}</option>
        </select>
      </form-group>

      <form-group :label="getDisplayName('title')" :is-required="isFieldRequired('title')" >
        <input class="form-control" data-vv-name="title" type="text" v-model="record.title" />
      </form-group>

      <form-group :label="getDisplayName('description')" :is-required="isFieldRequired('description')">
        <textarea class="form-control" data-vv-name="description" v-model="record.description"></textarea>
      </form-group>

      <form-group :label="getDisplayName('image')" :is-required="isFieldRequired('image')">
        <file-upload data-vv-name="image" v-model="record.image" accept="image/*"></file-upload>
      </form-group>

      <form-group  :label="getDisplayName('start_date')" :is-required="isFieldRequired('start_date')">
        <date-picker data-vv-name="start_date" v-model="record.start_date" format="YYYY-MM-DD" locale="ja" ></date-picker>
      </form-group>

      <form-group  :label="getDisplayName('end_date')" :is-required="isFieldRequired('end_date')">
        <date-picker data-vv-name="end_date" v-model="record.end_date" format="YYYY-MM-DD" locale="ja" ></date-picker>
      </form-group>

      <form-group :label="getDisplayName('is_active')" :is-required="isFieldRequired('is_active')">
        <radio-group inline="true"  data-vv-name="is_active"
                     v-model="record.is_active" :options="activeOptions"/>
      </form-group>
    </validation-form>

    <div class="col-sm-12 btn-control">
      <div class="text-center">
        <button type="button" class="btn btn-primary btn-sm" @click="showModal()">
          <span class="glyphicon glyphicon-ok"></span> {{ $t("common_action.ok") }}
        </button>
        <button type="button" class="btn btn-default btn-sm" @click="resetChange()">
          <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.cancel") }}
        </button>
      </div>
    </div>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="updateChange"
                         :message="$t('message.before_update')">
    </confirmation-dialog>
  </div>
</template>

<script>

  import _ from 'lodash';
  import Multiselect from 'vue-multiselect';
  import {user} from '../../../js/app/manage/main';
  import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
  import DatePicker from '../../../components/common/DatetimePicker/DatePicker.vue';
  import rf from '../../../js/lib/RequestFactory';
  import Utils from '../../../js/common/Utils';
  import Const from '../../../js/common/Const';
  import FileUpload from '../../../components/common/FileUpload.vue';
let defaultRecord = {
  image: '',
  title: '',
  description: '',
  is_active: 1,
  start_date: '',
  end_date: '',
  meritList: [],
  matchCondition: 0,
  selectedCategoryLevel3Id: 0,
};
  export default {
    components: {
      DatePicker,
      FileUpload,
      Multiselect
    },

    data() {
      return {
        user,
        subNavigators,
        record: {
          atforms: [],
        },
        oldRecord: {},
        selectedMerits: [],
        meritList: [],
        matchCondition: 0,
        selectedCategoryLevel3Id: 0,
        masterdata: {},
        itemsToUseOptions: Utils.getItemToUseOptions(),
        activeOptions: Utils.getYesNoOptions(),
        isShowModal: false,
      }
    },

    computed: {
      currentYear: function () {
        return new Date().getFullYear();
      },

      currentMonth: function () {
        return new Date().getMonth() + 1;
      },

      currentDate: function () {
        return new Date().getDate();
      },

      isMeritCondition() {
        return this.matchCondition == Math.pow(2, Const.PICKUP_CONDITION_MERIT);
      },

      isCategoryCondition() {
        return this.matchCondition == Math.pow(2, Const.PICKUP_CONDITION_CATEGORY);
      },
    },

    methods: {

      getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'pickups', fieldName);
      },
      isFieldRequired(fieldName) {
        return Utils.isFieldRequired(this.masterdata, 'pickups', fieldName);
      },
      getDaysInMonth: function (month, year) {
        return new Date(year, month, 0).getDate();
      },
      showModal() {
        this.isShowModal = true;
      },
      updateChange() {
        this.isShowModal = false;
        this.record.match_condition = this.matchCondition;
        if (this.isMeritCondition) {
          this.record.merits = _.map(this.selectedMerits, 'id');
          this.record.category_level3s = [];
        } else {
          this.record.merits = [];
          this.record.category_level3s = this.selectedCategoryLevel3Id ? [this.selectedCategoryLevel3Id] : [];
        }

        const pickupPromise = (this.record && this.record.id)
          ? rf.getRequest('PickupRequest').updateOne(this.record.id, this.record)
          : rf.getRequest('PickupRequest').createANewOne(this.record);
        pickupPromise.then(res => {
          Utils.growl('request.request_success');
          if (!this.record.id) {
            this.$router.push({
              path: '/pickup/list',
            });
          }
          this.$refs.pickupForm.$emit('REJECT_FORM', null);
        }).catch(({ validationErrors }) => {
          if (validationErrors) {
            this.$refs.pickupForm.$emit('REJECT_FORM', validationErrors);
          }
        });
      },
      resetChange() {
        this.$router.push({
          path: '/pickup/list',
        });
      },
      localReset() {
        this.record = JSON.parse(JSON.stringify(this.oldRecord));
        this.matchCondition = this.oldRecord.match_condition;
        this.selectedMerits =_.map(this.record.merits, meritId =>
          _.find(this.meritList, merit => merit.id === meritId));
        this.selectedCategoryLevel3Id = this.record.category_level3s? this.record.category_level3s[0] : [];
      },
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      let id = this.$route.query.id;

      const pickupPromise = id
        ? rf.getRequest('PickupRequest').getOne(id)
        : Promise.resolve(defaultRecord);

      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();

      Promise.all([pickupPromise, masterdataPromise]).then(([pickup, masterdata]) => {
        this.masterdata = masterdata;
        this.oldRecord = pickup;
        this.meritList = masterdata.merits;
        this.localReset();
      });
    }
  }
</script>

<style scoped>
  .btn-control {
    margin-bottom: 20px;
  }
</style>
