<template>
    <div>
        TODO: Urgent edit...
    </div>
</template>

<script>

import {user} from '../../../js/app/manage/main';
import {contentSettingsNavigators as subNavigators} from '../../../js/app/manage/routes';

export default {
  data() {
    return {
      user,
      subNavigators,
    }
  },

  methods: {

  },

  mounted() {
    this.$emit('EVENT_PAGE_CHANGE', this);
  }
}
</script>
