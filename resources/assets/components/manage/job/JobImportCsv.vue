<template>
  <div>
    <div class="alert alert-warning">
      <ul>
        <li>
          <p>一括登録の場合</p>
          <ol>
            <li>「CSVフォーマットダウンロード」から仕事情報マスタデータをダウンロードしてください。</li>
            <li>一括登録する仕事情報を入力編集してください。※1　※2　※3</li>
            <li>編集したCSVファイルを選択し登録を完了してください。</li>
            <li>完了</li>
          </ol>
        </li>
        <li>
          <p>一括更新の場合</p>
          <ol>
            <li>更新したい仕事情報を「更新用CSVダウンロード」からダウンロードしてください。※4</li>
            <li>一括更新する仕事情報を入力編集してください。※2　※3</li>
            <li>編集したCSVファイルを選択し更新を完了してください。※5</li>
            <li>完了</li>
          </ol>
        </li>
      </ul>
    </div>
    <div class="alert alert-info">
      <p>※1 登録には「掲載企業ID」が必要になります。掲載企業ID確認画面へ⇒ <a @click="openCompanyListPage()" href="javascript:void(0)">【掲載企業一覧画面】</a>
      </p>
      <p>※2 仕事情報マスタデータのCSVフォーマット仕様は「仕事情報マスタデータ項目表」をご覧ください。</p>
      <p>※3 仕事情報マスタデータの検索項目のコード対応表は下記「仕事情報検索項目　コード一覧」をご覧ください。</p>
      <p>※4 更新用CSVダウンロード画面へ⇒<a @click="openJobCsvExportPage()" href="javascript:void(0)">【更新用CSVダウンロード画面】</a></p>
      <p>※5 更新用CSVに新規の仕事情報も合わせて入力編集して頂く事で、一括登録・更新を同時に行うことができます。</p>
    </div>
    <div class="alert alert-danger">
      <p>※ 仕事情報の一括登録・更新の上限は10000件までになります。</p>
    </div>

    <form action="./job_csv_veri.jsp" method="post" enctype="multipart/form-data" onsubmit="disableSubmit(this)">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th nowrap="nowrap">仕事情報マスタデータ&nbsp;</th>
            <td>
            <input type="file" @change="onFileSelected" accept=".csv">
            </td>
            <td nowrap="nowrap">
              <a href="/manage/jobs/csv/sample/">CSVフォーマットのダウンロード</a>
            </td>
            <td>
              <a href="#job/job-info" target="_blank">仕事情報マスタデータ項目表</a>
            </td>
          </tr>
          <tr>
            <th nowrap="nowrap">画像の一括アップロードを行ないます。&nbsp;</th>
            <td>
            <input type="file" @change="onImagesSelected" accept=".zip">
            </td>
            <td nowrap="nowrap">
              ファイルを１ZIP ファイルだけに圧縮しておいてください
            </td>
            <td nowrap="nowrap">
            </td>
          </tr>
          <tr align="center">
            <td nowrap="nowrap" colspan="4" class="center">
              <button type="button" class="btn btn-primary" @click="upload()">登録</button>
              <button type="button" class="btn btn-primary" @click="back()">戻る</button>
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th nowrap="nowrap" colspan="4">
              仕事情報検索項目　コード一覧
            </th>
          </tr>


          <tr>
            <td nowrap="nowrap">
              <a href="/manage/csv/category_level2s">職種項目表</a>
            </td>


            <td nowrap="nowrap">
              <a href="/manage/csv/prefectures">都道府県・市区町村項目表 </a>
            </td>


            <td nowrap="nowrap">
              <a href="/manage/csv/wards">市区町村・市区町村項目表 </a>
            </td>


            <td nowrap="nowrap">
              <a href="/manage/csv/merits">メリット項目表 </a>
            </td>
          </tr>


          <tr>
            <td nowrap="nowrap">
              <a href="/manage/csv/employment_modes">雇用形態（検索用）項目表 </a>
            </td>


            <td nowrap="nowrap">
              <a href="/manage/csv/working_shifts">希望の時間帯項目表 </a>
            </td>


            <td nowrap="nowrap">
              <a href="/manage/csv/working_days">希望の勤務日数項目表 </a>
            </td>


            <td nowrap="nowrap">
              <a href="/manage/csv/working_hours">希望の勤務時間項目表 </a>
            </td>
          </tr>


          <tr>
            <td nowrap="nowrap">
              <a href="/manage/csv/working_periods">希望の勤務期間項目表 </a>
            </td>


            <td nowrap="nowrap">
              <a href="/manage/csv/salaries">給与項目表 </a>
            </td>

            <td nowrap="nowrap">
              <a href="/manage/csv/current_situations">現在の状況項目表 </a>
            </td>


            <td nowrap="nowrap">
              <a href="/manage/csv/stations">路線・駅項目表 </a>
            </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</template>

<script>

  import {user} from '../../../js/app/manage/main';
  import rf from '../../../js/lib/RequestFactory';
  import {jobNavigators as subNavigators} from '../../../js/app/manage/routes';
  import Utils from '../../../js/common/Utils';


  export default {
    data() {
      return {
        user,
        subNavigators,
        uploadedFile: null,
      }
    },

  methods: {
    openCompanyListPage() {
      this.$router.push({
        path: '/company/list'
      });
    },
    openJobCsvExportPage() {
      this.$router.push({
        path: '/job/list'
      });
    },
    back() {
      this.$router.push({
        path: '/job/job_import'
      });
    },
    upload() {
      if (!this.uploadedFile) return;

      Utils.turnOnLoading();
      rf.getRequest('JobRequest').importCsv(this.uploadedFile, this.images).then(res => {
        Utils.turnOffLoading();
        Utils.growl(res + " job(s) imported successfully");
      })
      .catch(() => {
        Utils.turnOffLoading();
      });
    },
    onFileSelected(e) {
      let files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
      this.uploadedFile = files[0];
    },
    onImagesSelected(e) {
      let files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
      this.images = files[0];
    }
  },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
    }
  }
</script>
