<template>
  <div class="scm-transaction-details-page">
    <!-- Header with navigation -->
    <div class="page-header">
      <el-page-header @back="gobackPaymentTransaction" content="Transaction Details"></el-page-header>
    </div>

    <!-- Transaction Content -->
    <div v-loading="loading" class="transaction-content">
      <template v-if="transaction">
        <div class="transaction-receipt">
          <div class="status-banner" :class="{'status-paid': transaction.payment_status === 'paid', 'status-pending': transaction.payment_status === 'pending'}">
            <div class="status-info">
              <i class="el-icon-check" v-if="transaction.payment_status === 'paid'"></i>
              <i class="el-icon-time" v-if="transaction.payment_status === 'pending'"></i>
              {{ transaction.payment_status === 'paid' ? 'Payment Successful' : 'Payment Pending' }}
            </div>

            <div class="scm-status-actions">
              <el-popover
                placement="bottom"
                width="300"
                v-model="statusPopoverVisible"
                trigger="click">
                <div class="scm-status-edit-form">
                  <h4>Update Payment Status</h4>
                  <el-form label-position="top">
                    <el-form-item>
                      <el-select v-model="editStatus" placeholder="Select Status" style="width: 100%">
                        <el-option label="Paid" value="paid"></el-option>
                        <el-option label="Pending" value="pending"></el-option>
                      </el-select>
                    </el-form-item>

                    <div class="status-form-actions">
                      <el-button size="small" @click="statusPopoverVisible = false">Cancel</el-button>
                      <el-button size="small" type="primary" :loading="updatingStatus" @click="updateTransactionStatus">
                        Update
                      </el-button>
                    </div>

                  </el-form>
                </div>
                <el-button slot="reference" size="small" type="text" icon="el-icon-edit" style="border: none">
                  Change Status
                </el-button>
              </el-popover>
            </div>
          </div>

          <!-- Transaction Details Card -->
          <el-card class="transaction-card">
            <div slot="header" class="card-header">
              <span>Transaction #{{ transaction.id }}</span>
              <el-tag size="small" effect="plain" :type="transaction.payment_status === 'paid' ? 'success' : 'warning'">
                {{ transaction.payment_status.charAt(0).toUpperCase() + transaction.payment_status.slice(1) }}
              </el-tag>
            </div>

            <div class="transaction-meta">
              <div class="meta-item">
                <i class="el-icon-date"></i>
                <span class="label">Date:</span>
                <span class="value">{{ transaction.updated_at }}</span>
              </div>
              <div class="meta-item">
                <i class="el-icon-money"></i>
                <span class="label">Amount:</span>
                <span class="value amount">{{ transaction.currency.toUpperCase() }} {{ (transaction.payment_total / 100).toFixed(2) }}</span>
              </div>
              <div class="meta-item">
                <i class="el-icon-bank-card"></i>
                <span class="label">Payment Method:</span>
                <span class="value">
                  <img :src="images_url + 'stripe.svg'" alt="Stripe" v-if="transaction.payment_method === 'stripe'" class="payment-icon">
                  <img :src="images_url + 'PayPal.svg'" alt="PayPal" v-if="transaction.payment_method === 'paypal'" class="payment-icon">
                </span>
              </div>
              <div class="meta-item" v-if="transaction.payment_mode">
                <i class="el-icon-s-operation"></i>
                <span class="label">Mode:</span>
                <span class="value">{{ transaction.payment_mode }}</span>
              </div>
            </div>
          </el-card>

          <!-- Main Content Tabs -->
          <el-tabs type="border-card" class="details-tabs">
            <el-tab-pane label="Details">
              <!-- Student & Course Details -->
              <el-row :gutter="20">
                <el-col :xs="24" :sm="12">
                  <el-card shadow="hover" class="detail-card">
                    <div slot="header">
                      <i class="el-icon-user"></i> Student Information
                    </div>
                    <div class="detail-list">
                      <div class="detail-item">
                        <span class="detail-label">Name:</span>
                        <span class="detail-value">{{ transaction.get_info.student_name }}</span>
                      </div>
                      <div class="detail-item">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">{{ transaction.get_info.student_email }}</span>
                      </div>
                      <div class="detail-item">
                        <span class="detail-label">Certificate Code:</span>
                        <span class="detail-value code">{{ transaction.get_info.certificate_code }}</span>
                      </div>
                    </div>
                  </el-card>
                </el-col>

                <el-col :xs="24" :sm="12">
                  <el-card shadow="hover" class="detail-card">
                    <div slot="header">
                      <i class="el-icon-reading"></i> Course Details
                    </div>
                    <div class="detail-list">
                      <div class="detail-item">
                        <span class="detail-label">Course:</span>
                        <span class="detail-value">{{ transaction.get_info.course_name }}</span>
                      </div>
                      <div class="detail-item">
                        <span class="detail-label">Graduation Date:</span>
                        <span class="detail-value">{{ formatDate(transaction.get_info.graduation_date) }}</span>
                      </div>
                    </div>
                  </el-card>
                </el-col>
              </el-row>

               <!-- {{ transaction }} -->

              <!-- Payment Details -->
              <el-card shadow="hover" class="detail-card payment-card">
                <div slot="header">
                  <i class="el-icon-bank-card"></i> Payment Details
                </div>
                <el-row :gutter="20">
                  <el-col :xs="24" :sm="12">
                    <div class="detail-list">
                      <div class="detail-item" v-if="transaction.card_brand">
                        <span class="detail-label">Card Type:</span>
                        <span class="detail-value">{{ transaction.card_brand }}</span>
                      </div>
                      <div class="detail-item" v-if="transaction.card_last_4">
                        <span class="detail-label">Card Number:</span>
                        <span class="detail-value">**** **** **** {{ transaction.card_last_4 }}</span>
                      </div>
                      <div class="detail-item">
                        <span class="detail-label">Transaction ID:</span>
                        <span class="detail-value small">
                          <div class="transaction" v-if="transaction.payment_method === 'stripe'">
                            <div v-if="transaction.payment_mode === 'test'">
                              <a
                                :href="'https://dashboard.stripe.com/test/payments/' + transaction.charge_id"
                                target="_blank"
                                style="text-decoration: none; color: #409EFF;"
                              >
                                {{ transaction.charge_id }}
                              </a>
                            </div>
                            <div v-else>
                              <a
                                :href="'https://dashboard.stripe.com/payments/' + transaction.charge_id"
                                target="_blank"
                                style="text-decoration: none"
                              >
                                {{ transaction.charge_id }}
                              </a>
                            </div>
                          </div>

                          <div class="transaction" v-else-if="transaction.payment_method === 'paypal'">
                            <div class="copy" :data-clipboard-text="getCopyText(transaction.charge_id)" style="color:#409EFF">{{ transaction.charge_id }}</div>
                          </div>
                        </span>
                      </div>
                      <div class="detail-item">
                        <span class="detail-label">Reference:</span>
                        <span class="detail-value small">{{ transaction.entry_hash }}</span>
                      </div>
                    </div>
                  </el-col>

                  <el-col :xs="24" :sm="12">
                    <div class="payment-summary">
                      <div class="payment-amount">
                        <div class="amount-label">Total Paid</div>
                        <div class="amount-value">{{ transaction.currency.toUpperCase() }} {{ (transaction.payment_total / 100).toFixed(2) }}</div>
                      </div>
                      <div class="payment-date">
                        <div class="date-label">Payment Date</div>
                        <div class="date-value">{{ formatDate(transaction.created_at) }}</div>
                      </div>
                    </div>
                  </el-col>
                </el-row>
              </el-card>
            </el-tab-pane>

            <el-tab-pane label="JSON Data" v-if="transaction.payment_note">
              <div class="json-viewer">
                <pre>{{ formatJSON(transaction.payment_note) }}</pre>
              </div>
            </el-tab-pane>
          </el-tabs>

          <!-- Action Buttons -->
          <div class="action-buttons">
            <el-button class="capsule-btn" round icon="el-icon-back" @click="gobackPaymentTransaction">Back to Transactions</el-button>
            <el-button class="scm-primary-btn" type="success" icon="el-icon-view" @click="getoViewCertificate(transaction.get_info.id)">View Request Certificate</el-button>
          </div>
        </div>
      </template>

      <el-empty description="Transaction not found" v-else></el-empty>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      transaction: null,
      images_url: window.SwiftCertificateManagerAdminVars.images_url,
      statusPopoverVisible: false,
      editStatus: '',
      updatingStatus: false
    }
  },

  methods: {
    getoViewCertificate(id) {
      this.$router.push({
        name: "view_certificate",
        params: {
          info_id: id,
        },
      });
    },
    gobackPaymentTransaction() {
      this.$router.push({
        name: "settings"
      });
    },
    fetchTransactionDetails() {
      this.loading = true;

      // Assuming your router passes an ID parameter
      const transactionId = this.$route.params.transaction_id;

      this.$get({
        action: 'scm_transaction_admin_ajax',
        route: 'get_transaction_details',
        transaction_id: transactionId,
        nonce: window.SwiftCertificateManagerAdminVars.nonce
      })
          .then(response => {
            this.transaction = response.data.transaction;
            this.editStatus = this.transaction.payment_status;
          })
          .fail(error => {
            this.$handleError(error);
            // this.$message.error('Failed to load transaction details');
          })
          .always(() => {
            this.loading = false;
          });
    },

    updateTransactionStatus() {
      if (this.editStatus === this.transaction.payment_status) {
        this.statusPopoverVisible = false;
        return;
      }

      this.updatingStatus = true;

      this.$post({
        action: 'scm_transaction_admin_ajax',
        route: 'update_transaction_status',
        transaction_id: this.transaction.id,
        status: this.editStatus,
        nonce: window.SwiftCertificateManagerAdminVars.nonce
      })
          .then(response => {
            if (response.success) {
              this.transaction.payment_status = this.editStatus;
              this.statusPopoverVisible = false;
              this.$handleSuccess(response.data.message);
            }
          })
          .fail(error => {
            this.$handleError(error);
          })
          .always(() => {
            this.updatingStatus = false;
          });
    },

    formatDate(dateString) {
      if (!dateString) return '-';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },

    formatJSON(jsonString) {
      try {
        const obj = typeof jsonString === 'string' ? JSON.parse(jsonString) : jsonString;
        return JSON.stringify(obj, null, 2);
      } catch (e) {
        return jsonString;
      }
    }
  },

  mounted() {
    this.fetchTransactionDetails();
  }
}
</script>