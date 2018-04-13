<template>
    <div>
      <h2>{{$t(this.list_name) }}{{ $t("field_settings.search_title") }}</h2>
      <div class="area-search">
        <form-group :label="$t('field_settings.item_name')">
          <input class="form-control" type="text" v-model="itemName"/>
        </form-group>
      </div>
      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="search()">{{ $t("form_action.search") }}</button>
        <button type="button" class="btn btn-primary" @click="clear()">{{ $t("form_action.clear") }}</button>
      </div>
      <h2>{{$t(this.list_name) }}{{ $t("field_settings.list_title") }}</h2>
      <data-table :getData="getData" ref="datatable">
        <th data-sort-field="display_name" style="width: 30%">{{ getDisplayName('display_name') }}</th>
        <th data-sort-field="field_name" style="width: 27%">{{ getDisplayName('field_name') }}</th>
        <th data-sort-field="is_required" style="width: 12%">{{ getDisplayName('is_required') }}</th>
        <th data-sort-field="is_list_display" style="width: 12%">{{ getDisplayName('is_list_display') }}</th>
        <th data-sort-field="is_active" style="width: 10%">{{ getDisplayName('is_active') }}</th>
        <th style="width: 19%"></th>
        <template slot="body" scope="props">
          <tr>
            <td style="width: 30%">{{ props.item.display_name }}</td>
            <td style="width: 27%">{{ props.item.field_name }}</td>
            <td style="width: 12%">{{ props.item.is_required}}</td>
            <td style="width: 12%">{{ props.item.is_list_display}}</td>
            <td style="width: 10%">{{ props.item.is_active }}</td>
            <td @click="openEditPage(props.item)" style="width: 19%">
              <button type="button" class="btn btn-default btn-sm">
              <span class="glyphicon glyphicon-pencil"></span>{{ $t("common_action.edit") }}</button>
            </td>
          </tr>
        </template>
      </data-table>
    </div>
</template>

<script>

import rf from '../../../js/lib/RequestFactory';
import {user} from '../../../js/app/manage/main';
import {fieldSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';

export default {
  data() {
    return {
      user,
      masterdata: null,
      subNavigators,
      itemName: '',
    }
  },
  watch: {
    '$route' (to, from) {
      this.getData({})
          .then(res => {
            this.$refs.datatable.rows = res;
          })
          .catch(err => {
            window.Utils.growlError(err);
          });
    }
  },
  computed: {
    table() {
      return this.$route.query.table;
    },
    list_name() {
      return ('field_settings.list_name.'+this.table);
    }
  },
  methods: {
    getData(params) {
      return new Promise((resolve, reject) => {
        let intervalId = setInterval(() => {
          if (this.masterdata) {
            clearInterval(intervalId);
            let result = _.filter(this.masterdata.field_settings, e => e.table_name === this.table);
            if(params.orderBy || params.sortedBy){
              let listFields =  _.sortBy(result, function(e) {
                  return e[params.orderBy];
              })
              listFields = (params.sortedBy === 'desc') ? listFields : listFields.reverse();
              return resolve(listFields);
            }
            if(params.item_name){
              result = _.filter(result, (e) => {
                return e.display_name.toLowerCase().match(new RegExp(params.item_name.toLowerCase()));
              });
            }
            return resolve(result);
          }
        }, 0);
      });
    },
    openEditPage(row) {
      this.$router.push({
        path: '/field_settings/edit',
        query: {
          id: row ? row.id : null
        }
      });
    },
    getListFieldDisplay() {
      return Utils.getListFieldDisplay(this.masterdata, 'field_settings');
    },
    getDisplayName(fieldName) {
      return Utils.getFieldDisplayName(this.masterdata, 'field_settings', fieldName);
    },
    search(){
      this.$refs.datatable.$emit('DataTable:filter', {item_name: this.itemName});
    },
    clear(){
      this.itemName = '';
      this.search();
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    return rf.getRequest('MasterdataRequest')
            .getAll()
            .then(res => {
              this.masterdata = res;
            });
  },

}
</script>
<style scope>
  td {
    overflow: hidden;
    white-space: normal;
    text-overflow: ellipsis;
  }
  .area-search{
    margin-bottom: 70px;
  }
</style>