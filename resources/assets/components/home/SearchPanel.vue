<template>
  <div class="search-panel">
    <div class="search_criteria">
      <input type="hidden" name="_token" value="">
      <input type="hidden" name="key_region" value="">
      <div class="row_fee">
        <h5>フリーワード</h5>
        <input type="text" name="free_word" v-model="free_word">
      </div>
      <cross-job-item class="cross_job_item" label="職種" name="category"
                      :options="masterdata.category_level3s"
                      :reset="reset" v-model="category">
      </cross-job-item>
      <cross-job-item class="cross_job_item" label="雇用形態" name="employment_mode"
                      :options="masterdata.employment_modes"
                      :reset="reset" v-model="employment_mode">
      </cross-job-item>

      <div class="merit" v-show="enableAdvanced">
        <input type="hidden" v-model="merits" name="merits"/>
        <div v-for="merit in masterdata.merit_groups" class="group-merit">
          <p class="category">◆ {{merit.name}}</p>
          <ul>
            <li v-for="item in where(masterdata.merits, 'merit_group_id', merit.id)">
              <label><input type="checkbox" :value="item.id" v-model="optionMerits">{{ item.name }}</label>
            </li>
          </ul>
        </div>
      </div>
      <div class="btn_search_panel">
        <template>
          <input type="button" value="この条件をクリアする" class="expand" @click="resetForm">
          <input type="button" v-show="!hideBtnExpand" value="さらに条件を指定する" class="reset">
          <input type="submit" value="この条件で検索する" class="search" @click="searchJob">
        </template>
      </div>
    </div>
  </div>
</template>
<script>
  import CrossJobItem from './CrossJobItem.vue';
  import rf from '../../js/lib/RequestFactory';
  export default {
    components: {
      CrossJobItem
    },
    props: ["enableAdvanced", "unspecified", "hideBtnExpand"],
    data: function () {
      return {
        url: window.location.href,
        reset: false,
        optionMerits: [],
        category: "",
        employment_mode: "",
        free_word: "",
        masterdata: {
          category_level3s: [],
          employment_modes: [],
          merit_groups: [],
          merits: [],
        }
      }
    },
    computed: {
      merits: {
        get: function () {
          return encodeURI(this.optionMerits.toString());
        },
      },
    },
    methods: {
      resetForm: function () {
        this.free_word = "";
        this.employment_mode = "";
        this.category = "";
        this.optionMerits = [];
      },

      searchJob(){
        let query = {};
        if(this.free_word){
          query["free_word"] = this.free_word;
        }
        if(this.category){
          query["category"] = this.category;
        }
        if(this.employment_mode){
          query["employment_mode"] = this.employment_mode;
        }
        if(this.merits){
          query["merits"] = this.merits;
        }
        this.$emit('search_panel_search', query)
      },

      getParam: function (url, param) {
        var reg = new RegExp(param + "=([^&]+)");
        var val = reg.exec(url);
        if (val == null)
          return "";
        return reg.exec(url)[1];
      },

      where: function (table, attr, val) {
        return _.filter(table, function (row) {
          return row[attr] == val;
        });
      },
    },

    mounted(){
      this.employment_mode = this.getParam(this.url, 'employment_mode');
      this.free_word = decodeURI(this.getParam(this.url, 'free_word'));
      this.category = this.getParam(this.url, 'category');
      let meritsParam = decodeURIComponent(this.getParam(this.url, 'merits'));
      if (meritsParam) {
        this.optionMerits = meritsParam.split(",");
      }
    }
  }
</script>
<style lang="sass">
  @import "../../sass/search_panel.scss"
</style>