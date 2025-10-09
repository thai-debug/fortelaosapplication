<script setup>
import { reactive, ref } from "vue";
import axios, { initCSRF } from "@/axios";

import FormField from "@/components/FormField.vue";

const form = reactive({
  first_name: "",
  last_name: "",
  employee_code: "",
  email: "",
  contactnumber: "",
  emergencycontact: "",
  address: "",
  gender: "",
  dob: "",
  hired_date: "",
  isactive: false,
});

const loading = ref(false)
const sucess = ref(false)
const error = ref(null)

const genderOptions = [
  { label: "Male", value: "male" },
  { label: "Female", value: "female" },
  { label: "Other", value: "other" },
];

const departmentOptions = [
  { label: "IT", value: "IT" },
  { label: "HR", value: "HR" },
  { label: "ADMIN", value: "ADMIN" },
  { label: "LEGAL & COMPLIANCE", value: "LEGAL&COMPLIANCE" },
  { label: "FINANCE", value: "FINANCE" },
  { label: "SALES", value: "SALES" },
  { label: "MARKETING", value: "MARKETING" },
  { label: "CLAIM", value: "CLAIM" },
];

const positionOptions = [
  {
    label: "Assistant Manager, IT Support",
    value: "Assistant Manager, IT Support",
  },
  { label: "HR Officer", value: "HR Officer" },
  { label: "HR Manager", value: "HR Manager" },
  { label: "Legal Compliance Officer", value: "Legal Compliance Officer" },
  { label: "Accountant", value: "Accountant" },
  { label: "Sales Officer", value: "Sales Officer" },
  { label: "Marketing Officer", value: "Marketing Officer" },
  { label: "Claim Officer", value: "Claim Officer" },
];

const employmentTypeOptions = [
  { label: "Full-time", value: "Full-time" },
  { label: "Part-time", value: "Part-time" },
  { label: "Contract", value: "Contract" },
];

const activeOptions = [
  { label: "Active", value: "active" },
  { label: "Inactive", value: "inactive" },
];

async function submitForm(){
  loading.value = true
  error.value = null
  try {
    await initCSRF()
    
    const response = await axios.post("/api/users", form)
    sucess.value = true
    console.log('submited:', response.data)
    loading.value = false
    
  } catch (error) {
    error.value = error.response.data.message

    console.error(error)
  }finally{
    loading.value = false
  }
}
</script>
<template>
  <div class="col-12">
    <div class="card">
      <div
        class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row"
      >
        <h5 class="card-title mb-sm-0 me-2">New Employee Form</h5>
      </div>
      <div class="card-body pt-5">
        <form @submit.prevent="submitForm">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="row g-6 pb-6">
                <div class="col-md-6">
                  <FormField
                    label="Department"
                    name="department"
                    id="department"
                    type="select"
                    v-model="form.department"
                    :options="departmentOptions"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Position"
                    name="position"
                    id="position"
                    type="select"
                    v-model="form.position"
                    :options="positionOptions"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Employment Type"
                    name="employment_type"
                    id="employment_type"
                    type="select"
                    v-model="form.employment_type"
                    :options="employmentTypeOptions"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Employee Code"
                    name="employee_code"
                    id="employee_code"
                    type="text"
                    placeholder=""
                    v-model="form.employee_code"
                  />
                </div>

                <div class="col-md-6">
                  <FormField
                    label="First name"
                    name="first_name"
                    id="first_name"
                    type="text"
                    placeholder=""
                    v-model="form.first_name"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Last name"
                    name="last_name"
                    id="last_name"
                    type="text"
                    placeholder=""
                    v-model="form.last_name"
                  />
                </div>

                <div class="col-md-12">
                  <FormField
                    label="Email"
                    name="email"
                    id="email"
                    type="email"
                    placeholder=""
                    v-model="form.email"
                    required
                  />
                </div>

                <div class="col-md-6">
                  <FormField
                    label="Contact Number"
                    name="contactnumber"
                    id="contactnumber"
                    type="text"
                    placeholder=""
                    v-model="form.contactnumber"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Emergency Contact"
                    name="emergencycontact"
                    id="emergencycontact"
                    type="text"
                    placeholder=""
                    v-model="form.emergencycontact"
                  />
                </div>

                <div class="col-12">
                  <FormField
                    label="Address"
                    name="address"
                    id="address"
                    type="textarea"
                    placeholder=""
                    v-model="form.address"
                  />
                </div>

                <div class="col-12">
                  <FormField
                    label="Gender"
                    name="gender"
                    id="gender"
                    type="radio"
                    v-model="form.gender"
                    :options="genderOptions"
                  />
                </div>

                <div class="col-md-6">
                  <FormField
                    label="Hired date"
                    name="hired_date"
                    id="hired_date"
                    type="date"
                    v-model="form.hired_date"
                  />
                </div>

                <div class="col-md-6">
                  <FormField
                    label="Date of Birth"
                    name="dob"
                    id="dob"
                    type="date"
                    v-model="form.dob"
                  />
                </div>

                <div class="col-md-12">
                  <FormField
                    label="Password"
                    name="password"
                    id="password"
                    type="password"
                    placeholder=""
                    v-model="form.password"
                    required
                  />
                </div>

                <div class="col-md-12">
                  <FormField
                    label="New employee will be inactive by default, please switch active."
                    name="isactive"
                    id="isactive"
                    type="switch"
                    v-model="form.isactive"
                  />
                </div>

                <div class="col-md-12">
                  <button
                    type="submit"
                    class="btn btn-primary waves-effect waves-light"
                    :disabled="loading"
                  >
                    {{ loading ? 'Submitting...' : 'Submit' }}
                  </button>
                  <button
                    type="reset"
                    class="btn btn-warning waves-effect waves-light"
                    :disabled="loading"
                  >
                    {{ loading ? 'Clearing...' : 'Clear' }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
