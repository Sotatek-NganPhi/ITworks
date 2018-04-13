<template>
    <div>
      <h2> {{$t("certificate.title_search")}} </h2>
      <validation-form ref="searchForm">
        <form-group :label="getDisplayName('certificates.group_name')">
          <select class="form-control" v-model="searchParams.group_id">
            <option value="">---</option>
            <option :value="certificate_group.id" v-for="certificate_group in masterdata.certificate_groups" :key="certificate_group.name">{{ certificate_group.name }}</option>
          </select>
        </form-group>
        <form-group :label="getDisplayName('name')">
          <input class="form-control" type="text" v-model="searchParams.certificate_name"/>
        </form-group>

        <div class="text-center">
          <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
          <button type="button" class="btn btn-primary" @click="clearForm()">{{ $t("form_action.clear") }}
          </button>
        </div>
      </validation-form>
      <h2> {{$t("certificate.title_list")}} </h2>
      <table class="table">
        <thead>
          <tr>
            <th> {{$t("certificate.group_name")}} </th>
            <th> {{$t("certificate.certificate_name")}} </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="group in groups.certificate_groups">
            <td>{{ group.name }}</td>
            <td>
              <table class="sub-table">
                <tr v-for="row in findCertificateByGroupID(group.id)">
                  <td>{{ row.name }}</td>
                  <td @click="openEditPage(row)" style="width: 13%">
                    <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-pencil"></span> {{$t("common_action.edit")}}</button>
                  </td>
                  <td @click="deleteRow(row)" style="width: 13%">
                    <button type="button" class="btn btn-danger btn-sm">
                    <span class="glyphicon glyphicon-remove"></span> {{$t("common_action.delete")}}</button>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </tbody>
      </table>
      <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                           @ConfirmationDialog:OK="deleteData"
                           :message="$t('message.before_delete')" :params="paramsModal">
      </confirmation-dialog>
      <template v-if="pages > 1">
        <one-part-paginator v-if="pages <= maxPageWidth" :page="page" :pages="pages" @change="onPageChange"/>
        <multi-part-paginator v-else :page="page" :pages="pages" @change="onPageChange"/>
      </template>
    </div>
</template>

<script>
import Vue from 'vue';
import rf from '../../../js/lib/RequestFactory';
import Utils from '../../../js/common/Utils';
import OnePartPaginator from '../../common/DataTable/OnePartPaginator.vue';
import MultiPartPaginator from '../../common/DataTable/OnePartPaginator.vue';
import {user} from '../../../js/app/manage/main';
import {searchKeysNavigators as subNavigators} from '../../../js/app/manage/routes';
import _ from 'lodash';
import QueryBuilder from '../../../js/lib/QueryBuilder';


const searchParams = {
  group_id: '',
  certificate_name: '',
  limit: 5
};
let groups = {
  certificate_groups: [],
  certificates: [],
};

export default {
  data() {
    return {
      searchParams,
      user,
      groups,
      subNavigators,
      maxPageWidth: 10,
      pages: 0,
      page: 1,
      fetching: false,
      masterdata: {},
      isShowModal: false,
      paramsModal: null,
      apiCertificateGroups: 'certificate_groups',
      apiCertificates: 'certificates',
      query: {},
    }
  },
  components: { OnePartPaginator, MultiPartPaginator },
  methods: {
    getData(params) {
      return rf.getRequest('CertificateRequest').getCertificate(params)
    },
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'certificates', fieldName);
    },
    clearForm() {
      this.searchParams.group_id = '';
      this.searchParams.certificate_name = '';
      this.searchParams.limit = 5;
      this.fetch();
    },
    search() {
      if(this.searchParams["group_id"] === '' && this.searchParams["certificate_name"] === ''){
        this.fetch();
      }else {
        let searchCertificate = rf.getRequest('CertificateRequest').getCertificate(this.searchParams)
        Promise.all([searchCertificate]).then(([search]) => {
          this.groups.certificate_groups = search.certificate_groups.data;
          this.groups.certificates = _.groupBy(search.certificates, 'certificate_group_id');
          this.page = search.certificate_groups.current_page;
          this.pages = search.certificate_groups.last_page;
        });
      }
    },
    openEditPage(row) {
      this.$router.push({
        path: '/search_keys/certificate/edit',
        query: {
          id: row ? row.id : null,
        }
      });
    },
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'certificates', fieldName);
    },
    deleteRow(row) {
      this.isShowModal = true;
      this.paramsModal = row;
    },

    deleteData(row) {
      this.isShowModal = false;
      rf.getRequest('CertificateRequest').removeOne(row.id).then(res => {
        location.reload();
      });
    },

    findCertificateByGroupID(groupID) {
      return this.groups.certificates[groupID];
    },
    onPageChange (page) {
      this.page = page;
      this.fetch();
    },

    fetch() {
      const meta = {
        page: this.page
      };

      this.fetching = true;
      this.getData(Object.assign(meta, this.searchParams)).then((res) => {
        this.groups.certificate_groups = res.certificate_groups.data;
        this.groups.certificates = _.groupBy(res.certificates, 'certificate_group_id');
        this.page = res.certificate_groups.current_page;
        this.pages = res.certificate_groups.last_page;
        this.fetching = false;
      })
    },
  },
  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    this.getData();
    this.fetch();
    rf.getRequest('MasterdataRequest').getAll().then(res => {
        this.masterdata = res;
    });
  }
}
</script>
<style type="text/css" scoped>
  tr{
    border-bottom: 1px solid #bfbfbf;
  }
  .sub-table{
    width: 100%;
  }
  .sub-table tr{
    height: 50px;
    line-height: 40px;
  }
  .sub-table tr:last-child{
    border-bottom: none;
  }
</style>