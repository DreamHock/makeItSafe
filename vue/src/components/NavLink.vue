<template>
  <RouterLink class="p-2 hover:bg-cyan-700 w-full flex justify-center" :to="props.to">
    <div>
      {{ props.name }}
    </div>
  </RouterLink>
</template>

<script setup>
const props = defineProps({
  to: String,
  name: String,
});
</script>

<style lang="scss" scoped></style>
