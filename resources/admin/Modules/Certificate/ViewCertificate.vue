<template>
  <div class="swiftcm-view-certificate-wrapper">
    <div class="title header">
      <h1>View {{ statusTitle }} Certificate</h1>
      <div class="fetch-certificate" style="text-align:right;">
        <el-button class="capsule-btn" icon="el-icon-edit" round @click="gotoEdit">Edit Certification Info</el-button>
        <el-button class="capsule-btn" icon="el-icon-edit" round @click="gotoEditCustomizationCertificate">Customize Certificate</el-button>
        <el-button class="capsule-btn" :loading="saving" icon="el-icon-refresh" round @click="updateHandler">
          Fetch Certificate
        </el-button>

        <el-button
          v-if="payment_transaction"
          round
          :type="getButtonType(payment_transaction.payment_status)"
          @click="gotoPaymentTransaction(payment_transaction.id)"
        >
          {{ formatStatus(payment_transaction.payment_status) }}
        </el-button>
        <el-button v-else round type="info">Free</el-button>
      </div>
    </div>
    <el-row>
      <el-col :span="24" class="pro-template">
        <div class="swiftcm-certificate-preview" v-loading="fetching">
          <!-- ✅ Preview box (fit into 1024x700 like Customization) -->
          <div class="certificate-outer-container">
            <div
              id="view-template"
              class="view-template"
              :style="viewTemplateStyle"
            >
              <!-- ✅ background as <img> -->
              <img
                v-if="templateImageSrc"
                :src="templateImageSrc"
                class="certificate-bg"
                alt="certificate background"
              />

              <div class="elements-container">
                <!-- Text -->
                <div
                  v-for="el in textElements"
                  :key="el.field"
                  class="certificate-element"
                  :style="getElementStyle(el)"
                >
                  {{ el.text }}
                </div>

                <!-- Images -->
                <div
                  v-for="el in imageElements"
                  :key="el.field"
                  class="certificate-element image-element"
                  :style="getImageStyle(el)"
                >
                  <img
                    :src="el.url || ''"
                    class="element-image"
                    :style="getElementImageStyle()"
                  />
                </div>

                <!-- QR -->
                <div
                  v-if="settings.qr_code_enable === 'yes'"
                  class="certificate-element qr-element"
                  :style="getQrCodeStyle()"
                >
                  <VueQRCode
                    :text="info.qr_code_url || ''"
                    :size="parseInt(settings.qr_code_url_width) || 150"
                    class="qr-code-image"
                  />
                </div>
              </div>
            </div>
          </div>
          <!-- v-if="info.status != 'draft'" -->
          <div class="footer-buttons">
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

            <el-button
              class="capsule-btn"
              icon="el-icon-message"
              round
              :loading="emailing"
              @click="sendEmailCertificate"
            >
              Email Certificate
            </el-button>
          </div>
        </div>
      </el-col>
    </el-row>

    <UpgradePopup 
      :upgradePopupVisible="upgradePopupVisible"
      @close="upgradePopupVisible = false"
    />
  </div>
</template>

