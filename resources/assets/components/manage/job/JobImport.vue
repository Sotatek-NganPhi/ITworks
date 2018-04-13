<template>
    <div>
        <ol>
          <!--<li>-->
            <!--<p>{{ $t("job_csv.register_company_title") }}</p>-->
            <!--<p>{{ $t("job_csv.register_company_description") }}</p>-->
            <!--<button type="button" class="btn btn-success btn-sm" @click="openCompanyEditPage()">-->
              <!--<span class="glyphicon glyphicon-plus"></span> {{ $t("job_csv.register_company_link") }}-->
            <!--</button>-->
          <!--</li>-->
          <li>
            <p>{{ $t("job_csv.register_csv_title") }}</p>
            <p>{{ $t("job_csv.register_csv_description") }}</p>
            <button type="button" class="btn btn-success btn-sm" @click="openJobCsvImportPage()">
              <span class="glyphicon glyphicon-plus"></span> {{ $t("job_csv.register_csv_link") }}
            </button>
          </li>
        </ol>
    </div>
</template>

<script>

import {user} from '../../../js/app/manage/main';
import {jobNavigators as subNavigators} from '../../../js/app/manage/routes';

export default {
  data() {
    return {
      user,
      subNavigators,
    }
  },

  methods: {
    openCompanyEditPage(row) {
      this.$router.push({
        path: '/company/edit',
        query: {
          id: row ? row.id : null
        }
      });
    },
    openJobCsvImportPage(row) {
      this.$router.push({
        path: '/job/import_csv'
      });
    },
  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
  }
}
</script>
