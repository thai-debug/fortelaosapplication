<script setup>
import { usePositionStore } from "../../stores/hr/PositionStore";
import { useDepartmentStore } from "../../stores/hr/DepartmentStore";
import FormField from "../../components/FormField.vue";
import { computed } from "vue";

const store = usePositionStore();
const departmentStore = useDepartmentStore();

const departments = computed(() => departmentStore.departments);
</script>
<template>
  <div class="col-12">
    <div class="card">
      <div
        class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row"
      >
        <h5 class="card-title mb-sm-0 me-2">New Position Form</h5>
      </div>
      <div class="card-body pt-5">
        <form @submit.prevent="store.submitForm">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="row g-6 pb-6">
                <div class="col-md-12">
                  <FormField
                    label="Department"
                    name="department_id"
                    id="department_id"
                    type="select"
                    placeholder=""
                    v-model="store.form.department_id"
                    :options="store.departmentOptions"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Position name"
                    name="title"
                    id="title"
                    type="text"
                    placeholder=""
                    v-model="store.form.title"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Level"
                    name="level"
                    id="level"
                    type="text"
                    placeholder=""
                    v-model="store.form.level"
                  />
                </div>

                <div class="col-md-12 gap-2 d-flex">
                  <button
                    type="submit"
                    class="btn btn-primary waves-effect waves-light"
                    :disabled="store.loading"
                  >
                    {{ store.loading ? "Submitting..." : "Submit" }}</button
                  >&nbsp;
                  <button
                    type="button"
                    class="btn btn-warning waves-effect waves-light"
                    :disabled="store.loading"
                    @click="store.resetForm"
                  >
                    Reset
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
