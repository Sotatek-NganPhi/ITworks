<template>
  <div>
    <h2>{{ $t("candidate.search_title") }}</h2>

    <validation-form ref="searchForm">
      <form-group :label="$t('candidate.name')">
        <input class="form-control" type="text" v-model="searchParams.name"/>
      </form-group>

      <form-group :label="$t('common_field.email')">
        <input name="email" v-validator="'email'" class="form-control" type="text" v-model="searchParams.email"/>
      </form-group>

      <form-group :label="$t('candidate.current_situation')">
        <select class="form-control" v-model="searchParams.current_situation">
          <option value="">---</option>
          <option v-for="situation in masterdata.current_situations" :value="situation.id">{{ situation.name }}</option>
        </select>
      </form-group>
      <h4>{{ $t("candidate.search_condition") }}</h4>

      <form-group :label="$t('candidate.prefecture')">
        <select class="form-control" v-model="searchParams.prefecture">
          <option value="">---</option>
          <option v-for="prefecture in masterdata.prefectures" :value="prefecture.id">{{ prefecture.name }}</option>
        </select>
      </form-group>
      <form-group :label="$t('candidate.category_level3')">
        <select class="form-control" v-model="searchParams.category_level3">
          <option value="">---</option>
          <option v-for="category_level3 in masterdata.category_level3s" :value="category_level3.id">{{ category_level3.name }}</option>
        </select>
      </form-group>
      <form-group :label="$t('candidate.salary')">
        <select class="form-control" v-model="searchParams.salary">
          <option value="">---</option>
          <option v-for="salary in masterdata.salaries" :value="salary.id">{{ salary.description }}</option>
        </select>
      </form-group>
      <form-group :label="$t('candidate.working_shift')">
        <select class="form-control" v-model="searchParams.working_shift">
          <option value="">---</option>
          <option v-for="working_shift in masterdata.working_shifts" :value="working_shift.id">{{ working_shift.name }}</option>
        </select>
      </form-group>
      <form-group :label="$t('candidate.employment_mode')">
        <select class="form-control" v-model="searchParams.employment_mode">
          <option value="">---</option>
          <option v-for="employment_mode in masterdata.employment_modes" :value="employment_mode.id">{{ employment_mode.description }}</option>
        </select>
      </form-group>
      <form-group :label="$t('candidate.merit')">
        <select class="form-control" v-model="searchParams.merit">
          <option value="">---</option>
          <option v-for="merit in masterdata.merits" :value="merit.id">{{ merit.name }}</option>
        </select>
      </form-group>

      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="search">{{ $t("form_action.search") }}</button>
        <button type="button" class="btn btn-primary" @click="clear">{{ $t("form_action.clear") }}</button>
      </div>

    </validation-form>

    <h2>{{ $t("candidate.list_title") }}</h2>

    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 5%">{{ $t("common_field.id") }}</th>
      <th data-sort-field="users.name" style="width: 14%">{{ $t("candidate.name") }}</th>
      <th data-sort-field="users.name_phonetic" style="width: 15%">{{ $t("candidate.name_phonetic") }}</th>
      <th data-sort-field="users.birthday" style="width: 11%">{{ $t("common_field.birthday") }}</th>
      <th data-sort-field="users.email" style="width: 18%">{{ $t("common_field.email") }}</th>
      <th data-sort-field="candidates.created_at" style="width: 11%">{{ $t("candidate.registed_date") }}</th>
      <th data-sort-field="users.mail_receivable" style="width: 16%">{{ $t("candidate.mail_receivable") }}</th>
      <th style="width: 10%"></th>
      <template slot="body" scope="props">
        <tr>
          <td>{{ props.item.id }}</td>
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.name_phonetic }}</td>
          <td>{{ props.item.birthday }}</td>
          <td>{{ props.item.email }}</td>
          <td>{{ props.item.created_at }}</td>
          <td>{{ props.item.mail_receivable | boolean }}</td>
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
    current_situation: '',
    prefecture: '',
    category_level3: '',
    salary: '',
    working_shift: '',
    employment_mode: '',
    merit: '',
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
          'current_situation_id': this.searchParams.current_situation,
          'prefectures.prefecture_id': this.searchParams.prefecture,
          'categoryLevel3s.category_level3_id': this.searchParams.category_level3,
          'salaries.salary_id': this.searchParams.salary,
          'workingShifts.working_shift_id': this.searchParams.working_shift,
          'employmentModes.employment_mode_id': this.searchParams.employment_mode,
          'merits.merit_id': this.searchParams.merit,
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