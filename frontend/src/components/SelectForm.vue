<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  label: String,
  name: String,
  type: {
    type: String,
    default: "text",
  },
  placeholder: String,
  required: {
    type: Boolean,
    default: false,
  },
  modelValue: {
    type: [String, Number],
    default: "",
  },
  options: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(["update:modelValue"]);
</script>
<template>
  <div>
    <!-- Select -->
    <select
      v-if="type === 'select'"
      class="form-select"
      :id="name"
      :name="name"
      :required="required"
      :value="modelValue"
      @change="$emit('update:modelValue', $event.target.value)"
    >
      <option disabled value="">-- Select Department --</option>
      <option
        v-for="(option, index) in options"
        :key="index"
        :value="option.value"
      >
        {{ option.label }}
      </option>
    </select>
  </div>
</template>
