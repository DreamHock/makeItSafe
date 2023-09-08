<script setup>
import { defineComponent, ref } from "vue";
import { useStore } from "vuex";
defineComponent({});
const props = defineProps({
  actionForm: Object,
});
const { errors } = useStore().state.action;
const complexities = [
  { id: 1, name: "Moderee" },
  { id: 2, name: "Complexe" },
  { id: 3, name: "Tres complexe" },
  // { id: 4, name: "Groupe" },
];
const priorities = [
  { id: 1, name: "Basse" },
  { id: 2, name: "Intermediare" },
  { id: 3, name: "Urgente" },
];

const inputClasses =
  "appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline disabled:bg-gray-200";
</script>

<template>
  <div class=" flex flex-col">
   
    <div class="mb-4">
      <label class="text-gray-700 font-bold mb-2" for="name"
        >Nom <span class="text-red-500">*</span></label
      >
      <input
        v-model="organization.name"
        :class="inputClasses"
        type="text"
        id="name"
        required
      />
      <div class="text-red-500">{{ errors.name }}</div>
    </div>
    <div class="mb-4">
      <label class="text-gray-700 font-bold mb-2 flex gap-1" for="relation"
        >Relation
        <span class="text-red-500"
          ><v-icon name="bi-exclamation-circle-fill" class="text-teal-400"
        /></span>
        <span class="text-red-500">*</span>
      </label>
      <select
        v-model="organization.relation"
        :class="inputClasses"
        id="relation"
        required
      >
        <option
          v-for="complexity in complexities"
          :value="complexity.id"
          :key="complexity.id"
        >
          {{ complexity.name }}
        </option>
      </select>
      <div class="text-red-500">{{ errors.complexity }}</div>
    </div>
    <div class="mb-4">
      <label class="text-gray-700 font-bold mb-2" for="postalCode"
        >Adresse postale</label
      >
      <input
        v-model="organization.postalAddress"
        :class="inputClasses"
        type="text"
        id="postalAddress"
        required
      />
      <div class="text-red-500">{{ errors.postalAddress }}</div>
    </div>
    <div class="flex gap-8 w-full">
      <div class="mb-4 w-1/2">
        <div class="flex justify-between items-center">
          <label class="text-gray-700 font-bold mb-2" for="postalCode"
            >Code postale</label
          >
          <input
            v-model="organization.postalCode"
            class="appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline disabled:bg-gray-200 w-8/12"
            type="text"
            id="postalCode"
            required
          />
        </div>
        <div class="text-red-500">{{ errors.postalCode }}</div>
      </div>
      <div class="mb-4 w-1/2">
        <div class="flex justify-between items-center">
          <label class="text-gray-700 font-bold mb-2" for="city">Ville</label>
          <input
            v-model="organization.city"
            class="appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline disabled:bg-gray-200 w-8/12"
            type="text"
            id="city"
            required
          />
        </div>
        <div class="text-red-500">{{ errors.city }}</div>
      </div>
    </div>
    <div class="mb-4">
      <label class="text-gray-700 font-bold mb-2" for="country"
        >Pays
        <span class="text-red-500">*</span>
      </label>
      <select v-model="organization.country" name="" id="country" :class="inputClasses">
        <option
          v-for="priority in priorities"
          :value="priority.id"
          :key="priority.id"
        >
          {{ priority.name }}
        </option>
      </select>
      <div class="text-red-500">{{ errors.priority }}</div>
    </div>
    <div class="mb-4">
      <label class="text-gray-700 font-bold mb-2" for="website">Site web</label>
      <input
        v-model="organization.website"
        :class="inputClasses"
        type="text"
        id="website"
      />
      <div class="text-red-500">{{ errors.website }}</div>
    </div>
    <div class="mb-4">
      <label class="text-gray-700 font-bold mb-2" for="siret">SIRET</label>
      <input
        v-model="organization.siret"
        :class="inputClasses"
        type="text"
        id="siret"
      />
      <div class="text-red-500">{{ errors.siret }}</div>
    </div>
    <div class="mb-4">
      <label class="text-gray-700 font-bold mb-2" for="activityArea"
        >secteur d'activite</label
      >
      <input
        v-model="organization.activityArea"
        :class="inputClasses"
        type="text"
        id="activityArea"
      />
      <div class="text-red-500">{{ errors.activityArea }}</div>
    </div>
  </div>
</template>
