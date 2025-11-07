<script setup>
import { onMounted } from "vue";
import { useEmployeeStore } from "../../stores/hr/EmployeeStore";
import CreateEmployee from "../../components/CreateEmployee.vue";

const store = useEmployeeStore();

const handleCompleted = async () => {
  await store.fetchEmployees();
};

onMounted(() => {
  store.fetchEmployees();
});

</script>
<template>
  <div class="col-12">
    <!--Create Employee-->
    <div class="pb-4">
      <button
        class="btn btn-primary waves-effect waves-light"
        v-if="!store.showCreateForm"
        @click="store.toggleCreateForm(true)"
      >
        <i class="icon-base ri ri-add-line me-1_5"></i>New Employee
      </button>

      <div v-if="store.showCreateForm">
        <button
          class="btn btn-primary waves-effect waves-light"
          @click="store.clearSelectedEmployee()"
        >
          <i class="icon-base ri ri-arrow-left-line me-1_5"></i>Back
        </button>
        <CreateEmployee @completed="handleCompleted" />
      </div>
    </div>

    <!--Employee List-->
    <div v-if="!store.showCreateForm" class="card">
      <h5 class="card-header p-4">Employee List</h5>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-hover" v-if="store.employees.length">
            <thead>
              <tr>
                <th class="text-truncate">NUMBER</th>
                <th class="text-truncate">Code</th>
                <th class="text-truncate">Staff Name</th>
                <th class="text-truncate">Email</th>
                <th class="text-truncate">Contact Number</th>
                <th class="text-truncate">Emergency Contact</th>
                <th class="text-truncate">Address</th>
                <th class="text-truncate">Gender</th>
                <th class="text-truncate">Date of Birth</th>
                <th class="text-truncate">Hired Date</th>
                <th class="text-truncate">Type</th>
                <th class="text-truncate">Department</th>
                <th class="text-truncate">Position</th>
                <th class="text-truncate">Status</th>
                <th class="text-truncate">ACTIONS</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr v-for="(employee, index) in store.employees" :key="employee.id">
                <td>
                  {{ index + 1 }}
                </td>
                <td>{{ employee.user_code }}</td>
                <td>{{ employee.first_name }} {{ employee.last_name }}</td>
                <td>{{ employee.email }}</td>
                <td>{{ employee.phone }}</td>
                <td>{{ employee.emergency_contact }}</td>
                <td>{{ employee.address }}</td>
                <td>{{ employee.gender }}</td>
                <td>{{ employee.dob }}</td>
                <td>{{ employee.hire_date }}</td>
                <td>{{ employee.employment_type.name }}</td>
                <td>{{ employee.department.name }}</td>
                <td>{{ employee.position.title }}</td>
                <td>{{ employee.status ? 'Enabled' : 'Disabled' }}</td>
                <td>
                  <span
                    class="badge bg-warning rounded-pill cursor-pointer"
                    @click="store.setSelectedEmployee(employee)"
                    >Edit</span
                  >
                </td>
              </tr>
            </tbody>
          </table>
          <div v-else>
            <p>No employees found.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
