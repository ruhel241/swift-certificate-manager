<template>
    <div v-if="app_ready" class="swiftcm_file_upload_wrap">
        <div @click="initUploader" v-if="!image_url" class="el-button el-button--upload el-button--default is-plain">
            <i class="el-icon el-icon-upload"></i>
            <span>{{ 'Upload Your Signature' }}</span>
        </div>
        <div class="swiftcm_file_upload_result" v-if="image_url?.length > 0">
            <div class="swiftcm_file_upload_preview">
                <img :src="image_url"/>
            </div>
            <div class="swiftcm_file_upload_data">
                <div v-if="image_name" class="swiftcm_file_upload_description">
                    {{ image_name }}
                    <el-button
                        class="el-button--icon"
                        type="primary"
                        icon="el-icon el-icon-upload"
                        size="mini"
                        @click="initUploader">
                    </el-button>

                    <el-button
                        class="el-button--icon"
                        type="danger"
                        icon="el-icon-delete"
                        size="mini"
                        @click="image_url = ''">
                    </el-button>
                </div>
                <div v-if="image_size" class="swiftcm_file_upload_size">
                    {{ image_size }}
                </div>
            </div>
        </div>
        <UpgradePopup 
            :upgradePopupVisible="upgradePopupVisible"
            @close="upgradePopupVisible = false"
        />
    </div>
</template>

<script type="text/babel">
import UpgradePopup from '../Modules/Components/UpgradePopup.vue';

    export default {
        name: 'photo_widget',
        props: ['value'],
        components: {
            UpgradePopup
        },
        data() {
            return {
                app_ready: false,
                image_size: '',
                upgradePopupVisible: false,
                hasPro: !!window.swiftcmAdminVars.has_pro
            }
        },
        methods: {
            initUploader(event) {
                if (!this.hasPro) {
                    this.upgradePopupVisible = true;
                    return;
                }
                const that = this;
                const send_attachment_bkp = wp.media.editor.send.attachment;
                wp.media.editor.send.attachment = function (props, attachment) {
                    that.image_url = attachment.url;
                    that.image_size = attachment.filesizeHumanReadable;
                    wp.media.editor.send.attachment = send_attachment_bkp;
                };
                wp.media.editor.open();
                return false;
            },
        },
	    computed: {
		    image_url : {
				get() {
					return this.value || '';
				},
			    set(value) {
				    this.$emit('input', value);
			    }
		    },
		    image_name() {
			    let url = this.image_url;
			    let name = url.substring(url.lastIndexOf("/")+1, url?.length);
			    // 15 character for suitable visible name
			    if (name?.length > 15) {
				    name = name.slice(0, 15) + '...' + name.substring(name.lastIndexOf(".") - 2, name?.length);
			    }
				return name;
		    },
	    },
        mounted() {
            if (!window.wpActiveEditor) {
                window.wpActiveEditor = null;
            }
            this.app_ready = true;
        }
    }
</script>

<style lang="scss">

.swiftcm_file_upload_wrap {
    width: 100%;
    .el-button--upload {
        border-style: dashed;
        padding: 20px;
        width: 100%;
        justify-content: center;
    }       

    .swiftcm_file_upload_result {
        background-color: #fafafa;
        border: 1px solid #f2f2f2;
        border-radius: 8px;
        display: flex;
        align-items: center;
        position: relative;
        padding: 10px;
        overflow: hidden;
        margin-top: 8px;
    }

    .swiftcm_file_upload_preview {
        width: 44px;
        height: 44px;
    }

    .swiftcm_file_upload_data {
        flex: 1;
        margin-left: 15px;
    }

    .swiftcm_file_upload_description {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        color: #1E1F21;
    .el-button--primary {
            margin-left: auto;
        }
        .el-button--danger {
            margin-left: 6px;
        }
    }

    .swiftcm_file_upload_preview img {
        width: 44px;
        height: 100%;
        -o-object-fit: cover;
        object-fit: cover;
        border-radius: 4px;
    }
}
</style>

