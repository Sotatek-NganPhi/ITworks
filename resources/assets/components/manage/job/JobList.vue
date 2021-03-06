<template>
  <div>
    <template>
      <div class="text-center">
        <button type="button" class="btn btn-success btn-sm" @click="openEditPage()">
          <span class="glyphicon glyphicon-plus"></span> {{ $t("common_action.new") }}
        </button>
      </div>

      <h2>{{ $t("job_list.search_title") }}</h2>

      <validation-form ref="searchForm">
        <form-group :label="getDisplayName('id')">
          <input v-validator="'numeric|min:0'" class="form-control" type="text" v-model="searchParams.id"/>
        </form-group>
        <form-group :label="getDisplayName('company_name')">
          <select class="form-control" v-model="searchParams.company_id">
            <option value="">---</option>
            <option v-for="company in companies" :key="company.id" :value="company.id"> {{company.name }}</option>
          </select>
        </form-group>
        <form-group :label="getDisplayName('post_start_date')">
          <date-picker ref="post_start_date" v-model="searchParams.post_start_date" format="YYYY-MM-DD" locale="en"
                       required></date-picker>
        </form-group>
        <form-group :label="getDisplayName('post_end_date')">
          <date-picker ref="post_end_date" v-model="searchParams.post_end_date" format="YYYY-MM-DD"
                       locale="en"></date-picker>
        </form-group>
        <form-group :label="getDisplayName('salary')">
          <input class="form-control" type="text" v-model="searchParams.salary"/>
        </form-group>
        <div class="text-center">
          <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
          <button type="button" class="btn btn-primary" @click="clearForm()">{{ $t("form_action.clear") }}
          </button>
        </div>
      </validation-form>

      <h1>{{ $t("job_list.job_list_title") }}</h1>
      <data-table :getData="getData" ref="datatable">
        <th data-sort-field="id" style="width: 60px; max-width: 60px; min-width: 60px">{{ getDisplayName('id') }}</th>
        <th data-sort-field="company_name" style="width: 100px; max-width: 100px; min-width: 100px">{{ getDisplayName('company_name') }}</th>
        <th data-sort-field="description" style="width: 200px; max-width: 200px; min-width: 200px">{{ getDisplayName('description') }}</th>
        <th data-sort-field="post_start_date" style="width: 110px; max-width: 110px; min-width: 110px">{{ getDisplayName('post_start_date') }}</th>
        <th data-sort-field="post_end_date" style="width: 110px; max-width: 110px; min-width: 110px">{{ getDisplayName('post_end_date') }}</th>
        <th data-sort-field="email_receive_applicant" style="width: 230px; max-width: 230px; min-width: 230px">{{ getDisplayName('email_receive_applicant') }}</th>
        <th style="width: 75px; max-width: 75px; min-width: 75px"></th>
        <th style="width: 75px; max-width: 75px; min-width: 75px"></th>
        <template slot="body" scope="props">
          <tr>
            <td>{{ props.item.id }}</td>
            <td>{{ props.item.company.name }}</td>
            <td>{{ props.item.description }}</td>
            <td>{{ props.item.post_start_date }}</td>
            <td>{{ props.item.post_end_date }}</td>
            <td>{{ props.item.email_receive_applicant }}</td>
            <td @click="openEditPage(props.item)">
              <button type="button" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-pencil"></span> {{$t("common_action.edit")}}
              </button>
            </td>
            <td @click="deleteRow(props.item)">
              <button type="button" class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-remove"></span> {{$t("common_action.delete")}}
              </button>
            </td>
          </tr>
        </template>
      </data-table>
      <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                           @ConfirmationDialog:OK="deleteData"
                           :message="$t('message.before_delete')" :params="paramsModal">
      </confirmation-dialog>
    </template>
  </div>
</template>

