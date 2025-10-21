<script setup>
import { ref, watch } from "vue";
import { useDepartmentStore } from "../stores/hr/DepartmentStore";
import FormField from "../components/FormField.vue";

const store = useDepartmentStore();
const isUpdate = ref(false);
const emit = defineEmits(['completed'])

watch(() => store.selectedDepartment, (dep) => {
  if (dep) {
    store.form.name = dep.name
    store.form.code = dep.code
    isUpdate.value = true
  }else{
    store.form.name = ''
    store.form.code = ''
    isUpdate.value = false
  }
}, { immediate: true })

const submit = async () => {
  try {
    if (isUpdate.value) {
      await store.updateDepartment(store.selectedDepartment.id, store.form)
    } else {
      await store.submitForm()
    }
    emit('completed')
  } catch (error) {
    console.log(error)
  }
}

const deleteDepartment = async () => {
  try {
    await store.deleteDepartment(store.selectedDepartment.id)
    emit('completed')
  } catch (error) {
      console.log(error)
    }
}

</script>
<template>
  <div class="col-12 pt-4">
    <div class="card">
      <div
        class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row"
      >
        <h5 class="card-title mb-sm-0 me-2">{{ isUpdate ? 'Update' : 'Create' }} Department</h5>
      </div>
      <div class="card-body pt-5">
        <form @submit.prevent="submit">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="row g-6 pb-6">
                <div class="col-md-6">
                  <FormField
                    label="Department name"
                    name="name"
                    id="name"
                    type="text"
                    placeholder=""
                    v-model="store.form.name"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Code"
                    name="code"
                    id="code"
                    type="text"
                    placeholder=""
                    v-model="store.form.code"
                    
                  />
                </div>

                <div v-if="isUpdate" class="col-md-12 gap-2 d-flex">
                  <button
                    type="button"
                    class="btn btn-primary waves-effect waves-light"
                    @click="submit"
                  >
                    Update
                  </button>&nbsp;
                  <button
                    type="button"
                    class="btn btn-danger waves-effect waves-light"
                    @click="deleteDepartment"
                  >
                    Delete
                  </button>

                </div>
                <div v-else class="col-md-12 gap-2 d-flex">
                  <button
                    type="button"
                    class="btn btn-primary waves-effect waves-light"
                    @click="submit"
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
