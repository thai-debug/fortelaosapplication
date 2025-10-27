import { defineStore } from "pinia";

export const useHelperStore = defineStore("helper", {
    state: () => ({
        showCreateForm: false,
        loading: false,
        success: false,
        error: null,
    })
})