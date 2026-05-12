<template>
  <div class="scm-manage-certificate">
    <div class="title header">
      <h1>Manage Certificate</h1>
      <!-- {{ infos }} -->
      <div class="header-buttons">
        <router-link to="/" class="nav-logo-lin">
          <el-button
            class="scm-primary-btn svg-span-btn"
            round
          >
            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.5 5.83332V14.1667C17.5 16.6667 16.25 18.3333 13.3333 18.3333H6.66667C3.75 18.3333 2.5 16.6667 2.5 14.1667V5.83332C2.5 3.33332 3.75 1.66666 6.66667 1.66666H13.3333C16.25 1.66666 17.5 3.33332 17.5 5.83332Z" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M12.9166 1.66666V8.21664C12.9166 8.58331 12.4832 8.76664 12.2166 8.52497L10.2833 6.74168C10.1249 6.59168 9.8749 6.59168 9.71656 6.74168L7.78327 8.52497C7.51661 8.76664 7.08325 8.58331 7.08325 8.21664V1.66666H12.9166Z" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M11.0417 11.6667H14.5834" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M7.5 15H14.5833" stroke="#424145" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ $t("Assign New Certificate") }}
          </el-button>

        </router-link>
      </div>
    </div>

    <div class="scm-card scm-mange-action">
      <div class="scm-mange-tabs">
        <el-tabs v-model="status" @tab-click="handleTabClick">
          <el-tab-pane label="Created" name="assign">
            <template #label>
              <svg
                width="16"
                height="16"
                viewBox="0 0 16 16"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M14.6667 6.66659V9.99992C14.6667 13.3333 13.3333 14.6666 10 14.6666H6.00001C2.66668 14.6666 1.33334 13.3333 1.33334 9.99992V5.99992C1.33334 2.66659 2.66668 1.33325 6.00001 1.33325H9.33334"
                  stroke="#291465"
                  stroke-width="0.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M14.6667 6.66658H12C10 6.66658 9.33334 5.99992 9.33334 3.99992V1.33325L14.6667 6.66658Z"
                  stroke="#291465"
                  stroke-width="0.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M4.66666 8.66675H8.66666"
                  stroke="#291465"
                  stroke-width="0.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M4.66666 11.3333H7.33332"
                  stroke="#424145"
                  stroke-width="0.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
              Created
            </template>
          </el-tab-pane>

          <el-tab-pane label="Request" name="request">
            <template #label>
              <svg
                width="16"
                height="16"
                viewBox="0 0 16 16"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M7.33333 1.33325H6C2.66666 1.33325 1.33333 2.66659 1.33333 5.99992V9.99992C1.33333 13.3333 2.66666 14.6666 6 14.6666H10C13.3333 14.6666 14.6667 13.3333 14.6667 9.99992V8.66659"
                  stroke="#424145"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M10.6933 2.01326L5.44 7.26659C5.24 7.46659 5.04 7.85992 5 8.14659L4.71333 10.1533C4.60666 10.8799 5.12 11.3866 5.84666 11.2866L7.85333 10.9999C8.13333 10.9599 8.52666 10.7599 8.73333 10.5599L13.9867 5.30659C14.8933 4.39992 15.32 3.34659 13.9867 2.01326C12.6533 0.679924 11.6 1.10659 10.6933 2.01326Z"
                  stroke="#424145"
                  stroke-miterlimit="10"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M9.94 2.7666C10.3867 4.35993 11.6333 5.6066 13.2333 6.05993"
                  stroke="#424145"
                  stroke-miterlimit="10"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
              Request
            </template>
          </el-tab-pane>

          <el-tab-pane label="Drafts" name="draft">
            <template #label>
              <svg
                width="16"
                height="16"
                viewBox="0 0 16 16"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M14 4.66659V11.3333C14 13.3333 13 14.6666 10.6667 14.6666H5.33333C3 14.6666 2 13.3333 2 11.3333V4.66659C2 2.66659 3 1.33325 5.33333 1.33325H10.6667C13 1.33325 14 2.66659 14 4.66659Z"
                  stroke="#424145"
                  stroke-width="0.8"
                  stroke-miterlimit="10"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M10.3333 1.33325V6.57324C10.3333 6.86658 9.98664 7.01324 9.77331 6.81991L8.22667 5.39327C8.10001 5.27327 7.89997 5.27327 7.77331 5.39327L6.22667 6.81991C6.01334 7.01324 5.66666 6.86658 5.66666 6.57324V1.33325H10.3333Z"
                  stroke="#424145"
                  stroke-width="0.8"
                  stroke-miterlimit="10"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M8.83334 9.33325H11.6667"
                  stroke="#424145"
                  stroke-width="0.8"
                  stroke-miterlimit="10"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <path
                  d="M6 12H11.6667"
                  stroke="#424145"
                  stroke-width="0.8"
                  stroke-miterlimit="10"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
              Drafts
            </template>
          </el-tab-pane>
        </el-tabs>
      </div>
      <div class="scm-mange-search">
        <el-input
          placeholder="Search"
          prefix-icon="el-icon-search"
          v-model="search"
          @input="searchHandler"
          clearable
        >
        </el-input>

        <div class="scm-button">
          <el-button class="capsule-btn defult-svg-span-btn" round @click="exportCSV">
            <svg
                width="16"
                height="16"
                viewBox="0 0 16 16"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
              <path
                  d="M8 1.33325V5.99992L9.33333 4.66659"
                  stroke="#1B1A1F"
                  stroke-width="0.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"
              />
              <path
                  d="M7.99996 6.00008L6.66663 4.66675"
                  stroke="#1B1A1F"
                  stroke-width="0.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"
              />
              <path
                  d="M1.31995 8.66675H4.25995C4.51328 8.66675 4.73995 8.80675 4.85328 9.03341L5.63328 10.5934C5.85995 11.0467 6.31995 11.3334 6.82661 11.3334H9.17995C9.68661 11.3334 10.1466 11.0467 10.3733 10.5934L11.1533 9.03341C11.2666 8.80675 11.4999 8.66675 11.7466 8.66675H14.6533"
                  stroke="#424145"
                  stroke-width="0.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"
              />
              <path
                  d="M4.66671 2.75342C2.30671 3.10008 1.33337 4.48675 1.33337 7.33342V10.0001C1.33337 13.3334 2.66671 14.6668 6.00004 14.6668H10C13.3334 14.6668 14.6667 13.3334 14.6667 10.0001V7.33342C14.6667 4.48675 13.6934 3.10008 11.3334 2.75342"
                  stroke="#424145"
                  stroke-width="0.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"
              />
            </svg>
            Export CSV
          </el-button>
        </div>
      </div>
    </div>

    <div class="scm-manage-table-wrap">
      <table-selections
          :current_status="status"
          @reloadData="fetchInfos"
          :selections="multipleSelection"
      />
      <el-table
        v-loading="fetching"
        ref="multipleTable"
        :data="infos"
        @selection-change="handleSelectionChange"
        style="width: 100%; padding-bottom: 20px;"
        :cell-style="{ height: '80px', border: 'none' }"
      >
        <el-table-column type="selection"></el-table-column>

        <el-table-column label="Certificate Name" prop="course_name" sortable>
          <template slot-scope="scope">{{ scope.row.course_name }}</template>
        </el-table-column>

        <el-table-column label="Student Name" prop="student_name" sortable>
          <template slot-scope="scope">{{ scope.row.student_name }}</template>
        </el-table-column>

        <el-table-column label="Date" prop="graduation_date" sortable :sort-method="sortDate">
          <template slot-scope="scope">{{ scope.row.graduation_date }}</template>
        </el-table-column>

        <el-table-column label="Certificate Code">
          <template slot-scope="scope">
            <span class="scm-certificate-code">{{ scope.row.certificate_code }}</span>
            <el-tooltip
              effect="dark"
              content="Click To Copy"
              title="Click To Copy"
              placement="top"
            >
              <code
                class="copy"
                :data-clipboard-text="getCopyText(scope.row.certificate_code)"
              >
                <i class="el-icon-document-copy"></i>
              </code>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column label="Payment Status">
          <template slot-scope="scope">
            <el-tag
              :type="scope.row.payment_status === 'paid'
                ? 'success'
                : (scope.row.payment_status === 'pending' ? 'warning' : '')"
            >
              {{ formatStatus(scope.row.payment_status) }}
            </el-tag>
          </template>
        </el-table-column>

        <el-table-column :label="$t('Action')">
          <template slot-scope="scope">
            <div class="scm-table-action">
              <el-tooltip content="Edit" placement="top">
                <a href="javascript:void(0)" @click="gotoEdit(scope.row.id)">
                  <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                      <rect x="1" y="1" width="38" height="38" rx="19" stroke="#CCBEF5"/>
                      <g transform="translate(2,2)">
                      <path d="M17.3334 11.333H16C12.6667 11.333 11.3334 12.6663 11.3334 15.9997V19.9997C11.3334 23.333 12.6667 24.6663 16 24.6663H20C23.3334 24.6663 24.6667 23.333 24.6667 19.9997V18.6663"
                        stroke="#5B2DE0" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M20.6934 12.0135L15.44 17.2668C15.24 17.4668 15.04 17.8602 15 18.1468L14.7134 20.1535C14.6067 20.8802 15.12 21.3868 15.8467 21.2868L17.8534 21.0002C18.1334 20.9602 18.5267 20.7602 18.7334 20.5602L23.9867 15.3068C24.8934 14.4002 25.32 13.3468 23.9867 12.0135C22.6534 10.6802 21.6 11.1068 20.6934 12.0135Z"
                        stroke="#5B2DE0" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M19.9399 12.7666C20.3866 14.3599 21.6333 15.6066 23.2333 16.0599"
                        stroke="#5B2DE0" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                  </svg>
                </a>
              </el-tooltip>
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

      <table-selections
          :current_status="status"
          @reloadData="fetchInfos"
          :selections="multipleSelection"
      />

      <div class="scm_pagination_wrap">
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

    <UpgradePopup 
      :upgradePopupVisible="upgradePopupVisible"
      @close="upgradePopupVisible = false"
    />

