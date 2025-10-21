<script setup>
import { useDepartmentStore } from "../stores/hr/DepartmentStore";
import FormField from "./FormField.vue";

const departmentsStore = useDepartmentStore();

</script>
<template>
  <div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent="departmentsStore.submitForm">
          <div class="modal-header">
            <h5 class="modal-title">Submit Info</h5>
            <button
              type="button"
              class="btn-close"
              @click="departmentsStore.closeModal('formModal')"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12 mx-auto">
                <div class="row g-6 pb-6">
                  <div class="col-md-12">
                    <FormField
                      label="Department Name"
                      name="name"
                      id="name"
                      type="text"
                      placeholder=""
                      v-model="departmentsStore.form.name"
                      :error="departmentsStore.form.name"
                    />
                  </div>
                  <div class="col-md-12">
                    <FormField
                      label="Department Code"
                      name="code"
                      id="code"
                      type="text"
                      placeholder=""
                      v-model="departmentsStore.form.code"
                      :error="departmentsStore.form.code"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="submit"
              class="btn btn-primary waves-effect waves-light"
              :disabled="departmentsStore.loading"
            >
              <span
                class="spinner-border spinner-border-sm me-2"
                v-if="departmentsStore.loading"
                role="status"
                aria-hidden="true"
              ></span>
              Submit</button
            >&nbsp;
            <button
              type="button"
              class="btn btn-warning waves-effect waves-light"
              :disabled="departmentsStore.loading"
              @click="departmentsStore.closeModal('formModal')"
            >
              Close
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>
