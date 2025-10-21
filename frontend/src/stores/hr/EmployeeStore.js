import { defineStore } from "pinia";
import axios from "../../axios"; // your Axios config with CSRF setup


export const useFormStore = defineStore("form", {
  state: () => ({
    form: {
      first_name: "",
      last_name: "",
      employee_code: "",
      email: "",
      contactnumber: "",
      emergencycontact: "",
      address: "",
      gender: "",
      dob: "",
      hired_date: "",
      isactive: false,
      password: "",
    },
    
    genderOptions: [
      { label: "Male", value: "male" },
      { label: "Female", value: "female" },
      { label: "Other", value: "other" },
    ],

    positionOptions: [
      {
        label: "Assistant Manager, IT Support",
        value: "Assistant Manager, IT Support",
      },
      { label: "HR Officer", value: "HR Officer" },
      { label: "HR Manager", value: "HR Manager" },
      { label: "Legal Compliance Officer", value: "Legal Compliance Officer" },
      { label: "Accountant", value: "Accountant" },
      { label: "Sales Officer", value: "Sales Officer" },
      { label: "Marketing Officer", value: "Marketing Officer" },
      { label: "Claim Officer", value: "Claim Officer" },
    ],

    departmentOptions: [
      { label: "IT", value: "IT" },
      { label: "HR", value: "HR" },
      { label: "ADMIN", value: "ADMIN" },
      { label: "LEGAL & COMPLIANCE", value: "LEGAL&COMPLIANCE" },
      { label: "FINANCE", value: "FINANCE" },
      { label: "SALES", value: "SALES" },
      { label: "MARKETING", value: "MARKETING" },
      { label: "CLAIM", value: "CLAIM" },
    ],

    employmentTypeOptions: [
      { label: "Full-time", value: "Full-time" },
      { label: "Part-time", value: "Part-time" },
      { label: "Contract", value: "Contract" },
    ],

    activeOptions: [
      { label: "Active", value: "active" },
      { label: "Inactive", value: "inactive" },
    ],

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
        const response = await axios.post("/api/users", this.form);
        this.success = true;
        console.log("Submitted:", response.data);
      } catch (err) {
        this.error = "Submission failed.";
        console.error(err);
      } finally {
        this.loading = false;
      }
    },
  },
});
