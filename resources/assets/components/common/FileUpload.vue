<template>
  <div class="upload-file">
    <div class="control">
      <div class="name-file">
        <input type="text" class="upload-file-input" v-model="imagePath" readonly/>
        <span v-if="!!imagePath"
              class="form-control-clear glyphicon glyphicon-remove vue-datepicker__input-clear"
              @click="clear()">
        </span>
      </div>
      <div class="choose-file">
        <span>Upload</span>
        <input type="file" :accept="accept" name="btn_upload_file" class="upload" @change="uploadFile"/>
      </div>
    </div>
    <template v-if="imagePath">
      <div class="view">
        <img :src="imagePath" width="200px" class="image"/>
      </div>
    </template>
  </div>
</template>

<script>
  import rf from '../../js/lib/RequestFactory';
  export default {
    data(){
      return {
        url: "/upload-images",
        imagePath: "",
      }
    },
    props: ["value", "accept", "type"],

    watch: {
      imagePath: function (val) {
        this.$emit('input', val);
      },
      value: function (val) {
        this.imagePath = val;
      }
    },

    methods: {
      uploadFile: function (e) {
        let files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        if (this.type == "temporary") {
          rf.getRequest('UploadFile').uploadFileTemporary(this.url, files[0]).then(res => {
            this.imagePath = res.path;
            $("input[name='btn_upload_file']").val('');
            this.$emit('input', res.path);
          });
        } else {
          rf.getRequest('UploadFile').uploadFile(this.url, files[0]).then(res => {
            this.imagePath = res.path;
            $("input[name='btn_upload_file']").val('');
            this.$emit('input', res.path);
          });
        }
      },

      clear(){
        this.imagePath = null;
      },

      init() {
        if (this.value) {
          this.imagePath = this.value;
        }
      },
    },
    mounted() {
      this.init();
    }
  }
</script>

<style scoped>
  .choose-file {
    display: inline-block;
    position: relative;
    overflow: hidden;
    border: 1px solid #BFBFBF;
    background-color: #F9F9F9;
    width: 60px;
    height: 30px;
    border-radius: 4px;
    top: 10px;
    font-weight: bold;
    color: #595959;
    padding-top: 3px;
    text-align: center;
  }

  .choose-file input {
    position: absolute;
    top: 0px;
    left: 0px;
    margin: 0px;
    padding: 0;
    height: 100%;
    width: 100%;
    font-size: 0;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
  }

  .name-file {
    display: inline-block;
    position: relative;
  }
  .vue-datepicker__input-clear{
    position: absolute;
    right: 0px;
    line-height: 30px;
  }

  .name-file input {
    width: 300px;
    border-radius: 3px;
    border: 1px solid #BFBFBF;
    padding: 3px 3px 3px 5px;
    font-size: 12px;
    height: 30px;
  }
  .image{
    padding: 5px;
  }
</style>