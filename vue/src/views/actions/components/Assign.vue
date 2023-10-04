<script setup>
import { onBeforeMount, onMounted, watch } from "vue";
import { useStore } from "vuex";

const store = useStore();
const props = defineProps({
  actionForm: Object,
});
const assign = props.actionForm.assign;
onMounted(() => {
  store.commit("action/setAssignLoading", true);
  const getMyOrganizations = store.dispatch("action/getMyOrganizations");
  const getMyOrganization = store.dispatch("action/getMyOrganization");
  Promise.all([getMyOrganizations, getMyOrganization]).then((value) => {
    store.commit("action/setAssignLoading", false);
    props.actionForm.assign.organization =
      store.state.action.assign.myOrganization.id;
  });
});
watch(
  () => assign.organization,
  async (newValue, oldValue) => {
    store.commit("action/setAssignLoading", true);
    const getRolesByOrganization = store.dispatch(
      "action/getRolesByOrganization",
      newValue
    );
    const getUsersByOrganization = store.dispatch(
      "action/getUsersByOrganization",
      newValue
    );
    Promise.all([getRolesByOrganization, getUsersByOrganization]).then(
      (value) => {
        console.log(value);
        store.commit("action/setAssignLoading", false);
      }
    );
  }
);
watch(
  () => assign.role,
  async (newValue, oldValue) => {
    if (newValue !== "") {
      console.log(newValue);
      store.commit("action/setAssignLoading", true);
      const getUsersByRoleAndOrganization = store
        .dispatch("action/getUsersByRoleAndOrganization", {
          roleId: newValue,
          organizationId: assign.organization,
        })
        .then((res) => {
          console.log(res);
          store.commit("action/setAssignLoading", false);
        });
    }
  }
);
const inputClasses =
  "appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline disabled:bg-gray-200";
</script>
<template>
  <div class="relative">
    <div class="flex">
      <label class="text-gray-700 font-bold w-1/5" for="description"
        >Assigner A</label
      >
      <div class="flex flex-col flex-grow gap-2">
        <div class="flex">
          <label class="w-2/12" for="">Organisme</label>
          <select
            v-model="assign.organization"
            class="flex-grow"
            :class="inputClasses"
            name=""
            id=""
          >
            <option :value="store.state.action.assign.myOrganization.id">
              {{ store.state.action.assign.myOrganization.name }}
            </option>
            <option
              v-for="organization in store.state.action.assign.organizations"
              :value="organization.id"
            >
              {{ organization.name }}
            </option>
          </select>
        </div>
        <div class="flex gap-4">
          <div class="flex w-1/2 items-center">
            <label class="w-4/12" for="">Role</label>
            <select
              v-model="assign.role"
              :class="inputClasses"
              class="w-8/12"
              name=""
              id=""
            >
              <option value="">All</option>
              <option
                v-for="role in store.state.action.assign.roles"
                :value="role.id"
              >
                {{ role.name }}
              </option>
            </select>
          </div>
          <div class="flex w-1/2 items-center">
            <label class="w-4/12" for="">Utilisateurs</label>
            <select
              v-model="assign.user"
              :class="inputClasses"
              class="w-8/12"
              name=""
              id=""
            >
              <option value="">All</option>
              <option
                v-for="user in store.state.action.assign.users"
                :value="user.id"
              >
                {{ user.firstName }}
                {{ user.lastName }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div
      class="absolute top-0 left-0 w-full h-full bg-gray-100 bg-opacity-50 flex items-center justify-center"
      v-if="store.state.action.assign.loading"
    >
      <svg
        aria-hidden="true"
        class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
        viewBox="0 0 100 101"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
          fill="currentColor"
        />
        <path
          d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
          fill="currentFill"
        />
      </svg>
    </div>
  </div>
</template>
