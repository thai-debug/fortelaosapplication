import { defineStore } from "pinia";
import axios from "../../axios"; // your Axios config with CSRF setup
import Swal from "sweetalert2";

export const useEmployeeRoleStore = defineStore("employeeRole", {
  state: () => ({
    form: {
      name: "",
      descriptions: "",
    },

    employeeRoles: [],
    selectedEmployeeRole: null,
    showCreateForm: false,
    loading: false,
    success: false,
    error: null,
  }),

  actions: {
    async submitForm() {
      this.error = null;
      this.showLoading("Creating employment type...");

      try {
        await axios.get("/sanctum/csrf-cookie");
        const response = await axios.post("/api/roles", this.form);

        this.success = true;

        await Swal.fire({
          icon: "success",
          title: "Success",
          text: response.data.message || "Employment type created successfully!",
          timer: 5000,
          showConfirmButton: true,
          timerProgressBar: true,
        });

        this.toggleCreateForm(false);

        this.fetchEmployeeRoles();
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
    async fetchEmployeeRoles() {
      this.showLoading("Loading employee roles...");
      this.error = null;

      try {
        const response = await axios.get("/api/roles");
        this.employeeRoles = response.data.data || response.data;
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to load employee roles";
      } finally {
        this.closeLoading();
      }
    },


    // Update department options
    async updateEmployeeRole(id, data) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently update this employee role!",
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
          this.showLoading("Updating employee role...");
          const response = await axios.put(`/api/roles/${id}`, data);
          const updated = response.data.data || response.data;
          const index = this.employeeRoles.findIndex((emp) => emp.id === id);
          if (index !== -1) {
            this.employeeRoles[index] = updated;
            this.clearSelectedEmployeeRole();
            this.success = true;

            await Swal.fire({
              icon: "success",
              title: "Success",
              text: "Employee role updated successfully!",
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
    async deleteEmployeeRole(id) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently delete this employee role!",
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
          this.showLoading("Deleting employee role...");
          await axios.delete(`/api/roles/${id}`);
          this.employeeRoles = this.employeeRoles.filter((emp) => emp.id !== id);
          this.clearSelectedEmployeeRole();
          this.success = true;

          await Swal.fire({
            icon: "success",
            title: "Success",
            text: "Employee role deleted successfully!",
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
        name: "",
        descriptions: "",
      };
      this.success = false;
      this.error = null;
    },

    // toggleCreateForm(show)
    toggleCreateForm(show) {
      this.showCreateForm = show;
    },

    // selected department
    setSelectedEmployeeRole(employeeRole) {
      //console.log(position)
      this.selectedEmployeeRole = employeeRole;
      this.showCreateForm = true;
    },

    // clear selected department
    clearSelectedEmployeeRole() {
      this.selectedEmployeeRole = null;
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
