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
      <th data-sort-field="id" style="width: 10%"> {{ $t("job.id") }} </th>
      <th data-sort-field="company_name" style="width: 53%"> {{ $t("job.company_name") }} </th>
      <th data-sort-field="email_receive_applicant" style="width: 24%"> {{ $t("job.email_receive_applicant") }} </th>
      <th style="width: 13%"></th>
      <template slot="body" scope="props">
        <tr>
          <td>{{ props.item.id }}</td>
          <td>{{ props.item.company_name }}</td>
          <td>{{ props.item.email_receive_applicant }}</td>
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

const localMasterdata = {
  regions: []
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
      localMasterdata: localMasterdata,
      filterRegions: []
    }
  },
  methods: {
    getData(params) {
      return rf.getRequest('JobRequest').getList(params);
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
        'company_name': this.searchParams.name
      };
      const query = new QueryBuilder(searchParams);
      if(this.filterRegions.length) {
        const regions = _.map(this.filterRegions, 'id');
        query.append('prefectures.region_id', regions, '=');
      }

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
    const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
    Promise.all([masterdataPromise]).then(([masterdata]) => {
      this.localMasterdata = masterdata;
    });
  }
}
</script>

<style>
  .multiselect {
    z-index: 3;
  }
</style>