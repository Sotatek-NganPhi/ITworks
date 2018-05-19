<template>
    <div>
        <h1>{{record.first_name}} {{record.last_name}} CV</h1>
        <br>
        <table class="detail">
            <tbody>
            <tr>
                <th>Email</th>
                <td>
                    {{record.email}}
                </td>
            </tr>
            <tr>
                <th>Họ và tên</th>
                <td>
                    {{ record.first_name }}
                    {{ record.last_name}}
                </td>
            </tr>
            <tr>
                <th>Giới tính</th>
                <td>
                    {{record.gender | sex}}
                </td>
            </tr>
            <tr>
                <th>Ngày sinh</th>
                <td>
                    {{ record.birthday}}
                </td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td>
                    {{ record.address }}
                </td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td>
                    {{ record.phone_number}}
                </td>
            </tr>
            <tr>
                <th>Trình độ học vấn</th>
                <td>
                    {{ getOneField(masterdata.educations, 'id', record.education_id, 'name')}}
                </td>
            </tr>
            <tr>
                <th>Thời gian tốt nghiệp</th>
                <td>
                    {{ record.graduated_at }}
                </td>
            </tr>
            <tr>
                <th>Kinh nghiệm làm việc</th>
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
                <th>Trình độ ngôn ngữ</th>
                <td>
                    {{ getOneField(masterdata.language_conversation_levels, 'id', record.language_conversation_level_id, 'description')}}
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
      sex(value){
        if (value == "male") {
          return "Nam";
        }
        return "Nữ";
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
