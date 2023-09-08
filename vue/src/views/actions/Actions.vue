<script setup>
import AuthLayout from "../layouts/AuthLayout.vue";
import { onBeforeMount, ref } from "vue";
import { useStore } from "vuex";
import Modal from "../../components/Modal.vue";
import CreateAction from "./CreateAction.vue";

const store = useStore();
const isOpen = ref(false);
onBeforeMount(() => {
  console.log(store.state.user.name);
  store.dispatch("organization/getMyOrganizations");
});

const deleteOrganization = (id) => {
  store.dispatch("organization/deleteOrganization", id);
};

const openModal = () => {
  isOpen.value = true;
};
const closeModal = () => {
  isOpen.value = false;
};
</script>

<template>
  <AuthLayout>
    <div class="flex flex-col">
      <div class="flex justify-between items-center p-4 pb-6 border-b">
        <p class="text-2xl">Plan d'action</p>
        <button>
          <v-icon name="bi-plus-circle" class="text-teal-400" scale="2.5" @click="openModal"/>
          <Modal :isOpen="isOpen" :closeModal="closeModal" name="Nouvelle action">
            <CreateAction />
          </Modal>
        </button>
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
