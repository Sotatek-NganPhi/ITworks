<template>
    <div>
        <app>
            <template slot="main_menu">
                <li id="job"><router-link to="/job/list">{{ $t("menu.job") }}</router-link></li>
                <li id="company"><router-link to="/company/list">{{ $t("menu.company") }}</router-link></li>
                <li id="candidate"><router-link to="/candidate/list">{{ $t("menu.candidate") }}</router-link></li>
               <!--  <li id="content_settings"><router-link to="/special/list">{{ $t("menu.content_settings") }}</router-link></li>
                <li id="analysis"><router-link to="/analysis/merit">{{ $t("menu.analysis") }}</router-link></li> -->
                <li id="field_settings"><router-link to="/field_settings/list?table=jobs">{{ $t("menu.field_settings") }}</router-link></li>
                <!-- <li id="search_keys"><router-link to="/search_keys/region/list">{{ $t("menu.search_keys") }}</router-link></li>
                <li id="metadata"><router-link to="/metadata/list">{{ $t("menu.metadata") }}</router-link></li> -->
            </template>
        </app>
    </div>
</template>

<script>
  import App from './App.vue';
  export default {
    components: {
      App
    },
    data () {
      return {}
    }
  }
</script>