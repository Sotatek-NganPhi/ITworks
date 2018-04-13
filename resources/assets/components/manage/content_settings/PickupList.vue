<template>
  <div>
    <validation-form ref="searchForm">
      <div class="text-center">
        <button type="button" class="btn btn-success btn-sm" @click="openEditPage()">
          <span class="glyphicon glyphicon-plus"></span> {{ $t("common_action.new") }}
        </button>
      </div>
      <h2>{{ $t("pickup.search_title") }}</h2>

      <form-group :label="$t('pickup.items')">
        <radio-group inline="true" v-model="searchParams.match_condition" :options="itemsToUseOptions"/>
      </form-group>
      <form-group :label=" $t('pickup.item_merit')" v-show="isMeritCondition">
        <select class="form-control" v-model="searchParams.merit">
          <option value="">---</option>
          <option v-for="merit in masterdata.merits" :key="merit.id" :value="merit.id">
            {{ merit.name }}
          </option>
        </select>
      </form-group>

      <form-group :label="$t('pickup.item_category')" v-show="isCategoryCondition">
        <select class="form-control" v-model="searchParams.category_level3">
          <option value="">---</option>
          <option v-for="item in masterdata.category_level3s" :key="item.id" :value="item.id">
            {{ item.name }}
          </option>
        </select>
      </form-group>

      <form-group :label="$t('pickup.title')">
        <input class="form-control" type="text" v-model="searchParams.title"/>
      </form-group>

      <form-group :label="$t('pickup.post_start_date')">
        <date-picker v-model="searchParams.start_date" ref="pickup_start_date" format="YYYY-MM-DD" locale="ja" required></date-picker>
      </form-group>

      <form-group :label="$t('pickup.post_end_date')">
        <date-picker v-model="searchParams.end_date" ref="pickup_end_date" format="YYYY-MM-DD" locale="ja"></date-picker>
      </form-group>

      <form-group :label="$t('pickup.status.title')">
        <radio-group inline="true" v-model="searchParams.isActive" :options="pickupStatusOptions"/>
      </form-group>

    </validation-form>
    <div class="text-center">
      <button type="button" class="btn btn-primary" @click="search()">
        {{ $t("form_action.search") }}
      </button>
      <button type="button" class="btn btn-primary" @click="clearSearchForm()">
        {{ $t("form_action.clear") }}
      </button>
      <button type="button" class="btn btn-primary" @click="downloadCsv()">
        {{ $t("form_action.download_csv") }}
      </button>
    </div>

    <h1>{{$t("pickup.pickup_list_title")}}</h1>

    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 10%">{{getDisplayName('id')}}</th>
      <th data-sort-field="title" style="width: 40%">{{getDisplayName('title')}}</th>
      <th data-sort-field="is_active" style="width: 6%">{{getDisplayName('is_active')}}</th>
      <th data-sort-field="start_date" style="width: 14%">{{getDisplayName('start_date')}}</th>
      <th data-sort-field="end_date" style="width: 14%">{{getDisplayName('end_date')}}</th>
      <th style="width: 8%"></th>
      <th style="width: 8%"></th>
      <template slot="body" scope="props">
        <tr>
          <td style="width: 10%">{{ props.item.id}}</td>
          <td style="width: 40%">{{ props.item.title }}</td>
          <td style="width: 6%">{{ props.item.is_active | boolean}}</td>
          <td style="width: 14%">{{ props.item.start_date }}</td>
          <td style="width: 14%">{{ props.item.end_date }}</td>
          <td @click="openEditPage(props.item)" style="width: 8%">
            <button type="button" class="btn btn-default btn-sm">
              <span class="glyphicon glyphicon-pencil"></span> {{$t("common_action.edit")}}
            </button>
          </td>
          <td @click="deleteRow(props.item)" style="width: 8%">
            <button type="button" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-remove"></span> {{$t("common_action.delete")}}
            </button>
          </td>
        </tr>
      </template>
    </data-table>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="deleteData"
                         :message="$t('message.before_delete')" :params="paramsModal">
    </confirmation-dialog>
  </div>
</template>

<script>

  import _ from 'lodash';
  import queryString from 'querystring';
  import QueryBuilder from '../../../js/lib/QueryBuilder';
  import {user} from '../../../js/app/manage/main';
  import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
  import rf from '../../../js/lib/RequestFactory';
  import Const from '../../../js/common/Const';
  import DatePicker from '../../../components/common/DatetimePicker/DatePicker.vue';

  let masterdata = {};
  const searchParams = {
    match_condition: '0',
    merit: '',
    category_level3: '',
    start_date: '',
    end_date: '',
    isActive: '1',
    title: '',
  };
  export default {
    components: {
      DatePicker,
    },

    data() {
      return {
        searchParams,
        user,
        subNavigators,
        masterdata,
        rows: [],
        itemsToUseOptions: Utils.getItemToUseOptions(),
        pickupStatusOptions: Utils.getStatus(),
        isShowModal: false,
        paramsModal: null
      }
    },
    computed: {
      isMeritCondition() {
        return this.searchParams.match_condition == Math.pow(2, Const.PICKUP_CONDITION_MERIT);
      },

      isCategoryCondition() {
        return this.searchParams.match_condition == Math.pow(2, Const.PICKUP_CONDITION_CATEGORY);
      },
    },
    methods: {
      downloadCsv() {
        const query = queryString.stringify(this.buildSearchQuery());
        window.location.href = `manage/pickup/csv?${query}`;
      },
      getDisplayName(fieldName) {
      return window.Utils.getFieldDisplayName(this.masterdata, 'pickups', fieldName);
    },
      matchConditionMerit: function () {
        return this.match_condition == '0';
      },
      getDaysInMonth: function (month, year) {
        return new Date(year, month, 0).getDate();
      },
      getData(params) {
        return rf.getRequest('PickupRequest').getList(params);
      },
      openEditPage(row) {
        this.$router.push({
          path: '/pickup/edit',
          query: {
            id: row ? row.id : null
          }
        });
      },
      clearSearchForm() {
        this.searchParams = JSON.parse(JSON.stringify(searchParams));
        this.$refs.pickup_start_date.$emit('DatePicker:clear');
        this.$refs.pickup_end_date.$emit('DatePicker:clear');
        this.search();
      },
      search() {
        this.$refs.searchForm.validate().then(() => {
          this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
        }).catch(() => {});
      },
      deleteRow(row) {
        this.isShowModal = true;
        this.paramsModal = row;
      },
      deleteData(row) {
        this.isShowModal = false;
        rf.getRequest('PickupRequest').removeOne(row.id).then(res => {
          this.$refs.datatable.$emit('DataTable:refresh')
        });
      },
      buildSearchQuery() {
        const searchParams = {
        'id': this.searchParams.id,
        'title': [this.searchParams.title, 'like'],
        'is_active': [this.searchParams.isActive,'='],
        'match_condition': [this.searchParams.match_condition, '='],
        'merits.merit_id': [this.searchParams.merit,'='],
        'category_level3s.category_level3_id': [this.searchParams.category_level3,'='],
        'start_date': [this.searchParams.start_date, '>='],
        'end_date': [this.searchParams.end_date, '<='],
        };
        const query = new QueryBuilder(searchParams);
        return query;
      },
      filterByProp(data, prop, value){
        return _.filter(data, function (row) {
          return row[prop] == value;
        });
      }
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      rf.getRequest('MasterdataRequest').getAll().then(masterdata => {
        this.masterdata = masterdata;
        this.clearSearchForm();
      });
    }
  }
</script>
