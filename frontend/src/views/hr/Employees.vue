<script setup>
import { useFormStore } from "../../stores/hr/EmployeeStore";
import FormField from "../../components/FormField.vue";

const store = useFormStore();
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
        <form @submit.prevent="store.submitForm">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="row g-6 pb-6">
                <div class="col-md-6">
                  <FormField
                    label="Department"
                    name="department"
                    id="department"
                    type="select"
                    v-model="store.form.department"
                    :options="store.departmentOptions"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Position"
                    name="position"
                    id="position"
                    type="select"
                    v-model="store.form.position"
                    :options="store.positionOptions"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Employment Type"
                    name="employment_type"
                    id="employment_type"
                    type="select"
                    v-model="store.form.employment_type"
                    :options="store.employmentTypeOptions"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Employee Code"
                    name="employee_code"
                    id="employee_code"
                    type="text"
                    placeholder=""
                    v-model="store.form.employee_code"
                  />
                </div>

                <div class="col-md-6">
                  <FormField
                    label="First name"
                    name="first_name"
                    id="first_name"
                    type="text"
                    placeholder=""
                    v-model="store.form.first_name"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Last name"
                    name="last_name"
                    id="last_name"
                    type="text"
                    placeholder=""
                    v-model="store.form.last_name"
                  />
                </div>

                <div class="col-md-12">
                  <FormField
                    label="Email"
                    name="email"
                    id="email"
                    type="email"
                    placeholder=""
                    v-model="store.form.email"
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
                    v-model="store.form.contactnumber"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Emergency Contact"
                    name="emergencycontact"
                    id="emergencycontact"
                    type="text"
                    placeholder=""
                    v-model="store.form.emergencycontact"
                  />
                </div>

                <div class="col-12">
                  <FormField
                    label="Address"
                    name="address"
                    id="address"
                    type="textarea"
                    placeholder=""
                    v-model="store.form.address"
                  />
                </div>

                <div class="col-12">
                  <FormField
                    label="Gender"
                    name="gender"
                    id="gender"
                    type="radio"
                    v-model="store.form.gender"
                    :options="store.genderOptions"
                  />
                </div>

                <div class="col-md-6">
                  <FormField
                    label="Hired date"
                    name="hired_date"
                    id="hired_date"
                    type="date"
                    v-model="store.form.hired_date"
                  />
                </div>

                <div class="col-md-6">
                  <FormField
                    label="Date of Birth"
                    name="dob"
                    id="dob"
                    type="date"
                    v-model="store.form.dob"
                  />
                </div>

                <div class="col-md-12">
                  <FormField
                    label="Password"
                    name="password"
                    id="password"
                    type="password"
                    placeholder=""
                    v-model="store.form.password"
                    required
                  />
                </div>

                <div class="col-md-12">
                  <FormField
                    label="New employee will be set to inactive by default, please switch to active."
                    name="isactive"
                    id="isactive"
                    type="switch"
                    v-model="store.form.isactive"
                  />
                </div>

                <div class="col-md-12">
                  <button
                    type="submit"
                    class="btn btn-primary waves-effect waves-light"
                    :disabled="store.loading"
                  >
                    {{ store.loading ? "Submitting..." : "Submit" }}
                  </button>&nbsp;
                  <button
                    type="reset"
                    class="btn btn-warning waves-effect waves-light"
                    :disabled="store.loading"
                  >
                    {{ store.loading ? "Clearing..." : "Clear" }}
                  </button>

                  <div v-if="store.success" class="text-success mt-2">
                    New employee successfully created!
                  </div>
                  <div v-if="store.error" class="text-danger mt-2">
                    {{ store.error }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
