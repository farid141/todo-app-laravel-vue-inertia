<script setup>
import { onMounted, ref } from "vue";

const props = defineProps({
  options: {
    type: Array,
    required: true,
    default: () => [],
  },
  labelField: {
    type: String,
    default: "label",
  },
  valueField: {
    type: String,
    default: "value",
  },
  placeholder: {
    type: String,
    default: "Select an option",
  },
  required: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
});

const model = defineModel({
  type: [String, Number],
  required: true,
});

const input = ref(null);

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
  }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <select
    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
    v-model="model"
    ref="input"
    :required="required"
    :disabled="disabled"
  >
    <option value="" selected>{{ placeholder }}</option>
    <option v-for="option in options" :key="option.id" :value="option.id">
      {{ option.name }}
    </option>
  </select>
</template>
