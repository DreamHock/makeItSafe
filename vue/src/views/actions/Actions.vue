<script setup>
import AuthLayout from "../layouts/AuthLayout.vue";
import { onBeforeMount, ref } from "vue";
import { useStore } from "vuex";
import Modal from "../../components/Modal.vue";
import CreateAction from "./CreateAction.vue";

const store = useStore();
const isOpen = ref(false);
onBeforeMount(() => {
  store.dispatch("action/getMyActions");
});

const deleteAction = (id) => {
  store.dispatch("action/deleteAction", id);
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
            v-for="action in $store.state.action.myActions"
            :key="action.id"
          >
            <div>{{ action.title }}</div>
            <button @click="deleteAction(action.id)">Delete</button>
          </li>
        </ul>
      </div>
    </div>
  </AuthLayout>
</template>
