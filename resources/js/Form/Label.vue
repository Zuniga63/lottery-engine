<template>
  <label class="block text-sm font-medium text-gray-700" :class="{required:required}">
    <span v-if="value">{{ value }}</span>
    <span v-else><slot></slot></span>
  </label>
</template>

<script>
export default {
  props:{
    value: String,
    required: {
      type: Boolean,
      default(){
        return false
      }
    },
  }
};
</script>

<style scoped>
/* 
  Regla para agregar un asterisco rojo 
  delante de un campo obligatorio
*/
.required:after{
  content: " *";
  color: #e73d4a;
}
</style>