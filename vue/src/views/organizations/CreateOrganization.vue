<script setup>
import { ref } from "vue";
import { useStore } from "vuex";
import CreateLayout from "../layouts/CreateLayout.vue";
import OrganizationForm from "./components/OrganizationForm.vue";

const store = useStore();

const organizationForm = ref({
  name: "",
  parent: "Webaide",
  relation: "",
  postalAddress: "",
  postalCode: "",
  city: "",
  country: "",
  website: "",
  siret: "",
  activityArea: "",
});

const handleCreateOrganizations = () => {
  store.dispatch("organization/createOrganization", {
    ...organizationForm.value,
  });
};
</script>
<template>
  <CreateLayout
    name="Nouveau organisme"
    :steps="[`Details de l'organisme`, `representant`]"
  >
    <OrganizationForm :organizationForm="organizationForm" />
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
  </CreateLayout>
</template>
