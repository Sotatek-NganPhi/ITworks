<template>
  <div>
    <validation-form ref="adminForm">
      <form-group :label="getDisplayName('id')" :is-required="isFieldRequired('id')" v-show="record.id">
        <input class="form-control" id="input-id" type="text" v-model="record.id" disabled/>
      </form-group>
      <form-group :label="getDisplayName('type')" :is-required="isFieldRequired('type')">
        <radio-group inline="true" data-vv-name="type" v-model="record.type" :options="typeManagerOptions"/>
      </form-group>
      <form-group :label="getDisplayName('name')" :is-required="isFieldRequired('name')">
        <input class="form-control" id="input-name" type="text" v-model="record.name" />
      </form-group>
      <form-group :label="getDisplayName('username')" :is-required="isFieldRequired('username')">
        <input class="form-control" data-vv-name="username" id="input-username" type="text" v-model="record.username" />
      </form-group>
      <form-group :label="getDisplayName('password')" :is-required="isPasswordRequired()">
        <input class="form-control" data-vv-name="password" id="input-password" type="password" v-model="record.password" />
      </form-group>
      <form-group :label="$t('common_field.password_confirmation')" :is-required="isPasswordRequired()">
        <input class="form-control" data-vv-name="password" type="password" v-model="record.password_confirmation" />
      </form-group>
      <form-group :label="getDisplayName('email')" :is-required="isFieldRequired('email')">
        <input class="form-control" data-vv-name="email" id="input-email" type="text" v-model="record.email" />
      </form-group>
      <form-group :label="getDisplayName('is_active')" :is-required="isFieldRequired('is_active')">
        <radio-group inline="true" data-vv-name="is_active" v-model="record.is_active" :options="isActiveOptions"/>
      </form-group>
      <form-group :label="$t('admin_list.manage')" v-show="record.type == 2">
        <multiselect
                v-model="selectedCompanies"
                :placeholder="$t('common_action.pick')"
                label="name"
                track-by="id"
                :options="companies"
                :multiple="true"
                :close-on-select="false"
                :clear-on-select="false"
                :hide-selected="true"/>
      </form-group>
    </validation-form>


    <div class="text-center">
      <button type="button" class="btn btn-primary btn-sm" @click="confirmUpdate()">
        <span class="glyphicon glyphicon-ok"></span> {{$t('common_action.ok')}}
      </button>
      <button type="button" class="btn btn-default btn-sm" @click="cancel()">
        <span class="glyphicon glyphicon-remove"></span> {{$t('common_action.cancel')}}
      </button>
    </div>

    <h2 class="list-title" v-show="record.type == 2">{{ $t("admin_list.company_list") }}</h2>

    <data-table :getData="getManagingCompanies" ref="datatable" v-show="record.type == 2">
      <th data-sort-field="id">{{ getDatatableName('id')}}</th>
      <th data-sort-field="name">{{ getDatatableName('name')}}</th>
      <th data-sort-field="phone_number">{{ getDatatableName('phone_number')}}</th>
      <th data-sort-field="is_active">{{ getDatatableName('is_active')}}</th>
      <th data-sort-field="expire_date">{{ getDatatableName('expire_date')}}</th>
      <th></th>
      <th></th>
      <template slot="body" scope="props">
        <tr>
          <td>{{ props.item.id }}</td>
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.phone_number }}</td>
          <td>{{ props.item.is_active | state }}</td>
          <td>{{ props.item.expire_date | date }}</td>
          <td @click="openEditPage(props.item)">
            <button type="button" class="btn btn-default btn-sm">
              <span class="glyphicon glyphicon-pencil"></span> {{$t('common_action.edit')}}</button>
          </td>
          <td @click="deleteRow(props.item)">
            <button type="button" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-remove"></span> {{$t('common_action.delete')}}</button>
          </td>
        </tr>
      </template>
    </data-table>

    <confirmation-dialog v-if="isEditModal" @ConfirmationDialog:CANCEL="isEditModal = false"
                         @ConfirmationDialog:OK="updateChange"
                         :message="messageEditModal">
    </confirmation-dialog>

    <confirmation-dialog v-if="isDeleteModal" @ConfirmationDialog:CANCEL="isDeleteModal = false"
                         @ConfirmationDialog:OK="deleteData"
                         :message="messageDeleteModal" :params="paramsDeleteModal">
    </confirmation-dialog>
  </div>
