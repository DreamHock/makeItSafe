<script setup>
import { ref } from "vue";
import { useStore } from "vuex";

const store = useStore();

const username = ref("");
const password = ref("");

</script>

<template>
  <form
    class="flex flex-col gap-3"
    @submit.prevent="store.dispatch('user/handleLogin', { username, password })"
  >
    <div class="flex flex-col">
      email:
      <input
        class="border rounded-md"
        type="text"
        name="username"
        v-model="username"
      />
    </div>
    <div class="flex flex-col">
      password:
      <input
        class="border rounded-md"
        type="text"
        name="password"
        v-model="password"
      />
    </div>
    <button class="border rounded-md">Login</button>
  </form>
</template>
