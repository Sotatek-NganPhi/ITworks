<template>
  <div>
    <analysis-search criteria="category_level3" criteria-display="job type"></analysis-search>
  </div>
</template>

<script>
  import {user} from '../../../js/app/manage/main';
  import {analysisNavigators as subNavigators} from '../../../js/app/manage/routes';
  import AnalysisSearch from '../../common/AnalysisSearch.vue';

  export default {
    components: {
      AnalysisSearch
    },
    data(){
      return {
        user,
        subNavigators,
      }
    },

    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
    }
  }
</script>