<script setup>
import AuthLayout from "../layouts/AuthLayout.vue";
import axios from "axios";
import { onBeforeMount } from "vue";
import { useStore } from "vuex";

const store = useStore();
onBeforeMount(() => {
  console.log(store.state.user.name);
  store.dispatch("user/getMyUsers");
});

const deleteUser = (id) => {
  axios
    .delete(`/users/${id}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
    })
    .then((data) => {
      console.log(data);
    });
};
</script>

<template>
  <AuthLayout>
    <div class="flex flex-col">
      <div class="flex justify-between items-center p-4 pb-6 border-b">
        <p>Utilisateurs</p>
        <RouterLink to="/users/create" class="border rounded-md px-2 py-1"
          >Ajouter un</RouterLink
        >
      </div>
      <div class="p-4">
        <ul>
          <li
            class="flex items-center justify-between p-2"
            v-for="user in $store.state.user.myUsers"
            :key="user.id"
          >
            <div>{{ user.email }}</div>
            <button @click="deleteUser(user.id)">Delete</button>
          </li>
        </ul>
      </div>
    </div>
  </AuthLayout>
</template>