</template>

<script>

import _ from 'lodash';
import $ from 'jquery';
import rf from '../../../js/lib/RequestFactory';
import Utils from '../../../js/common/Utils';
import {user} from '../../../js/app/manage/main';
import {companyNavigators as subNavigators} from '../../../js/app/manage/routes';
import Multiselect from 'vue-multiselect';
import QueryBuilder from '../../../js/lib/QueryBuilder';

const companyAdminType = 2;
const defaultRecord = {
  id: '',
  name: '',
  type: '',
  username: '',
  password: '',
  password_confirmation: '',
  email: '',
  is_active: '',
  companies: [],
};

export default {
  components: {
      Multiselect
  },
  data() {
    return {
      user,
      subNavigators,
      record: {},
      masterdata: Utils.getMasterdataSkel(),
      oldRecord: {
        'type': '',
        'is_active': ''
      },
      selectedCompanies: [],
      companies: [],
      typeManagerOptions: Utils.getTypeManagers(),
      isActiveOptions: Utils.getYesNoOptions(),
      isEditModal: false,
      messageEditModal: "Bạn có muốn lưu thay đổi?",

      isDeleteModal: false,
      messageDeleteModal: "Bạn có muốn xóa?",
      paramsDeleteModal: null,
    }
  },

  methods: {
    isPasswordRequired() {
      if (this.$route.query.id) return false;
      return true;
    },
    isFieldRequired(fieldName) {
      return Utils.isFieldRequired(this.masterdata, 'managers', fieldName);
    },
    getDatatableName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'companies', fieldName);
    },
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'managers', fieldName);
    },
    getManagingCompanies(params) {
      var searchParams = _.merge(new QueryBuilder({'managers.manager_id': this.$route.query.id}), params);
      return rf.getRequest('CompanyRequest').getList(searchParams);
    },
    confirmUpdate() {
      this.isEditModal = true;
    },
    updateChange() {
      this.isEditModal = false;
      var selectedCompanies = [];
      if (this.record.type !== companyAdminType) {
        this.record.companies = [];
      } else {
        this.record.companies = _.map(this.selectedCompanies, 'id');
        selectedCompanies = this.selectedCompanies;
      }
      if (this.record.password == '' && this.record.password_confirmation == '' && this.record.id) {
        delete this.record.password;
        delete this.record.password_confirmation;
      }
      const adminPromise = (this.record && this.record.id)
      ? rf.getRequest('AdminRequest').updateOne(this.record.id, this.record)
      : rf.getRequest('AdminRequest').createANewOne(this.record);
      adminPromise.then(res => {
        window.Utils.growl('request.request_success');
        if (!this.$route.query.id) {
          this.$router.push({
            path: '/admin/list'
          });
        }
        this.oldRecord = res;
        this.oldRecord.companies = selectedCompanies;
        this.resetChange();
        this.$refs.datatable.$emit('DataTable:refresh');
      }).catch(({ validationErrors }) => {
        if (validationErrors) {
          this.$refs.adminForm.$emit('REJECT_FORM', validationErrors);
        }
      });
    },
    resetChange() {
      this.record = JSON.parse(JSON.stringify(this.oldRecord));
      this.selectedCompanies = this.oldRecord.companies;
      this.$refs.adminForm.$emit('FORM_ERRORS_CLEAR');
    },
    cancel() {
      this.$router.push({
        path: '/admin/list'
      });
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
      this.isDeleteModal = true;
      this.paramsDeleteModal = row;
    },
    deleteData(row) {
      this.isDeleteModal = false;
      rf.getRequest('CompanyRequest').removeOne(row.id, {managers: []}).then(res => {
          this.$refs.datatable.$emit('DataTable:refresh')
      });
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    let id = this.$route.query.id;
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    const companyPromise = rf.getRequest('CompanyRequest').getCompanies();
    const managerPromise = id
        ? rf.getRequest('AdminRequest').getOne(id, {'with': 'companies'})
        : Promise.resolve(defaultRecord);

    Promise.all([companyPromise, managerPromise, masterdataPromise]).then(([companies, managers, masterdata]) => {
      this.companies = companies;
      this.oldRecord = managers;
      this.masterdata = masterdata;
      this.selectedCompanies = this.oldRecord.companies;
      this.resetChange();
    });
  }
}
</script>

<style>
  .multiselect {
    z-index: 3;
  }
</style>


