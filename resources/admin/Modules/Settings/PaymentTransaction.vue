<template>
  <div class="wscm_payment_transaction">
    <div class="wpsc-card">
      <div class="settings-item">
        <div class="header-title">
          <h3 class="title">Payment Transaction</h3>
        </div>
        <div v-loading="fetching" style="width: 100%">
          <el-table
              :data="transactions"
              style="width: 100%">
            <el-table-column
                label="Id"
                width="70"
                sortable>
              <template slot-scope="scope">
                {{ scope.$index + 1 }}
              </template>
            </el-table-column>
            <el-table-column
                label="Date"
                width="180">
              <template slot-scope="scope">
                {{scope.row.updated_at}}
              </template>
            </el-table-column>
            <el-table-column
                label="Name"
                width="180">
              <template slot-scope="scope">
                {{scope.row.get_info.student_name}}
              </template>
            </el-table-column>
            <el-table-column
                label="Amount">
              <template slot-scope="scope">
                {{(scope.row.payment_total / 100)}}
              </template>
            </el-table-column>
            <el-table-column
                label="Status">
              <template slot-scope="scope">
                <span :class="[scope.row.payment_status == 'pending' ? 'wscm_status_pending wscm_status' : 'wscm_status_paid wscm_status']">
                  {{scope.row.payment_status}}
                </span>
              </template>
            </el-table-column>
            <el-table-column
                label="Method">
              <template slot-scope="scope">
                <span class="wscm_payment_method">
                  <img :src="images_url + 'stripe.svg'" alt="" v-if="scope.row.payment_method === 'stripe'">
                  <img :src="images_url + 'PayPal.svg'" alt="" v-if="scope.row.payment_method === 'paypal'">
                </span>
              </template>
            </el-table-column>
            <el-table-column
                label="Mode">
              <template slot-scope="scope">
                <span>
                  {{ scope.row.payment_mode ? scope.row.payment_mode : '-'}}
                </span>
              </template>
            </el-table-column>
            <el-table-column :label="$t('Action')">
              <template slot-scope="scope">
                <div class="wscm-table-action">
                  <el-tooltip content="View" placement="top">
                    <a href="javascript:void(0)" @click="gotoView(scope.row.id)">
                      <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <rect x="1" y="1" width="38" height="38" rx="19" stroke="#CCBEF5"/>
                          <g transform="translate(2,2)">
                          <path d="M20.3867 18C20.3867 19.32 19.32 20.3867 18 20.3867C16.68 20.3867 15.6133 19.32 15.6133 18C15.6133 16.68 16.68 15.6133 18 15.6133C19.32 15.6133 20.3867 16.68 20.3867 18Z"
                            stroke="#5B2DE0" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M18 23.5133C20.3534 23.5133 22.5467 22.1267 24.0734 19.7267C24.6734 18.7867 24.6734 17.2067 24.0734 16.2667C22.5467 13.8667 20.3534 12.48 18 12.48C15.6467 12.48 13.4534 13.8667 11.9267 16.2667C11.3267 17.2067 11.3267 18.7867 11.9267 19.7267C13.4534 22.1267 15.6467 23.5133 18 23.5133Z"
                            stroke="#5B2DE0" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                      </svg>
                    </a>
                  </el-tooltip>
                  <el-tooltip content="Delete" placement="top">
                    <a href="javascript:void(0)" @click.prevent="handleDeleteModal(scope.row.id)">
                      <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <rect x="1" y="1" width="38" height="38" rx="19" stroke="#F890A1"/>
                        <g transform="translate(2,2)">
                          <path d="M24 13.9867C21.78 13.7667 19.5467 13.6533 17.32 13.6533C16 13.6533 14.68 13.72 13.36 13.8533L12 13.9867"
                            stroke="#F00E33" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M15.6666 13.313L15.8133 12.4397C15.92 11.8063 16 11.333 17.1266 11.333H18.8733C20 11.333 20.0866 11.833 20.1866 12.4463L20.3333 13.313"
                            stroke="#F00E33" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M22.5667 16.0938L22.1333 22.8071C22.06 23.8537 22 24.6671 20.14 24.6671H15.86C14 24.6671 13.94 23.8537 13.8667 22.8071L13.4333 16.0938"
                            stroke="#F00E33" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M16.8867 21H19.1067"
                            stroke="#F00E33" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M16.3334 18.333H19.6667"
                            stroke="#F00E33" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                      </svg>
                    </a>
                  </el-tooltip>
                </div>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </div>
    </div>
    <div class="wscm_pagination_wrap">
      <el-pagination
          :hide-on-single-page="false"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
          :current-page.sync="paginate.current_page"
          :page-sizes="[5, 10, 20, 50, 100]"
          :page-size="paginate.per_page"
          layout="total, sizes, prev, pager, next"
          :total="paginate.total">
      </el-pagination>
    </div>
  </div>
