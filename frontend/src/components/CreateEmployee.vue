<script setup>
import { ref, watch, onMounted } from "vue";
import { useEmployeeStore } from "../stores/hr/EmployeeStore";
import FormField from "../components/FormField.vue";

const store = useEmployeeStore();
const isUpdate = ref(false);
const emit = defineEmits(["completed"]);

onMounted(async () => {
  await Promise.all([
    store.fetchDepartments(),
    store.fetchPositions(),
    store.fetchEmploymentTypes(),
  ]);
  if (!isUpdate.value) {
    await store.generateNextEmployeeCode(); // auto generate employee code
  }
});

// generate email only for new employees
watch(
  () => [store.form.first_name, store.form.last_name],
  ([firstName, lastName]) => {
    if (firstName && lastName && !isUpdate.value) {
      const email = `${firstName.toLowerCase()}.${lastName[0].toLowerCase()}@fortelaos.com`;
      store.form.email = email;
    }
  },
  { immediate: true }
);

// auto regenerate employee code when department is selected for new employees
watch(
  () => store.form.department_id,
  async (newVal) => {
    if (newVal && !isUpdate.value) {
      await store.generateNextEmployeeCode();
    }
  },
  { immediate: true }
);

// selected employee
watch(
  () => store.selectedEmployee,
  (emp) => {
    if (emp) {

      store.form.department_id = emp.department_id,
      store.form.position_id = emp.position_id,
      store.form.employment_type_id = emp.employment_type_id,
      store.form.user_code = emp.user_code,
      store.form.first_name = emp.first_name,
      store.form.last_name = emp.last_name,
      store.form.email = emp.email,
      store.form.phone = emp.phone,
      store.form.emergency_contact = emp.emergency_contact,
      store.form.address = emp.address,
      store.form.gender = emp.gender,
      store.form.dob = emp.dob,
      store.form.hire_date = emp.hire_date,
      store.form.status = emp.status,
      store.form.password = emp.password,
      store.form.password_confirmation = emp.password_confirmation,
      isUpdate.value = true;
    } else {

      store.form.department_id = "",
      store.form.position_id = "",
      store.form.employment_type_id = "",
      store.form.user_code = "",
      store.form.first_name = "",
      store.form.last_name = "",
      store.form.email = "",
      store.form.phone = "",
      store.form.emergency_contact = "",
      store.form.address = "",
      store.form.gender = "",
      store.form.dob = "",
      store.form.hire_date = "",
      store.form.status = false,
      store.form.password = "Admin@2025",
      store.form.password_confirmation = "Admin@2025",
      isUpdate.value = false;
    }
  },
  { immediate: true }
);

// submit
const submit = async () => {
  try {
    if (isUpdate.value) {
      await store.updateEmployee(store.selectedEmployee.user_code, store.form);
    } else {
      await store.submitForm();
    }
    emit("completed");
  } catch (error) {
    console.log(error);
  }
};

