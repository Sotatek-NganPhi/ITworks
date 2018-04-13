<template>
  <div>
  <h2>{{ $t("mail_logs.search_title") }}</h2>

  <validation-form ref="searchForm">
    <form-group :label="getDisplayName('date')">
      <radio-group inline="true" v-model="selectedTime" :options="timeOptions"/>
    </form-group>

    <form-group :label="getDisplayName('type')">
      <radio-group inline="true" v-model="searchParams.type" :options="typeOptions"/>
    </form-group>

    <div class="text-center">
      <button type="button" class="btn btn-primary" @click="search">{{ $t("form_action.search") }}</button>
      <button type="button" class="btn btn-primary" @click="clear()">{{ $t("form_action.clear") }}</button>
      <button type="button" class="btn btn-primary" @click="downloadCsv">{{ $t("form_action.download_csv") }}</button>
    </div>

  </validation-form>

  <h2>{{ $t("mail_logs.list_title") }}</h2>

    <template v-if="getListFieldDisplay()">
      <data-table :getData="getData" ref="datatable">
        <template v-for="field in getListFieldDisplay()">
          <th :data-sort-field="field.field_name">{{field.display_name}}</th>
        </template>
        <th>{{getDisplayName('content')}}</th>
        <th>{{ $t("mail_logs.time_created") }}</th>
        <th></th>
        <th></th>
        <th></th>
        <template slot="body" scope="props">
          <tr>
            <template v-for="field in getListFieldDisplay()">
              <td>{{ props.item[field.field_name] }}</td>
            </template>
            <td>{{ getContent(props.item.content) }}</td>
            <td>{{ props.item.created_at | date }}</td>
            <template v-if="getListFieldDisplay()">
              <td @click="previewRow(props.item)">
                <button type="button" class="btn btn-info btn-sm">
                  <span class="glyphicon glyphicon-eye-open"></span> {{$t("common_action.preview")}}
                </button>
              </td>
              <td @click="deleteRow(props.item)">
                <button type="button" class="btn btn-danger btn-sm">
                  <span class="glyphicon glyphicon-remove"></span> {{$t("common_action.delete")}}
                </button>
              </td>
            </template>
          </tr>
        </template>
      </data-table>
    </template>
    <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                         @ConfirmationDialog:OK="deleteData"
                         :message="messageModal" :params="paramsModal">
    </confirmation-dialog>
  </div>
</template>

<script>
  import rf from '../../../js/lib/RequestFactory';
  import QueryBuilder from '../../../js/lib/QueryBuilder';
  import moment from 'moment';
  import Utils from '../../../js/common/Utils';
  import {candidateNavigators as subNavigators} from '../../../js/app/manage/routes';
  import queryString from 'querystring';
  import Multiselect from 'vue-multiselect';

  const searchParams = {
    created_at:'',
    type:'',
  };

  export default {
    components: {
      Multiselect
    },
    data() {
      return {
        subNavigators,
        searchParams,
        timeOptions: Utils.getMail_time(),
        typeOptions: Utils.getMail_type(),
        localMasterdata: Utils.getMasterdataSkel(),
        isShowModal: false,
        messageModal: "あなたは、このデータをしません削除したいです?",
        paramsModal: null,
        selectedTime: ''
      }
    },
    methods: {
      getData(params) {
        return rf.getRequest('MailLogsRequest').getList(params);
      },
      getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.localMasterdata, 'mail_logs', fieldName);
      },
      getListFieldDisplay() {
        var fields = Utils.getListFieldDisplay(this.localMasterdata, 'mail_logs');
        return _.filter(fields, function(item) { return item.field_name !== 'content';});
      },
      getContent(content) {
        var startIndex = content.indexOf("Content") + 13;
        content = content.substring(startIndex);
        if (content.indexOf("/") == 1) return '';
        content = content.substring(content.indexOf('p>') + 2, content.indexOf('</p'));
        return content;
      },
      deleteRow(row) {
        this.isShowModal = true;
        this.paramsModal = row;
      },
      previewRow(row) {
        this.$router.push({
        path: '/candidate/mail_logs/preview',
         query: {
           id: row ? row.id : null
         }
        });
      },
      calculateDate(option) {
        if (!option) return {};
        var date = new Date();
        var y = date.getFullYear();
        var m = date.getMonth();
        if (option === '2_months_ago') {
          m = m - 2;
        } else if (option === 'last_month') {
          m = m - 1;
        }
        var firstDay = new Date(y, m, 1);
        var lastDay = new Date(y, m + 1, 0);
        return {
          'firstDay': this.formatDate(firstDay),
          'lastDay': this.formatDate(lastDay)
        };
      },
      formatDate(date) {
        return moment(date).format('YYYY/MM/DD');
      },
      deleteData(row){
        this.isShowModal = false;
        rf.getRequest('MailLogsRequest').removeOne(row.id).then(res => {
          this.$refs.datatable.$emit('DataTable:refresh')
        });
      },
      initSearchParams() {
        this.selectedTime = '';
        this.searchParams = Object.assign({}, searchParams);
      },
      buildSearchQuery() {
        var time = this.calculateDate(this.selectedTime);
        const query = new QueryBuilder({});
              query.append('type', this.searchParams.type, '=');
              query.append('created_at', time.firstDay, '>=');
              query.append('created_at', time.lastDay, '<');
        return query;
      },
      search() {
        this.$refs.datatable.$emit('DataTable:filter', this.buildSearchQuery());
      },
      clear() {
        this.initSearchParams();
        this.search();
      },
      downloadCsv() {
        const query = queryString.stringify(this.buildSearchQuery());
        window.location.href = "/manage/mail_log/csv?" + queryString.stringify(query);
      },
    },
    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
      Promise.all([masterdataPromise]).then(([masterdata]) => {
        this.localMasterdata = masterdata;
        this.initSearchParams();
      });
    },
  }
</script>