import axios from "axios";

const organization = {
  namespaced: true,
  state: {
    myOrganizations: [],
    formData: {},
    errors: {},
  },
  mutations: {
    setMyOrgnizations: (state, organizations) => {
      state.myOrganizations = organizations;
    },
    setErrors: (state, errors) => {
      for (const key in state.errors) {
        if (state.errors.hasOwnProperty(key)) {
          delete state.errors[key];
        }
      }
      errors.map((error) => {
        state.errors[error.propertyPath] = error.title;
      });
    },
  },
  actions: {
    getMyOrganizations: async ({ commit }) => {
      const { data } = await axios.get(
        "/organizations/organizations-current-organization",
        {
          headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
        }
      );
      commit("setMyOrgnizations", data);
    },

    createOrganization: async ({ dispatch, commit }, payload) => {
      const { data } = await axios.post(
        "/organizations",
        { ...payload },
        {
          headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
        }
      );
      console.log(data);
      data.violations && commit("setErrors", data.violations);
    },

    deleteOrganization: async ({ dispatch }, id) => {
      // console.log(id)
      try {
        const { data } = await axios.delete(`/organizations/${id}`, {
          headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
        });
        console.log(data);
        dispatch("getMyOrganizations");
      } catch (errors) {
        console.log(errors);
      }
    },
  },
};

export default organization;