// delete
const deleteEmployee = async () => {
  try {
    await store.deleteEmployee(store.selectedEmployee.user_code);
    emit("completed");
  } catch (error) {
    console.log(error);
  }
};
</script>
<template>
  <div class="col-12 pt-4">
    <div class="card">
      <div
        class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row"
      >
        <h5 class="card-title mb-sm-0 me-2">
          {{ isUpdate ? "Update" : "Create" }} Employee
        </h5>
      </div>
      <div class="card-body pt-5">
        <form @submit.prevent="submit">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="row g-6 pb-6">
                <div class="col-md-6">
                  <label for="department" class="form-label">Department</label>
                  <select
                    id="department"
                    name="department"
                    v-model="store.form.department_id"
                    class="form-select"
                  >
                  <option v-if="isUpdate" :value=store.selectedEmployee.department_id>{{ store.selectedEmployee.department.name }}</option>
                    <option v-else value="" disabled>Select Department</option>
                    <option
                      v-for="dept in store.departmentOptions"
                      :key="dept.id"
                      :value="dept.id"
                    >
                      {{ dept.name }}
                    </option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="position" class="form-label">Position</label>
                  <select
                  id="position"
                  name="position"
                  class="form-select"
                  v-model="store.form.position_id" 
                  >
                    <option v-if="isUpdate" :value=store.selectedEmployee.position_id>{{ store.selectedEmployee.position.title }}</option>
                    <option v-else value="" disabled>Select Position</option>
                    <option
                      v-for="pos in store.positionOptions"
                      :key="pos.id"
                      :value="pos.id"
                    >
                      {{ pos.title }}
                    </option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="employment_type" class="form-label"
                    >Employment Type</label
                  >
                  <select
                    id="employment_type"
                    name="employment_type"
                    v-model="store.form.employment_type_id"
                    class="form-select"
                    required
                  >
                  <option v-if="isUpdate" :value=store.selectedEmployee.employment_type_id>{{ store.selectedEmployee.employment_type.name }}</option>
                    <option v-else value="" disabled>Select Employment Type</option>
                    <option
                      v-for="type in store.employmentTypeOptions"
                      :key="type.id"
                      :value="type.id"
                    >
                      {{ type.name }}
                    </option>
                    <div v-if="!store.form.employment_type_id" class="text-danger small mt-1">Please select employment type</div>
                  </select>
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Employee Code"
                    name="user_code"
                    id="user_code"
                    type="text"
                    placeholder=""
                    v-model="store.form.user_code"
                    :disabled="isUpdate"
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
                    required
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
                    required
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
                    name="phone"
                    id="phone"
                    type="text"
                    placeholder=""
                    v-model="store.form.phone"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Emergency Contact"
                    name="emergency_contact"
                    id="emergency_contact"
                    type="text"
                    placeholder=""
                    v-model="store.form.emergency_contact"
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
                    required
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
                    name="hire_date"
                    id="hire_date"
                    type="date"
                    v-model="store.form.hire_date"
                    required
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
                <div class="col-md-12" v-if="!isUpdate">
                  <FormField
                    label="Password"
                    name="password"
                    id="password"
                    type="text"
                    placeholder=""
                    v-model="store.form.password"
                    required
                  />
                </div>

                <div class="col-md-12" v-if="isUpdate">
                  <FormField
                    label="Change Password (leave empty to keep current)"
                    name="password"
                    id="password_update"
                    type="password"
                    placeholder=""
                    v-model="store.form.password"
                  />
                </div>

                <div class="col-md-12" v-if="isUpdate && store.form.password">
                  <FormField
                    label="Confirm New Password"
                    name="password_confirmation"
                    id="password_confirmation_update"
                    type="password"
                    placeholder=""
                    v-model="store.form.password_confirmation"
                  />
                </div>

                 <div class="col-md-12">
                  <div class="form-check form-switch">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="status"
                      v-model="store.form.status"
                      :true-value="true"
                      :false-value="false"
                    >
                    <label class="form-check-label" for="status">
                      {{ store.form.status ? 'Active' : 'Inactive' }}
                    </label>
                  </div>
                  <small class="text-muted">
                    {{ isUpdate ? 'Toggle employee status' : 'New employee will be set to inactive by default, please switch to active.' }}
                  </small>
                </div>

                <div v-if="isUpdate" class="col-md-12 gap-2 d-flex">
                  <button
                    type="submit"
                    class="btn btn-primary waves-effect waves-light"
                  >
                    Update</button
                  >&nbsp;
                  <button
                    type="button"
                    class="btn btn-danger waves-effect waves-light"
                    @click="deleteEmployee()"
                  >
                    Delete
                  </button>
                </div>
                <div v-else class="col-md-12 gap-2 d-flex">
                  <button
                    type="submit"
                    class="btn btn-primary waves-effect waves-light"
                  >
                    Create</button
                  >&nbsp;
                  <button
                    type="button"
                    class="btn btn-warning waves-effect waves-light"
                    @click="store.resetForm"
                  >
                    Clear
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
