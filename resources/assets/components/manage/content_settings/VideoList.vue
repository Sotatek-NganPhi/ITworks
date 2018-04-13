<template>
  <div>
    <div class="text-center">
      <button type="button" class="btn btn-success btn-sm" @click="openEditPage()">
        <span class="glyphicon glyphicon-plus"></span> {{ $t("common_action.new") }}
      </button>
    </div>

    <h2>{{ $t("video.search_title") }}</h2>
    <validation-form ref="searchForm">

      <form-group :label="getDisplayName('id')">
        <input class="form-control" v-validator="'numeric|min:0'" type="text" v-model="searchParams.id"/>
      </form-group>

      <form-group :label="getDisplayName('name')">
        <input class="form-control" type="text" v-model="searchParams.name"/>
      </form-group>

       <form-group :label="$t('video.region')">
        <select class="form-control" v-model="regions">
          <option value="">---</option>
          <option v-for="item in masterdata.regions" :key="item.id" :value="item.id">
            {{ item.name }}
          </option>
        </select>
      </form-group>

      <form-group :label="getDisplayName('is_active')">
        <radio-group inline="true" v-model="searchParams.is_active" :options="specialStatusOptions"/>
      </form-group>

    </validation-form>
    <div class="text-center">
      <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
      <button type="button" class="btn btn-primary" @click="clearSearchForm()">{{ $t("form_action.clear") }}</button>
    </div>


    <h2 class="section-space">{{ $t("video.list_title") }}</h2>

    <data-table :getData="getData" ref="datatable">
      <th style="width:8%" data-sort-field="id">{{getDisplayName('id')}}</th>
      <th style="width:68%" data-sort-field="name">{{getDisplayName('name')}}</th>
      <th style="width:8%" data-sort-field="is_active">{{getDisplayName('is_active')}}</th>
      <th style="width:8%"></th>
      <th style="width:8%"></th>
      <template slot="body" scope="props">
        <tr>
          <td style="width:8%">{{ props.item.id }}</td>
          <td style="width:68%">{{ props.item.name }}</td>
          <td style="width:8%">{{ props.item.is_active | boolean }}</td>
          <td style="width:8%" @click="openEditPage(props.item)">
            <button type="button" class="btn btn-default btn-sm">
              <span class="glyphicon glyphicon-pencil"></span> {{ $t("common_action.edit") }}
            </button>
          </td>
          <td style="width:8%" @click="deleteRow(props.item)">
            <button type="button" class="btn btn-danger btn-sm">
              <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.delete") }}
            </button>
          </td>
        </tr>
      </template>
    </data-table>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
               @ConfirmationDialog:OK="deleteData"
               :message="$t('message.before_delete')" :params="paramsModal">
    </confirmation-dialog>
  </div>
</template>

<script>

  import _ from 'lodash';
  import QueryBuilder from '../../../js/lib/QueryBuilder';
  import rf from '../../../js/lib/RequestFactory';
  import queryString from 'querystring';
  import {user} from '../../../js/app/manage/main';
  import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';

  const searchParams = {
    id: '',
    name: '',
    is_active: '',
  };

  export default {
    data() {
      return {
        user,
        subNavigators,
        rows: [],
        searchParams,
        masterdata: {},
        specialStatusOptions: Utils.getBooleans(),
        isShowModal: false,
        paramsModal: null,
        regions: ''
      }
    },

    methods: {
      getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'videos', fieldName);
      },
      isFieldRequired(fieldName) {
        return Utils.isFieldRequired(this.masterdata, 'videos', fieldName);
      },
      getData(params) {
        return rf.getRequest('VideoRequest').getList(params);
      },
      buildSearchQuery() {
        var query = new QueryBuilder(this.searchParams)
        if (this.regions) {
          query.append('regions.region_id', this.regions, '=');
        }
        return query;
      },
      search() {
        this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
        this.$refs.searchForm.validate().then(() => {
          this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
        }).catch(() => {});
      },
      clearSearchForm() {
        this.regions = '';
        this.searchParams = Object.assign({}, searchParams);
        this.$refs.searchForm.$emit('FORM_ERRORS_CLEAR');
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
      },
      openEditPage(row) {
        this.$router.push({
          path: '/video/edit',
          query: {
            id: row ? row.id : null
          }
        });
      },
      deleteRow(row) {
        this.isShowModal = true;
        this.paramsModal = row;

      },
      deleteData(row) {
        this.isShowModal = false;
        rf.getRequest('VideoRequest').removeOne(row.id).then(res => {
          this.$refs.datatable.$emit('DataTable:refresh')
        });
      }
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      rf.getRequest('MasterdataRequest').getAll().then(res => {
        this.masterdata = res;
      });
      this.clearSearchForm();
    }
  }
</script>
