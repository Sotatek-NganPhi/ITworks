import Vue from 'vue';
import Masterdata from '../../../components/home/Masterdata.vue';

var app = new Vue({
  el: '#register_condition',
  extends: Masterdata,
  data: {
    category: null,
    municipality: null,
    routeStation: null,
    conditions: null,
    meritConditions: null,
    freeWork: null,
    employment_mode_id: null,
    category_id: null,
    prefecture_id: null,
    ward_id: null,
    route_id: null,
    station_id: null,
    empty: "なし"
  },
  watch: {
    isLoading: function (val) {
      this.category = this.getCategory();
      this.conditions = this.getConditions();
      this.meritConditions = this.getMeritCondition();
      this.municipality = this.getMunicipality();
      this.routeStation = this.getRouteStation();
    },
  },
  methods: {
    getMeritCondition: function () {
      if(this.merits.length === 0 || this.merits[0] === "")
      {
        return [this.empty];
      }
      var meritCondition = "";
      for(let i = 0; i < this.merits.length; i++){
        if(meritCondition){
          meritCondition += '・';
        }
        meritCondition += this.find(this.masterdata.merits, 'id', this.merits[i]).name;
      }
      return [meritCondition];
    },

    getConditions: function () {
      var val = [];
      if (!this.isEmpty(this.employment_mode_id)) {
        var employment_mode = this.find(this.masterdata.employment_modes, 'id', this.employment_mode_id);
        val.push({title: "雇用形態（検索用）", value: employment_mode.description});
      }
      if(val.length === 0){
        return [this.empty]
      }
      return val;
    },
    getCategory: function () {
      var val = [];
      if (!this.isEmpty(this.category_id)) {
        var category_parent = this.find(this.masterdata.category_level2s, 'id', this.category_id);
        if (!category_parent) {
          this.unspecified = true;
          return [];
        }
        val.push(category_parent.name);
      }
      if(val.length === 0){
        return [this.empty]
      }
      return val;
    },
    getMunicipality: function () {
      var val = [];
      if (!this.isEmpty(this.prefecture_id)) {
        var prefecture = this.find(this.masterdata.prefectures, 'id', this.prefecture_id);
        val.push(prefecture.name);
      }
      if (!this.isEmpty(this.ward_id)) {
        var ward = this.find(this.where(this.masterdata.wards, "prefecture_id", this.prefecture_id), 'id', this.ward_id);
        if (ward) {
          val.push(ward.name);
        } else {
          this.unspecified = true;
        }
      }
      if(val.length === 0){
        return [this.empty]
      }
      return val;
    },

    getRouteStation: function () {
      var val = "";

      if (!this.isEmpty(this.route_id)) {
        var route = this.find(this.masterdata.railway_lines, 'id', this.route_id);
        if (!route) {
          this.unspecified = true;
          return [val];
        }
        val += route.name;
      }
      if (!this.isEmpty(this.station_id)) {
        if (!this.isEmpty(this.prefecture_id)) {
          var station = this.find(this.masterdata.stations, 'prefecture_id', this.prefecture_id);
          if (station) {
            if (val.length > 0) {
              val += "    ";
            }
            val += station.name;
          }
        }
      }
      if(!val){
        return [this.empty]
      }
      return [val];
    },
  },

  mounted() {
    this.freeWork = $('input[name="free_word"]').val() || this.empty;
    this.employment_mode_id = $('input[name="employment_mode_id"]').val();
    this.category_id = $('input[name="category_id"]').val();
    this.prefecture_id = $('input[name="prefecture_id"]').val();
    this.ward_id = $('input[name="ward_id"]').val();
    this.route_id = $('input[name="line_id"]').val();
    this.station_id = $('input[name="station_id"]').val();
    this.merits = ($('input[name="merits"]').val() || "" ).split(",")
  }
});

export default app;