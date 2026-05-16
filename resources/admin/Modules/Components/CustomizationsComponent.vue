<template>
  <div class="swiftcm-customizations-wrapper">
    <!-- {{ settings }} -->
    <el-row :gutter="20">
      <!-- Certificate Panel -->
      <el-col :span="17">
        <div class="swiftcm-certificate-preview" v-loading="fetching">
          <!-- Certificate Container with Fixed Size -->
          <div class="certificate-outer-container">
            <div id="view-template" class="view-template" :style="viewTemplateStyle">
              <!-- Background image as real image -->
              <img
                :src="uploadCertificateUrl + template.template_image"
                class="certificate-bg"
              />
              <!-- Draggable Elements Container -->
              <div class="elements-container" ref="elementsContainer">
                <!-- Text Elements -->
                <div
                    v-for="element in textElements"
                    :key="element.field"
                    class="certificate-element"
                    :class="{ 'selected': selectedElement === element.field }"
                    :style="getElementStyle(element)"
                    @mousedown.prevent="startDrag($event, element)"
                    @click.stop="selectElement(element.field)"
                >
                  {{ element.text }}

                  <!-- Font resize handle when selected -->
                  <div v-if="selectedElement === element.field" class="resize-handle font-resize" @mousedown.stop="startFontResize($event, element)">
                    <i class="el-icon-zoom-in"></i>
                  </div>
                </div>

                <!-- Image Elements (signatures, QR codes) -->
                <div
                    v-for="element in imageElements"
                    :key="element.field"
                    class="certificate-element image-element"
                    :class="{ 'selected': selectedElement === element.field }"
                    :style="getImageStyle(element)"
                    @mousedown.prevent="startDrag($event, element)"
                    @click.stop="selectElement(element.field)"
                >
                  <img :src="element.url || ''" class="element-image" :style="getElementImageStyle(element)" />

                  <!-- Resize handles when selected -->
                  <div v-if="selectedElement === element.field" class="resize-handles">
                    <div class="resize-handle top-left" @mousedown.stop="startResizeImage($event, element, 'top-left')"></div>
                    <div class="resize-handle top-right" @mousedown.stop="startResizeImage($event, element, 'top-right')"></div>
                    <div class="resize-handle bottom-left" @mousedown.stop="startResizeImage($event, element, 'bottom-left')"></div>
                    <div class="resize-handle bottom-right" @mousedown.stop="startResizeImage($event, element, 'bottom-right')"></div>
                  </div>
                </div>

                <!-- QR Code Element (if enabled) -->
                <div
                    v-if="settings.qr_code_enable === 'yes'"
                    class="certificate-element qr-element"
                    :class="{ 'selected': selectedElement === 'qr_code_url' }"
                    :style="getQrCodeStyle()"
                    @mousedown.prevent="startDrag($event, {
                        field: 'qr_code_url',
                        x: parseInt(settings.qr_code_url_left) || 0,
                        y: parseInt(settings.qr_code_url_top) || 0,
                        width: parseInt(settings.qr_code_url_width) || 150,
                        height: parseInt(settings.qr_code_url_height) || 150
                    })"
                    @click.stop="selectElement('qr_code_url')"
                >
                  <VueQRCode
                      :text="settings.qr_code_url"
                      :size="parseInt(settings.qr_code_url_width) || 150"
                      class="qr-code-image"
                  ></VueQRCode>

                  <!-- Resize handles when selected -->
                  <div v-if="selectedElement === 'qr_code_url'" class="resize-handles">
                    <div class="resize-handle top-left" @mousedown.stop="startResizeImage($event, {
                            field: 'qr_code_url',
                            x: parseInt(settings.qr_code_url_left) || 0,
                            y: parseInt(settings.qr_code_url_top) || 0,
                            width: parseInt(settings.qr_code_url_width) || 150,
                            height: parseInt(settings.qr_code_url_height) || 150
                        }, 'top-left')"></div>
                    <div class="resize-handle top-right" @mousedown.stop="startResizeImage($event, {
                            field: 'qr_code_url',
                            x: parseInt(settings.qr_code_url_left) || 0,
                            y: parseInt(settings.qr_code_url_top) || 0,
                            width: parseInt(settings.qr_code_url_width) || 150,
                            height: parseInt(settings.qr_code_url_height) || 150
                        }, 'top-right')"></div>
                    <div class="resize-handle bottom-left" @mousedown.stop="startResizeImage($event, {
                            field: 'qr_code_url',
                            x: parseInt(settings.qr_code_url_left) || 0,
                            y: parseInt(settings.qr_code_url_top) || 0,
                            width: parseInt(settings.qr_code_url_width) || 150,
                            height: parseInt(settings.qr_code_url_height) || 150
                        }, 'bottom-left')"></div>
                    <div class="resize-handle bottom-right" @mousedown.stop="startResizeImage($event, {
                            field: 'qr_code_url',
                            x: parseInt(settings.qr_code_url_left) || 0,
                            y: parseInt(settings.qr_code_url_top) || 0,
                            width: parseInt(settings.qr_code_url_width) || 150,
                            height: parseInt(settings.qr_code_url_height) || 150
                        }, 'bottom-right')"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="footer-buttons">
            <el-button  
              class="capsule-btn"
              icon="el-icon-refresh"
              :loading="redesigning"
              round 
              @click="emitRedesignCertificate">
              Redesign Certificate
            </el-button>

            <el-button
              :loading="downloading"
              class="swiftcm-primary-btn svg-span-btn"
              @click="downloadCertificate"
            >
              <svg v-if="!downloading" width="16" height="16" viewBox="0 0 16 16" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
                <path d="M8 1.33334V6L9.33333 4.66667" stroke="#424145" stroke-width="0.8"
                      stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8.00008 6L6.66675 4.66666" stroke="#424145" stroke-width="0.8"
                      stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M1.32007 8.66666H4.26007C4.5134 8.66666 4.74007 8.80666 4.8534 9.03333L5.6334 10.5933C5.86007 11.0467 6.32007 11.3333 6.82674 11.3333H9.18007C9.68674 11.3333 10.1467 11.0467 10.3734 10.5933L11.1534 9.03333C11.2667 8.80666 11.5001 8.66666 11.7467 8.66666H14.6534"
                      stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M4.66659 2.75333C2.30659 3.1 1.33325 4.48667 1.33325 7.33333V10C1.33325 13.3333 2.66659 14.6667 5.99992 14.6667H9.99992C13.3333 14.6667 14.6666 13.3333 14.6666 10V7.33333C14.6666 4.48667 13.6933 3.1 11.3333 2.75333"
                      stroke="#424145" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Download Certificate
            </el-button>
          </div>
        </div>
      </el-col>

      <!-- Customization Panel -->
      <el-col :span="7">
        <div class="swiftcm-customizations-panel">
          <div class="title">
            <h2 class="panel-title mb-20">Certificate Information</h2>
          </div>
          <div class="customization-fields">
            <el-collapse v-model="activePanel" accordion @change="panelChangeHandler">
              <el-collapse-item title="Student Name" name="1">
                <TextCustomizationFields
                  type="text"
                  :settings="settings"
                  :fonts="fonts"
                  fieldKey="student_name"
                  inputLabel="Student Name | Max 40 characters"
                  placeholder="Student Name"
                  :maxLength="40"
                  :showWordLimit="true"
                  @change="changeHandler"
                />
              </el-collapse-item>
             
              <el-collapse-item title="Course Name" name="2">
                <TextCustomizationFields
                  type="text"
                  :settings="settings"
                  :fonts="fonts"
                  fieldKey="course_name"
                  inputLabel="Course Name | Max 80 characters"
                  placeholder="Course Name"
                  :maxLength="80"
                  :showWordLimit="true"
                  @change="changeHandler"
                />
              </el-collapse-item>
             
              <el-collapse-item title="Graduation Date" name="3">
                <TextCustomizationFields
                  type="date"
                  :settings="settings"
                  :fonts="fonts"
                  fieldKey="graduation_date"
                  inputLabel="Date"
                  placeholder="Pick a Date"
                  @change="changeHandler"
                />
              </el-collapse-item>
              
              <el-collapse-item title="Primary Signature" name="4" v-if="settings.instructor_active_signature === 'yes'">
                <TextCustomizationFields
                  type="text"
                  :settings="settings"
                  :fonts="fonts"
                  fieldKey="instructor_name"
                  inputLabel="Name"
                  placeholder="John Deo"
                  @change="changeHandler"
                />
                <hr/>
                <el-form>
                  <el-form-item label="Signature Image Enable" style="display: flex; align-items: center;">
                    <el-switch
                        style="margin-left: 10px"
                        v-model="settings.instructor_signature_img_enable"
                        active-value="yes"
                        inactive-value="no"
                        @input="(value) => changeHandler(value, 'instructor_signature_img_enable')">
                    </el-switch>
                  </el-form-item>
                </el-form>

                <TextCustomizationFields
                  v-if="settings.instructor_signature_img_enable == 'yes'"
                  type="upload"
                  :settings="settings"
                  :fonts="fonts"
                  fieldKey="instructor_signature_img"
                  placeholder="John Deo"
                  :fontSizeEnable="false"
                  :fontFamilyEnable="false"
                  :fontWeightEnable="false"
                  :fontColorEnable="false"
                  :widthEnable="true"
                  :heightEnable="true"
                  @change="changeHandler"
                />
               
                <TextCustomizationFields
                  v-if="settings.instructor_signature_img_enable === 'no'"
                  type="text"
                  :settings="settings"
                  :fonts="fonts"
                  fieldKey="instructor_signature"
                  inputLabel="Signature"
                  placeholder="John"
                  @change="changeHandler"
                />
              </el-collapse-item>

              <el-collapse-item title="Secondary Signature" name="5" v-if="settings.auth_active_signature === 'yes'">
                <TextCustomizationFields
                  type="text"
                  :settings="settings"
                  :fonts="fonts"
                  fieldKey="auth_name"
                  inputLabel="Name"
                  placeholder="John Deo"
                  @change="changeHandler"
                />
                <hr/>

                <el-form>
                  <el-form-item label="Signature Image Enable" style="display: flex; align-items: center;">
                    <el-switch
                        style="margin-left: 10px"
                        v-model="settings.auth_signature_img_enable"
                        active-value="yes"
                        inactive-value="no"
                        @input="(value) => changeHandler(value, 'auth_signature_img_enable')">
                    </el-switch>
                  </el-form-item>
                </el-form>

                <TextCustomizationFields
                  v-if="settings.auth_signature_img_enable == 'yes'"
                  type="upload"
                  :settings="settings"
                  :fonts="fonts"
                  fieldKey="auth_signature_img"
                  placeholder="John Deo"
                  :fontSizeEnable="false"
                  :fontFamilyEnable="false"
                  :fontWeightEnable="false"
                  :fontColorEnable="false"
                  :widthEnable="true"
                  :heightEnable="true"
                  @change="changeHandler"
                />
               
                <TextCustomizationFields
                  v-if="settings.auth_signature_img_enable === 'no'"
                  type="text"
                  :settings="settings"
                  :fonts="fonts"
                  fieldKey="auth_signature"
                  inputLabel="Signature"
                  placeholder="John"
                  @change="changeHandler"
                />
              </el-collapse-item>

              <el-collapse-item title="Certificate Code" name="6">
                <TextCustomizationFields
                  type="text"
                  :settings="settings"
                  :fonts="fonts"
                  fieldKey="certificate_code"
                  inputLabel="Certificate Code"
                  placeholder="SC26789567"
                  @change="changeHandler"
                />
              </el-collapse-item>

              <el-collapse-item title="QR Code Generate" name="7" v-if="settings.qr_code_enable == 'yes'">
                <TextCustomizationFields
                  type="text"
                  :settings="settings"
                  :fonts="fonts"
                  fieldKey="qr_code_url"
                  inputLabel="QR Code Link"
                  placeholder="link"
                  :disabled="true"
                  :fontSizeEnable="false"
                  :fontFamilyEnable="false"
                  :fontWeightEnable="false"
                  :fontColorEnable="false"
                  :widthEnable="true"
                  :heightEnable="true"
                  @change="changeHandler"
                />
              </el-collapse-item>
            </el-collapse>
          </div>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import ColorSelect from "../../inputComponent/colorSelect.vue";
