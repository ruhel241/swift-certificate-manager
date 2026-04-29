<template>
    <div class="wscm-color-select">
        <p class="label">{{title}}</p>
        <el-color-picker
            v-model="model"
            @active-change="activeChangedEvent"
            :predefine="predefineColors">
        </el-color-picker>
    </div>
</template>

<script>
export default {
    name: 'color-select',
    props:['value', 'title'],

    data() {
        return {
            predefineColors: [
                '#ff4500',
                '#ff8c00',
                '#ffd700',
                '#90ee90',
                '#00ced1',
                '#1e90ff',
                '#c71585',
                'rgba(255, 69, 0, 0.68)',
                'rgb(255, 120, 0)',
                'hsv(51, 100, 98)',
                'hsva(120, 40, 94, 0.5)',
                'hsl(181, 100%, 37%)',
                'hsla(209, 100%, 56%, 0.73)',
                '#c7158577'
            ]
        }
    },
    
    computed: {
        model:{
            get() {
                return this.value;
            },
            set(newValue){
                this.$emit('input', newValue);
            }
        }
    },

    methods: {
        activeChangedEvent(color) {
            this.$emit('input', color);
        }
    }    
}
</script>