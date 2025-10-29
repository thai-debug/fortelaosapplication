<script setup>
import { onMounted } from "vue";
import { useHolidayStore } from "../../stores/hr/HolidayStore";
import CreateHoliday from "@/components/CreateHoliday.vue";
import { useDateFormat } from "../../stores/helper";

const store = useHolidayStore();

const handleCompleted = async () => {
  await store.fetchHolidays();
};

onMounted(() => {
  store.fetchHolidays();
});
</script>
<template>
  <div class="col-12">
    <div class="pb-4">
      <button
        class="btn btn-primary waves-effect waves-light"
        v-if="!store.showCreateForm"
        @click="store.toggleCreateForm(true)"
      >
        <i class="icon-base ri ri-add-line me-1_5"></i>New Holiday
      </button>

      <div v-if="store.showCreateForm">
        <button
          class="btn btn-primary waves-effect waves-light"
          @click="store.clearSelectedHoliday()"
        >
          <i class="icon-base ri ri-arrow-left-line me-1_5"></i>Back
        </button>
        <CreateHoliday @completed="handleCompleted" />
      </div>
    </div>

    <!--Holiday List-->
    <div v-if="!store.showCreateForm" class="card">
      <h5 class="card-header p-4">Holiday List</h5>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-hover" v-if="store.holidays.length">
            <thead>
              <tr>
                <th class="text-truncate">NUMBER</th>
                <th class="text-truncate">HOLIDAY NAME</th>
                <th class="text-truncate">FROM DATE</th>
                <th class="text-truncate">TO DATE</th>
                <th class="text-truncate">IS PUBLIC</th>
                <th class="text-truncate">ACTIONS</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr v-for="(holiday, index) in store.holidays" :key="holiday.id">
                <td>
                  {{ index + 1 }}
                </td>
                <td>{{ holiday.name }}</td>
                <td>{{ useDateFormat(holiday.holidays_from_date, 'DD-MM-YYYY') }}</td>
                <td>{{ useDateFormat(holiday.holidays_to_date, 'DD-MM-YYYY') }}</td>
                <td>{{ holiday.is_public ? 'Yes' : 'No' }}</td>
                <td>
                  <span
                    class="badge bg-warning rounded-pill cursor-pointer"
                    @click="store.setSelectedHoliday(holiday)"
                    >Edit</span
                  >
                </td>
              </tr>
            </tbody>
          </table>
          
        </div>
      </div>
    </div>
  </div>
</template>
