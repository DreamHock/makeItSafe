<script setup>
import { ref } from "vue";
import { useStore } from "vuex";
import CreateLayout from "../layouts/CreateLayout.vue";
import ContactForm from "./components/ContactForm.vue";
import UserForm from "./components/UserForm.vue";

const store = useStore();

const contactForm = ref({
  lastName: "",
  firstName: "",
  func: "",
  email: "",
  phone: "",
  useOrganizationAddress: true,
  organizationAddress: "120 blbl mlml dldl",
  address: "",
});
const userForm = ref({
  email: "",
  language: 1,
  role: "",
  technicalRoles: { ROLE_USER: true, ROLE_ADMIN: false, ROLE_INTERVIEW: false },
  endDemoAt: "",
  endValidationAt: "",
  confirmInvitation: true,
  enableNotifications: false,
});

const handleCreateUser = () => {
  store.dispatch("user/createUser", {
    contact: contactForm.value,
    user: userForm.value,
  });
};
</script>
<template>
  <CreateLayout
    name="Nouveau contact"
    :steps="['Details du contact', 'Compte utilisateur']"
  >
    <ContactForm :contactForm="contactForm" />
    <UserForm :userForm="userForm" />
    <div class="flex justify-between p-4">
      <RouterLink
        class="bg-white border border-blue-500 text-blue-500 py-2 px-4 rounded hover:bg-gray-200"
        to="/"
        >Annuler</RouterLink
      >
      <button
        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
        type="submit"
        @click="handleCreateUser"
      >
        Suivant
      </button>
    </div>
  </CreateLayout>
</template>
