<script setup>
import {computed, ref, onMounted} from "vue";

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
    type: [String, Number, Boolean, Array],
    default: "",
  },
  options: {
    type: Array,
    default: () => [],
  },
  rules: { type: Object, default: () => ({}) }, // e.g. { required: true, minLength: 3 }
  condition: { type: Function, default: () => true }, //condition to filter
});

const error = computed(() => {
  if (props.rules.required && !props.modelValue) {
    return "This field is required.";
  }
  if (
    props.rules.minLength &&
    props.modelValue.length < props.rules.minLength
  ) {
    return `Minimum length is ${props.rules.minLength}.`;
  }
  return "";
});

const emit = defineEmits(["update:modelValue"]);

function toggleCheckbox(value) {
  const newValue = Array.isArray(props.modelValue) ? [...props.modelValue] : [];
  const index = newValue.indexOf(value);

  if (index > -1) {
    newValue.splice(index, 1);
  } else {
    newValue.push(value);
  }

  emit("update:modelValue", newValue);
}
</script>

<template>
  <div v-if="type !== 'checkbox' && type !== 'switch'">
    <label :for="name" class="form-label">{{ label }}</label>

    <!-- Text, Email, Number -->
    <input
      v-if="['text', 'email', 'password', 'date'].includes(type)"
      :type="type"
      class="form-control"
      :id="name"
      :name="name"
      :placeholder="placeholder"
      :required="required"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
    />
    <div v-if="error" class="text-danger mt-1">{{ error }}</div>

    <!-- Textarea -->
    <textarea
      v-else-if="type === 'textarea'"
      class="form-control"
      :id="name"
      :name="name"
      :placeholder="placeholder"
      :required="required"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
    ></textarea>
    <div v-if="error" class="text-danger mt-1">{{ error }}</div>

    <!-- Select -->
    <select
      v-else-if="type === 'select'"
      class="form-select"
      :id="name"
      :name="name"
      :required="required"
      :value="modelValue"
      @change="$emit('update:modelValue', $event.target.value)"
    >
      <option disabled value="">-- Select an option --</option>
      <option
        v-for="(option, index) in options"
        :key="index"
        :value="option.value"
      >
        {{ option.label }}
      </option>
    </select>
    <div v-if="error" class="text-danger mt-1">{{ error }}</div>

    <!-- Radio -->
    <div v-else-if="type === 'radio'" class="d-block">
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
    <div v-if="error" class="text-danger mt-1">{{ error }}</div>
  </div>

  <!-- Checkbox -->
  <div class="mb-3" v-else-if="type === 'checkbox'">
    <label class="form-label d-block">{{ label }}</label>
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
    <div v-if="error" class="text-danger mt-1">{{ error }}</div>
  </div>

  <!-- Switch -->
  <div class="form-check form-switch mb-3" v-else-if="type === 'switch'">
    <input
      class="form-check-input"
      type="checkbox"
      :id="name"
      :checked="modelValue"
      @change="$emit('update:modelValue', $event.target.checked)"
    />
    <label class="form-check-label" :for="name">
      {{ label }}
    </label>
    <div v-if="error" class="text-danger mt-1">{{ error }}</div>
  </div>
</template>
