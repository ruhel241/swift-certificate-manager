<template>
    <div class="upgrade-to-popup-wrapper">
        <!-- Dialog -->
        <el-dialog
            width="70%"
            custom-class="upgrade-dialog"
            :visible="upgradePopupVisible"
            @close="closePopup"
        >
        <div class="upgrade-card">
            <div class="swiftcm-upgrade-header">
                <!-- LEFT -->
                <div class="upgrade-left">
                    <span class="badge">PRO</span>
                    <h1>
                        Upgrade to Pro for <br>
                        <span>powerful certificate <br/>management</span>
                    </h1>
                    <p>
                        Unlock premium tools to customize certificates,
                        manage records faster, and create a smoother experience 
                        for your learners and customers
                    </p>
                </div>
                <!-- RIGHT -->
                <div class="upgrade-right">
                    <img :src="imageUrl+'/upgrade-customize-certificate.png'" />
                </div>
            </div>
        
            <div class="swiftcm-upgrade-footer">
                <div class="features-section">
                    <span> Everything you need to work smarter</span>
                    <div class="features">
                        <ul>
                            <li><i class="el-icon-success"></i> Edit certification info</li>
                            <li><i class="el-icon-success"></i> Customize certificates</li>
                            <li><i class="el-icon-success"></i> Email certificates instantly</li>
                        </ul>
                        <ul>
                            <li><i class="el-icon-success"></i> Edit, delete & export CSV</li>
                            <li><i class="el-icon-success"></i> Upload your signature</li>
                            <li><i class="el-icon-success"></i> Enable payment methods</li>
                        </ul>
                        <ul>
                            <li><i class="el-icon-success"></i> Order customized certificates</li>
                            <li><i class="el-icon-success"></i> Advanced settings tools</li>
                            <li><i class="el-icon-success"></i> Faster premium support</li>
                        </ul>
                    </div>
                </div>
                
                <div class="actions">
                    <a href="https://swiftcertificate.com/" type="button" class="btn-primary el-button el-button--primary" target="_blank">
                    👑 Upgrade To PRO
                    </a>

                    <a href="https://swiftcertificate.com/pricing/" type="button" class="el-button btn-secondary el-button--default">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
        </el-dialog>
    </div>
</template>

<script>
export default {
  name: 'upgrade-popup',
  props: {
    upgradePopupVisible: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
        imageUrl: window.swiftcmAdminVars.images_url,
    }
  },

  methods: {
    closePopup() {
      this.$emit('close');
    }
  }
}
</script>