<template>
  <div class="">
    <div class="">
      <Disclosure v-slot="{ open }">
        <DisclosureButton class="">
          <span> {{ props.name }} </span>
        </DisclosureButton>
        <DisclosurePanel class="flex flex-col items-center">
          <slot />
        </DisclosurePanel>
      </Disclosure>
    </div>
  </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";

const props = defineProps({
  name: String,
});
</script>
