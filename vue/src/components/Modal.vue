<script setup>
const { isOpen, closeModal } = defineProps({
  isOpen: Boolean,
  closeModal: Function,
  name: String,
});

import { TransitionRoot, TransitionChild, Dialog } from "@headlessui/vue";
</script>
<template>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <div
              class="w-[800px] transform overflow-hidden rounded-sm bg-white text-left text-gray-800 align-middle shadow-xl transition-all"
            >
              <div class="border-b p-4 flex justify-between">
                <div class="font-bold">{{ name }}</div>
                <button @click="closeModal" class="font-extrabold">&#10005;</button>
              </div>
              <div class="py-5 px-7">
                <slot />
              </div>
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
