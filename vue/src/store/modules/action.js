import axios from "axios";

const action = {
  namespaced: true,
  state: {
    myActions: [],
    errors: {},
    assign: {
      myOrganization: {},
      organizations: [],
      roles: [],
      users: [],
      loading: false,
    },
  },
  mutations: {
    setMyActions: (state, actions) => {
      state.myActions = actions;
    },
    setMyRoles: (state, roles) => {
      state.assign.roles = roles;
    },
    setMyUsers: (state, users) => {
      state.assign.users = users;
    },
    setMyOrgnizations: (state, organizations) => {
      state.assign.organizations = organizations;
    },
    setMyOrgnization: (state, myOrganization) => {
      state.assign.myOrganization = myOrganization;
    },
    setAssignLoading: (state, loadingValue) => {
      state.assign.loading = loadingValue;
    },
    // setErrors: (state, errors) => {
    //   for (const key in state.errors) {
    //     if (state.errors.hasOwnProperty(key)) {
    //       delete state.errors[key];
    //     }
    //   }
    //   errors.map((error) => {
    //     state.errors[error.propertyPath] = error.title;
    //   });
    // },
  },
  actions: {
    getMyOrganizations: async ({ commit }) => {
      const { data } = await axios.get(
        "/organizations/organizations-current-organization",
        {
          headers: {
            Authorization: `bearer ${localStorage.getItem("token")}`,
          },
        }
      );
      commit("setMyOrgnizations", data);
      return data;
    },
    getMyOrganization: async ({ commit }) => {
      const { data } = await axios.get("/organizations/my-organization", {
        headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
      });
      commit("setMyOrgnization", data);
      return data;
    },
    getRolesByOrganization: async ({ commit }, organizationId) => {
      const { data } = await axios.get(
        `/roles/organization=${organizationId}`,
        {
          headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
        }
      );
      commit("setMyRoles", data);
      return data;
    },
    getUsersByOrganization: async ({ commit }, organizationId) => {
      const { data } = await axios.get(
        `/users/organization=${organizationId}`,
        {
          headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
        }
      );
      commit("setMyUsers", data);
      return data;
    },
    getUsersByRoleAndOrganization: async (
      { commit },
      { roleId, organizationId }
    ) => {
      const { data } = await axios.get(
        `/users/role=${roleId}-organization=${organizationId}`,
        {
          headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
        }
      );
      commit("setMyUsers", data);
      return data;
    },

    getMyActions: async ({ commit }) => {
      const { data } = await axios.get(
        "/actions/actions-current-organization",
        {
          headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
        }
      );
      commit("setMyActions", data);
    },

    createAction: async ({ dispatch, commit }, payload) => {
      const { data } = await axios.post(
        "/actions",
        { ...payload },
        {
          headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
        }
      );
      console.log(data);
    //   data.violations && commit("setErrors", data.violations);
    },

    deleteAction: async ({ dispatch }, id) => {
      // console.log(id)
      try {
        const { data } = await axios.delete(`/actions/${id}`, {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        });
        console.log(data);
        dispatch("getMyActions");
      } catch (errors) {
        console.log(errors);
      }
    },
  },
};

export default action;
