<template>
    <div class="form-inline">
      <validation-form ref="searchForm">
        <form-group class="phone-form" id="first" label=" ">
          <input

          name="電話番号"
          class="form-inline" 
          type="text"
          maxlength="3"
          placeholder="---"
          ref='first'
          v-model="first_3">
          </input>
        </form-group >
        <form-group label="-" class="phone-form">
          <input

          name="電話番号"
          type="text" maxlength="4"
          class="form-inline"
          placeholder="----"
          ref='second'
          v-model="first_4">
          </input>
        </form-group>
        <form-group label="-" class="phone-form" >
          <input
   
          name="電話番号"
          type="text" class="form-inline"
          placeholder="----"
          ref='third'
          maxlength="4"
          v-model="second_4">
          </input>
        </form-group>
      </validation-form>
      <input type="hidden" :name="name" :value="formattedValue"></input>
    </div>
</template>

<script>
    export default {
    data() {
            return {
                first_3 : '',
                first_4 : '',
                second_4 : '',
            };
        },
        watch : {
            value(val) {
                this.init();
            },
            first_3(val) {
                if(val.length==3)
                   this.$refs.second.focus();
            },
            first_4(val) {
                if(val.length==4)
                    this.$refs.third.focus();
            },
            formattedValue(val) {
                this.$emit('input', val);
            }
        },
    props: {
      value: {
        value: String,
      },
      name: {
        value: String,
      },
      id: {
        value: String,
      },
      locale: {
        value: String,
        default: 'en',
      },
      placeholder: {
        type: String,
      },
      inputClass: {
        type: String,
      },
      wrapperClass: {
        type: String,
      },
      disabledPicker: {
        type: Boolean,
        default: false,
      },
      required: {
        type: Boolean,
        default: false,
      },
    },
        computed : {
            formattedValue() {
                let v = this.first_3+"-"+this.first_4+"-"+this.second_4;
                return v;
            }
        },
        methods : {
            init() {
               if(this.value){
                var arr=this.value.split("-");
                this.first_3=arr[0];
                this.first_4=arr[1];
                this.second_4=arr[2];
             }
             else {
                this.first_3='';
                this.first_4='';
                this.second_4='';              
             }
            },
            clear() {
                this.first_3='';
                this.first_4='';
                this.second_4='';  
            },
        created() {;
            this.init();
          },
        },
            mounted() {
              this.init();
      },
    };

</script>
<style>
  .phone-form {
    width: 140px;
    display: inline-block;
    margin: 0;
    padding: 0;
    padding-right: 5px;
    margin-left: 0 !important;
  }
  #first {
  
  }
  #first label{
    width: 20px;
    height: 30px;
    text-align: center;
  }
  .phone-form .form-group .__vv-form-group {
    width: 120px;
    padding: 0;
  }
  .phone-form .col-sm-10 {
    width: 110px !important;
    margin: 0;
    padding: 0;
  }
   .phone-form .col-sm-10 input {
     border: 1px solid #ccd0d2;
     border-radius: 4px;
     padding-left: 10px;
     width: 90px;
    }
  .phone-form .control-label {
    margin: 4!important;
    width: 20px;
    padding: 4px !important;
    padding-right: 50px;
    text-align: center;
  }
  .control-label,
  .col-sm-10 {
    display: inline-block;
  }
</style>