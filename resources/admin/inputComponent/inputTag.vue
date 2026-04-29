<template>
    <div>
        <el-tag
            :key="index"
            v-for="(tag, index) in tags"
            closable
            :disable-transitions="false"
            @close="handleClose(tag)">
            {{tag}}
        </el-tag>
        <el-input
            class="input-new-tag"
            v-if="inputVisible"
            v-model="inputValue"
            ref="saveTagInput"
            size="mini"
            @keyup.enter.native="handleInputConfirm"
            @blur="handleInputConfirm"
            placeholder="Separate with commas or the Enter key."
        >
        </el-input>
        <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Tag</el-button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                inputVisible: false,
                inputValue: ''
            };
        },
        props: ['tags'],
        watch:{
            inputValue() {
               
                if (this.inputValue.includes(",")) {
                   let inputValue = this.inputValue;
                    if (inputValue) {
                        this.tags.push(inputValue.substring(0, (inputValue.length -1) ));
                    } else {
                        this.tags = '';
                    }
                    this.inputVisible = false;
                    this.inputValue = '';
                }
            }
        },
        methods: {
            handleClose(tag) {
                this.tags.splice(this.tags.indexOf(tag), 1);
            },

            showInput() {
                this.inputVisible = true;
                this.$nextTick(_ => {
                    this.$refs.saveTagInput.$refs.input.focus();
                });
            },

            handleInputConfirm() {
                let inputValue = this.inputValue;
                if (inputValue) {
                    this.tags.push(inputValue);
                } 
                this.inputVisible = false;
                this.inputValue = '';
            }
        }
    }
</script>
