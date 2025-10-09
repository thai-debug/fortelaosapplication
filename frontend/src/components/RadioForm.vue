<template>
    <div>
      <label class="form-label d-block">{{ label }}</label>
  
      <div
        v-for="(option, index) in options"
        :key="index"
        class="form-check form-check-inline"
      >
        <input
          class="form-check-input"
          type="radio"
          :id="`${name}-${option.value}`"
          :name="name"
          :value="option.value"
          :checked="modelValue === option.value"
          @change="$emit('update:modelValue', option.value)"
        />
        <label class="form-check-label" :for="`${name}-${option.value}`">
          {{ option.label }}
        </label>
      </div>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({
    label: String,
    name: String,
    modelValue: {
      type: String,
      default: ''
    },
    options: {
      type: Array,
      required: true
    }
  })
  
  const emit = defineEmits(['update:modelValue'])
  </script>
  