<script setup>
import { onMounted, onBeforeUnmount, ref } from "vue";
import { useStore } from "vuex";
const props = defineProps({
  contactForm: Object,
});
let contact = ref(props.contactForm);
const { errors } = useStore().state.user;

// onMounted(() => {
//   window.addEventListener("beforeunload", (e) => {
//     e.returnValue = "if you leave this page you will lose your data";
//   });
// });
// onBeforeUnmount(() => {
//   window.removeEventListener("beforeunload");
// });
const inputClasses =
  "appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline disabled:bg-gray-200";
</script>

<template>
  <div class="py-8 px-12 flex flex-col">
    <h2
      class="block text-gray-700 text-xl font-bold mb-6 pb-1 border-b-4 border-b-gray-200"
    >
      1.Details du contact
    </h2>
    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2" for="nom"
        >Nom <span class="text-red-500">*</span></label
      >
      <input
        v-model="contact.lastName"
        :class="inputClasses"
        type="text"
        id="nom"
        required
      />
      <span class="text-red-500">{{ errors.lastName }}</span>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2" for="prenom"
        >Prénom <span class="text-red-500">*</span></label
      >
      <input
        v-model="contact.firstName"
        :class="inputClasses"
        type="text"
        id="prenom"
        required
      />
      <span class="text-red-500">{{ errors.firstName }}</span>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2" for="func"
        >Fonction</label
      >
      <input
        v-model="contact.func"
        :class="inputClasses"
        type="text"
        id="func"
      />
      <span class="text-red-500">{{ errors.function }}</span>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2" for="email"
        >E-mail</label
      >
      <input
        v-model="contact.email"
        :class="inputClasses"
        type="text"
        id="email"
      />
      <span class="text-red-500">{{ errors.contactEmail }}</span>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2" for="phone"
        >Telephone</label
      >
      <input
        v-model="contact.phone"
        :class="inputClasses"
        type="text"
        id="phone"
      />
      <span class="text-red-500">{{ errors.phone }}</span>
    </div>

    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2">Adresse</label>
      <input
        v-model="contact.address"
        :class="inputClasses"
        type="text"
        :disabled="contact.useOrganizationAddress"
      />
      <span class="text-red-500">{{ errors.address }}</span>
      <label class="inline-flex items-center mt-2">
        <input
          v-model="contact.useOrganizationAddress"
          type="checkbox"
          class="form-checkbox"
        />
        <span class="ml-2">Use Organization Address</span>
      </label>
    </div>
  </div>
</template>
