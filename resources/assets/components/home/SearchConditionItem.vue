<template>
  <div>
    <table border="0" align="center" cellpadding="0" cellspacing="0">

      <tbody>
      <tr>
        <th>希望の市区町村</th>
        <td>
          <template v-for="(item, index) in municipality">
            <template>
              <template v-if="index > 0" style="padding-left: 8px">L</template>
              {{ isObject(item) ? item.title + ":" + item.value : item }}<br>
            </template>
          </template>
        </td>
      </tr>


      <tr>
        <th>希望の路線</th>
        <td>
          <template v-for="(item, index) in routeStation">
            <template>
              <template v-if="index > 0">駅</template>
              {{ isObject(item) ? item.title + ":" + item.value : item }}<br>
            </template>
          </template>
        </td>
      </tr>


      <tr>
        <th>希望の職種</th>
        <td>
          <template v-for="(item, index) in category">
            <template>
              <template v-if="index > 0" style="padding-left: 8px">L</template>
              {{ isObject(item) ? item.title + ":" + item.value : item }}<br>
            </template>
          </template>
        </td>
      </tr>

      <tr>
        <th>条件</th>
        <td>
          <template v-for="(item, index) in conditions">
            <template>
              {{ isObject(item) ? item.title + ":" + item.value : item }}<br>
            </template>
          </template>
        </td>
      </tr>
      <tr>
        <th>希望のメリット</th>
        <td>
          <template v-for="(item, index) in meritConditions">
            <template>
              {{ isObject(item) ? item.title + ":" + item.value : item }}<br>
            </template>
          </template>
        </td>
      </tr>
      <tr>
        <th>希望のフリーワード</th>
        <td colspan="3">
          <template>{{ free_word || empty }}</template>
        </td>
      </tr>
      </tbody>
    </table>
      <input hidden name="free_word" v-model="free_word">
      <input hidden name="category_id" v-model="category_id">
      <input hidden name="prefecture_id" v-model="prefecture_id">
      <input hidden name="ward_id" v-model="ward_id">
      <input hidden name="line_id" v-model="line_id">
      <input hidden name="station_id" v-model="station_id">
      <input hidden name="employment_mode_id" v-model="employment_mode_id">
      <input hidden name="merits" v-model="merits">
  </div>
</template>

<script>
  import Masterdata from '../../components/home/Masterdata.vue';

  export default {
    extends: Masterdata,
    props: [
      "free_word",
      "category_id",
      "prefecture_id",
      "ward_id",
      "line_id",
      "station_id",
      "employment_mode_id",
      "merits"
    ],
    data(){
      return {
        category: null,
        municipality: null,
        routeStation: null,
        conditions: null,
        meritConditions: null,
        empty: "なし",
      }
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
        this._merits = (this.merits || "").split(',');
        if (this._merits.length === 0 || this._merits[0] === "") {
          return [this.empty];
        }
        var meritCondition = "";
        for (let i = 0; i < this._merits.length; i++) {
          if (meritCondition) {
            meritCondition += '・';
          }
          meritCondition += this.find(this.masterdata.merits, 'id', this._merits[i]).name;
        }
        return [meritCondition];
      },

      getConditions: function () {
        var val = [];
        if (!this.isEmpty(this.employment_mode_id)) {
          var employment_mode = this.find(this.masterdata.employment_modes, 'id', this.employment_mode_id);
          val.push({title: "雇用形態（検索用）", value: employment_mode.description});
        }
        if (val.length === 0) {
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
        if (val.length === 0) {
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
        if (val.length === 0) {
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
        if (!val) {
          return [this.empty]
        }
        return [val];
      },

      isObject(item){
        return _.isObject(item);
      }
    },
  }
</script>