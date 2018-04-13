<template>
  <div>
    <validation-form ref="searchForm">
      <div class="text-center">
        <button type="button" class="btn btn-success btn-sm" @click="openEditPage()">
          <span class="glyphicon glyphicon-plus"></span> {{ $t("common_action.new") }}
        </button>
      </div>
      <h2>{{ $t("expo_list.search_title") }}</h2>
      <form-group :label="getDisplayName('id')">
        <input class="form-control" v-validator="'numeric|min:0'" type="text" v-model="searchParams.id"/>
      </form-group>

      <form-group :label="getDisplayName('title')">
        <input class="form-control" type="text" v-model="searchParams.title"/>
      </form-group>

      <form-group :label="getDisplayName('start_at')">
        <datetime-picker class="col-sm-4" v-model="searchParams.dateFrom" format="YYYY-MM-DD HH:mm:ss" locale="ja"></datetime-picker>
      </form-group>

      <form-group :label="getDisplayName('end_at')">
        <datetime-picker class="col-sm-4" v-model="searchParams.dateTo" format="YYYY-MM-DD HH:mm:ss" locale="ja"></datetime-picker>
      </form-group>

      <form-group :label="getDisplayName('is_active')">
        <radio-group inline="true" v-model="searchParams.isActive" :options="mailReceivableOptions"/>
      </form-group>
    </validation-form>

    <div class="text-center">
      <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
      <button type="button" class="btn btn-primary" @click="clearSearchForm()">{{ $t("form_action.clear") }}</button>
    </div>

    <h2>{{ $t("campaign.list_title") }}</h2>

    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 12%">{{ getDisplayName('id') }}</th>
      <th data-sort-field="title" style="width: 30%">{{ getDisplayName('title') }}</th>
      <th data-sort-field="start_at" style="width: 14%">{{ getDisplayName('start_at') }}</th>
      <th data-sort-field="end_at" style="width: 14%">{{ getDisplayName('end_at') }}</th>
      <th data-sort-field="is_active" style="width: 6%">{{ getDisplayName('is_active') }}</th>
      <th style="width: 8%"></th>
      <th style="width: 8%"></th>
      <th style="width: 8%"></th>
      <template slot="body" scope="props">
        <tr>
          <td style="width: 12%">{{ props.item.id }}</td>
          <td style="width: 30%">{{ props.item.title }}</td>
          <td style="width: 14%">{{ props.item.start_at }}</td>
          <td style="width: 14%">{{ props.item.end_at }}</td>
          <td style="width: 6%">{{ props.item.is_active | boolean }}</td>
          <td @click="openCampaignPage(props.item)" style="width: 8%">
            <button type="button" class="btn btn-info btn-sm">
              <span class="glyphicon glyphicon-eye-open"></span> {{$t("common_action.preview")}}
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

import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import moment from 'moment';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
import QueryBuilder from '../../../js/lib/QueryBuilder';
export default {
  data() {
    return {
      searchParams: {
        id: '',
        title: '',
        dateFrom: '',
        dateTo: '',
        isActive: ''
      },
      user,
      subNavigators,
      mailReceivableOptions: window.Utils.getBooleans(),
      masterdata: [],
      isShowModal: false,
      messageModal: "あなたは、このデータをしません削除したいです?",
      paramsModal: null,
    }
  },

  methods: {
    getDisplayName(fieldName) {
      return window.Utils.getFieldDisplayName(this.masterdata, 'campaigns', fieldName);
    },
    getData(params) {
      return rf.getRequest('CampaignRequest').getList(params);
    },
    openCampaignPage(row) {
      window.open("/campaign/" + row.id, "_blank");
    },
    openEditPage(row) {
      this.$router.push({
        path: '/campaign/edit',
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
      rf.getRequest('CampaignRequest').removeOne(row.id).then(() => {
        this.$refs.datatable.$emit('DataTable:refresh');
      });
    },
    clearSearchForm() {
      this.searchParams = {
        id: '',
        title: '',
        dateFrom: '',
        dateTo: '',
        isActive: ''
      }
      this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
    },
    buildSearchQuery() {
      const searchParams = {
        'id': [this.searchParams.id,'='],
        'title': [this.searchParams.title,'like'],
        'content': [this.searchParams.content,'like'],
        'start_at': [this.searchParams.dateFrom,'>='],
        'end_at': [this.searchParams.dateTo,'<='],
        'is_active': this.searchParams.isActive,
      };
      if(this.searchParams.dateFrom) {
        searchParams['start_at'] = [moment(this.searchParams.dateFrom).unix(), '>=']
      }
      if(this.searchParams.dateTo) {
        searchParams['end_at'] = [moment(this.searchParams.dateTo).unix(), '<=']
      }
      const query = new QueryBuilder(searchParams);
      return query;
    },
    search() {
      this.$refs.searchForm.validate().then(() => {
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
      }).catch(() => {});
    }
  },
  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    rf.getRequest('MasterdataRequest')
      .getAll()
      .then(masterdata => {
        this.masterdata = masterdata;
      });
  }
}
</script>
