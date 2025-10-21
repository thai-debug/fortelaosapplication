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

    loading: false,
    success: false,
    error: null,
  }),

  actions: {
    async submitForm() {
      this.loading = true;
      this.error = null;

      try {
        await axios.get("/sanctum/csrf-cookie");
        const response = await axios.post("/api/positions", this.form);

        this.success = true;

        Swal.fire({
          icon: "success",
          title: "Success",
          text: response.data.message || "Position created successfully!",
          timer: 5000,
          showConfirmButton: true,
          timerProgressBar: true,
        });

        this.resetForm();

      } catch (err) {

        this.error = err.response?.data?.message || "Something went wrong!";

        Swal.fire({
          icon: "error",
          title: "Error",
          text: this.error,
          timer: 5000,
          showConfirmButton: true,
          timerProgressBar: true,
        });

      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.form = {
        title: "",
        level: "",
        department_id: "",
      }
      this.success = false;
      this.error = null;
    },
  },
});
