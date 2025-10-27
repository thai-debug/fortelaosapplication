import { defineStore } from "pinia";
import axios from "../../axios"; // your Axios config with CSRF setup
import Swal from "sweetalert2";

export const usePositionStore = defineStore("position", {
  state: () => ({
    form: {
      title: "",
      level: "",
      department_id: "",
    },

    departmentOptions: [],
    positions: [],
    selectedPosition: null,
    showCreateForm: false,
    loading: false,
    success: false,
    error: null,
  }),

  actions: {
    async submitForm() {
      this.error = null;
      this.showLoading("Creating position...");

      try {
        await axios.get("/sanctum/csrf-cookie");
        const response = await axios.post("/api/positions", this.form);

        this.success = true;

        await Swal.fire({
          icon: "success",
          title: "Success",
          text: response.data.message || "Position created successfully!",
          timer: 5000,
          showConfirmButton: true,
          timerProgressBar: true,
        });

        this.toggleCreateForm(false);

        this.fetchPositions();
      } catch (err) {
        this.error = err.response?.data?.message || "Something went wrong!";

        await Swal.fire({
          icon: "error",
          title: "Error",
          text: this.error,
          timer: 5000,
          showConfirmButton: true,
          timerProgressBar: true,
        });
      } finally {
        this.closeLoading();
      }
    },

    // Fetch department options
    async fetchPositions() {
      this.showLoading("Loading positions...");
      this.error = null;

      try {
        const response = await axios.get("/api/positions");
        this.positions = response.data.data || response.data;
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to load positions";
      } finally {
        this.closeLoading();
      }
    },


    // Fetch department options
    async fetchDepartments() {
      this.loading = true;
      this.error = null;

      try {
        const response = await axios.get("/api/departments");
        this.departmentOptions = response.data.data || response.data;
        // this.departmentOptions = response.data.map(dep => ({
        //   value: dep.id,
        //   label: dep.name,
        // }));
      } catch (err) {
        this.error = "Failed to load department options";
      } finally {
        this.loading = false;
      }
    },


    // Update department options
    async updatePosition(id, data) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently update this position!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, update it!",
        cancelButtonText: "Cancel",
        timer: 5000,
        timerProgressBar: true,
      });

      if (result.isConfirmed) {
        try {
          this.showLoading("Updating position...");
          const response = await axios.put(`/api/positions/${id}`, data);
          const updated = response.data.data || response.data;
          const index = this.positions.findIndex((pos) => pos.id === id);
          if (index !== -1) {
            this.positions[index] = updated;
            this.clearSelectedPosition();
            this.success = true;

            await Swal.fire({
              icon: "success",
              title: "Success",
              text: "Position updated successfully!",
              timer: 5000,
              showConfirmButton: true,
              timerProgressBar: true,
            });
          }
        } catch (err) {
          this.error = err.response?.data?.message || "Something went wrong!";
          await Swal.fire({
            icon: "error",
            title: "Error",
            text: this.error,
            timer: 5000,
            showConfirmButton: true,
            timerProgressBar: true,
          });
        } finally {
          this.closeLoading();
        }
      }
    },

    // Delete department options
    async deletePosition(id) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently delete this position!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        timer: 5000,
        timerProgressBar: true,
      });

      if (result.isConfirmed) {
        try {
          this.showLoading("Deleting position...");
          await axios.delete(`/api/positions/${id}`);
          this.positions = this.positions.filter((pos) => pos.id !== id);
          this.clearSelectedPosition();
          this.success = true;

          await Swal.fire({
            icon: "success",
            title: "Success",
            text: "Position deleted successfully!",
            timer: 5000,
            showConfirmButton: true,
            timerProgressBar: true,
          });
        } catch (err) {
          this.error = err.response?.data?.message || "Something went wrong!";

          await Swal.fire({
            icon: "error",
            title: "Error",
            text: this.error,
            timer: 5000,
            showConfirmButton: true,
            timerProgressBar: true,
          });
        } finally {
          this.closeLoading();
        }
      }
    },

    resetForm() {
      this.form = {
        title: "",
        level: "",
        department_id: "",
      };
      this.success = false;
      this.error = null;
    },

    // toggleCreateForm(show)
    toggleCreateForm(show) {
      this.showCreateForm = show;
    },

    // selected department
    setSelectedPosition(position) {
      //console.log(position)
      this.selectedPosition = position;
      this.showCreateForm = true;
    },

    // clear selected department
    clearSelectedPosition() {
      this.selectedPosition = null;
      this.showCreateForm = false;
    },

    showLoading(message = "Processing...") {
      return Swal.fire({
        title: message,
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });
    },

    closeLoading() {
      return Swal.close();
    },
  },
});
