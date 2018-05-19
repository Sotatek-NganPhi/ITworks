<template>
  <div>
    <h5>{{label}}</h5>
    <select v-model="select" :name="name" @change="selectCrossJob" :disabled="disable">
      <option value="" selected v-if="!disable">--- 選択 ---</option>
      <option value="" v-if="disable">{{text_disable}}</option>
      <option v-for="(option, index) in options" :value="option.id">
        {{ option.name || option.description }}
      </option>
    </select>
  </div>
</template>
<script>
  export default {
    props: ['label', 'options', 'name', 'depend', 'reset', "text_disable", "value", "disable", "depend"],
    data: function () {
      return {
        select: this.getParam(window.location.href, this.name),
        dependAttr: "",
      }
    },
    watch: {
      reset: function (val) {
        this.select = '';
      },
      value: function (val) {
        this.select = val
      },
      depend: function (val) {
        if(this.dependAttr == ""){
          this.dependAttr = val;
        }else {
          if(this.dependAttr != val){
            this.select = "";
            this.dependAttr = val;
          }
        }
      }
    },
    methods: {
      selectCrossJob: function () {
        this.$emit('input', this.select)
      },
      getParam: function (url, param) {
        var reg = new RegExp(param + "=([^&]+)");
        var val = reg.exec(url);
        if(val == null)
          return "";
        return reg.exec(url)[1];
      },
    },
  }
</script>