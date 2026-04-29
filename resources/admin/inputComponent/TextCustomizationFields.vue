<template>
  <el-form>
    <el-form-item :label="inputLabel">
      <el-input
        v-if="type === 'text'"
        :value="settings[textKey]"
        :placeholder="placeholder"
        :maxlength="maxLength"
        :show-word-limit="showWordLimit"
        :disabled="disabled"
        @input="handleChange($event, textKey)"
      />
      <el-date-picker
          v-else-if="type === 'date'"
          :value="settings[textKey]"
          type="date"
          :placeholder="placeholder"
          format="dd MMMM yyyy"
          value-format="dd MMMM yyyy"
          :picker-options="pickerDateOptions"
          @input="handleChange($event, textKey)"
      />
      <PhotoUploader
        v-else-if="type === 'upload'"
        :value="settings[textKey]"
        @input="handleChange($event, textKey)"
      />
    </el-form-item>

    <el-form-item label="Font Size" v-if="fontSizeEnable">
      <el-input
        type="number"
        :value="settings[fontSizeKey]"
        @input="handleChange($event, fontSizeKey)"
      />
    </el-form-item>

    <el-form-item label="Font Family" v-if="fontFamilyEnable">
      <el-select
        :value="settings[fontFamilyKey]"
        placeholder="Select a font"
        filterable
        @input="handleChange($event, fontFamilyKey)"
      >
        <el-option-group
          v-for="(group, groupLabel) in fonts"
          :key="groupLabel"
          :label="groupLabel"
        >
          <el-option
            v-for="(fontName, fontKey) in group"
            :key="fontKey"
            :label="fontName"
            :value="fontKey"
          >
            {{ fontName }}
          </el-option>
        </el-option-group>
      </el-select>
    </el-form-item>

    <el-form-item label="Font Weight" v-if="fontWeightEnable">
      <el-select
        :value="settings[fontWeightKey]"
        placeholder="Select"
        @change="handleChange($event, fontWeightKey)"
      >
        <el-option
          v-for="item in fontWeightOptions"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        />
      </el-select>
    </el-form-item>

    <el-form-item label="Top Position">
      <el-input
        type="number"
        :value="settings[topKey]"
        placeholder="ex: 420"
        @input="handleChange($event, topKey)"
      />
    </el-form-item>

    <el-form-item label="Left Position">
      <el-input
        type="number"
        :value="settings[leftKey]"
        placeholder="ex: 280"
        @input="handleChange($event, leftKey)"
      />
    </el-form-item>

    <el-form-item label="Width" v-if="widthEnable">
      <el-input
          type="number"
          placeholder="ex: 420"
          :value="settings[widthKey]"
          @input="handleChange($event, widthKey)"
      />
    </el-form-item>

    <el-form-item label="Height" v-if="heightEnable">
      <el-input
          type="number"
          placeholder="ex: 420"
          :value="settings[heightKey]"
          @input="handleChange($event, heightKey)"
      />
    </el-form-item>

    <el-form-item v-if="fontColorEnable">
      <color-select
        :title="$t('Font Color:')"
        :value="settings[colorKey]"
        @input="handleChange($event, colorKey)"
      />
    </el-form-item>
  </el-form>
</template>
<script>
import ColorSelect from "./colorSelect.vue";
import PhotoUploader from "./PhotoUploader";
export default {
  name: "TextCustomizationFields",
  components: {
    ColorSelect,
    PhotoUploader
  },
  props: {
    type:{
      type: String,
      required: true
    },
    fieldKey: {
      type: String,
      required: true
    },
    settings: {
      type: Object,
      required: true
    },
    fonts: {
      type: Object,
      required: true
    },
    inputLabel: {
      type: String,
      default: ""
    },
    placeholder: {
      type: String,
      default: ""
    },
    maxLength: {
      type: [Number, String],
      default: null
    },
    showWordLimit: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    fontFamilyEnable: {
      type: Boolean,
      default: true
    },
    fontWeightEnable: {
      type: Boolean,
      default: true
    },
    fontSizeEnable: {
      type: Boolean,
      default: true
    },
    fontColorEnable: {
      type: Boolean,
      default: true
    },
    widthEnable: {
      type: Boolean,
      default: false
    },
    heightEnable: {
      type: Boolean,
      default: false
    },
  },
  computed: {
    textKey() {
      return this.fieldKey;
    },
    fontSizeKey() {
      return `${this.fieldKey}_font_size`;
    },
    fontFamilyKey() {
      return `${this.fieldKey}_font_family`;
    },
    fontWeightKey() {
      return `${this.fieldKey}_font_weight`;
    },
    topKey() {
      return `${this.fieldKey}_top`;
    },
    leftKey() {
      return `${this.fieldKey}_left`;
    },
    colorKey() {
      return `${this.fieldKey}_color`;
    },
    widthKey() {
      return `${this.fieldKey}_width`;
    },
    heightKey() {
      return `${this.fieldKey}_height`;
    }
  },
  data() {
    return {
      pickerDateOptions: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      fontWeightOptions: [
        { label: 'Normal (400)', value: 400 },
        { label: 'Medium (500)', value: 500 },
        { label: 'Semi Bold (600)', value: 600 },
        { label: 'Bold (700)', value: 700 }
      ]
    };
  },
  methods: {
    handleChange(value, key) {
      this.$emit("change", value, key);
    }
  }
};
</script>