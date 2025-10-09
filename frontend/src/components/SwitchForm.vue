<template>
    <div>
      <input
        class="form-check-input"
        type="checkbox"
        :id="name"
        :checked="modelValue"
        @change="$emit('update:modelValue', $event.target.checked)"
      />
      <label class="form-check-label px-2" :for="name">
        {{ label }}
      </label>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({
    label: String,
    name: String,
    modelValue: {
      type: Boolean,
      default: false
    }
  })
  
  const emit = defineEmits(['update:modelValue'])
  </script>