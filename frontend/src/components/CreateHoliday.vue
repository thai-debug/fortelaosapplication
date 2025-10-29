<script setup>
import { ref, watch, onMounted } from "vue";
import { useHolidayStore } from "../stores/hr/HolidayStore";
import FormField from "../components/FormField.vue";
import { useDateFormat } from "../stores/helper"; 

const store = useHolidayStore();
const isUpdate = ref(false);
const emit = defineEmits(['completed'])

watch(() => store.selectedHoliday, (holiday) => {
  if (holiday) {
    store.form.holidays_from_date = useDateFormat(holiday.holidays_from_date, 'DD-MM-YYYY')
    store.form.holidays_to_date = useDateFormat(holiday.holidays_to_date, 'DD-MM-YYYY')
    store.form.name = holiday.name
    store.form.is_public = holiday.is_public
    isUpdate.value = true
  }else{
    store.form.holidays_from_date = ''
    store.form.holidays_to_date = ''
    store.form.name = ''
    store.form.is_public = ''
    isUpdate.value = false
  }
}, { immediate: true })

// onMounted(async() => {
//   await store.fetchHolidays()
// })

const submit = async () => {
  try {
    if (isUpdate.value) {
      await store.updateHoliday(store.selectedHoliday.id, store.form)
    } else {
      await store.submitForm()
    }
    emit('completed')
  } catch (error) {
    console.log(error)
  }
}

const deleteHoliday = async () => {
  try {
    await store.deleteHoliday(store.selectedHoliday.id)
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
        <h5 class="card-title mb-sm-0 me-2">{{ isUpdate ? 'Update' : 'Create' }} Holiday</h5>
      </div>
      <div class="card-body pt-5">
        <form @submit.prevent="submit">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="row g-6 pb-6">
                <div class="col-md-12">
                  <FormField
                    label="Holiday name"
                    name="name"
                    id="name"
                    type="text"
                    placeholder=""
                    v-model="store.form.name"
                  />
                </div>
                <div class="col-md-6">
                  <p>{{ store.form.holidays_from_date }}</p>
                  <FormField
                    label="From Date"
                    name="from_date"
                    id="from_date"
                    type="date"
                    placeholder=""
                    v-model="store.form.holidays_from_date"
                  />

                </div>
                <div class="col-md-6">
                  <p>{{ store.form.holidays_to_date }}</p>
                  <FormField
                    label="To Date"
                    name="to_date"
                    id="to_date"
                    type="date"
                    placeholder=""
                    v-model="store.form.holidays_to_date"
                  />
                </div>
                <div class="col-md-12">
                  <FormField
                    label="Is Public"
                    name="is_public"
                    id="is_public"
                    type="switch"
                    placeholder=""
                    v-model="store.form.is_public"
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
                    @click="deleteHoliday"
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
