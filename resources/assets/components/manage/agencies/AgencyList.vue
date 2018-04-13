<template>
    <div>
        <h1>{{$t('sub_menu.company.agency')}}</h1>
        <data-table :getData="getData" ref="datatable">
            <th data-sort-field="name" style="width: 510px;">{{getDisplayName('name')}}</th>
            <th data-sort-field="code">{{getDisplayName('code')}}</th>
            <th style="width: 10%"></th>
            <template slot="body" scope="props">
                <tr>
                    <td style="width: 510px;">{{ props.item.name }}</td>
                    <td>{{ props.item.code }}</td>
                    <td @click="openEditPage(props.item)" style="width: 10%">
                        <button type="button" class="btn btn-info btn-sm">
                            <span class="glyphicon glyphicon-eye-open"></span> {{$t("common_action.preview")}}
                        </button>
                    </td>
                    <!--<td @click="deleteRow(props.item)" style="width: 13%">-->
                        <!--<button type="button" class="btn btn-danger btn-sm">-->
                            <!--<span class="glyphicon glyphicon-remove"></span> {{$t('common_action.delete')}}</button>-->
                    <!--</td>-->
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

  import rf from '../../../js/lib/RequestFactory';
  import {user} from '../../../js/app/manage/main';
  import Utils from '../../../js/common/Utils';
  import {companyNavigators as subNavigators} from '../../../js/app/manage/routes';

  export default {
    data() {
      return {
        user,
        masterdata: Utils.getMasterdataSkel(),
        subNavigators,
        isShowModal: false,
        paramsModal: null,
        api: 'referral_agencies',
      }
    },

    methods: {
      getData(params) {
        return rf.getRequest('MasterdataRequest').getList(this.api, params);
      },
      openEditPage(row) {
        this.$router.push({
          path: '/agency/edit',
          query: {
            id: row ? row.id : null
          }
        })
      },
      deleteRow(row) {
        this.isShowModal = true;
        this.paramsModal = row;
      },

      deleteData(row) {
        this.isShowModal = false;
        rf.getRequest('MasterdataRequest').removeOne(this.api, row.id).then(res => {
          this.$refs.datatable.$emit('DataTable:refresh')
        });
      },
      getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'referral_agencies', fieldName);
      },
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      rf.getRequest('MasterdataRequest').getAll().then(res => {
        this.masterdata = res;
      });
    },

  }
</script>

<style scoped>
    td{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>