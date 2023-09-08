<script setup>
import NavLink from "../../components/NavLink.vue";
import Disclosure from "../../components/Disclosure.vue";
import { onBeforeMount } from "vue";
import { useStore } from "vuex";

const store = useStore();
onBeforeMount(() => {
  store.dispatch("user/getUser");
});

const handleLogout = () => {
  store.dispatch("user/handleLogout")
}
</script>

<template>
  <div class="flex min-h-screen">
    <div
      class="w-[150px] bg-cyan-900 text-gray-300 flex flex-col items-center text-[10px] font-bold"
    >
      <RouterLink class="px-3 py-1" to="/home">
        <img
          src="https://www.makeitsafe.fr/wp-content/uploads/2022/09/logo-logiciel-cybersecurite-conformite-make-it-safe-bleu.png"
          alt="Make it safe logo"
        />
      </RouterLink>
      <div class="mb-4 font-extrabold text-white">
        {{ $store.state.user.user.email }}
      </div>
      <Disclosure name="Mon ecosystem">
        <NavLink to="/organizations" name="organismes" />
        <NavLink to="/users" name="utilisateurs" />
      </Disclosure>
      <!-- <NavLink to="/ecosystem" name="Mon ecosystem" /> -->
      <NavLink to="/actions" name="Actions" />
    </div>
    <div class="flex flex-col w-full">
      <div class="h-9 bg-gray-200 flex">
        <button @click="handleLogout()">Se deconnecter</button>
      </div>
      <div><slot /></div>
    </div>
  </div>
</template>
