<script setup>
import { onMounted } from "vue";
import { useDepartmentStore } from "../../stores/hr/DepartmentStore";
import CreateDepartment from "@/components/CreateDepartment.vue";

const store = useDepartmentStore();

onMounted(() => {
  store.fetchDepartments();
});

const handleCompleted = async () => {
  await store.fetchDepartments();
};
</script>
<template>
  <div class="col-12">
    <div class="pb-4">
      <button
        class="btn btn-primary waves-effect waves-light"
        v-if="!store.showCreateForm"
        @click="store.toggleCreateForm(true)"
      >
        <i class="icon-base ri ri-add-line me-1_5"></i>New Department
      </button>

      <div v-if="store.showCreateForm">
        <button
          class="btn btn-primary waves-effect waves-light"
          @click="store.clearSelectedDepartment()"
        >
          <i class="icon-base ri ri-arrow-left-line me-1_5"></i>Back
        </button>
        <CreateDepartment @completed="handleCompleted" />
      </div>
    </div>

    <!--Department List-->
    <div v-if="!store.showCreateForm" class="card">
      <h5 class="card-header p-4">Department List</h5>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-hover" v-if="store.departments.length">
            <thead>
              <tr>
                <th class="text-truncate">NUMBER</th>
                <th class="text-truncate">DEPARTMENT NAME</th>
                <th class="text-truncate">CODE</th>
                <th class="text-truncate">ACTIONS</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr v-for="(dept, index) in store.departments" :key="dept.id">
                <td>
                  {{ index + 1 }}
                </td>
                <td>{{ dept.name }}</td>
                <td>{{ dept.code }}</td>
                <td>
                  <span
                    class="badge bg-warning rounded-pill cursor-pointer"
                    @click="store.setSelectedDepartment(dept)"
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
