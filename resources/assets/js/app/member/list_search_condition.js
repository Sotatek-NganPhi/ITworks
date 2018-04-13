import Vue from 'vue';
import SearchConditionItem from '../../../components/home/SearchConditionItem.vue';
import rf from '../../../js/lib/RequestFactory';

Vue.component('search-condition-item', SearchConditionItem);

var app = new Vue({
  el: '#list_search_condition',
  data(){
    return {
      rows: [],
      isLoading: false,
    }
  },

  methods: {
    getListSearchCondition(){
      rf.getRequest('UserCandidateRequest').getListSearchCondition().then(res => {
        this.rows = res;
        this.isLoading = !this.isLoading;
      });
    },

    openPageSearch(url){
      window.open(url, '_blank');
    },

    removeSearchCondition(id){
      rf.getRequest('UserCandidateRequest').removeCondition(id).then(res => {
        location.reload();
      });
    }
  },

  mounted(){
    this.getListSearchCondition();
  }
});

export default app;