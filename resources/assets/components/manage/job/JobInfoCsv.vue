<template>
  <div class="col-md-12">
    <div>
      <h3>CSVの基本仕様</h3>
      <ul>
        <li>項目(列)区切り文字は「,(カンマ)」とする。</li>
        <li>項目(列)内の区切り文字は「|(パイプ)」とする。</li>
        <li>CSVファイルは最初の2行目は行見出し(項目名)として読み飛ばすものとする。</li>
        <li>
          「改行」や「,(カンマ)」が入っている場合は、必ず項目(列)内の両端に「"(ダブルクォート)」を囲むものとする。
        </li>
      </ul>
    </div>
    <div>
      <h3>仕事情報マスタデータ項目表</h3>
      <ul>
        <li>
          各項目の入力条件（必須・任意）は仕事情報を1件ずつ登録する場合とは異なります。
        </li>
        <li>検索用の項目を複数登録する場合は、「|（パイプ）」で区切ってください。</li>
        <li>
          検索用の項目で重複して入力があった場合、一つに統合されます。例）2000|2000|2001（入力した内容）　→　2000|2001（変換後）
        </li>
      </ul>
    </div>
    <div>
      <table>
        <tbody>
        <tr>
          <th width="33%">CSVフォーマット項目名</th>
          <th width="52%">説明</th>
          <th width="15%">入力例</th>
        </tr>
        <tr v-for="rule in rules" :key="rule">
          <td>{{rule.fields_jp}}
            <img v-if="!isMandatory(rule)" src="/images/nomust_icon.gif" alt="Nomust" style="float:right;"/>
            <img v-if="isMandatory(rule)" src="/images/must_icon.gif" alt="Must" style="float:right;"/>
          </td>
          <td>
            &nbsp;{{rule.description}}
            <a href="javascript:void(0)" v-if="isReference(rule)" @click="downloadReferenceTable(rule)">Download</a>
          </td>
          <td>{{rule.example}}&nbsp;
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  import rf from '../../../js/lib/RequestFactory';
  export default {
    data () {
      return {
        rules: {},
        referenceTable: [
          {'name': 'categoryLevel3s', url: '/manage/csv/category_level2s'},
          {'name': 'prefectures', url: '/manage/csv/prefectures'},
          {'name': 'wards', url: '/manage/csv/wards'},
          {'name': 'merits', url: '/manage/csv/merits'},
          {'name': 'employmentModes', url: '/manage/csv/employment_modes'},
          {'name': 'workingDays', url: '/manage/csv/working_days'},
          {'name': 'workingHours', url: '/manage/csv/working_hours'},
          {'name': 'workingShifts', url: '/manage/csv/working_shifts'},
          {'name': 'workingPeriods', url: '/manage/csv/working_periods'},
          {'name': 'salaries', url: '/manage/csv/salaries'},
          {'name': 'currentSituations', url: '/manage/csv/current_situations'},
          {'name': 'routes', url: '/manage/csv/stations'},
        ]
      }
    },
    
    methods: {
      loadRules(){
        rf.getRequest('JobRequest').loadRules().then(res => {
          this.rules = res;
        });
      },

      isMandatory(rule){
        return rule.mandatory === 1;
      },

      isReference(rule){
        return rule.reference_table !== null;
      },

      downloadReferenceTable(rule){
        const referenceTable = _.find(this.referenceTable, [ 'name', rule.fields ]);
        if(referenceTable){
          window.location.href = referenceTable.url;
        }
      }
    },

    mounted () {
      this.loadRules();
    }
  }
</script>

<style scoped>
  table{
    border: 1px solid #999999;
  }
  th{
    border: 1px solid #999999;
    height: 40px;
    padding: 4px;
  }
  td{
    border: 1px solid #999999;
    height: 40px;
    padding: 4px;
  }
</style>