<script>
import html2canvas from "html2canvas";
import { jsPDF } from "jspdf";
import VueQRCode from "vue-qrcode-component";
import UpgradePopup from '../Components/UpgradePopup.vue';
export default {
  name: "ViewCertificate",
  components: { 
    VueQRCode,
    UpgradePopup 
  },

  data() {
    return {
      fetching: false,
      saving: false,
      downloading: false,
      emailing: false,
      infoId: parseInt(this.$route.params.info_id),
      info: {},
      settings: {
        instructor_active_signature: "no",
        auth_active_signature: "no",
        qr_code_enable: "no",
      },
      payment_transaction: null,
      uploadCertificateUrl: window.swiftcmAdminVars.upload_certificate_url,
      globalSettings: window.swiftcmAdminVars.globalSettings,
      // ✅ preview box size (same as customization)
      editorMaxWidth: 1024,
      editorMaxHeight: 700,
      // ✅ template natural px
      templateNaturalWidth: 1024,
      templateNaturalHeight: 700,
      templateOrientation: "landscape",
      statusTitle: "",
      upgradePopupVisible: false,
      hasPro: !!window.swiftcmAdminVars.has_pro
    };
  },

  computed: {
    templateImageSrc() {
      if (!this.settings || !this.settings.slug) return "";
      return this.uploadCertificateUrl + this.settings.slug + ".png";
    },

    renderScale() {
      const natW = this.templateNaturalWidth || 1024;
      const natH = this.templateNaturalHeight || 700;
      return Math.min(this.editorMaxWidth / natW, this.editorMaxHeight / natH);
    },

    viewTemplateStyle() {
      const natW = this.templateNaturalWidth || 1024;
      const natH = this.templateNaturalHeight || 700;
      const s = this.renderScale;

      return {
        width: Math.round(natW * s) + "px",
        height: Math.round(natH * s) + "px",
      };
    },

    textElements() {
      const el = [];

      // dynamic info texts
      if (this.info.student_name) el.push(this.makeText("student_name", this.info.student_name));
      if (this.info.course_name) el.push(this.makeText("course_name", this.info.course_name));
      if (this.info.graduation_date) el.push(this.makeText("graduation_date", this.info.graduation_date));
      if (this.info.certificate_code) el.push(this.makeText("certificate_code", this.info.certificate_code));

      // Primary(instructor) name and Singnature
      if (this.settings.instructor_active_signature === "yes" && this.settings.instructor_name) {
        el.push(this.makeText("instructor_name", this.settings.instructor_name));
      }
      if (
        this.settings.instructor_signature_img_enable === 'no' &&
        this.settings.instructor_active_signature === 'yes' &&
        this.settings.instructor_signature
      ) {
        el.push(this.makeText("instructor_signature", this.settings.instructor_signature));
      }

      // Secondary(auth) name and signature 
      if (this.settings.auth_active_signature === "yes" && this.settings.auth_name) {
        el.push(this.makeText("auth_name", this.settings.auth_name));
      }
      if (
        this.settings.auth_signature_img_enable === "no" &&
        this.settings.auth_active_signature === "yes" &&
        this.settings.auth_signature
      ) {
        el.push(this.makeText("auth_signature", this.settings.auth_signature));
      }

      return el;
    },

    imageElements() {
      const el = [];

      if (
        this.settings.auth_signature_img_enable === "yes" &&
        this.settings.auth_active_signature === "yes" &&
        this.settings.auth_signature_img
      ) {
        el.push(this.makeImage("auth_signature_img", this.settings.auth_signature_img));
      }

      if (
        this.settings.instructor_signature_img_enable === "yes" &&
        this.settings.instructor_active_signature === "yes" &&
        this.settings.instructor_signature_img
      ) {
        el.push(this.makeImage("instructor_signature_img", this.settings.instructor_signature_img));
      }

      return el;
    },
  },

  methods: {
    // ---------- Builders ----------
    makeText(field, text) {
      return {
        field,
        text,
        x: parseFloat(this.settings[field + "_left"]) || 0,
        y: parseFloat(this.settings[field + "_top"]) || 0,
        fontSize:
          parseFloat(this.settings[field + "_font_size"]) ||
          (field === "student_name" ? 16 : 14),
        fontFamily: this.settings[field + "_font_family"],
        color: this.settings[field + "_color"],
        align: this.settings[field + "_align"] || "center",
      };
    },

    makeImage(field, url) {
      return {
        field,
        url,
        x: parseFloat(this.settings[field + "_left"]) || 0,
        y: parseFloat(this.settings[field + "_top"]) || 0,
        width: parseFloat(this.settings[field + "_width"]) || 200,
        height: parseFloat(this.settings[field + "_height"]) || 100,
      };
    },

    // ---------- UI helpers ----------
    formatStatus(status) {
      const s = (status || "").toString();
      return s.charAt(0).toUpperCase() + s.slice(1);
    },

    getButtonType(status) {
      const s = (status || "").toLowerCase();
      if (s === "paid") return "success";
      if (s === "pending") return "warning";
      if (s === "failed") return "danger";
      if (s === "processing") return "info";
      return "default";
    },

    getAnchorTransform(align) {
      if (align === "left") return "translate(0%, -50%)";
      if (align === "right") return "translate(-100%, -50%)";
      return "translate(-50%, -50%)";
    },

    getElementStyle(element) {
      const s = this.renderScale || 1;
      const align = "center"; //element.align || "center";
      const fontFamily = element.fontFamily || "sans-serif";

      return {
        position: "absolute",
        left: `${(element.x || 0) * s}px`,
        top: `${(element.y || 0) * s}px`,
        fontSize: `${(element.fontSize || 16) * s}px`,
        fontFamily,
        color: element.color || "#000",
        textAlign: align,
        transform: this.getAnchorTransform(align),
        lineHeight: 1.2,
        whiteSpace: "nowrap",
        zIndex: 10,
      };
    },

    getImageStyle(element) {
      const s = this.renderScale || 1;
      return {
        position: "absolute",
        left: `${(element.x || 0) * s}px`,
        top: `${(element.y || 0) * s}px`,
        width: `${(element.width || 200) * s}px`,
        height: `${(element.height || 100) * s}px`,
        transform: "translate(-50%, -50%)",
        zIndex: 10,
      };
    },

    getQrCodeStyle() {
      const s = this.renderScale || 1;
      return {
        position: "absolute",
        left: `${(parseFloat(this.settings.qr_code_url_left) || 0) * s}px`,
        top: `${(parseFloat(this.settings.qr_code_url_top) || 0) * s}px`,
        width: `${(parseFloat(this.settings.qr_code_url_width) || 150) * s}px`,
        height: `${(parseFloat(this.settings.qr_code_url_height) || 150) * s}px`,
        transform: "translate(-50%, -50%)",
        zIndex: 10,
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        background: "#fff",
      };
    },

    getElementImageStyle() {
      return {
        width: "100%",
        height: "100%",
        objectFit: "contain",
        pointerEvents: "none",
      };
    },

    // ---------- Data fetch ----------
    fetchInfo() {
      this.fetching = true;

      this.$get({
        action: "swiftcm_generate_admin_ajax",
        route: "get_certificate_info",
        info_id: this.infoId,
        nonce: window.swiftcmAdminVars.nonce,
      })
        .then(async (response) => {
          this.info = response.data.info || {};
          this.statusTitle = this.info.status.charAt(0).toUpperCase() + this.info.status.slice(1);

          this.payment_transaction = this.info.payment_transaction || null;

          // settings json from info (this contains slug + positions)
          this.settings = jQuery.parseJSON(this.info.settings || "{}") || {};

          // qr link
          if (this.settings.qr_code_enable === "yes") {
            const verify = this.globalSettings.verify_certificate_url || "https://example.com/";
            // const prefix = this.globalSettings.certificate_code_prefix || "";
            this.info.qr_code_url = verify + "?code=" + (this.info.certificate_code || "");
          } else {
            this.info.qr_code_url = "";
          }

          // detect natural size from bg image
          await this.detectTemplateOrientationAndSize();
        })
        .fail((error) => {
          this.$handleError(error);
        })
        .always(() => {
            setTimeout(() => {
                 this.fetching = false;
            }, 500);
        });
    },

    gotoEdit() {
      if (!this.hasPro) {
        this.upgradePopupVisible = true;
        return;
      } 
      this.$router.push({ 
        name: "update_info",
        params: { 
          info_id: this.infoId
        }
      });  
    },

    gotoEditCustomizationCertificate() {
      if (!this.hasPro) {
        this.upgradePopupVisible = true;
        return;
      } 
      this.$router.push({ 
        name: "edit_certificate_customizations",
        params: { 
          info_id: this.infoId
        } 
      });
    },

    updateHandler() {
      this.saving = true;
      this.$post({
        action: "swiftcm_generate_admin_ajax",
        route: "update_certificate_info",
        info: this.info,
        info_id: this.infoId,
        nonce: window.swiftcmAdminVars.nonce,
      })
        .then(() => {
          this.fetchInfo();
          this.$notify({ type: "success", title: "Success", message: this.$t("Fetch Certificate") });
        })
        .fail((error) => this.$handleError(error))
        .always(() => (this.saving = false));
    },

    gotoPaymentTransaction(id) {
      this.$router.push({ name: "view_transaction", params: { transaction_id: id } });
    },

    // ---------- Export helpers ----------
    async detectTemplateOrientationAndSize() {
      if (!this.templateImageSrc) return;

      await new Promise((resolve) => {
        const img = new Image();
        img.crossOrigin = "anonymous";
        img.onload = () => {
          this.templateNaturalWidth = img.naturalWidth || img.width || 1024;
          this.templateNaturalHeight = img.naturalHeight || img.height || 700;
          this.templateOrientation =
            this.templateNaturalWidth > this.templateNaturalHeight ? "landscape" : "portrait";
          resolve();
        };
        img.onerror = () => resolve();
        img.src = this.templateImageSrc;
      });
    },

    async waitForImagesInside(el) {
      const imgs = Array.from(el.querySelectorAll("img"));
      await Promise.all(
        imgs.map((img) => {
          if (img.complete && img.naturalWidth) return Promise.resolve();
          return new Promise((resolve) => {
            img.onload = resolve;
            img.onerror = resolve;
          });
        })
      );
    },

    async renderCanvasForExport(element) {
      if (document.fonts && document.fonts.ready) {
        try { await document.fonts.ready; } catch (e) {}
      }

      await this.waitForImagesInside(element);

      return html2canvas(element, {
        scale: window.devicePixelRatio * 2,
        useCORS: true,
        backgroundColor: null,
        imageTimeout: 20000,
      });
    },

    generateFilename() {
      const rawStudentName = this.info.student_name || "certificate";
      const formatted = rawStudentName
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]/g, "")
        .replace(/\-{2,}/g, "-")
        .replace(/^\-+|\-+$/g, "");
      return `${formatted}-${this.info.certificate_code || "code"}.pdf`;
    },

    // ---------- Download ----------
    async downloadCertificate() {
      const element = document.getElementById("view-template");
      if (!element) return;

      this.downloading = true;
      let loading = null;

      try {
        element.classList.add("is-exporting");

        loading = this.$loading({
          fullscreen: true,
          text: "Downloading Certificate....",
          spinner: "el-icon-loading",
          background: "rgba(0, 0, 0, 0.7)",
          customClass: "swiftcm-text-loading",
        });

        await this.detectTemplateOrientationAndSize();

        const canvas = await this.renderCanvasForExport(element);
        const imgData = canvas.toDataURL("image/png", 1.0);

        const pdf = new jsPDF({
          orientation: this.templateOrientation,
          unit: "mm",
          format: "a4",
          compress: true,
        });

        const pageW = pdf.internal.pageSize.getWidth();
        const pageH = pdf.internal.pageSize.getHeight();

        pdf.addImage(imgData, "PNG", 0, 0, pageW, pageH);
        pdf.save(this.generateFilename());
      } catch (e) {
        console.error(e);
        this.$message && this.$message.error("PDF download failed. Please try again.");
      } finally {
        element.classList.remove("is-exporting");
        if (loading) loading.close();
        this.downloading = false;
      }
    },

    async sendEmailCertificate() {
      if (!this.hasPro) {
        this.upgradePopupVisible = true;
        return;
      } 

      const element = document.getElementById("view-template");
      if (!element) return;

      this.emailing = true;
      let loading = null;

      element.classList.add("is-exporting");

      loading = this.$loading({
        fullscreen: true,
        text: "Certificate email is being processed...",
        spinner: "el-icon-loading",
        background: "rgba(0, 0, 0, 0.7)",
        customClass: "swiftcm-text-loading",
      });

      await this.detectTemplateOrientationAndSize();
      const canvas = await this.renderCanvasForExport(element);
      const imageData = canvas.toDataURL("image/png", 1.0);

      this.$post({
        action: "swiftcm_generate_admin_ajax",
        route: "sending_email_certificate",
        info: this.info,
        certificate_data: imageData,
        nonce: window.swiftcmAdminVars.nonce,
      })
        .then((response) => {
          if (response.success === true) {
             this.$handleSuccess(response.data.message);
          } else {
              this.$handleError(response.data.message);
          }
        })
        .fail((error) => {
          this.$handleError(error);
        })
        .always(() => {
          element.classList.remove("is-exporting");
          if (loading) loading.close();
          this.emailing = false;
        });
    },
  },

  mounted() {
    this.fetchInfo();  
    jQuery('head title').text('View Certificate - Swift Certificate Manager');
  },
};
</script>