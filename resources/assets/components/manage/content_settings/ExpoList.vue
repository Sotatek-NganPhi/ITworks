<template>
  <div>
      <div class="text-center">
        <button type="button" class="btn btn-success btn-sm" @click="openEditPage()">
          <span class="glyphicon glyphicon-plus"></span> {{ $t("common_action.new") }}
        </button>
      </div>

      <h2>{{ $t("expo_list.search_title") }}</h2>
      <validation-form ref="searchForm">
        <form-group :label="getDisplayName('id')">
          <input v-validator="'numeric|min:0'" class="form-control" type="text" v-model="searchParams.id"/>
        </form-group>

        <form-group :label="getDisplayName('presentation_name')">
          <input class="form-control" type="text" v-model="searchParams.presentationName"/>
        </form-group>

        <form-group :label="getDisplayName('address')">
          <input class="form-control" type="text" v-model="searchParams.address"/>
        </form-group>

        <form-group :label="getDisplayName('start_date')">
          <date-picker class="col-sm-6" v-model="searchParams.dateFrom" format="YYYY-MM-DD" locale="ja"></date-picker>
        </form-group>

        <form-group :label="getDisplayName('end_date')">
          <date-picker class="col-sm-6" v-model="searchParams.dateTo" format="YYYY-MM-DD" locale="ja"></date-picker>
        </form-group>
        <form-group :label="getDisplayName('is_active')">
          <radio-group inline="true" v-model="searchParams.isActive" :options="mailReceivableOptions"/>
        </form-group>
    </validation-form>
    <div class="text-center">
      <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
      <button type="button" class="btn btn-primary" @click="clearSearchForm()">{{ $t("form_action.clear") }}</button>
    </div>

    <h2>{{ $t("expo_list.list_title") }}</h2>
    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 7%">{{ getDisplayName('id') }}</th>
      <th data-sort-field="presentation_name" style="width: 28%">{{ getDisplayName('presentation_name') }}</th>
      <th data-sort-field="organizer_name" style="width: 14%">{{ getDisplayName('organizer_name') }}</th>
      <th data-sort-field="date" style="width: 10%">{{ getDisplayName('date') }}</th>
      <th data-sort-field="is_active" style="width: 7%">{{ getDisplayName('is_active') }}</th>
      <th data-sort-field="reservations_count" style="width: 9%">{{$t("expo.reservation_count")}}</th>
      <th style="width: 9%"></th>
      <th style="width: 8%"></th>
      <th style="width: 8%"></th>
      <template slot="body" scope="props">
        <tr>
          <td style="width: 7%">{{ props.item.id }}</td>
          <td style="width: 28%">{{ props.item.presentation_name }}</td>
          <td style="width: 14%">{{ props.item.organizer_name }}</td>
          <td style="width: 10%">{{ props.item.date }}</td>
          <td style="width: 7%">{{ props.item.is_active | boolean }}</td>
          <td style="width: 9%">{{ props.item.reservations_count }}</td>
          <td @click="openBookingListPage(props.item)" style="width: 9%">
            <button type="button" class="btn btn-info btn-sm">
              <span class="glyphicon glyphicon-eye-open"></span> {{$t("expo.booking_list")}}
            </button>
          </td>
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
                         :message="messageModal" :params="paramsModal">
    </confirmation-dialog>
  </div>
</template>

<script>

import QueryBuilder from '../../../js/lib/QueryBuilder';
import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
export default {
  data() {
    return {
      searchParams: {
        id: '',
        presentationName: '',
        dateFrom: '',
        dateTo: '',
        address: '',
        isActive: ''
      },
      user,
      subNavigators,
      mailReceivableOptions: window.Utils.getBooleans(),
      masterdata: {},
      isShowModal: false,
      messageModal: "あなたは、このデータをしません削除したいです?",
      paramsModal: null,
    }
  },

  methods: {
    getDisplayName(fieldName) {
      return window.Utils.getFieldDisplayName(this.masterdata, 'expos', fieldName);
    },
    getData(params) {
      return rf.getRequest('ExpoRequest').getList(params);
    },
    openBookingListPage(row) {
      this.$router.push({
        path: '/expo/reservations',
        query: {
          expo_id: row ? row.id : null
        }
      });
    },
    openEditPage(row) {
      this.$router.push({
        path: '/expo/edit',
        query: {
          id: row ? row.id : null
        }
      });
    },
    deleteRow(row) {
      this.isShowModal = true
      this.paramsModal = row
    },
    deleteData(row) {
      this.isShowModal = false
      rf.getRequest('ExpoRequest').removeOne(row.id).then(res => {
        this.$refs.datatable.$emit('DataTable:refresh')
    });
    },
    clearSearchForm() {
      this.initSearchParams()
      this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
    },
    buildSearchQuery() {
      const searchParams = {
        'id': this.searchParams.id,
        'presentation_name': [this.searchParams.presentationName, 'like'],
        'address': [this.searchParams.address, 'like'],
        'is_active': this.searchParams.isActive,
      }
      const query = new QueryBuilder(searchParams);
      if(this.searchParams.dateFrom) {
        query.append('date', this.searchParams.dateFrom, '>=')
      }
      if(this.searchParams.dateTo) {
        query.append('date', this.searchParams.dateTo, '<=')
      }
      return query;
    },
    search() {
      this.$refs.searchForm.validate().then(() => {
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
      }).catch(() => {});
    },
    initSearchParams() {
      this.searchParams = {
        id: '',
        presentationName: '',
        dateFrom: '',
        dateTo: '',
        address: '',
        isActive: ''
      }
    }
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    Promise.all([masterdataPromise]).then(([masterdata]) => {
      this.masterdata = masterdata;
    });
    this.initSearchParams();
  }
}
</script>
