<template>
  <div>
    <div class="text-center">
      <button type="button" class="btn btn-success btn-sm" @click="openEditPage()">
        <span class="glyphicon glyphicon-plus"></span> {{ $t("common_action.new") }}
      </button>
    </div>
    <h2>{{ $t("admin_list.search_title") }}</h2>
    <validation-form ref="searchForm">
      <form-group :label="getDisplayName('id')">
        <input class="form-control" v-validator="'numeric|min:0'" name="id" id="input-id" type="text" v-model="searchParams.id"/>
      </form-group>
      <form-group :label="getDisplayName('type')">
        <radio-group inline="true" v-model="searchParams.type" :options="typeManagerOptions"/>
      </form-group>
      <form-group :label="getDisplayName('username')">
        <input class="form-control" id="input-user_name" type="text" v-model="searchParams.username"/>
      </form-group>
      <form-group :label="getDisplayName('name')">
        <input class="form-control" id="input-full_name" type="text" v-model="searchParams.name"/>
      </form-group>
      <form-group :label="getDisplayName('email')">
        <input class="form-control" name="email" id="input-email" v-validator="'email'" type="text" v-model="searchParams.email"/>
      </form-group>
      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
        <button type="button" class="btn btn-primary" @click="clearSearchForm()">{{ $t("form_action.clear") }}</button>
        </button>
      </div>
    </validation-form>
    <h1>{{ $t("admin_list.list_title") }}</h1>
    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 7%">{{ this.getDisplayName('id') }}</th>
      <th data-sort-field="type" style="width: 15%">{{ this.getDisplayName('type') }}</th>
      <th data-sort-field="username" style="width: 15%">{{ this.getDisplayName('username') }}</th>
      <th data-sort-field="name" style="width: 26%">{{ this.getDisplayName('name') }}</th>
      <th data-sort-field="email" style="width: 21%">{{ this.getDisplayName('email') }}</th>
      <th style="width: 8%"></th>
      <th style="width: 8%"></th>
      <template slot="body" scope="props">
        <tr>
          <td style="width: 7%">{{ props.item.id }}</td>
          <td style="width: 15%">{{ props.item.type | managerType }}</td>
          <td style="width: 15%">{{ props.item.username }}</td>
          <td style="width: 26%">{{ props.item.name }}</td>
          <td style="width: 21%">{{ props.item.email }}</td>
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

import rf from '../../../js/lib/RequestFactory';
import QueryBuilder from '../../../js/lib/QueryBuilder';
import {user} from '../../../js/app/manage/main';
import {companyNavigators as subNavigators} from '../../../js/app/manage/routes';

const searchParams = {
  id: '',
  username: '',
  name: '',
  email: '',
  type: ''
};

export default {
  data() {
    return {
      searchParams: {},
      masterdata: {},
      user,
      masterdata: Utils.getMasterdataSkel(),
      type_manager: '0',
      subNavigators,
      typeManagerOptions: Utils.getTypeManagers(),
      isShowModal: false,
      messageModal: "Bạn có muốn xóa không?",
      paramsModal: null,
    }
  },
  filters: {
    managerType(type) {
      if (type == 1) return 'Quản trị hệ thống';
      else if (type == 2) return 'Quản trị viên công ty';
    },
  },
  methods: {
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'managers', fieldName);
    },
    getData(params) {
      return rf.getRequest('AdminRequest').getList(params);
    },
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'managers', fieldName);
    },
    initSearchParams() {
      this.searchParams = Object.assign({}, searchParams);
    },
    clearSearchForm() {
      this.initSearchParams();
      this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
    },
    openEditPage(row) {
      this.$router.push({
        path: '/admin/edit',
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
      rf.getRequest('AdminRequest').removeOne(row.id).then(res => {
        this.$refs.datatable.$emit('DataTable:refresh');
      });
    },
    buildSearchQuery() {
      return new QueryBuilder(this.searchParams);
    },
    search() {
      this.$refs.searchForm.validate().then(() => {
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
      }).catch(() => {});
    },
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
