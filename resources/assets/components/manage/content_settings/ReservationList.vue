<template>
  <div>
    <h2>{{ $t("reservation_list.search_title") }}</h2>

  <validation-form ref="searchForm">
    <form-group :label="$t('common_field.id')">
      <input name="id" v-validator="'numeric|min:0'" class="form-control" type="text" v-model="searchParams.id"/>
    </form-group>

    <form-group :label="$t('candidate.name')">
      <input class="form-control" type="text" v-model="searchParams.full_name"/>
    </form-group>

    <form-group :label="$t('common_field.email')">
      <input name="email" v-validator="'email'" class="form-control" type="text" v-model="searchParams.email"/>
    </form-group>

    <form-group :label="$t('common_field.phone_number')">
      <input class="form-control" type="text" v-model="searchParams.phone_number"/>
    </form-group>

    <div class="text-center">
      <button type="button" class="btn btn-primary" @click="search">{{ $t("form_action.search") }}</button>
      <button type="button" class="btn btn-primary" @click="initSearchParams">{{ $t("form_action.clear") }}</button>
    </div>

  </validation-form>

  <h2>{{ $t("reservation_list.list_title") }}</h2>

  <data-table :getData="getData" ref="datatable">
    <th data-sort-field="id" style="width: 9%">{{ getDisplayName('id') }}</th>
    <th data-sort-field="full_name" style="width: 14%">{{ getDisplayName('full_name') }}</th>
    <th data-sort-field="full_name_phonetic" style="width: 14%">{{ getDisplayName('full_name_phonetic') }}</th>
    <th data-sort-field="email" style="width: 22%">{{ getDisplayName('email') }}</th>
    <th data-sort-field="gender" style="width: 7%">{{ getDisplayName('gender') }}</th>
    <th data-sort-field="phone" style="width: 16%">{{ getDisplayName('phone_number') }}</th>
    <th data-sort-field="current_situations" style="width: 10%">{{ getDisplayName('current_situation') }}</th>
    <th style="width: 8%"></th>
    <template slot="body" scope="props">
      <tr>
        <td style="width: 9%">{{ props.item.id }}</td>
        <td style="width: 14%">{{ props.item.full_name }}</td>
        <td style="width: 14%">{{ props.item.full_name_phonetic }}</td>
        <td style="width: 22%">{{ props.item.email }}</td> 
        <td style="width: 7%">{{ props.item.gender | gender }}</td>
        <td style="width: 16%">{{ props.item.phone_number }}</td>
        <td style="width: 10%">{{ props.item.current_situations }}</td>
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
import QueryBuilder from '../../../js/lib/QueryBuilder';
import {user} from '../../../js/app/manage/main';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';

const searchParams = {
  id:'',
  full_name: '',
  email: '',
  phone_number: '',
  expo_id: ''
};

export default {
  data() {
    return {
      user,
      subNavigators,
      masterdata : {},
      searchParams,
      isShowModal: false,
      messageModal: "あなたは、このデータをしません削除したいです?",
      paramsModal: null,
    }
  },

  methods: {
    getData(params) {
      return rf.getRequest('ReservationRequest').getList(params);
    },
    deleteRow(row) {
      this.isShowModal = true
      this.paramsModal = row
    },
    deleteData(row) {
      rf.getRequest('ReservationRequest').removeOne(row.id).then(() => {
        this.isShowModal = false
        this.$refs.datatable.rows = _.filter(this.$refs.datatable.rows, record => {
          return record.id != row.id
        });
      });
    },
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'candidates', fieldName);
    },
    buildSearchQuery() {
      return new QueryBuilder(this.searchParams);
    },
    search() {
      this.$refs.searchForm.validate().then(() => {
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
      }).catch((err) => {});
    },
    initSearchParams() {
      this.searchParams = {
        id:'',
        full_name: '',
        email: '',
        phone_number: '',
        expo_id: this.searchParams.expo_id
      };
      this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    this.searchParams.expo_id = this.$route.query.expo_id;
    this.search();
    rf.getRequest('MasterdataRequest').getAll().then(res => {
        this.masterdata = res;
    });
  }
}
</script>
