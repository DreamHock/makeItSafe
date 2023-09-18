<script setup>
import { ref } from "vue";
import { useStore } from "vuex";
const props = defineProps({
  userForm: Object,
});
let user = ref(props.userForm);
const { errors } = useStore().state.user;

const inputClasses =
  "appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline disabled:bg-gray-200";
</script>

<template>
  <div class="py-8 px-12 flex flex-col">
    <h2
      class="block text-gray-700 text-xl font-bold mb-6 pb-1 border-b-4 border-b-gray-200"
    >
      1.compte utilisateur
    </h2>
    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2" for="nom"
        >Email <span class="text-red-500">*</span></label
      >
      <input
        v-model="user.email"
        :class="inputClasses"
        type="text"
        id="email"
        required
      />
      <div class="text-red-500">{{ errors.email ? errors.email : errors.emailTaken }}</div>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2" for="language"
        >langue <span class="text-red-500">*</span></label
      >
      <select
        v-model="user.language"
        :class="inputClasses"
        id="language"
        required
      >
        <option value="1">Arabe</option>
        <option value="2">Englais</option>
        <option value="3">Francais</option>
      </select>
      <div class="text-red-500">{{ errors.language }}</div>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2" for="role"
        >Role <span class="text-red-500">*</span></label
      >
      <select v-model="user.role" :class="inputClasses" id="role" required>
        <option value="ROLE_ADMINISTRATEUR">Administrateur</option>
        <option value="ROLE_COMMANDITAIRE">Commanditaire</option>
        <option value="ROLE_AUDITEUR">Auditeur</option>
        <option value="ROLE_AUDITE">Audité</option>
      </select>
      <div class="text-red-500">{{ errors.role }}</div>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2"
        >Role technique<span class="text-red-500">*</span></label
      >
      <div>
        <input type="checkbox" v-model="user.technicalRoles.ROLE_ADMIN" />
        ROLE_ADMIN <br />
        <input type="checkbox" v-model="user.technicalRoles.ROLE_USER" />
        ROLE_USER <br />
        <input type="checkbox" v-model="user.technicalRoles.ROLE_INTERVIEW" />
        ROLE_INTERVIEW
      </div>
      <div class="text-red-500">{{ errors.technicalRoles }}</div>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2" for="endValidation"
        >Date de fin de validite d l'invitation</label
      >
      <input
        v-model="user.endValidationAt"
        :class="inputClasses"
        type="date"
        id="endValidation"
      />
      <div class="text-red-500">{{ errors.endValidationAt }}</div>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 font-bold mb-2" for="endDemo"
        >Date de fin de demo</label
      >
      <input
        v-model="user.endDemoAt"
        :class="inputClasses"
        type="date"
        id="endDemo"
      />
      <div class="text-red-500">{{ errors.endDemoAt }}</div>
    </div>
    <div class="mb-4 flex items-center gap-2">
      <label class="block text-gray-700 font-bold" for="confirmInvitation"
        >Confirmez-vous l'invitation de cet utilisateur
        <span class="text-red-500">*</span></label
      >
      <input
        v-model="user.confirmInvitation"
        type="checkbox"
        id="confirmInvitation"
        required
      />
      <div class="text-red-500">{{ errors.hasNotifications }}</div>
    </div>
    <div class="mb-4 flex items-center gap-2">
      <label class="block text-gray-700 font-bold" for="enableNotification"
        >Desactiver les notifications <span class="text-red-500">*</span></label
      >
      <input
        v-model="user.enableNotifications"
        type="checkbox"
        id="enableNotification"
        required
      />
      <div class="text-red-500">{{ errors.hasInvitation }}</div>
    </div>
  </div>
</template>
