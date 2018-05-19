<template>
  <div>
    <div style="padding:5px;">
      <button @click="toggleJobSearch()" :class="{'is-active': isShowJobSearch}">{{ $t("applicant.title.one") }}</button>
      <button @click="toggleApplicationSearch()" :class="{'is-active': !isShowJobSearch}">{{ $t("applicant.title.two") }}</button>
      <ApplicationJobList v-show="isShowJobSearch" ref="job"></ApplicationJobList>
      <ApplicationApplicantList v-show="!isShowJobSearch" ref="part"></ApplicationApplicantList>
    </div>
    <div>
    </div>
  </div>
</template>

<script>
import {candidateNavigators  as subNavigators} from '../../../js/app/manage/routes';
import ApplicationJobList from '../../../components/manage/application/ApplicationJobList.vue';
import ApplicationApplicantList from '../../../components/manage/application/ApplicationApplicantList.vue';

export default {
  components: {
    ApplicationJobList,
    ApplicationApplicantList,
  },

  data() {
    return {
      isShowJobSearch: true,
      subNavigators
    }
  },

  methods: {
    toggleJobSearch() {
      this.isShowJobSearch = true
    },
    toggleApplicationSearch() {
      this.isShowJobSearch = false
    }
  },

  created() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    this.$on('JOB_APPLICANT', (id) => {
      this.isShowJobSearch = false
      this.$refs.part.$emit('search', id);
    });
  },
 mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
    if(this.$route.query.id != null){
      this.isShowJobSearch = false;
    }

  }
}
</script>
<style type="text/css" scoped>  
  button.is-active {
    color: white;
    background-color: #3097D1;
    border: 1px solid #2a88bd;
    outline: none;
  }
</style>
