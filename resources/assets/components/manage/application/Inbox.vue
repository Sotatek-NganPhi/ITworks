<template>
  <div>
    <h3>{{$t('inbox.search_title')}}</h3>
    <div class="area-search">
      <form-group :label="'フリーワード'">
        <input class="form-control" type="text" v-model="freeWord"/>
      </form-group>
    </div>
    <div class="text-center">
      <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
      <button type="button" class="btn btn-primary" @click="clear()">{{ $t("form_action.clear") }}</button>
    </div>

    <h3>{{$t('inbox.list_title')}}</h3>

    <template>
      <data-table :getData="getData" ref="datatable">
          <th width="15%"></th>
          <th width="50%"></th>
          <th width="15%"></th>
          <th width="10%"></th>
        <template slot="body" scope="props">
          <tr>
            <td>{{ props.item.from === 'user' ? props.item.user_name : props.item.company_name}}</td>
            <td>
              <span style="width: 100%">
                <span>{{ props.item.title }}</span>
                <span v-if="props.item.content">-</span>
                <span>{{ getInnerText(props.item.content) }}</span>

              </span>
            </td>
            <td class="ellipsis">
              {{ formatDate(props.item.created_at) }}
            </td>
            <td @click="showConversations(props.item)">
              <button type="button" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-pencil"></span> {{$t('inbox.show_action')}}<
              </button>
            </td>
          </tr>
        </template>
      </data-table>
    </template>
  </div>
</template>

<script>
import {candidateNavigators  as subNavigators} from '../../../js/app/manage/routes';
import rf from '../../../js/lib/RequestFactory';
import queryString from 'querystring';
import Utils from '../../../js/common/Utils';
import QueryBuilder from '../../../js/lib/QueryBuilder';
import moment from 'moment'

export default {
  data() {
    return {
      subNavigators,
      freeWord: ''
    }
  },

  methods: {
    getData(params) {
      return rf.getRequest('MessageRequest').getConversations(params);
    },

    formatDate(date) {
      return moment(date).calendar(null, {
        sameDay: '[今日] HH:mm:ss',
        lastDay: '[昨日] HH:mm:ss',
        lastWeek: '[前] dddd',
        sameElse: 'YYYY-MM-DD'
      });
    },

    showConversations(row) {
      this.$router.push({
        path: '/application/inbox/conversations',
        query: {
          applicant_id: row ? row.applicant_id : null
        }
      });
    },

    clear() {
      this.freeWord = "";
    },

    search() {
      this.$refs.datatable.$emit('DataTable:filter',  new QueryBuilder({free_word: this.freeWord}));
    },

    getInnerText(content) {
      let div = document.createElement("div");
      div.innerHTML = content;
      return div.innerText;
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
  },

}
</script>

<style scoped>
  .ellipsis{
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    cursor: pointer;
    max-width: 10px;
  }
  .area-search{
    margin-bottom: 70px;
  }
</style>
