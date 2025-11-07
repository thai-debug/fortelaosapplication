<script setup>
import { useEmployeeRoleStore } from "../../stores/hr/EmployeeRoleStore";
import CreateEmployeeRole from "../../components/CreateEmployeeRole.vue";
import { onMounted } from "vue";

const store = useEmployeeRoleStore();


const handleCompleted = async () => {
  await store.fetchEmployeeRoles();
};

onMounted(() => {
  store.fetchEmployeeRoles();
});

</script>
<template>
  <div class="col-12">
    <!--Create Position-->
    <div class="pb-4">
      <button
        class="btn btn-primary waves-effect waves-light"
        v-if="!store.showCreateForm"
        @click="store.toggleCreateForm(true)"
      >
        <i class="icon-base ri ri-add-line me-1_5"></i>New Employee Role
      </button>

      <div v-if="store.showCreateForm">
        <button
          class="btn btn-primary waves-effect waves-light"
          @click="store.clearSelectedEmployeeRole()"
        >
          <i class="icon-base ri ri-arrow-left-line me-1_5"></i>Back
        </button>
        <CreateEmployeeRole @completed="handleCompleted" />
      </div>
    </div>

    <!--Position List-->
    <div v-if="!store.showCreateForm" class="card">
      <h5 class="card-header p-4">Employee Role List</h5>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-hover" v-if="store.employeeRoles.length">
            <thead>
              <tr>
                <th class="text-truncate">NUMBER</th>
                <th class="text-truncate">NAME</th>
                <th class="text-truncate">DESCRIPTION</th>
                <th class="text-truncate">ACTIONS</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr v-for="(emp, index) in store.employeeRoles" :key="emp.id">
                <td>
                  {{ index + 1 }}
                </td>
                <td>{{ emp.name }}</td>
                <td>{{ emp.descriptions }}</td>
                <td>
                  <span
                    class="badge bg-warning rounded-pill cursor-pointer"
                    @click="store.setSelectedEmployeeRole(emp)"
                    >Edit</span
                  >
                </td>
              </tr>
            </tbody>
          </table>
          <div v-else>
            <p>No employee roles found.</p>
          </div>
        </div>        
      </div>
    </div>
  </div>
</template>