</template>

<script>
export default {
  name: "payment-transaction",
  data() {
    return {
      fetching: false,
      transactions: [],
      paginate: {
        total: 0,
        current_page: +(localStorage.getItem('transactionCurrentPage') || 1),
        last_page: 1,
        per_page: +(localStorage.getItem('transactionPerPage') || 10)
      },
      images_url: window.SwiftCertificateManagerAdminVars.images_url,
      hasPro: !!window.SwiftCertificateManagerAdminVars.has_pro,
    }
  },
  methods: {
    gotoView(id) {
      this.$router.push({
        name: "view_transaction",
        params: {
          transaction_id: id,
        },
      });
    },
    handleSizeChange(val) {
      localStorage.setItem('transactionPerPage', val);
      this.paginate.per_page = val;
      this.getPaymentTransactionHandler();
    },
    handleCurrentChange(val) {
      localStorage.setItem('transactionCurrentPage', val);
      this.paginate.current_page = val
      this.getPaymentTransactionHandler();
    },

    getPaymentTransactionHandler() {
      this.fetching = true;
      this.$get({
        action: 'swift_certificate_manager_transaction_admin_ajax',
        route: 'get_payment_transactions',
        current_page: this.paginate.current_page,
        per_page: this.paginate.per_page,
        nonce: window.SwiftCertificateManagerAdminVars.nonce
      })
          .then(response => {
            this.transactions = response.data.transactions;
            this.paginate.total = response.data.total;
            this.paginate.current_page = response.data.current_page;
            this.paginate.last_page = response.data.last_page;
          })
          .fail(error => {
            this.$handleError(error);
          })
          .always(() => {
            this.fetching = false;
          });
    },

    handleDeleteModal(id) {
      this.$confirm("Do you want delete this payment transaction permanently", "Warning", {
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        type: "warning",
      })
        .then(() => {
          this.performAction("delete", id);
        })
        .catch(() => {
          this.$message({
            type: "info",
            offset: 50,
            showClose: true,
            message: "Delete canceled",
          });
        });
    },

     performAction(type, id) {
      this.$post({
        action: "swift_certificate_manager_transaction_admin_ajax",
        route: "maybe_delete_transactions",
        transactions_ids: [id],
        action_type: type,
        nonce: window.SwiftCertificateManagerAdminVars.nonce,
      })
        .then((response) => {
          this.$notify({
            title: "Sucess",
            message: response.data.message,
            type: "success",
          });
          this.getPaymentTransactionHandler();
        })
        .fail((error) => {
          this.$handleError(error);
        })
        .always(() => {});
    },

  },

  mounted() {
    if (this.hasPro) {
      this.getPaymentTransactionHandler();
    }
  }
}
</script>

<style lang="scss">
.wscm_payment_transaction {
  .settings-item {
    margin-bottom: 0 !important;
  }
  .wscm_status {
    padding: 2px 6px;
    border-radius: 5px;
    color: #141414;
    text-transform: capitalize;
    border: 1px solid #ccc;
    font-size: 12px;
  }

  .wscm_status_paid {
    border: 1px solid rgba(26, 255, 178, 0.5019607843);
    background: rgba(26, 255, 178, 0.5019607843);
  }

  .wscm_status_pending{
    border: 1px solid rgba(255, 235, 59, 0.55);
    background: rgba(255, 235, 59, 0.55);
  }
  .wscm_payment_method {
    img {
      width: 40%;
    }
  }
}
</style>