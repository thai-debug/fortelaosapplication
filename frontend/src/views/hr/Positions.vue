<script setup>
import { usePositionStore } from "../../stores/hr/PositionStore";
import CreatePosition from "../../components/CreatePosition.vue";
import { onMounted } from "vue";

const store = usePositionStore();

const handleCompleted = async () => {
  await store.fetchPositions();
};

onMounted(() => {
  store.fetchPositions();
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
        <i class="icon-base ri ri-add-line me-1_5"></i>New Position
      </button>

      <div v-if="store.showCreateForm">
        <button
          class="btn btn-primary waves-effect waves-light"
          @click="store.clearSelectedPosition()"
        >
          <i class="icon-base ri ri-arrow-left-line me-1_5"></i>Back
        </button>
        <CreatePosition @completed="handleCompleted" />
      </div>
    </div>

    <!--Position List-->
    <div v-if="!store.showCreateForm" class="card">
      <h5 class="card-header p-4">Position List</h5>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-hover" v-if="store.positions.length">
            <thead>
              <tr>
                <th class="text-truncate">NUMBER</th>
                <th class="text-truncate">POSITION NAME</th>
                <th class="text-truncate">LEVEL</th>
                <th class="text-truncate">DEPARTMENT</th>
                <th class="text-truncate">ACTIONS</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr v-for="(pos, index) in store.positions" :key="pos.id">
                <td>
                  {{ index + 1 }}
                </td>
                <td>{{ pos.title }}</td>
                <td>{{ pos.level }}</td>
                <td>{{ pos.department.name }}</td>
                <td>
                  <span
                    class="badge bg-warning rounded-pill cursor-pointer"
                    @click="store.setSelectedPosition(pos)"
                    >Edit</span
                  >
                </td>
              </tr>
            </tbody>
          </table>
          <div v-else>
            <p>No positions found.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
