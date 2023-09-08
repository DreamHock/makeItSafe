<script setup>
import { ref } from "vue";
import { useStore } from "vuex";
import ActionForm from "./components/ActionForm.vue";

const store = useStore();

const actionForm = ref({
  organization: "",
  title: "",
  complexity: "",
  priority: "",
  description: "",
  startAt: "",
  dueAt: "",
  assign: {
    organization: "",
    role: "",
    user: "",
  },
});

const handleCreateOrganizations = () => {
  store.dispatch("organization/createOrganization", {
    ...organizationForm.value,
  });
};
</script>
<template>
  <ActionForm :actionForm="actionForm" />
  <div class="flex justify-between p-4">
    <RouterLink
      to="/"
      class="bg-white border border-blue-500 text-blue-500 py-2 px-4 rounded hover:bg-blue-50"
    >
      Annuler
    </RouterLink>
    <button
      class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
      type="submit"
      @click="handleCreateOrganizations"
    >
      Suivant
    </button>
  </div>
</template>
