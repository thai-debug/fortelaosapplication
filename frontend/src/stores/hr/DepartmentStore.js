import { defineStore } from "pinia";
import axios from "../../axios"; 
import Swal from "sweetalert2";

export const useDepartmentStore = defineStore("department", {
  state: () => ({
    form: {
      name: "",
      code: "",
    },

    departments: [],
    showCreateForm: false,
    selectedDepartment: null,
    loading: false,
    success: false,
    error: null,
  }),

  actions: {
    // Submit department options
    async submitForm() {
      this.error = null;
      this.showLoading("Creating department...");

      try {

          await axios.get("/sanctum/csrf-cookie");
          const response = await axios.post("/api/departments", this.form);

          this.success = true;

          await Swal.fire({
            icon: "success",
            title: "Success",
            text: response.data.message || "Department created successfully!",
            timer: 5000,
            showConfirmButton: true,
            timerProgressBar: true,
          });

          this.toggleCreateForm(false); // hide form after creation

          this.fetchDepartments();
          
 
      } catch (err) {
        this.error = err.response.data.message;
        
          await Swal.fire({
            icon: "error",
            title: "Error",
            text: this.error,
            timer: 5000,
            showConfirmButton: true,
            timerProgressBar: true,
          });

          this.toggleCreateForm(false); // hide form after showing error message
  
      }finally{
        this.closeLoading();
      }
    },

    // selected department
    setSelectedDepartment(department) {
      this.selectedDepartment = department;
      this.showCreateForm = true;
    },

    // clear selected department
    clearSelectedDepartment() {
      this.selectedDepartment = null;
      this.showCreateForm = false;
    },

    // toggleCreateForm(show)
    toggleCreateForm(show) {
      this.showCreateForm = show;
    },

    // Reset form
    resetForm() {
      this.form = {
        name: "",
        code: "",
      };
      this.success = false;
      this.error = null;
    },

    // Fetch department options
    async fetchDepartments() {
      this.showLoading("Loading departments...");
      this.error = null;
  
      try {
        const response = await axios.get("/api/departments");
        this.departments = response.data.data || response.data;
      } catch (err) {
        this.error =
          err.response?.data?.message || "Failed to load departments";
      } finally {
        this.closeLoading();
      }
    },

    // Update department options
    async updateDepartment(id, data) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently update this department!",
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
          this.showLoading("Updating department...");
          const response = await axios.put(`/api/departments/${id}`, data);
          const updated = response.data.data || response.data;
          const index = this.departments.findIndex((dept) => dept.id === id);
          if (index !== -1) {
            this.departments[index] = updated;
            this.clearSelectedDepartment();
            this.success = true;

            await Swal.fire({
              icon: "success",
              title: "Success",
              text: "Department updated successfully!",
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
    async deleteDepartment(id) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently delete this department!",
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
         this.showLoading("Deleting department...");
          await axios.delete(`/api/departments/${id}`);
          this.departments = this.departments.filter((dept) => dept.id !== id);
          this.clearSelectedDepartment();
          this.success = true;

          await Swal.fire({
            icon: "success",
            title: "Success",
            text: "Department deleted successfully!",
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
