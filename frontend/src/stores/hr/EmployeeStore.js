import { defineStore } from "pinia";
import axios from "../../axios"; // your Axios config with CSRF setup
import Swal from "sweetalert2";

export const useEmployeeStore = defineStore("employee", {
  state: () => ({
    form: {
      first_name: "",
      last_name: "",
      user_code: "",
      email: "",
      phone: "",
      emergency_contact: "",
      address: "",
      gender: "",
      dob: "",
      hire_date: "",
      status: false,
      password: "Admin@2025",
      password_confirmation: "Admin@2025",
      department_id: "",
      position_id: "",
      employment_type_id: "",
    },

    genderOptions: [
      { label: "Male", value: "male" },
      { label: "Female", value: "female" },
      { label: "Other", value: "other" },
    ],

    positionOptions: [],
    departmentOptions: [],
    employmentTypeOptions: [],
    statusOptions: [
      { label: "Active", value: "active" },
      { label: "Inactive", value: "inactive" },
    ],

    showCreateForm: false,
    selectedEmployee: null,
    employees: [],
    loading: false,
    success: false,
    error: null,
  }),

  actions: {
    async submitForm() {
      // Validate required fields
      if (
        !this.form.department_id ||
        !this.form.position_id ||
        !this.form.employment_type_id
      ) {
        this.error =
          "Please fill all required fields: Department, Position, and Employment Type";
        await Swal.fire({
          icon: "error",
          title: "Error",
          text: this.error,
          timer: 5000,
          showConfirmButton: true,
          timerProgressBar: true,
        });
        return;
      }

      this.showLoading("Creating employee...");

      this.error = null;
      try {
        await axios.get("/sanctum/csrf-cookie");
        const response = await axios.post("/api/users", this.form);

        this.success = true;

        await Swal.fire({
          icon: "success",
          title: "Success",
          text: response.data.message || "Employee created successfully!",
          timer: 5000,
          showConfirmButton: true,
          timerProgressBar: true,
        });

        //console.log(response.data);

        this.toggleCreateForm(false); // hide form after creation

        this.fetchEmployees();

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

        //this.toggleCreateForm(false); // hide form after showing error message
      } finally {
        this.closeLoading();
      }
    },

    // Update employee
    async updateEmployee(userCode, data) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently update this employee!",
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
          this.showLoading("Updating employee...");

          // Remove password confimation if password is not being changed
          if (!data.password) {
            delete data.password;
            delete data.password_confirmation;
          }

          const response = await axios.put(`/api/users/${userCode}`, data);
          const updated = response.data.data || response.data;

          // Update employee in the local state
          const index = this.employees.findIndex(
            (employee) => employee.user_code === userCode
          );

          if (index !== -1) {
            this.employees[index] = updated;
          }

          this.clearSelectedEmployee();
          this.success = true;

          await Swal.fire({
            icon: "success",
            title: "Success",
            text: "Employee updated successfully!",
            timer: 5000,
            showConfirmButton: true,
            timerProgressBar: true,
          });

          return updated;
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
          console.log(err.response.data.message);
          throw err;
        } finally {
          this.closeLoading();
        }
      }
    },

    // Delete employee
    async deleteEmployee(userCode) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently delete this employee!",
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
          this.showLoading("Deleting employee...");
          await axios.delete(`/api/users/${userCode}`);
          this.employees = this.employees.filter(
            (employee) => employee.user_code !== userCode
          );
          this.clearSelectedEmployee();
          this.success = true;

          await Swal.fire({
            icon: "success",
            title: "Success",
            text: "Employee deleted successfully!",
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
          console.log(err.response.data.message);
          throw err;
        } finally {
          this.closeLoading();
        }
      }
    },

    // clear selected employee
    clearSelectedEmployee() {
      this.selectedEmployee = null;
      this.showCreateForm = false;
    },

    // toggleCreateForm(show)
    toggleCreateForm(show) {
      this.showCreateForm = show;
    },

    // Reset form
    async resetForm() {
      this.form = {
        first_name: "",
        last_name: "",
        user_code: "",
        email: "",
        phone: "",
        emergency_contact: "",
        address: "",
        gender: "",
        dob: "",
        hire_date: "",
        status: false,
        password: "Admin@2025",
        password_confirmation: "Admin@2025",
        department_id: "",
        position_id: "",
        employment_type_id: "",
      };
      this.success = false;
      this.error = null;

      await this.generateNextEmployeeCode();
    },

    // Fetch employees
    async fetchEmployees() {
      this.showLoading("Loading employees...");
      this.error = null;

      try {
        const response = await axios.get("/api/users");
        this.employees = response.data.data || response.data;
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to load employees";
      } finally {
        this.closeLoading();
      }
    },

    // Fetch department options
    async fetchPositions() {
      this.error = null;

      try {
        const response = await axios.get("/api/positions");
        this.positionOptions = response.data.data || response.data;
      } catch (err) {
        this.error = err.response?.data?.message || "Failed to load positions";
      } finally {
        this.closeLoading();
      }
    },

    // Fetch department options
    async fetchEmploymentTypes() {
      this.error = null;

      try {
        const response = await axios.get("/api/employment-types");
        this.employmentTypeOptions = response.data.data || response.data;
      } catch (err) {
        this.error =
          err.response?.data?.message || "Failed to load employment types";
      } finally {
        this.closeLoading();
      }
    },

    // Fetch department options
    async fetchDepartments() {
      this.error = null;

      try {
        const response = await axios.get("/api/departments");
        this.departmentOptions = response.data.data || response.data;
      } catch (err) {
        this.error =
          err.response?.data?.message || "Failed to load departments";
      } finally {
        this.closeLoading();
      }
    },

    // generate next employee code
    async generateNextEmployeeCode() {
      try {
        if (!this.form.department_id) {
          console.warn("Department is not selected");
          return;
        }

        const response = await axios.get(
          `/api/users/next/${this.form.department_id}`
        );

        this.form.user_code = response.data.next_code;
      } catch (err) {
        console.log(err);

        this.form.user_code = "FL-XX000";
      } finally {
        this.closeLoading();
      }
    },

    // selected employee
    setSelectedEmployee(employee) {
      this.selectedEmployee = employee;

      this.showCreateForm = true;
    },

    // clear selected employee
    clearSelectedEmployee() {
      this.selectedEmployee = null;
      this.showCreateForm = false;
    },

    // toggleCreateForm(show)
    toggleCreateForm(show) {
      this.showCreateForm = show;
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