import PhotoUploader from "../../inputComponent/PhotoUploader";
import TextCustomizationFields from "../../inputComponent/TextCustomizationFields.vue";
import VueQRCode from 'vue-qrcode-component';
import html2canvas from 'html2canvas';
import { jsPDF } from 'jspdf';

export default {
  name: "customizations_component",
  props:[
    'fetching',
    'redesigning',
    'template', 
    'fonts',
    'settings', 
    'certificateCodePrefix', 
    'verifyCertificateUrl'
  ],
  components: {
    TextCustomizationFields,
    ColorSelect,
    PhotoUploader,
    VueQRCode,
  },
  data() {
    return {
      downloading: false,
      activePanel: localStorage.getItem('swiftcm_settings_active_panel') || '1',
      fontColor: "",
      primaryColor: "",
      secondaryColor: "",
      logo: "",
      xOffset: 0,
      debounceTimeout: null,
      uploadCertificateUrl: window.swiftcmAdminVars.upload_certificate_url,
      globalSettings: window.swiftcmAdminVars.globalSettings,
      // New properties for drag & drop
      selectedElement: null,
      dragging: null,
      fontResizing: null,
      imageResizing: null,
      preference: window.swiftcmAdminVars.globalSettings.preference,
      templateOrientation: 'landscape',
      templateNaturalWidth: 0,
      templateNaturalHeight: 0,
      // Editor box limit (UI te eto'r beshi hobe na)
      editorMaxWidth: 1024,
      editorMaxHeight: 700, 
    };
  },
  watch: {
    template: {
      immediate: true,
      deep: true,
      handler() {
        this.$nextTick(async () => {
          try {
            await this.detectTemplateOrientationAndSize();
          } catch (e) {
            // ignore
          }
        });
      }
    },
  },
  computed: {
    // Compute text elements from settings
    textElements() {
      const elements = [];

      // Student name element
      if (this.settings.student_name) {
        elements.push({
          field: 'student_name',
          text: this.settings.student_name,
          x: parseInt(this.settings.student_name_left) || 0,
          y: parseInt(this.settings.student_name_top) || 0,
          fontSize: parseInt(this.settings.student_name_font_size) || 16,
          fontFamily: this.settings.student_name_font_family,
          fontWeight: this.settings.student_name_font_weight || 400,
          color: this.settings.student_name_color,
          align: this.settings.student_name_align || 'center'
        });
      }

      // Course name element
      if (this.settings.course_name) {
        elements.push({
          field: 'course_name',
          text: this.settings.course_name,
          x: parseInt(this.settings.course_name_left) || 0,
          y: parseInt(this.settings.course_name_top) || 0,
          fontSize: parseInt(this.settings.course_name_font_size) || 16,
          fontFamily: this.settings.course_name_font_family,
          fontWeight: this.settings.course_name_font_weight || 400,
          color: this.settings.course_name_color,
          align: this.settings.course_name_align || 'center'
        });
      }

      // Graduation date element
      if (this.settings.graduation_date) {
        elements.push({
          field: 'graduation_date',
          text: this.settings.graduation_date,
          x: parseInt(this.settings.graduation_date_left) || 0,
          y: parseInt(this.settings.graduation_date_top) || 0,
          fontSize: parseInt(this.settings.graduation_date_font_size) || 14,
          fontFamily: this.settings.graduation_date_font_family,
          fontWeight: this.settings.graduation_date_font_weight || 400,
          color: this.settings.graduation_date_color,
          align: this.settings.graduation_date_align || 'center'
        });
      }

      // Certificate code element
      if (this.settings.certificate_code) {
        elements.push({
          field: 'certificate_code',
          text: this.settings.certificate_code,
          x: parseInt(this.settings.certificate_code_left) || 0,
          y: parseInt(this.settings.certificate_code_top) || 0,
          fontSize: parseInt(this.settings.certificate_code_font_size) || 14,
          fontFamily: this.settings.certificate_code_font_family,
          fontWeight: this.settings.certificate_code_font_weight || 400,
          color: this.settings.certificate_code_color,
          align: this.settings.certificate_code_align || 'center'
        });
      }

      // Instructor name (if enabled)
      if (this.settings.instructor_active_signature === 'yes' && this.settings.instructor_name) {
        elements.push({
          field: 'instructor_name',
          text: this.settings.instructor_name,
          x: parseInt(this.settings.instructor_name_left) || 0,
          y: parseInt(this.settings.instructor_name_top) || 0,
          fontSize: parseInt(this.settings.instructor_name_font_size) || 16,
          fontFamily: this.settings.instructor_name_font_family,
          fontWeight: this.settings.instructor_name_font_weight || 400,
          color: this.settings.instructor_name_color,
          align: this.settings.instructor_name_align || 'center'
        });
      }

      // Instructor signature text (if enabled)
      if (this.settings.instructor_signature_img_enable === 'no' &&
          this.settings.instructor_active_signature === 'yes' &&
          this.settings.instructor_signature) {
        elements.push({
          field: 'instructor_signature',
          text: this.settings.instructor_signature,
          x: parseInt(this.settings.instructor_signature_left) || 0,
          y: parseInt(this.settings.instructor_signature_top) || 0,
          fontSize: parseInt(this.settings.instructor_signature_font_size) || 16,
          fontFamily: this.settings.instructor_signature_font_family,
          fontWeight: this.settings.instructor_signature_font_weight || 400,
          color: this.settings.instructor_signature_color,
          align: this.settings.instructor_signature_align || 'center'
        });
      }

      // Secondary name (if enabled)
      if (this.settings.auth_active_signature === 'yes' && this.settings.auth_name) {
        elements.push({
          field: 'auth_name',
          text: this.settings.auth_name,
          x: parseInt(this.settings.auth_name_left) || 0,
          y: parseInt(this.settings.auth_name_top) || 0,
          fontSize: parseInt(this.settings.auth_name_font_size) || 16,
          fontFamily: this.settings.auth_name_font_family,
          fontWeight: this.settings.auth_name_font_weight || 400,
          color: this.settings.auth_name_color,
          align: this.settings.auth_name_align || 'center'
        });
      }

      // Secondary signature text (if enabled)
      if (this.settings.auth_signature_img_enable === 'no' &&
          this.settings.auth_active_signature === 'yes' &&
          this.settings.auth_signature) {
        elements.push({
          field: 'auth_signature',
          text: this.settings.auth_signature,
          x: parseInt(this.settings.auth_signature_left) || 0,
          y: parseInt(this.settings.auth_signature_top) || 0,
          fontSize: parseInt(this.settings.auth_signature_font_size) || 16,
          fontFamily: this.settings.auth_signature_font_family,
          fontWeight: this.settings.auth_signature_font_weight || 400,
          color: this.settings.auth_signature_color,
          align: this.settings.auth_signature_align || 'center'
        });
      }

      return elements;
    },

    // Compute image elements from settings
    imageElements() {
      const elements = [];

      // Auth signature image (if applicable)
      if (this.settings.auth_signature_img_enable === 'yes' &&
          this.settings.auth_active_signature === 'yes' &&
          this.settings.auth_signature_img) {
        elements.push({
          field: 'auth_signature_img',
          url: this.settings.auth_signature_img,
          x: parseInt(this.settings.auth_signature_img_left) || 0,
          y: parseInt(this.settings.auth_signature_img_top) || 0,
          width: parseInt(this.settings.auth_signature_img_width) || 200,
          height: parseInt(this.settings.auth_signature_img_height) || 100
        });
      }

      // Instructor signature image (if applicable)
      if (this.settings.instructor_signature_img_enable === 'yes' &&
          this.settings.instructor_active_signature === 'yes' &&
          this.settings.instructor_signature_img) {
        elements.push({
          field: 'instructor_signature_img',
          url: this.settings.instructor_signature_img,
          x: parseInt(this.settings.instructor_signature_img_left) || 0,
          y: parseInt(this.settings.instructor_signature_img_top) || 0,
          width: parseInt(this.settings.instructor_signature_img_width) || 200,
          height: parseInt(this.settings.instructor_signature_img_height) || 100
        });
      }

      return elements;
    },

    viewTemplateStyle() {
      const natW = this.templateNaturalWidth || 1024;
      const natH = this.templateNaturalHeight || 700;

      const maxW = this.editorMaxWidth;
      const maxH = this.editorMaxHeight;

      const scale = Math.min(maxW / natW, maxH / natH);

      const w = Math.round(natW * scale);
      const h = Math.round(natH * scale);

      return {
        width: w + 'px',
        height: h + 'px',
      };
    },
    renderScale() {
      const natW = this.templateNaturalWidth || 1024;
      const natH = this.templateNaturalHeight || 700;
      const maxW = this.editorMaxWidth;
      const maxH = this.editorMaxHeight;
      return Math.min(maxW / natW, maxH / natH);
    }
  },
  beforeDestroy() {
    // Clean up event listeners
    document.removeEventListener('mousemove', this.handleDrag);
    document.removeEventListener('mousemove', this.handleFontResize);
    document.removeEventListener('mousemove', this.handleImageResize);
    document.removeEventListener('mouseup', this.stopDrag);
    document.removeEventListener('mouseup', this.stopFontResize);
    document.removeEventListener('mouseup', this.stopImageResize);
    document.removeEventListener('click', this.clearSelection);
  },
  methods: {
    emitRedesignCertificate() {
      this.confirmRedesignBox();
    },

    // Your existing methods
    panelChangeHandler(val) {
      localStorage.setItem('swiftcm_settings_active_panel', val);
    },

    changeHandler(val, attr) {
      this.settings[attr] = val;
      this.settings.qr_code_url = this.verifyCertificateUrl + '?code='+ this.settings.certificate_code;
    },

    confirmRedesignBox() {
      this.$confirm('Are you sure you want to redesign the certificate?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning'
      }).then(() => {
        this.$emit('redesignCertificate');
      }).catch(() => {
      });
    },

    getAnchorTransform(align) {
      if (align === 'left') return 'translate(0%, -50%)';
      if (align === 'right') return 'translate(-100%, -50%)';
      return 'translate(-50%, -50%)'; // center (default)
    },

    getElementStyle(element) {
      const s = this.renderScale;
      const align = 'center'; //element.align || 'center';
      const fontFamily = element.fontFamily || 'sans-serif';
      const fontWeight = element.fontWeight || '400';
      
      return {
        position: 'absolute',
        left: `${(element.x || 0) * s}px`,
        top: `${(element.y || 0) * s}px`,
        fontSize: `${(element.fontSize || 16) * s}px`,
        fontFamily,
        fontWeight,
        color: element.color || '#000',
        textAlign: align,
        transform: this.getAnchorTransform(align),
        cursor: 'move',
        lineHeight: 1.2,
        whiteSpace: 'nowrap',
        zIndex: 10,
      };
    },

    getImageStyle(element) {
      const s = this.renderScale;
      return {
        position: 'absolute',
        left: `${(element.x || 0) * s}px`,
        top: `${(element.y || 0) * s}px`,
        width: `${(element.width || 200) * s}px`,
        height: `${(element.height || 100) * s}px`,
        transform: 'translate(-50%, -50%)',
        cursor: 'move',
        zIndex: 10
      };
    },

    getQrCodeStyle() {
      const s = this.renderScale;
      const x = parseInt(this.settings.qr_code_url_left) || 0;
      const y = parseInt(this.settings.qr_code_url_top) || 0;
      const w = parseInt(this.settings.qr_code_url_width) || 150;
      const h = parseInt(this.settings.qr_code_url_height) || 150;

      return {
        position: 'absolute',
        left: `${x * s}px`,
        top: `${y * s}px`,
        width: `${w * s}px`,
        height: `${h * s}px`,
        transform: 'translate(-50%, -50%)',
        cursor: 'move',
        zIndex: 10,
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
      };
    },

    getElementImageStyle(element) {
      return {
        width: '100%',
        height: '100%',
        objectFit: 'contain',
        pointerEvents: 'none' // Prevents the image from capturing events
      };
    },

    selectElement(field) {
      this.selectedElement = field;
      // Update the activePanel to match the selected element type
      switch(field) {
        case 'student_name':
          this.activePanel = '1';
          break;
        case 'course_name':
          this.activePanel = '2';
          break;
        case 'graduation_date':
          this.activePanel = '3';
          break;
        case 'instructor_name':
        case 'instructor_signature':
        case 'instructor_signature_img':
          this.activePanel = '4';
          break;
        case 'auth_name':
        case 'auth_signature':
        case 'auth_signature_img':
          this.activePanel = '5';
          break;
        case 'certificate_code':
          this.activePanel = '6';
          break;
        case 'qr_code_url':
          this.activePanel = '7';
          break;
      }
    },

    clearSelection(event) {
      if (event.target.closest('.view-template') &&
          !event.target.closest('.certificate-element')) {
        this.selectedElement = null;
      }
    },

    startDrag(event, element) {
      this.dragging = {
        element: element,
        field: element.field,
        startX: event.clientX,
        startY: event.clientY,
        originalX: element.x,
        originalY: element.y
      };

      this.selectElement(element.field);
      event.preventDefault();
    },

    handleDrag(event) {
      if (!this.dragging) return;

      const s = this.renderScale;

      const dx = (event.clientX - this.dragging.startX) / s;
      const dy = (event.clientY - this.dragging.startY) / s;

      const newX = this.dragging.originalX + dx;
      const newY = this.dragging.originalY + dy;

      this.settings[this.dragging.field + '_left'] = Math.round(newX).toString();
      this.settings[this.dragging.field + '_top']  = Math.round(newY).toString();
    },

    stopDrag() {
      if (this.dragging) {
        // After dragging completes, save the changes
        this.dragging = null;
      }
    },

    startFontResize(event, element) {
      this.fontResizing = {
        element: element,
        field: element.field,
        startY: event.clientY,
        originalFontSize: element.fontSize
      };

      event.stopPropagation();
    },

    handleFontResize(event) {
      if (!this.fontResizing) return;

      const s = this.renderScale;

      const dy = (this.fontResizing.startY - event.clientY) / s;
      const newSize = Math.max(8, Math.min(200, this.fontResizing.originalFontSize + Math.round(dy / 2)));

      this.settings[this.fontResizing.field + '_font_size'] = newSize.toString();
    },

    stopFontResize() {
      if (this.fontResizing) {
        this.fontResizing = null;
      }
    },

    startResizeImage(event, element, handle) {
      this.imageResizing = {
        element: element,
        field: element.field,
        handle: handle,
        startX: event.clientX,
        startY: event.clientY,
        originalX: element.x,
        originalY: element.y,
        originalWidth: element.width,
        originalHeight: element.height
      };

      event.stopPropagation();
    },

    handleImageResize(event) {
      if (!this.imageResizing) return;

      const s = this.renderScale;
      const dx = (event.clientX - this.imageResizing.startX) / s;
      const dy = (event.clientY - this.imageResizing.startY) / s;

      let newWidth, newHeight, newX, newY;

      // Calculate new dimensions based on the handle being dragged
      switch(this.imageResizing.handle) {
        case 'top-left':
          newWidth = Math.max(50, this.imageResizing.originalWidth - dx);
          newHeight = Math.max(50, this.imageResizing.originalHeight - dy);
          newX = this.imageResizing.originalX - (newWidth - this.imageResizing.originalWidth) / 2;
          newY = this.imageResizing.originalY - (newHeight - this.imageResizing.originalHeight) / 2;
          break;
        case 'top-right':
          newWidth = Math.max(50, this.imageResizing.originalWidth + dx);
          newHeight = Math.max(50, this.imageResizing.originalHeight - dy);
          newX = this.imageResizing.originalX + (newWidth - this.imageResizing.originalWidth) / 2;
          newY = this.imageResizing.originalY - (newHeight - this.imageResizing.originalHeight) / 2;
          break;
        case 'bottom-left':
          newWidth = Math.max(50, this.imageResizing.originalWidth - dx);
          newHeight = Math.max(50, this.imageResizing.originalHeight + dy);
          newX = this.imageResizing.originalX - (newWidth - this.imageResizing.originalWidth) / 2;
          newY = this.imageResizing.originalY + (newHeight - this.imageResizing.originalHeight) / 2;
          break;
        case 'bottom-right':
        default:
          newWidth = Math.max(50, this.imageResizing.originalWidth + dx);
          newHeight = Math.max(50, this.imageResizing.originalHeight + dy);
          newX = this.imageResizing.originalX + (newWidth - this.imageResizing.originalWidth) / 2;
          newY = this.imageResizing.originalY + (newHeight - this.imageResizing.originalHeight) / 2;
          break;
      }

      // Update image dimensions and position in settings
      this.settings[this.imageResizing.field + '_left'] = newX.toString();
      this.settings[this.imageResizing.field + '_top'] = newY.toString();
      this.settings[this.imageResizing.field + '_width'] = newWidth.toString();
      this.settings[this.imageResizing.field + '_height'] = newHeight.toString();
    },

    stopImageResize() {
      if (this.imageResizing) {
        this.imageResizing = null;
      }
    },

    async downloadCertificate() {
      const element = document.getElementById('view-template');
      if (!element) return;

      this.downloading = true;
      let loading = null;

      try {
        // ✅ temporarily hide selectors for export only
        element.classList.add("is-exporting");

        loading = this.$loading({
          fullscreen: true,
          text: 'Downloading Certificate....',
          spinner: 'el-icon-loading',
          background: 'rgba(0, 0, 0, 0.7)',
          customClass: 'swiftcm-text-loading'
        });

        // ✅ ensure template orientation & size is ready
        try {
          await this.detectTemplateOrientationAndSize();
        } catch (e) {}

        // ✅ wait for images inside template (signature etc)
        await this.waitForImagesInside(element);

        // ✅ IMPORTANT: use scale 4 for clear export
        const canvas = await html2canvas(element, {
          scale: window.devicePixelRatio * 2,
          useCORS: true,
          backgroundColor: null,
          imageTimeout: 20000,
        });

        const imgData = canvas.toDataURL('image/png', 1.0);

        const pdf = new jsPDF({
          orientation: this.templateOrientation, // 'portrait' or 'landscape'
          unit: 'mm',
          format: 'a4',
          compress: true
        });

        const pageW = pdf.internal.pageSize.getWidth();
        const pageH = pdf.internal.pageSize.getHeight();

        // ✅ full page fit
        pdf.addImage(imgData, 'PNG', 0, 0, pageW, pageH);

        pdf.save(this.generateFilename());
      } catch (error) {
        console.error('PDF generation failed:', error);
        this.$message && this.$message.error('PDF download failed. Please try again.');
      } finally {
        // ✅ bring back selector after export
        element.classList.remove("is-exporting");
        if (loading) loading.close();
        this.downloading = false;
      }
    },

    generateFilename() {
      const rawStudentName = this.settings.student_name || 'certificate';
      const formattedStudentName = rawStudentName
          .toLowerCase()
          .replace(/\s+/g, '-')
          .replace(/[^\w\-]/g, '')
          .replace(/\-{2,}/g, '-')
          .replace(/^\-+|\-+$/g, '');
      // const now = new Date();
      // const month = (now.getMonth() + 1).toString().padStart(2, '0');
      // const date = now.getDate().toString().padStart(2, '0');
      // const year = now.getFullYear().toString().slice(-2);
      // const seconds = now.getSeconds().toString().padStart(2, '0');
      // -${year}${month}${date}${seconds}

      return `${formattedStudentName}-${this.settings.certificate_code}.pdf`;
    },

    async detectTemplateOrientationAndSize() {
      if (!this.template || !this.template.template_image) return;

      const src = this.uploadCertificateUrl + this.template.template_image;

      await new Promise((resolve, reject) => {
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = () => {
          this.templateNaturalWidth = img.naturalWidth || img.width;
          this.templateNaturalHeight = img.naturalHeight || img.height;

          this.templateOrientation =
            this.templateNaturalWidth > this.templateNaturalHeight
              ? 'landscape'
              : 'portrait';

          resolve();
        };
        img.onerror = reject;
        img.src = src;
      });
    },

    async waitForImagesInside(el) {
      const imgs = Array.from(el.querySelectorAll('img'));
      await Promise.all(
        imgs.map((img) => {
          if (img.complete && img.naturalWidth) return Promise.resolve();
          return new Promise((resolve) => {
            img.onload = resolve;
            img.onerror = resolve; // fail হলেও continue
          });
        })
      );
    },
  },

  beforeMount() {
    if (this.appVars && this.appVars.is_onboarded === 'no') {
      this.$router.push(
          {
            name: 'setup_template',
            params: {}
          }
      )
    }
  },
  mounted() {
    // Existing mounted methods
    // Add event listeners for drag and resize
    document.addEventListener('mousemove', this.handleDrag);
    document.addEventListener('mousemove', this.handleFontResize);
    document.addEventListener('mousemove', this.handleImageResize);
    document.addEventListener('mouseup', this.stopDrag);
    document.addEventListener('mouseup', this.stopFontResize);
    document.addEventListener('mouseup', this.stopImageResize);
    document.addEventListener('click', this.clearSelection);
  },
};
</script>
<!-- ***
 it's help for developer
 Note: Primary Singnature means: instructor, Secondary Singnature means: auth
** -->