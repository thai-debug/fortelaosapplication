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
    <!-- Textarea -->
    <label :for="name">{{ label }}</label>
    <textarea
      v-if="type === 'textarea'"
      class="form-control active"
      :id="name"
      :name="name"
      :placeholder="placeholder"
      :value="modelValue"
      :required="required"
      @input="$emit('update:modelValue', $event.target.value)"
    ></textarea>
  </div>
</template>
