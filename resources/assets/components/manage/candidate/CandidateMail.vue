<template>
  <div>

    <validation-form ref="searchForm">
      <form-group :label="$t('candidate.name')">
        <input class="form-control" type="text" v-model="searchParams.name"/>
      </form-group>

      <form-group :label="$t('common_field.email')">
        <input name="email" v-validator="'email'" class="form-control" type="text" v-model="searchParams.email"/>
      </form-group>
      
      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="search">{{ $t("form_action.search") }}</button>
        <button type="button" class="btn btn-primary" @click="clear">{{ $t("form_action.clear") }}</button>
      </div>

    </validation-form>

    <h2>{{ $t("candidate.list_title") }}</h2>

    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 5%">{{ $t("common_field.id") }}</th>
      <th data-sort-field="users.name" style="width: 20%">{{ $t("candidate.name") }}</th>
      <th data-sort-field="users.birthday" style="width: 15%">{{ $t("common_field.birthday") }}</th>
      <th data-sort-field="users.email" style="width: 20%">{{ $t("common_field.email") }}</th>
      <th data-sort-field="candidates.created_at" style="width: 14%">{{ $t("candidate.registed_date") }}</th>
      <th style="width: 10%"></th>
      <template slot="body" scope="props">
        <tr>
          <td>{{ props.item.id }}</td>
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.birthday }}</td>
          <td>{{ props.item.email }}</td>
          <td>{{ props.item.created_at }}</td>
          <td @click="openMailPage(props.item)">
            <button type="button" class="btn btn-default btn-sm">
              <span class="glyphicon glyphicon-envelope"></span> {{$t("candidate.sendmail")}}
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

  const searchParams = {
    name: '',
    email: undefined,
    prefecture: '',
  };

  export default {
    data() {
      return {
        searchParams,
        user,
        subNavigators,
        rows: [],
        masterdata: {},
      }
    },
    methods: {
      getData(params) {
        params.with = params.with ? `${params.with};user` : 'user';
        return rf.getRequest('CandidateRequest').getList(params);
      },
      openMailPage(row) {
        this.$router.push({
          path: '/candidate/candidate_sendmail',
          query: {
            id: row ? row.id : null
          }
        });
      },
      initSearchParams() {
        this.searchParams = Object.assign({}, searchParams);
      },
      buildSearchQuery() {
        const searchParams = {
          'user.name': this.searchParams.name,
          'user.email': this.searchParams.email,
        };
        const query = new QueryBuilder(searchParams);
        query.append('user.created_at', this.searchParams.registedDateFrom, '>=');
        query.append('user.created_at', this.searchParams.registedDateTo, '<=');

        return query;
      },
      search() {
        this.$refs.searchForm.validate().then(() => {
          this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
        }).catch(() => {});
      },
      clear() {
        this.initSearchParams();
        this.search();
        this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      }
    },
    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      rf.getRequest('MasterdataRequest').getAll().then(res => this.masterdata = res);
      this.initSearchParams();
    }
  }
</script>