<script setup>
// import RouterLInk from "vue-router";
// import {defineProps} from "vue"

const props = defineProps({ name: String, steps: Array });
</script>

<template>
  <div class="flex min-h-screen">
    <div
      class="w-[150px] bg-cyan-900 text-gray-300 flex flex-col items-center text-[10px] font-bold"
    >
      <RouterLink class="px-3 py-1 mb-10" to="/home">
        <img
          src="https://www.makeitsafe.fr/wp-content/uploads/2022/09/logo-logiciel-cybersecurite-conformite-make-it-safe-blanc.png"
          alt="Make it safe logo"
        />
      </RouterLink>
      <div class="pointer-events-none">
        <div
          v-for="(step, index) in props.steps"
          class="flex gap-2 items-center mb-3"
        >
          <div class="border-2 py-1 px-2 rounded-full">{{ index + 1 }}</div>
          <div class="text-[7px]">{{ step }}</div>
        </div>
      </div>
    </div>
    <div class="flex flex-col w-full">
      <div
        class="h-12 bg-cyan-500 flex items-center justify-between px-8 text-gray-100"
      >
        <div>{{ props.name }}</div>
        <RouterLink to="/" >Retour</RouterLink>
      </div>
      <div><slot /></div>
    </div>
  </div>
</template>
