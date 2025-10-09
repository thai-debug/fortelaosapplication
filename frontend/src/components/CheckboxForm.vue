<template>
    <div>
      <label class="form-check-label d-block">{{ label }}</label>
  
      <div
        v-for="(option, index) in options"
        :key="index"
        class="form-check form-check-inline"
      >
        <input
          class="form-check-input"
          type="checkbox"
          :id="`${name}-${option.value}`"
          :value="option.value"
          :checked="modelValue.includes(option.value)"
          @change="toggleCheckbox(option.value)"
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
      type: Array,
      default: () => []
    },
    options: {
      type: Array,
      required: true
    }
  })
  
  const emit = defineEmits(['update:modelValue'])
  
  function toggleCheckbox(value) {
    const newValue = [...props.modelValue]
    const index = newValue.indexOf(value)
  
    if (index > -1) {
      newValue.splice(index, 1)
    } else {
      newValue.push(value)
    }
  
    emit('update:modelValue', newValue)
  }
  </script>