<template>
  <input
    class="
      block
      w-full
      border-gray-300
      rounded-md
      mt-1
      shadow-sm
      sm:text-sm
    "
    :class="{
      'border-gray-300': !hasError,
      'focus:ring-indigo-500': !hasError,
      'focus:border-indigo-500': !hasError,
      'border-red-300': hasError,
      'focus:ring-red-500': hasError,
      'focus:border-red-500': hasError,
    }"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    @focus="$event.target.select()"
    ref="input"
  />
</template>

<script>
export default {
  // props: ["modelValue"],
  props: {
    modelValue: {},
    hasError: {
      type: Boolean,
      default(){
        return false
      }
    }
  },
  emits: ["update:modelValue"],
  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
};
</script>