<!--    <div class="scm-card p20" v-else>-->
<!--      <h3>{{ $t("No Data Found") }}</h3>-->
<!--    </div>-->
  </div>
</template>

<script>
import TableSelections from "../Components/_TableSelectionHandler.vue";
import UpgradePopup from '../Components/UpgradePopup.vue';
export default {
  name: "manage-certificates",
  components: {
    TableSelections,
    UpgradePopup
  },
  data() {
    return {
      status: localStorage.getItem('scStatus') || "assign",
      search: "",
      searchTimeout: null,
      fetching: false,
      infos: [],
      multipleSelection: [],
      paginate: {
        total: 0,
        current_page: +(localStorage.getItem('infosCurrentPage') || 1),
        last_page: 1,
        per_page: +(localStorage.getItem('infosPerPage') || 10)
      },
      upgradePopupVisible: false,
      hasPro: !!window.SwiftCertificateManagerAdminVars.has_pro
    };
  },
  methods: {
    parseGraduationDate(dateStr) {
      if (!dateStr) return 0;

      const parts = dateStr.trim().split(' ');
      if (parts.length !== 3) return 0;

      const day = parseInt(parts[0], 10);
      const monthName = parts[1].toLowerCase();
      const year = parseInt(parts[2], 10);

      const months = {
        january: 0,
        february: 1,
        march: 2,
        april: 3,
        may: 4,
        june: 5,
        july: 6,
        august: 7,
        september: 8,
        october: 9,
        november: 10,
        december: 11
      };

      const month = months[monthName];

      if (month === undefined || isNaN(day) || isNaN(year)) {
        return 0;
      }

      return new Date(year, month, day).getTime();
    },

    sortDate(a, b) {
      return this.parseGraduationDate(a.graduation_date) - this.parseGraduationDate(b.graduation_date);
    },
    formatStatus(status) {
      const s = (status || "").toString();
      return s.charAt(0).toUpperCase() + s.slice(1);
    },
    handleSizeChange(val) {
        localStorage.setItem('infosPerPage', val);
        this.paginate.per_page = val;
        this.fetchInfos();
    },
    handleCurrentChange(val) {
        localStorage.setItem('infosCurrentPage', val);
        this.paginate.current_page = val
        this.fetchInfos();
    },
    handleTabClick(tab) {
      localStorage.setItem('scStatus', tab.name);
      this.status = tab.name;
      this.fetchInfos();
    },
    searchHandler(val) {
      this.search = val;
      // clear previous timeout
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout);
      }
      // set new debounce
      this.searchTimeout = setTimeout(() => {
        this.fetchInfos();
      }, 300);
    },
    handleSelectionChange(val) {
      this.multipleSelection = val;
    },
    exportCSV() {
      if (!this.hasPro) {
        this.upgradePopupVisible = true;
        return;
      }
      // Create loading indicator
      const loading = this.$loading({
        fullscreen: true,
        text: 'Exporting CSV File....',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)',
        customClass: 'scm-text-loading'
      });

      // Add setTimeout for 1000ms (1 second) delay
      setTimeout(() => {
        // Use fetch instead of direct location.href to handle the response
        fetch(SwiftCertificateManagerAdminVars.ajaxurl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: new URLSearchParams({
            action: 'scm_generate_admin_ajax',
            route: 'get_csv_download',
            status: this.status,
            search: this.search,
            current_page: this.paginate.current_page,
            per_page: this.paginate.per_page,
            nonce: window.SwiftCertificateManagerAdminVars.nonce,
          })
        })
            .then(response => {
              if (!response.ok) {
                return response.json().then(errorData => {
                  throw new Error(errorData.data?.message || 'Failed to download CSV');
                });
              }
              // For successful response, get the blob and download it
              return response.blob();
            })
            .then(blob => {
              // Create a download link for the blob
              const url = window.URL.createObjectURL(blob);
              const a = document.createElement('a');
              const date = new Date().toISOString().split('T')[0];
              a.href = url;
              a.download = `swift-certificate-manager-export-${date}.csv`;
              document.body.appendChild(a);
              a.click();
              window.URL.revokeObjectURL(url);
              a.remove();
            })
            .catch(error => {
              // If error is about no data, show a specific message
              if (error.message) {
                this.$message({
                  message: error.message,
                  type: 'warning',
                  offset: 50
                });
              } else {
                this.$handleError(error);
              }
            })
            .finally(() => {
              // Always close the loading indicator
              loading.close();
            });
      }, 1000); // 1000ms timeout
    },
    gotoEdit(id) {
      if (!this.hasPro) {
        this.upgradePopupVisible = true;
        return;
      } 
      this.$router.push({
        name: "update_info",
        params: {
          info_id: id,
        },
      });      
    },
    
    gotoView(id) {
      this.$router.push({
        name: "view_certificate",
        params: {
          info_id: id,
        },
      });
    },
    handleDeleteModal(infoId) {
      if (!this.hasPro) {
        this.upgradePopupVisible = true;
        return;
      } 
      this.$confirm("Do you want delete this info permanently", "Warning", {
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        type: "warning",
      })
        .then(() => {
          this.performAction("delete", infoId);
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
    performAction(type, infoId) {
      this.$post({
        action: "scm_generate_admin_ajax",
        route: "maybe_delete_infos",
        info_ids: [infoId],
        action_type: type,
        nonce: window.SwiftCertificateManagerAdminVars.nonce,
      })
        .then((response) => {
          this.$notify({
            title: "Sucess",
            message: response.data.message,
            type: "success",
          });
          this.fetchInfos();
        })
        .fail((error) => {
          this.$handleError(error);
        })
        .always(() => {});
    },
    fetchInfos() {
      this.fetching = true;
      this.$get({
        action: "scm_generate_admin_ajax",
        route: "get_certificate_infos",
        status: this.status,
        search: this.search,
        current_page: this.paginate.current_page,
        per_page: this.paginate.per_page,
        nonce: window.SwiftCertificateManagerAdminVars.nonce,
      })
        .then((response) => {
          this.infos = response.data.infos;
          this.paginate.total = response.data.total;
          this.paginate.current_page = response.data.current_page;
          this.paginate.last_page = response.data.last_page;
        })
        .fail((error) => {
          this.$handleError(error);
        })
        .always(() => {
          this.fetching = false;
        });
    },
  },

  mounted() {
    this.fetchInfos();
    jQuery('head title').text('Manage Certificate - Swift Certificate Manager');
  },
  beforeMount() {
    if (this.appVars.is_onboarded === 'no') {
      this.$router.push(
          {
            name: 'setup_template',
            params: {}
          }
      )
    }
  },
};
</script>