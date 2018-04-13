<template>
    <div>
        <validation-form ref="agencyForm" style="margin-bottom: 70px">
            <form-group :label="getDisplayName('id')" :is-required="isFieldRequired('id')">
                <input class="form-control" type="text" v-model="record.id" disabled/>
            </form-group>
            <form-group :label="getDisplayName('name')" :is-required="isFieldRequired('name')">
                <input class="form-control" data-vv-name="name" type="text" v-model="record.name" disabled>
            </form-group>
            <form-group :label="getDisplayName('code')" :is-required="isFieldRequired('code')">
                <input class="form-control" data-vv-name="code"
                       type="text" v-model="record.code" disabled>
            </form-group>
            <form-group :label="getDisplayName('password')" :is-required="isFieldRequired('password')">
                <input class="form-control" type="text" v-model="record.password" disabled/>
            </form-group>
        </validation-form>
        <div class="text-center">
            <button type="button" class="btn btn-primary btn-sm" @click="showModal()">
                <span class="glyphicon glyphicon-ok"></span>  {{$t('common_action.ok')}}
            </button>
            <button type="button" class="btn btn-default btn-sm" @click="cancel()">
                <span class="glyphicon glyphicon-remove"></span>  {{$t('common_action.cancel')}}
            </button>
        </div>

        <data-table v-show="record.code" :getData="getCandidates" ref="datatable" class="table-candidate-list" :title="$t('candidate.list_title')">
            <th><dt-list-items-chekbox/></th>
            <th data-sort-field="id">{{ $t("common_field.id") }}</th>
            <th data-sort-field="users.name">{{ $t("candidate.name") }}</th>
            <th data-sort-field="users.name_phonetic">{{ $t("candidate.name_phonetic") }}</th>
            <th data-sort-field="users.birthday">{{ $t("common_field.birthday") }}</th>
            <th data-sort-field="users.email">{{ $t("common_field.email") }}</th>
            <th data-sort-field="candidates.created_at">{{ $t("candidate.registed_date") }}</th>
            <th data-sort-field="users.mail_receivable">{{ $t("candidate.mail_receivable") }}</th>
            <th></th>
            <th></th>
            <template slot="body" scope="props">
                <tr>
                    <td><dt-item-chekbox :value="props.item"/></td>
                    <td>{{ props.item.id }}</td>
                    <td>{{ props.item.name }}</td>
                    <td>{{ props.item.name_phonetic }}</td>
                    <td>{{ props.item.birthday }}</td>
                    <td>{{ props.item.email }}</td>
                    <td>{{ props.item.created_at }}</td>
                    <td>{{ props.item.mail_receivable | boolean }}</td>
                    <td @click="openEditPage(props.item)">
                        <button type="button" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-pencil"></span> {{$t("common_action.edit")}}
                        </button>
                    </td>
                    <td @click="confirmRemove(props.item)" style="width: 13%">
                        <button type="button" class="btn btn-danger btn-sm">
                            <span class="glyphicon glyphicon-remove"></span> {{$t('common_action.delete')}}</button>
                    </td>
                </tr>
            </template>
        </data-table>

        <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                             @ConfirmationDialog:OK="updateChange" :message="$t('message.before_update')">
        </confirmation-dialog>

        <confirmation-dialog v-if="isShowDeleteModal" @ConfirmationDialog:CANCEL="isShowDeleteModal = false"
                             @ConfirmationDialog:OK="removeCandidate"
                             :message="$t('message.before_delete')" :params="deleteParam">
        </confirmation-dialog>
    </div>
</template>


<script>

  import Utils from '../../../js/common/Utils';
  import rf from '../../../js/lib/RequestFactory';
  import {user} from '../../../js/app/manage/main';
  import {companyNavigators as subNavigators} from '../../../js/app/manage/routes';
  import QueryBuilder from '../../../js/lib/QueryBuilder';
  import _ from 'lodash';

  const defaultAgency = {
    id: '',
    name: '',
    code: '',
  };
  export default {

    data() {
      return {
        subNavigators,
        record: defaultAgency,
        api: 'referral_agencies',
        masterdata: Utils.getMasterdataSkel(),
        isShowModal: false,
        hasCandidates: false,
        isShowDeleteModal: false,
        deleteParam: null
      };
    },
    methods: {
      openEditPage(row) {
        this.$router.push({
          path: '/candidate/edit',
          query: {
            id: row ? row.id : null,
            agency: this.record.id
          }
        });
      },
      getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'referral_agencies', fieldName);
      },
      showModal() {
        this.isShowModal = true;
      },
      isFieldRequired(fieldName) {
        return Utils.isFieldRequired(this.masterdata, 'referral_agencies', fieldName);
      },
      getDatatableName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'candidates', fieldName);
      },
      getCandidates(params) {
        let searchParams = _.merge(new QueryBuilder({'reference.referral_code': this.record.code}), params);
        let candidates = rf.getRequest('CandidateRequest').getList(searchParams)
        return candidates;
      },
      updateChange() {
        this.isShowModal = false;
        if (this.record && this.record.id) {
          rf.getRequest('MasterdataRequest').updateOne(this.api, this.record.id, this.record).then(res => {
            window.Utils.growl('request.request_success');
            this.$refs.agencyForm.$emit('FORM_ERRORS_CLEAR');
          }).catch(({ validationErrors }) => {
            if (validationErrors) {
              this.$refs.agencyForm.$emit('REJECT_FORM', validationErrors);
            }
          });
        }
      },
      cancel() {
        this.$router.push({
          path: '/agency/list',
        });
      },
      confirmRemove(row) {
        this.isShowDeleteModal = true;
        this.deleteParam = row;
      },
      removeCandidate(row) {
        this.isShowDeleteModal = false
        rf.getRequest('CandidateRequest').removeReferralCode(row.id).then(res => {
          this.checkDatatableData();
          this.$refs.datatable.$emit('DataTable:refresh');
        })
      },
      checkDatatableData() {
        this.getCandidates().then(res => {
          this.hasCandidates = !!res.data.length;
        });
      }
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      const id = this.$route.query.id;
      const agencyPromise = rf.getRequest('MasterdataRequest').getOne(this.api, id);
      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
      Promise.all([agencyPromise, masterdataPromise]).then(([agency, masterdata]) => {
        this.record = agency;
        this.masterdata = masterdata;
        this.checkDatatableData();
        this.$refs.datatable.$emit('DataTable:refresh');
      })
    }
  }
</script>

<style>
  .table-responsive {
    overflow-x: visible !important;
  }
</style>