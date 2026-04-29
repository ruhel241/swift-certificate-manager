<template>
  <el-row>
    <el-col :span="24">
      <el-card shadow="never">
        <h2 class="title" style="font-size: 20px; margin: 0;">
          {{ $t('Certificate Information') }}
        </h2>
        <hr style="border-bottom: initial;" />

        <el-form
          ref="infoForm"
          :model="info"
          :rules="rules"
          label-position="top"
          label-width="100px"
          v-loading="saving"
        >
          <el-form-item
            label="Course Name | Max 80 characters"
            prop="course_name"
          >
            <el-input
              type="text"
              v-model="info.course_name"
              placeholder="Enter course name"
              maxlength="80"
              show-word-limit
            />
          </el-form-item>

          <el-form-item
            label="Student Name | Max 40 characters"
            prop="student_name"
          >
            <el-input
              type="text"
              v-model="info.student_name"
              placeholder="Enter student name"
              maxlength="40"
              show-word-limit
            />
          </el-form-item>

          <el-form-item
            label="Graduation Date"
            prop="graduation_date"
          >
            <el-date-picker
              v-model="info.graduation_date"
              type="date"
              placeholder="Pick a Date"
              format="dd MMMM yyyy"
              value-format="dd MMMM yyyy"
              :picker-options="pickerDateOptions"
              style="width: 100%;"
            />
          </el-form-item>

          <el-form-item
            label="Email"
            prop="student_email"
          >
            <el-input
              type="email"
              v-model="info.student_email"
              placeholder="Enter student email"
            />
          </el-form-item>

          <el-form-item label="Note:">
            <p style="color: #7B7A7D">
              You need to put all the information on this form. So, it will show on the generated certificate.
              <br />
              On the Certificate customization page, you can only change colors, logos and signature.
            </p>
          </el-form-item>
        </el-form>
      </el-card>
    </el-col>
  </el-row>
</template>

<script>
export default {
  name: 'information-form',
  props: ['info', 'saving'],

  data() {
    return {
      pickerDateOptions: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        }
      },

      rules: {
        course_name: [
          {
            required: true,
            message: 'Please enter course name',
            trigger: 'blur'
          }
        ],
        student_name: [
          {
            required: true,
            message: 'Please enter student name',
            trigger: 'blur'
          }
        ],
        graduation_date: [
          {
            required: true,
            message: 'Please select graduation date',
            trigger: 'change'
          }
        ],
        student_email: [
          {
            required: false,
            message: 'Please enter email address',
            trigger: 'blur'
          },
          {
            type: 'email',
            message: 'Please enter a valid email address',
            trigger: ['blur', 'change']
          }
        ]
      }
    }
  },

  methods: {
    validateForm() {
      return new Promise((resolve) => {
        this.$refs.infoForm.validate((valid) => {
          resolve(valid)
        })
      })
    }
  }
}
</script>