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
    <!-- text -->
    <label :for="name">{{ label }}</label>
    <input
      v-if="type !== 'textarea' || type !== 'select'"
      :type="type"
      class="form-control active"
      :id="name"
      :name="name"
      :placeholder="placeholder"
      :required="required"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
    />


  </div>
</template>


