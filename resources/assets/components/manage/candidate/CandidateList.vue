<template>
  <div>
  <h2>{{ $t("candidate.search_title") }}</h2>

  <validation-form ref="searchForm">
    <form-group :label="$t('common_field.id')">
      <input name="id" v-validator="'numeric|min:0'" class="form-control" type="text" v-model="searchParams.id"/>
    </form-group>

    <form-group :label="$t('candidate.name')">
      <input class="form-control" type="text" v-model="searchParams.name"/>
    </form-group>

    <form-group :label="$t('common_field.birthday')">
      <date-picker v-model="searchParams.birthday" format="YYYY-MM-DD" locale="ja"/>
    </form-group>

    <form-group :label="$t('common_field.email')">
      <input name="email" v-validator="'email'" class="form-control" type="text" v-model="searchParams.email"/>
    </form-group>

    <form-group :label="$t('common_field.gender')">
      <radio-group inline="true" v-model="searchParams.gender" :options="genderOptions"/>
    </form-group>

    <form-group :label="$t('candidate.registed_date')">
      <date-picker class="col-sm-6" :placeholder="$t('common_field.from')"
        name="registedFrom"
        v-model="searchParams.registedDateFrom"
        locale="ja"/>
      <date-picker class="col-sm-6" :placeholder="$t('common_field.to')"
        name="registedTo"
        v-model="searchParams.registedDateTo"
        locale="ja"/>
    </form-group>

    <div class="text-center">
      <button type="button" class="btn btn-primary" @click="search">{{ $t("form_action.search") }}</button>
      <button type="button" class="btn btn-primary" @click="clear()">{{ $t("form_action.clear") }}</button>
    </div>

  </validation-form>

  <data-table :getData="getData" ref="datatable" class="table-candidate-list" :title="$t('candidate.list_title')">
    <th data-sort-field="id" style="width: 4%">{{ $t("common_field.id") }}</th>
    <th data-sort-field="users.name" style="width: 14%">{{ $t("candidate.name") }}</th>
    <th data-sort-field="users.birthday" style="width: 12%">{{ $t("common_field.birthday") }}</th>
    <th data-sort-field="users.email" style="width: 20%">{{ $t("common_field.email") }}</th>
    <th data-sort-field="candidates.created_at" style="width: 11%">{{ $t("candidate.registed_date") }}</th>
    <th style="width: 10%"></th>
    <template slot="body" scope="props">
      <tr>
        <td style="width: 4%">{{ props.item.id }}</td>
        <td style="width: 14%">{{ props.item.name }}</td>
        <td style="width: 12%">{{ props.item.birthday }}</td>
        <td style="width: 20%">{{ props.item.email }}</td>
        <td style="width: 11%">{{ props.item.created_at }}</td>
        <td @click="openEditPage(props.item)" style="width: 10%">
          <button type="button" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-pencil"></span> {{$t("common_action.edit")}}
          </button>
        </td>
      </tr>
    </template>
  </data-table>
  </div>
</template>

<script>

  import _ from 'lodash';
  import moment from 'moment';
  import queryString from 'querystring';
  import Utils from '../../../js/common/Utils';
  import rf from '../../../js/lib/RequestFactory';
  import {user} from '../../../js/app/manage/main';
  import QueryBuilder from '../../../js/lib/QueryBuilder';
  import {candidateNavigators as subNavigators} from '../../../js/app/manage/routes';

  export default {
    data() {
      return {
        searchParams: {
          id: '',
          name: '',
          email: '',
          gender: '',
          birthday: '',
          mailReceivable: '',
          registedDateFrom: '',
          registedDateTo: '',
        },
        user,
        subNavigators,
        rows: [],
        masterdata: {},
        genderOptions: Utils.getGenders(),
        mailReceivableOptions: Utils.getBooleans(),
        isShowModal: false,
        paramsModal: null
      }
    },
    computed: {
      birthdayFromAge() {
        if (this.searchParams.age) {
          return moment().subtract(this.searchParams.age, 'years').format('YYYY-MM-DD');
        }
      }
    },
    methods: {
      getData(params) {
        params.with = params.with ? `${params.with};user` : 'user';
        return rf.getRequest('CandidateRequest').getList(params);
      },
      openEditPage(row) {
        this.$router.push({
          path: '/candidate/edit',
          query: {
            id: row ? row.id : null
          }
        });
      },
      initSearchParams() {
        this.searchParams = Object.assign({}, {
          id: '',
          name: '',
          email: '',
          gender: '',
          birthday: '',
          mailReceivable: '',
          registedDateFrom: '',
          registedDateTo: ''
        });
      },
      buildSearchQuery() {
        const searchParams = {
          'id': this.searchParams.id,
          'user.name': this.searchParams.name,
          'user.email': this.searchParams.email,
          'user.gender': this.searchParams.gender,
          'user.birthday': [this.searchParams.birthday, 'like'],
          'user.mail_receivable': [this.searchParams.mailReceivable, '=']
        };
        const query = new QueryBuilder(searchParams);
        query.append('user.created_at', this.searchParams.registedDateFrom, '>=');
        query.append('user.created_at', this.searchParams.registedDateTo, '<=');

        if (this.birthdayFromAge) {
          query.append('user.birthday', this.birthdayFromAge);
        }

        return query;
      },
      search() {
        this.$refs.searchForm.validate().then(() => {
          this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
        }).catch(() => {
        });
      },
      clear() {
        this.initSearchParams();
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
        this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      },
    },
    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      rf.getRequest('MasterdataRequest').getAll().then(res => this.masterdata = res);
    }
  }
</script>

<style>
  .table-candidate-list .panel-heading{
    display: flex !important;
  }
</style>