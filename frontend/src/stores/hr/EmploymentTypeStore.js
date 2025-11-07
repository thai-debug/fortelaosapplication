import { defineStore } from "pinia";
import axios from "../../axios"; // your Axios config with CSRF setup
import Swal from "sweetalert2";

export const useEmploymentTypeStore = defineStore("employmentType", {
  state: () => ({
    form: {
      name: "",
      descriptions: "",
    },

    employmentTypes: [],
    selectedEmploymentType: null,
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
        const response = await axios.post("/api/employment-types", this.form);

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

        this.fetchEmploymentTypes();
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
    async fetchEmploymentTypes() {
      this.showLoading("Loading employment types...");
      this.error = null;

      try {
        const response = await axios.get("/api/employment-types");
        this.employmentTypes = response.data.data || response.data;
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to load employment types";
      } finally {
        this.closeLoading();
      }
    },


    // Update department options
    async updateEmploymentType(id, data) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently update this employment type!",
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
          this.showLoading("Updating employment type...");
          const response = await axios.put(`/api/employment-types/${id}`, data);
          const updated = response.data.data || response.data;
          const index = this.employmentTypes.findIndex((emp) => emp.id === id);
          if (index !== -1) {
            this.employmentTypes[index] = updated;
            this.clearSelectedEmploymentType();
            this.success = true;

            await Swal.fire({
              icon: "success",
              title: "Success",
              text: "Employment type updated successfully!",
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
    async deleteEmploymentType(id) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently delete this employment type!",
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
          this.showLoading("Deleting employment type...");
          await axios.delete(`/api/employment-types/${id}`);
          this.employmentTypes = this.employmentTypes.filter((emp) => emp.id !== id);
          this.clearSelectedEmploymentType();
          this.success = true;

          await Swal.fire({
            icon: "success",
            title: "Success",
            text: "Employment type deleted successfully!",
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
    setSelectedEmploymentType(employmentType) {
      //console.log(position)
      this.selectedEmploymentType = employmentType;
      this.showCreateForm = true;
    },

    // clear selected department
    clearSelectedEmploymentType() {
      this.selectedEmploymentType = null;
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
