<template>
    <div class="form-inline">
        <input  name="region"
                :required="required"
                type="text"
                class="form-control"
                :placeholder="regionPlaceholder"
                v-model="region"
                size="6"
                maxlength="3">
        <span> - </span>
        <input  ref="area"
                :required="required"
                type="text"
                class="form-control"
                :placeholder="areaPlaceholder"
                v-model="area"
                size="8"
                maxlength="4">
        <input type="hidden" :name="name" class="form-control" :value="formatAddress">
    </div>

</template>

<script>
  export default {
    data() {
      return {
        regionPlaceholder: '---',
        areaPlaceholder: '----',
        region: '',
        area: '',
      }
    },
    watch: {
      value(val) {
        this.formatPostalCode(val);
      },
      region() {
        if (this.region.length == 3) {
         this.autoTab();
        }
      },
    },
    computed: {
      formatAddress() {
        return this.exportCode();
      }
    },
    props: {
      value: {
        value: String,
      },
      name: {
        value: String,
      },
      locale: {
        value: String,
        default: 'en',
      },
      required: {
        type: Boolean,
        default: false,
      },
    },
    methods: {
      formatPostalCode(postal_code) {
        if(~postal_code.indexOf('-') < 0) {
          let code = postal_code.split('-');
          this.region = code[0];
          this.area = code[1];
        } else {
          this.region = postal_code.substring(0, 3);
          this.area = postal_code.substring(3, 7);
        }
      },
      exportCode() {
        let code = this.region;
        code += (this.area.length) ? '-' + this.area : '';
        return code;
      },
      autoTab() {
        this.$refs.area.focus();
      },
    },
    created() {
      if (this.value) {
        this.formatPostalCode(this.value);
      }

    },
    mounted() {
      if (this.value) {
        this.formatPostalCode(this.value);
      }
    }
  }
</script>
