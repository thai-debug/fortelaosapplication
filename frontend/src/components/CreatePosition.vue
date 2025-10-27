<script setup>
import { ref, watch, onMounted, reactive } from "vue";
import { usePositionStore } from "../stores/hr/PositionStore";

import FormField from "../components/FormField.vue";

const store = usePositionStore();
const isUpdate = ref(false);
const emit = defineEmits(['completed'])

watch(() => store.selectedPosition, (pos) => {
  if (pos) {
    store.form.department_id = pos.department_id
    store.form.title = pos.title
    store.form.level = pos.level
    isUpdate.value = true
  }else{
    store.form.department_id = ''
    store.form.title = ''
    store.form.level = ''
    isUpdate.value = false
  }
}, { immediate: true })


onMounted(async() => {
  await store.fetchDepartments()
})

const submit = async () => {
  try {
    if (isUpdate.value) {
      await store.updatePosition(store.selectedPosition.id, store.form)
    } else {
      await store.submitForm()
    }
    emit('completed')
  } catch (error) {
    console.log(error)
  }
}

const deletePosition = async () => {
  try {
    await store.deletePosition(store.selectedPosition.id)
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
        <h5 class="card-title mb-sm-0 me-2">{{ isUpdate ? 'Update' : 'Create' }} Position</h5>
      </div>
      <div class="card-body pt-5">
        <form @submit.prevent="submit">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="row g-6 pb-6">
                <div class="col-md-12">
                  <label for="department_id" class="form-label">Department:</label>
                  <select
                    id="department_id"
                    name="department_id"
                    class="form-select"
                    v-model="store.form.department_id"
                  >
                    <option v-if="isUpdate" :value=store.selectedPosition.department_id>{{ store.selectedPosition.department.name }}</option>
                    <option v-else value="" disabled>--Select Department--</option>
                    <option
                      v-for="dep in store.departmentOptions"
                      :key="dep.id"
                      :value=dep.id
                    >
                      {{ dep.name }}
                    </option>
                  </select>

                </div>
                <div class="col-md-6">
                  <FormField
                    label="Position name:"
                    name="title"
                    id="title"
                    type="text"
                    placeholder=""
                    v-model="store.form.title"
                  />
                </div>
                <div class="col-md-6">
                  <FormField
                    label="Level:"
                    name="level"
                    id="level"
                    type="text"
                    placeholder=""
                    v-model="store.form.level"
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
                    @click="deletePosition"
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
