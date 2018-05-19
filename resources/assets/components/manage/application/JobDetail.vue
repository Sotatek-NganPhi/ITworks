<template>
  <div>
    <validation-form ref="jobDetailForm" style="margin-bottom: 70px">
      <div><span class="glyphicon glyphicon-triangle-bottom"></span> <span>Basic information</span></div>
      <form-group :label="$t('applicant.job.id')">
        <span>{{ record.id }}</span>
      </form-group>
      <div><span class="glyphicon glyphicon-triangle-bottom"></span> <span>TOP</span></div>

      <form-group :label="$t('applicant.job.description')">
        <span>{{ record.description }}</span>
      </form-group>

      <form-group :label="$t('applicant.job.seniors_hometown')">
        <span>{{ record.seniors_hometown }}</span>
      </form-group>

      <div><span class="glyphicon glyphicon-triangle-bottom"></span> <span>Application Guidelines</span></div>

      <form-group :label="$t('applicant.job.company_name')">
        <span>{{ record.company_name }}</span>
      </form-group>

      <form-group :label="$t('applicant.job.salary')">
        <span>{{ record.salary }}</span>
      </form-group>

      <form-group :label="$t('applicant.job.working_hours')">
        <span>{{ record.working_hours }}</span>
      </form-group>

      <form-group :label="$t('applicant.job.application_condition')">
        <span>{{ record.application_condition }}</span>
      </form-group>

      <form-group :label="$t('applicant.job.message')">
        <span>{{ record.message }}</span>
      </form-group>

      <form-group :label="$t('applicant.job.holiday_vacation')">
        <span>{{ record.holiday_vacation }}</span>
      </form-group>

      <form-group :label="$t('applicant.job.interview_place')">
        <span>{{ record.interview_place }}</span>
      </form-group>

      <form-group :label="$t('applicant.job.receptionist')">
        <span>{{ record.receptionist }}</span>
      </form-group>

      <div><span class="glyphicon glyphicon-triangle-bottom"></span> <span>Images</span></div>

      <div class="form-group">
        <label class="col-sm-3 control-label"></label>
        <div class="col-sm-9">
          <div class="view" v-if="record.main_image != ''">
            <img :src="record.main_image" width="200px" class="image"/>
          </div>
          <div class="view" v-if="record.sub_image1 != ''">
            <img :src="record.sub_image1" width="200px" class="image"/>
          </div>
          <div class="view" v-if="record.sub_image2 != ''">
            <img :src="record.sub_image2" width="200px" class="image"/>
          </div>
          <div class="view" v-if="record.sub_image3 != ''">
            <img :src="record.sub_image3" width="200px" class="image"/>
          </div>
        </div>
      </div>

      <div><span class="glyphicon glyphicon-triangle-bottom"></span> <span>About recruitment</span></div>

      <form-group :label="$t('applicant.job.email_receive_applicant')">
        <span>{{ record.email_receive_applicant }}</span>
      </form-group>

      <form-group :label="$t('applicant.job.email_company')">
        <span>{{ record.email_company }}</span>
      </form-group>

      <form-group :label="$t('applicant.job.sales_person_mail')">
        <span>{{ record.sales_person_mail }}</span>
      </form-group>

      <form-group :label="$t('applicant.job.remarks')">
        <span>{{ record.remarks }}</span>
      </form-group>

    </validation-form>
  </div>
</template>

<script>

import rf from '../../../js/lib/RequestFactory';
import {candidateNavigators  as subNavigators} from '../../../js/app/manage/routes';

  export default {

    data() {
      return {
        subNavigators,
        record: {},
      };
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);

      let id = this.$route.query.id;

      const jobPromise = rf.getRequest('JobRequest').getOne(id);
      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();
      const companiesPromise = rf.getRequest('CompanyRequest').getList({ limit:1000 });

      let tasks = [
        jobPromise,
        masterdataPromise,
        companiesPromise
      ];

      Promise.all(tasks).then(([job, masterdata, companies]) => {
        this.oldRecord = job;
        this.companies = companies.data;
        this.masterdata = masterdata;
        this.record = JSON.parse(JSON.stringify(this.oldRecord));
      });
    }
  }
</script>

<style lang="sass">
  @import "../../../sass/_merit.scss"
</style>