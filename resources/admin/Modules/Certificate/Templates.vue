<template>
    <templates-manager/>
</template>

<script>
import TemplatesManager from "../Onboarding/Step2.vue";

export default {
  name: "templates",
  components: {
    TemplatesManager
  },
  data() {
    return {
    };
  },
  methods: {
  },
  mounted() {
    jQuery('head title').text('Templates - Swift Certificate Manager');
  },
  beforeMount() {
    if (this.appVars.is_onboarded === 'no') {
      this.$router.push(
          {
            name: 'setup_template',
            params: {}
          }
      )
    }
  },
};
</script>