import { defineStore } from "pinia";
import axios from "../../axios"; 
import Swal from "sweetalert2";

export const useHolidayStore = defineStore("holiday", {
  state: () => ({
    form: {
      name: "",
      holidays_from_date: "",
      holidays_to_date: "",
      is_public: "",
    },

    holidays: [],
    showCreateForm: false,
    selectedHoliday: null,
    loading: false,
    success: false,
    error: null,

  }),

  actions: {
    // Submit holiday
    async submitForm() {
      this.error = null;
      this.showLoading("Creating holiday...");

      try {

          await axios.get("/sanctum/csrf-cookie");
          const response = await axios.post("/api/holidays", this.form);

          this.success = true;

          await Swal.fire({
            icon: "success",
            title: "Success",
            text: response.data.message || "Holiday created successfully!",
            timer: 5000,
            showConfirmButton: true,
            timerProgressBar: true,
          });

          this.toggleCreateForm(false); // hide form after creation

          this.fetchHolidays();
          
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

          this.toggleCreateForm(false); // hide form after showing error message
  
      }finally{
        this.closeLoading();
      }
    },

    // selected holiday
    setSelectedHoliday(holiday) {
      //console.log(holiday)
      this.selectedHoliday = holiday;

      // this.form = {
      //   id: holiday.id,
      //   name: holiday.name,
      //   holidays_from_date: holiday.holidays_from_date ? holiday.holidays_from_date.split('T')[0] : '',
      //   holidays_to_date: holiday.holidays_to_date ? holiday.holidays_to_date.split('T')[0] : '',
      //   is_public: holiday.is_public,
      // }

      this.showCreateForm = true;
    },

    // clear selected holiday
    clearSelectedHoliday() {
      this.selectedHoliday = null;
      this.showCreateForm = false;
    },

    // toggleCreateForm(show)
    toggleCreateForm(show) {
      this.showCreateForm = show;
    },

    // Reset form
    resetForm() {
      this.form = {
        holidays_from_date: "",
        holidays_to_date: "",
        name: "",
        is_public: "",
      };
      this.success = false;
      this.error = null;
    },

    // Fetch holidays
    async fetchHolidays() {
      this.showLoading("Loading holidays...");
      this.error = null;
  
      try {
        const response = await axios.get("/api/holidays");
        this.holidays = response.data.data || response.data;
      } catch (err) {
        this.error =
          err.response?.data?.message || "Failed to load holidays";
      } finally {
        this.closeLoading();
      }
    },

    // Update holiday
    async updateHoliday(id, data) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently update this holiday!",
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
          this.showLoading("Updating holiday...");
          const response = await axios.put(`/api/holidays/${id}`, data);
          const updated = response.data.data || response.data;
          const index = this.holidays.findIndex((holiday) => holiday.id === id);
          if (index !== -1) {
            this.holidays[index] = updated;
            this.clearSelectedHoliday();
            this.success = true;

            await Swal.fire({
              icon: "success",
              title: "Success",
              text: "Holiday updated successfully!",
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

    // Delete holiday
    async deleteHoliday(id) {
      const result = await Swal.fire({
        title: "Are you sure?",
        text: "This action will permanently delete this holiday!",
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
         this.showLoading("Deleting holiday...");
          await axios.delete(`/api/holidays/${id}`);
          this.holidays = this.holidays.filter((holiday) => holiday.id !== id);
          this.clearSelectedHoliday();
          this.success = true;

          await Swal.fire({
            icon: "success",
            title: "Success",
            text: "Holiday deleted successfully!",
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
