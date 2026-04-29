<template>
    <div class="wpsc-assign-certificate">
        <certificate-creator-intro/>
    </div>
</template>

<script>
import CertificateCreatorIntro from '../Components/_CertificateCreatorIntro.vue';
export default {
    name: 'create-certificate',
    components: {
        CertificateCreatorIntro
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
}
</script>
