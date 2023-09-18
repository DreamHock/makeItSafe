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
  <div class="flex flex-col">
    <div class="mb-4">
      <label class="text-gray-700 font-bold" for="title"
        >titre <span class="text-red-500">*</span></label
      >
      <input
        v-model="actionForm.title"
        :class="inputClasses"
        type="text"
        id="title"
        required
      />
      <div class="text-red-500">{{ errors.title }}</div>
    </div>
    <div class="pr-16">
      <div class="mb-4 flex justify-between items-center flex-wrap">
        <label class="text-gray-700 font-bold flex gap-1" for="complexity"
          >Complexite
        </label>
        <select
          class="w-40"
          v-model="actionForm.complexity"
          :class="inputClasses"
          id="complexity"
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
        <label class="text-gray-700 font-bold flex gap-1" for="priority"
          >Priorite
        </label>
        <select
          class="w-40"
          v-model="actionForm.priority"
          :class="inputClasses"
          id="priority"
          required
        >
          <option
            v-for="priority in priorities"
            :value="priority.id"
            :key="priority.id"
          >
            {{ priority.name }}
          </option>
        </select>
      </div>
      <div class="text-red-500">{{ errors.complexity }}</div>
      <div class="text-red-500">{{ errors.priority }}</div>
    </div>
    <div class="mb-4">
      <label class="text-gray-700 font-bold" for="description"
        >Description</label
      >
      <textarea
        class="min-h-[150px]"
        v-model="actionForm.description"
        :class="inputClasses"
        id="description"
        required
      ></textarea>
      <div class="text-red-500">{{ errors.description }}</div>
    </div>
    <hr class="h-1 bg-gray-100 border-0 rounded" />
    <div class="font-bold">Pilotage</div>
    <div>
      <div class="mb-4 flex items-center justify-between">
        <label class="text-gray-700 font-bold" for="startAt"
          >Date de debut</label
        >
        <input
          v-model="actionForm.startAt"
          :class="inputClasses"
          class="w-[200px]"
          type="date"
          id="startAt"
          required
        />
        <label class="text-gray-700 font-bold" for="startAt"
          >Date de debut</label
        >
        <input
          v-model="actionForm.startAt"
          :class="inputClasses"
          class="w-[200px]"
          type="date"
          id="startAt"
          required
        />
      </div>
      <div class="text-red-500">{{ errors.startAt }}</div>
      <div class="text-red-500">{{ errors.dueAt }}</div>
    </div>
    <div class="mb-4">
      <label class="text-gray-700 font-bold" for="description"
        >Assigner A</label
      >
      <div>
        
      </div>
    </div>
  </div>
</template>
