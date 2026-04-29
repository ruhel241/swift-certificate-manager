<template>
    <div v-if="selections.length" class="infos_selection_handler">
        <el-button-group>
            <el-button @click="handleDeleteModal()" size="mini" type="danger">Delete Selected</el-button>
            <el-button v-if="current_status !== 'draft'" @click="handleDraftModal()" size="mini" type="info">Draft Selected</el-button>
            <el-button v-if="current_status !== 'assign'" @click="performAction('assign')" size="mini" type="success">Assign Selected</el-button>
        </el-button-group>
    </div>
</template>

<script type="text/babel">
    import each from 'lodash/each';
    export default {
        name: 'infos_selection_handler',
        props: ['selections', 'current_status'],
        data() {
            return {}
        },
        methods: {
            handleDeleteModal() {
                this.$confirm('Do you want delete this link permanently', 'Warning', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {
                    this.performAction('delete');
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        offset: 50,
                        showClose: true,
                        message: 'Delete canceled'
                    });
                });
            },
            handleDraftModal() {
                this.$confirm('This will draft the selected infos. Continue?', 'Warning', {
                    confirmButtonText: 'Draft',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {
                    this.performAction('draft');
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        offset: 50,
                        showClose: true,
                        message: 'Draft canceled'
                    });
                });
            },
            
            performAction(type) {
                let selectedIds = [];
                each(this.selections, (selection) => {
                    selectedIds.push(selection.id);
                });
                this.$post({
                    action: 'swift_certificate_manager_generate_admin_ajax',
                    route: 'maybe_delete_infos',
                    info_ids: selectedIds,
                    action_type: type,
                    nonce: window.SwiftCertificateManagerAdminVars.nonce
                })
                    .then(response => {
                        this.$notify({
                            title: 'Sucess',
                            message: response.data.message,
                            type: 'success'
                        });
                        this.$emit('reloadData');
                    })
                    .fail(error => {
                        this.$handleError(error);
                    })
                    .always(() => {
                    });
            },
        }
    }
</script>
