<template>
    <div>
        <app ref="app">
            <template slot="main_menu">
                <li id="candidate"><router-link to="/candidate/application_list">{{ $t("menu.candidate") }}</router-link></li>
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
    mounted(){
      this.$refs.app.subNavigators = [
        { link: '/candidate/application_list', text: 'sub_menu.candidate.applicant', sub: 'candidate' },
        { link: '/candidate/inbox', text: 'sub_menu.candidate.inbox', sub: 'candidate' },
      ];
      this.$on("EVENT_CHANGE_SUB_NAVIGATOR", () => {
        this.$refs.app.subNavigators = [
          { link: '/candidate/application_list', text: 'sub_menu.candidate.applicant', sub: 'candidate' },
          { link: '/candidate/inbox', text: 'sub_menu.candidate.inbox', sub: 'candidate' },
        ];
      })
    }
  }
</script>