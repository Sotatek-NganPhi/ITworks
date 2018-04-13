<template>
    <div>
        <validation-form ref="videoForm">
            <form-group :label="getDisplayName('name')" :is-required="isFieldRequired('name')">
                <input class="form-control" name="getDisplayName('name')" type="text"
                       data-vv-name="name" v-model="video.name"/>
            </form-group>

            <form-group :label="getDisplayName('description')" :is-required="isFieldRequired('description')">
            <textarea  class="form-control" rows="5" name="getDisplayName('description')"
                       data-vv-name="description" v-model="video.description"></textarea>
            </form-group>

            <form-group :label="getDisplayName('url')" :is-required="isFieldRequired('url')">
                <input class="form-control" name="getDisplayName('url')" type="text"
                       data-vv-name="url" v-model="videoUrl" placeholder="Youtube URL"/>
            </form-group>
            <form-group>
                <button type="button" class="btn btn-default btn-sm" @click="getThumbnailDefault()">
                    <span class="glyphicon glyphicon-refresh"></span> {{ $t("video.update_thumbnail") }}
                </button>
            </form-group>

            <form-group :label="getDisplayName('thumbnail')" :is-required="isFieldRequired('thumbnail')">
                <file-upload data-vv-name="thumbnail"
                             v-model="video.thumbnail" accept="image/*"></file-upload>
            </form-group>

            <form-group :label="getDisplayName('is_active')" :is-required="isFieldRequired('is_active')">
                <radio-group inline="true"  data-vv-name="is_active"
                             v-model="video.is_active" :options="activeOptions"/>
            </form-group>

            <form-group :label="$t('video.region')">
                <multiselect
                        v-model="selectedRegions"
                        :placeholder="$t('common_action.pick')"
                        label="name"
                        track-by="id"
                        :options="masterdata.regions"
                        :multiple="true"
                        :close-on-select="false"
                        :clear-on-select="false"
                        :hide-selected="true"
                ></multiselect>
            </form-group>

        </validation-form>

        <div class="text-center section-space">
            <button type="button" class="btn btn-primary btn-sm button-space" @click="showModal()">
                <span class="glyphicon glyphicon-ok"></span> {{ $t("common_action.ok") }}
            </button>
            <button type="button" class="btn btn-default btn-sm" @click="cancel()">
                <span class="glyphicon glyphicon-remove"></span> {{ $t("common_action.cancel") }}
            </button>
        </div>
        <confirmation-dialog v-if="isShowModal" @ConfirmationDialog:CANCEL="isShowModal = false"
                             @ConfirmationDialog:OK="updateChange"
                             :message="$t('message.before_update')">
        </confirmation-dialog>
    </div>
</template>

<script>
  import _ from 'lodash';
  import Multiselect from 'vue-multiselect';
  import rf from '../../../js/lib/RequestFactory';
  import {user} from '../../../js/app/manage/main';
  import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';
  import FileUpload from '../../../components/common/FileUpload.vue';
  import Utils from '../../../js/common/Utils';

  export default {
    components: {
      Multiselect,
      FileUpload
    },
    data() {
      return {
        user,
        subNavigators,
        video: {
          is_active: 1,
          name: '',
          description: '',
          url: '',
          thumbnail: '',
        },
        selectedRegions: [],
        videoUrl: '',
        masterdata: Utils.getMasterdataSkel(),
        activeOptions: Utils.getYesNoOptions(),
        isShowModal: false,
        hasDefault: false,
      }
    },
    computed: {
      videoId: function () {
        var url = this.videoUrl;
        var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match && match[2].length == 11) {
          return match[2];
        } else {
          return '';
        }
      }
    },
    methods: {
      getDisplayName(fieldName) {
        return Utils.getFieldDisplayName(this.masterdata, 'videos', fieldName);
      },
      isFieldRequired(fieldName) {
        return Utils.isFieldRequired(this.masterdata, 'videos', fieldName);
      },
      getThumbnailDefault() {
        if (!this.videoId) return;
        this.video.thumbnail = "https://img.youtube.com/vi/" + this.videoId + "/hqdefault.jpg";
      },
      showModal() {
        this.isShowModal = true;
      },
      updateChange() {
        this.isShowModal = false;
        this.video.url = this.videoId ? "https://www.youtube.com/embed/" + this.videoId : this.videoUrl;
        this.video.regions = _.map(this.selectedRegions, 'id');
        const videoPromise = (this.video && this.video.id)
          ? rf.getRequest('VideoRequest').updateOne(this.video.id, this.video)
          : rf.getRequest('VideoRequest').createANewOne(this.video);
        videoPromise.then(res => {
          window.Utils.growl('request.request_success');
          this.$refs.videoForm.$emit('FORM_ERRORS_CLEAR');
          if (!this.video.id) {
            this.cancel();
          }
        }).catch(({validationErrors}) => {
          if (validationErrors) {
            this.$refs.videoForm.$emit('REJECT_FORM', validationErrors);
          }
        });
      },
      cancel() {
        this.$router.push({
          path: '/video/list',
        });
      },
      loadThumbnail(thumbnail) {
        if (this.video.thumbnail) {
          this.video.thumbnail = thumbnail;
        } else {
          this.getThumbnailDefault()
        }
      }
    },
    watch: {
      videoUrl: function () {
        if (this.hasDefault) {
          this.hasDefault = false;
          return;
        }
        this.getThumbnailDefault();
      }
    },
    mounted() {
      this.$emit('EVENT_PAGE_CHANGE', this);
      let id = this.$route.query.id;
      const videoPromise = id
        ? rf.getRequest('VideoRequest').getOne(id, {'with': 'regions'})
        : Promise.resolve(this.video);
      const masterdataPromise = rf.getRequest('MasterdataRequest').getAll();

      Promise.all([videoPromise, masterdataPromise]).then(([video, masterdata]) => {
        this.masterdata = masterdata;
        this.video = video;
        this.videoUrl = this.video.url;
        this.selectedRegions = id ? this.video.regions : this.masterdata.regions;
        if (video.thumbnail) {
          this.hasDefault = true;
          this.video.thumbnail = video.thumbnail;
        } else {
          this.getThumbnailDefault()
        }
      });
    }
  }
</script>
