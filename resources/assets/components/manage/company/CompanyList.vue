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
      <form-group :label="getDisplayName('phone_number')">
      <input class="form-control" type="number" v-model="searchParams.phone_number"/>
      </form-group>
      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
        <button type="button" class="btn btn-primary" @click="clearSearchForm()">{{ $t("form_action.clear") }}</button>
      </div>
    </validation-form>

    <h2>{{ $t("company_list.list_title") }}</h2>

    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 15%">{{ getDisplayName('id') }}</th>
      <th data-sort-field="name" style="width: 35%">{{ getDisplayName('name') }}</th>
      <th data-sort-field="phone_number" style="width: 30%">{{ getDisplayName('phone_number') }}</th>
      <th style="width: 15%"></th>
      <th style="width: 15%"></th>
      <template slot="body" scope="props">
        <tr>
          <td style="width: 15%">{{ props.item.id }}</td>
          <td style="width: 35%">{{ props.item.name }}</td>
          <td style="width: 30%">{{ props.item.phone_number }}</td>
          <td @click="openEditPage(props.item)" style="width: 15%">
            <button type="button" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-pencil"></span> {{$t('common_action.edit')}}</button>
          </td>
          <td @click="deleteRow(props.item)" style="width: 15%">
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
  phone_number: '',
};
export default {
  data() {
    return {
      searchParams,
      masterdata: Utils.getMasterdataSkel(),
      user,
      subNavigators,
      isShowModal: false,
      messageModal: "Bạn có muốn xóa công ty này không?",
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
    },
    clearSearchForm() {
      this.initSearchParams();
      this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
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
