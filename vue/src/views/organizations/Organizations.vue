<script setup>
import AuthLayout from "../layouts/AuthLayout.vue";
import axios from "axios";
import { onBeforeMount } from "vue";
import { useStore } from "vuex";

const store = useStore();
onBeforeMount(() => {
  console.log(store.state.user.name);
  store.dispatch("organization/getMyOrganizations");
});

const deleteOrganization = (id) => {
  store.dispatch("organization/deleteOrganization", id);
};
</script>

<template>
  <AuthLayout>
    <div class="flex flex-col">
      <div class="flex justify-between items-center p-4 pb-6 border-b">
        <p>Organizations</p>
        <RouterLink
          to="/organizations/create"
          class="border rounded-md px-2 py-1"
          >Ajouter un</RouterLink
        >
      </div>
      <div class="p-4">
        <ul>
          <li
            class="flex items-center justify-between p-2"
            v-for="organization in $store.state.organization.myOrganizations"
            :key="organization.id"
          >
            <div>{{ organization.name }}</div>
            <button @click="deleteOrganization(organization.id)">Delete</button>
          </li>
        </ul>
      </div>
    </div>
  </AuthLayout>
</template>