<script>
  import rf from '../../../js/lib/RequestFactory';
  import QueryBuilder from '../../../js/lib/QueryBuilder';
  import Utils from '../../../js/common/Utils';
  import {user} from '../../../js/app/manage/main';
  import {jobNavigators as subNavigators} from '../../../js/app/manage/routes';
  import queryString from 'querystring';
  import moment from 'moment';

  const searchParams = {
    id: '',
    company_id: '',
    post_start_date: '',
    post_end_date: '',
    salary: '',
    company_name: '',
  };

  export default {
    data() {
      return {
        user,
        subNavigators,
        searchParams,
        masterdata: Utils.getMasterdataSkel(),
        isShowModal: false,
        paramsModal: null,
        companies: [],
      }
    },
    methods: {
      getData(params) {
        return rf.getRequest('JobRequest').getList(params);
      },
      openEditPage(row) {
        this.$router.push({
          path: '/job/edit',
          query: {
            id: row ? row.id : null
          }
        });
      },
      getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'jobs', fieldName);
      },
      getListFieldDisplay() {
        return Utils.getListFieldDisplay(this.masterdata, 'jobs');
      },
      getReferenceValues(fieldName) {
        // TODO: make search fields configurable and remove these hack
        if (fieldName === 'is_active') {
          let result = {};
          result[this.$t('common_field.active')] = 1;
          result[this.$t('common_field.in_active')] = 0;
          result[this.$t('common_field.not_specified')] = '';
          return result;
        }
        let result = {};
        let refValues = Utils.getReferenceValues(this.masterdata, 'jobs', fieldName);
        for (let key in refValues) {
          result[key] = refValues[key].value;
        }

        return result;
      },

      clearForm() {
        this.initSearchParams();
        this.$refs.post_start_date.$emit('DatePicker:clear');
        this.$refs.post_end_date.$emit('DatePicker:clear');
        this.search();
      },

      deleteRow(row) {
        this.isShowModal = true;
        this.paramsModal = row;
      },

      deleteData(row) {
        this.isShowModal = false;
        rf.getRequest('JobRequest').removeOne(row.id).then(res => {
          this.$refs.datatable.$emit('DataTable:refresh')
        });
      },
      initSearchParams() {
        this.searchParams = Object.assign({}, searchParams);
      },
      buildSearchQuery() {
        const searchParams = {
          'id': this.searchParams.id,
          'is_active': this.searchParams.is_active,
          'salary': [this.searchParams.salary, 'like'],
          'company_id': [this.searchParams.company_id, '='],
        };
        const query = new QueryBuilder(searchParams);
        const now = moment().format('YYYY-MM-DD');
        switch (this.searchParams.posting_situation) {
          case 1:
            if (this.searchParams.post_start_date) {
              query.append('post_start_date', this.searchParams.post_start_date, '>');
            }
            query.append('post_start_date', now, '<');

            if (this.searchParams.post_end_date && ((new Date(this.searchParams.post_end_date)) < (new Date(now)))) {
              query.append('post_end_date', this.searchParams.post_end_date, '<');
            } else {
              query.append('post_end_date', now, '<');
            }
            break;
          case 2:
            break;
          default:
            if (this.searchParams.post_start_date) {
              query.append('post_start_date', this.searchParams.post_start_date, '>=');
            }
            // query.append('post_start_date', now, '<=');

            if (this.searchParams.post_end_date) {
              query.append('post_end_date', this.searchParams.post_end_date, '<=');
            }
            // query.append('post_end_date', now, '>=');
        }
        return query;
      },
      search() {
        this.$refs.searchForm.validate().then(() => {
          this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
        }).catch(() => {});
      },
    },
    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
      const companiesPromise = rf.getRequest('CompanyRequest').getList({limit: 1000});
      Promise.all([masterdataPromise, companiesPromise]).then(([masterdata, companies]) => {
        this.masterdata = masterdata;
        this.companies = companies.data;
        this.initSearchParams();
      });
    },
  }
</script>