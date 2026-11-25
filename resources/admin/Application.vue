<template>
    <div class="swifcema-app">
        <div class="swifcema-header">
            <navigation/>
        </div>
        <div class="swifcema-body">
            <router-view :key="$route.fullPath"></router-view>
        </div>
    </div>
</template>

<script type="text/babel">
import Navigation from './Layouts/Navigation';
import Clipboard from 'clipboard';

export default {
    name: 'Application',
    components: {
        Navigation
    },
    data() {
        return {
        }
      },
    mounted() {
        var clipboard = new Clipboard('.copy');
        clipboard.on('success', (e) => {
            this.$message({
                message: 'Copied to Clipboard!',
                type: 'success',
                offset: 50
            });
        });
    }
}
</script>
