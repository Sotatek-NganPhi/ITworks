<template>
    <div>
        <h1>{{record.first_name}} {{record.last_name}}の履歴書</h1>
        <br>
        <table class="detail">
            <tbody>
            <tr>
                <th>ログインID</th>
                <td>
                    {{record.email}}
                </td>
            </tr>
            <tr>
                <th>氏名</th>
                <td>
                    {{ record.first_name }}
                    {{ record.last_name}}
                </td>
            </tr>
            <tr>
                <th>フリガナ</th>
                <td>
                    {{ record.first_name_phonetic}}
                    {{ record.last_name_phonetic}}
                </td>
            </tr>
            <tr>
                <th>性別</th>
                <td>
                    {{record.gender | sex}}
                </td>
            </tr>
            <tr>
                <th>生年月日</th>
                <td>
                    {{ record.birthday}}
                </td>
            </tr>
            <tr>
                <th>郵便番号</th>
                <td>
                    {{ record.postal_code }}
                </td>
            </tr>
            <tr>
                <th>住所</th>
                <td>
                    {{ record.address }}
                </td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>
                    {{ record.phone_number}}
                </td>
            </tr>
            <tr>
                <th>就業状況</th>
                <td>
                    {{ getOneField(masterdata.current_situations, 'id', record.current_situation_id, 'name')}}
                </td>
            </tr>
            <tr>
                <th>最終学歴</th>
                <td>
                    {{ getOneField(masterdata.educations, 'id', record.education_id, 'name')}}
                </td>
            </tr>
            <tr>
                <th>最終学歴（学校名）</th>
                <td>
                    {{ record.final_academic_school }}
                </td>
            </tr>
            <tr>
                <th>最終学歴（卒業年月）</th>
                <td>
                    {{ record.graduated_at }}
                </td>
            </tr>
            <tr>
                <th>配偶者</th>
                <td>
                    {{ record.is_married | married}}
                </td>
            </tr>
            <tr>
                <th>経験社数</th>
                <td>
                    {{ record.worked_companies_number}}
                </td>
            </tr>
            <tr>
                <th>社名</th>
                <td>
                    {{ record.lastest_company_name }}
                </td>
            </tr>
            <tr>
                <th>雇用形態</th>
                <td>
                    {{ getOneField(masterdata.employment_modes, 'id', record.lastest_employment_mode_id, 'description')}}
                </td>
            </tr>
            <tr>
                <th>現在または直前の勤務先の業種</th>
                <td>
                    {{ getOneField(masterdata.industries, 'id', record.lastest_industry_id, 'name')}}
                </td>
            </tr>
            <tr>
                <th>年収</th>
                <td>
                    {{ record.lastest_annual_income }}
                </td>
            </tr>
            <tr>
                <th>役職</th>
                <td>
                    {{ getOneField(masterdata.positions, 'id', record.lastest_position_id, 'name')}}
                </td>
            </tr>
            <tr>
                <th>実務経験</th>
                <td>
                    {{ getOneField(masterdata.language_experiences, 'id', record.language_experience_id, 'description')}}
                </td>
            </tr>
            <tr>
                <th>TOEIC</th>
                <td>
                    {{ record.toeic }}
                </td>
            </tr>
            <tr>
                <th>TOEFL</th>
                <td>
                    {{ record.toefl }}
                </td>
            </tr>
            <tr>
                <th>会話レベル</th>
                <td>
                    {{ getOneField(masterdata.language_conversation_levels, 'id', record.language_conversation_level_id, 'description')}}
                </td>
            </tr>
            <tr>
                <th>自動車免許</th>
                <td>
                    {{ getOneField(masterdata.driver_licenses, 'id', record.driver_license_id, 'name')}}
                </td>
            </tr>
            <tr>
                <th>保有資格</th>
                <td>
                    <template v-for="certificate in record.certificates">
                        <p>{{ getOneField(masterdata.certificates, 'id', certificate, 'name')}}</p>
                    </template>
                </td>
            </tr>
            <tr>
                <th>職務内容</th>
                <td>
                    {{ record.lastest_job_description }}
                </td>
            </tr>
            <tr>
                <th>PR</th>
                <td>
                    {{ record.resume_pr }}
                </td>
            </tr>
            </tbody>
        </table>
        <br>
    </div>
</template>

<script>

  import rf from '../../../js/lib/RequestFactory'
  import { candidateNavigators  as subNavigators } from '../../../js/app/manage/routes'
  import queryString from 'querystring'
  import QueryBuilder from '../../../js/lib/QueryBuilder'
  import _ from 'lodash'
  import Utils from '../../../js/common/Utils';

  export default {
    data () {
      return {
        masterdata: Utils.getMasterdataSkel(),
        subNavigators,
        record: {},
      }
    },
    filters: {
      married(value){
         if(value == 1){
             return "はい";
         }
         return "いいえ";
      },
      sex(value){
        if (value == "male") {
          return "男性";
        }
        return "女性";
      }
    },

    methods: {
      getOneField (table, fieldCondition, value, field) {
        const row = _.find(table, [fieldCondition, value])
        if (row) {
          return row[field]
        }
        return null;
      }
    },

    mounted () {
      this.$emit('EVENT_PAGE_CHANGE', this)
      let id = this.$route.query.id
      const applicationPromise = rf.getRequest('ApplicantRequest').getOne(id)
      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll()
      Promise.all([applicationPromise, masterdataPromise]).then(([application, masterdata]) => {
        this.masterdata = masterdata
        this.record = application
      })
    }
  }
</script>
<style scoped>
    table.detail tr th {
        padding-top: 18px; /*2.3653%*/
        padding-bottom: 18px;
        padding-right: 57px; /*3.5625%*/
        padding-left: 20px;
    }

    table.detail tr td span.preview {
        white-space: pre-line;
    }

    table.detail tr td {
        padding-top: 18px; /*2.3653%*/
        padding-bottom: 18px;
        padding-right: 57px; /*3.5625%*/
        padding-left: 20px;
    }
</style>
