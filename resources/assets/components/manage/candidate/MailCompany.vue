<template>
  <div>
    <h2>{{ $t("company.search_title") }}</h2>

    <validation-form ref="searchForm">
      <form-group :label="$t('job.company_name')">
        <input class="form-control" type="text" v-model="searchParams.name"/>
      </form-group>

      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="search">{{ $t("form_action.search") }}</button>
        <button type="button" class="btn btn-primary" @click="clear">{{ $t("form_action.clear") }}</button>
      </div>

    </validation-form>
    <h2>{{ $t("company.list_title") }}</h2>

    <data-table :getData="getData" ref="datatable">
      <th data-sort-field="id" style="width: 20%">ID</th>
      <th data-sort-field="name" style="width: 40%">Tên công ty</th>
      <th data-sort-field="email" style="width: 20%">Email</th>
      <th style="width: 12%"></th>
      <template slot="body" scope="props">
        <tr>
          <td style="width: 20%">{{ props.item.id }}</td>
          <td style="width: 40%">{{ props.item.name }}</td>
          <td style="width: 20%">{{ props.item.email }}</td>
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

import Utils from '../../../js/common/Utils';
import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import $ from 'jquery';
import Multiselect from 'vue-multiselect';
import QueryBuilder from '../../../js/lib/QueryBuilder';
import {candidateNavigators as subNavigators} from '../../../js/app/manage/routes';

const searchParams = {
  name: '',
};

export default {
  components: {
    Multiselect
  },
  data() {
    return {
      searchParams: searchParams,
      user,
      subNavigators,
    }
  },
  methods: {
    getData(params) {
      return rf.getRequest('CompanyRequest').getList(params);
    },
    openMailPage(row) {
      this.$router.push({
        path: '/candidate/send_mail_to_company',
        query: {
          id: row ? row.id : null
        }
      });
    },

    buildSearchQuery() {
      const searchParams = {
        'name': this.searchParams.name
      };
      const query = new QueryBuilder(searchParams);

      return query;
    },

    initSearchParams() {
      this.filterRegions = [];
      this.searchParams.name = '';
    },

    search() {
      this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
    },

    clear() {
      this.initSearchParams();
      this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
      this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
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

<style>
  .multiselect {
    z-index: 3;
  }
</style>