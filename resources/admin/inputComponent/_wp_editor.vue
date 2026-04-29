<template>
    <div class="wp_vue_editor_wrapper">
        <textarea v-if="hasWpEditor" class="wp_vue_editor" :id="editor_id" v-model="plain_content"></textarea>
        <textarea 
            v-else
            class="wp_vue_editor wp_vue_editor_plain"
            type="textarea"
            v-model="plain_content">
        </textarea>
    </div>
</template>

<script type="text/babel">
    export default {
        name: 'wp_editor',
        props: {
            editor_id: {
                type: String,
                default() {
                    return 'wp_editor_' + Date.now() + parseInt(Math.random() * 1000);
                }
            },
            value: {
                type: String,
                default() {
                    return '';
                }
            },
           
            height: Number
        },
        data() {
            return {
                hasWpEditor: !!window.wp.editor,
                plain_content: this.value
                // wpEditorID: this.editor_id +'_'+ Date.now() + parseInt(Math.random() * 1000)
            }
        },
        watch: {
            plain_content() {
                this.$emit('input', this.plain_content);
            }
        },
        methods: {
            initEditor() {
                if (!window.tinymce) {
                    return;
                }
                window.wp.editor.remove(this.editor_id);
                const that = this;
                window.wp.editor.initialize(this.editor_id, {
                    mediaButtons: false,
                    tinymce: {
                        height: that.height,
                        toolbar1: 'bold,italic,bullist,numlist,link,blockquote,alignleft,aligncenter,alignright,strikethrough,forecolor,codeformat,undo,redo',
                        setup(ed) {
                            ed.on('init', (ed) => {
                                window.tinyMCE.get(that.editor_id).setContent(that.value);
                                window.tinyMCE.execCommand('mceRepaint');
                            }
                            );
                            ed.on('change', function (ed, l) {
                                that.changeContentEvent();
                            });
                        }
                    },
                    quicktags: true
                });

                jQuery('#' + this.editor_id).on('change', function (e) {
                    that.changeContentEvent();
                });
            },
            changeContentEvent() {
                let content = window.wp.editor.getContent(this.editor_id);
                this.$emit('input', content);
            }
        },
        mounted() {
            if (this.hasWpEditor) {
                this.initEditor();
            }
        }
    }
</script>
