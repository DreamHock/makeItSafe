<script setup>
import { defineComponent, ref } from "vue";
import { useStore } from "vuex";
defineComponent({});
const props = defineProps({
  organizationForm: Object,
});
let organization = ref(props.organizationForm);
const { errors } = useStore().state.organization;
const relations = [
  { id: 1, name: "Filiale" },
  { id: 2, name: "Sous-traitant" },
  { id: 3, name: "Client" },
  // { id: 4, name: "Groupe" },
];
const countries = [
  { id: 1, name: "France" },
  { id: 2, name: "Maroc" },
  { id: 3, name: "USA" },
];

const inputClasses =
  "appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline disabled:bg-gray-200";
</script>

<template>
  <div class="py-8 px-12 flex flex-col">
    <h2
      class="text-gray-700 text-xl font-bold mb-6 pb-1 border-b-4 border-b-gray-200"
    >
      1.details de l'organisme
    </h2>
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
          v-for="relation in relations"
          :value="relation.id"
          :key="relation.id"
        >
          {{ relation.name }}
        </option>
      </select>
      <div class="text-red-500">{{ errors.relation }}</div>
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
          v-for="country in countries"
          :value="country.id"
          :key="country.id"
        >
          {{ country.name }}
        </option>
      </select>
      <div class="text-red-500">{{ errors.country }}</div>
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
