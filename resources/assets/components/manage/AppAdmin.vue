<template>
    <div>
        <app>
            <template slot="main_menu">
                <li id="job"><router-link to="/job/list">{{ $t("menu.job") }}</router-link></li>
                <li id="company"><router-link to="/company/list">{{ $t("menu.company") }}</router-link></li>
                <li id="candidate"><router-link to="/candidate/list">{{ $t("menu.candidate") }}</router-link></li>
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