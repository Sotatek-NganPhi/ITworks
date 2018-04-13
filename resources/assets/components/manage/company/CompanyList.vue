<template>
  <div>

    <div class="text-center">
      <button type="button" class="btn btn-success btn-sm" @click="openEditPage()">
        <span class="glyphicon glyphicon-plus"></span> {{ $t("common_action.new") }}
      </button>
    </div>

    <h2>{{ $t("company_list.search_title") }}</h2>


    <validation-form ref="searchForm">
      <form-group :label="getDisplayName('id')">
        <input class="form-control" name="id" type="text" v-validator="'numeric|min:0'" v-model="searchParams.id"/>
      </form-group>
      <form-group :label="getDisplayName('name')">
        <input class="form-control" type="text" v-model="searchParams.name"/>
      </form-group>
      <form-group :label="getDisplayName('name_phonetic')">
        <input class="form-control" type="text" v-model="searchParams.name_phonetic"/>
      </form-group>
      <form-group :label="getDisplayName('phone_number')">
        <phone-input v-model="searchParams.phone_number"></phone-input>
      </form-group>
      <form-group :label="getDisplayName('expire_date')">
        <date-picker class="col-sm-6" :placeholder="$t('common_field.from')"
                         name="expireFrom"
                         data-vv-as="expire from"
                         format="YYYY-MM-DD"
                         v-model="expireDate.expireFrom"
                         locale="ja"/>
        <date-picker class="col-sm-6" :placeholder="$t('common_field.to')"
                         name="expireTo"
                         data-vv-as="expire to"
                         format="YYYY-MM-DD"
                         v-model="expireDate.expireTo"
                         locale="ja"/>
      </form-group>
      <form-group :label="getDisplayName('is_active')">
        <radio-group inline="true" v-model="searchParams.is_active" :options="isActiveOptions"/>
      </form-group>

      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
        <button type="button" class="btn btn-primary" @click="clearSearchForm()">{{ $t("form_action.clear") }}</button>
        <button type="button" class="btn btn-primary" @click="downloadCSV()">{{ $t("form_action.download_csv") }}</button>
      </div>
    </validation-form>

    <h2>{{ $t("company_list.list_title") }}</h2>

    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 9%">{{ getDisplayName('id') }}</th>
      <th data-sort-field="name" style="width: 24%">{{ getDisplayName('name') }}</th>
      <th data-sort-field="name_phonetic" style="width: 22%">{{ getDisplayName('name_phonetic') }}</th>
      <th data-sort-field="phone_number" style="width: 11%">{{ getDisplayName('phone_number') }}</th>
      <th data-sort-field="is_active" style="width: 9%">{{ getDisplayName('is_active') }}</th>
      <th data-sort-field="expire_date" style="width: 9%">{{ getDisplayName('expire_date') }}</th>
      <th style="width: 8%"></th>
      <th style="width: 8%"></th>
      <template slot="body" scope="props">
        <tr>
          <td style="width: 9%">{{ props.item.id }}</td>
          <td style="width: 24%">{{ props.item.name }}</td>
          <td style="width: 22%">{{ props.item.name_phonetic }}</td>
          <td style="width: 11%">{{ props.item.phone_number }}</td>
          <td style="width: 9%">{{ props.item.is_active | state  }}</td>
          <td style="width: 9%">{{ props.item.expire_date | date }}</td>
          <td @click="openEditPage(props.item)" style="width: 8%">
            <button type="button" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-pencil"></span> {{$t('common_action.edit')}}</button>
          </td>
          <td @click="deleteRow(props.item)" style="width: 8%">
            <button type="button" class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-remove"></span> {{$t('common_action.delete')}}</button>
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

import _ from 'lodash';
import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import Utils from '../../../js/common/Utils';
import queryString from 'querystring';
import {companyNavigators as subNavigators} from '../../../js/app/manage/routes';
import QueryBuilder from '../../../js/lib/QueryBuilder';

const searchParams = {
  id: '',
  name: '',
  name_phonetic: '',
  phone_number: '',
  is_active: ''
};
const expireDate = {
  expireFrom: '',
  expireTo: '',
};
export default {
  data() {
    return {
      searchParams,
      expireDate,
      masterdata: Utils.getMasterdataSkel(),
      user,
      subNavigators,
      isActiveOptions: Utils.getBooleans(),
      isShowModal: false,
      messageModal: "あなたは、このデータをしません削除したいです?",
      paramsModal: null,
    }
  },

  methods: {
    getData(params) {
      return rf.getRequest('CompanyRequest').getList(params);
    },
    getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'companies', fieldName);
    },
    openEditPage(row) {
      this.$router.push({
        path: '/company/edit',
        query: {
          id: row ? row.id : null
        }
      });
    },
    deleteRow(row) {
      this.isShowModal = true;
      this.paramsModal = row;
    },
    deleteData(row){
      this.isShowModal = false;
      rf.getRequest('CompanyRequest').removeOne(row.id).then(res => {
        this.$refs.datatable.$emit('DataTable:refresh')
      });
    },
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'companies', fieldName);
      },
    initSearchParams() {
      this.searchParams = Object.assign({}, searchParams);
      this.expireDate = Object.assign({}, expireDate);
    },
    clearSearchForm() {
      this.initSearchParams();
      this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
    },
    buildSearchQuery() {
      return new QueryBuilder(this.searchParams)
                  .append('expire_date', this.expireDate.expireFrom, '>')
                  .append('expire_date', this.expireDate.expireTo, '<');
    },

    search() {
      this.$refs.searchForm.validate().then(() => {
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
      }).catch(() => {});
    },

    downloadCSV() {
      var query = this.buildSearchQuery();
      window.location.href = "/manage/companies/csv?" + queryString.stringify(query);
    }
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    this.initSearchParams();
    rf.getRequest('MasterdataRequest').getAll().then(res => {
        this.masterdata = res;
    });
  }
}
</script>
