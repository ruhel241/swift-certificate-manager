<template>
    <div class="scm-app">
        <div class="scm-header">
            <navigation/>
        </div>
        <div class="scm-body">
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
          tableData: [{
            date: '2016-05-03',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
          }, {
            date: '2016-05-02',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
          }, {
            date: '2016-05-04',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
          }, {
            date: '2016-05-01',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
          }]
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
