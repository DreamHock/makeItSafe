import axios from "axios";

const action = {
  namespaced: true,
  state: {
    myActions: [],
    errors: {},
  },
  mutations: {
    setMyActions: (state, actions) => {
      state.myActions = actions;
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
    getMyActions: async ({ commit }) => {
      const { data } = await axios.get(
        "/actions/actions-current-organization",
        {
          headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
        }
      );
      commit("setMyActions", data);
    },

    // createAction: async ({ dispatch, commit }, payload) => {
    //   const { data } = await axios.post(
    //     "/actions",
    //     { ...payload },
    //     {
    //       headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
    //     }
    //   );
    // //   console.log(data);
    // //   data.violations && commit("setErrors", data.violations);
    // },

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
