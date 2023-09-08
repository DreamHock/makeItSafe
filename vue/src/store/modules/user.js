import axios from "axios";
import router from "../../router";

const user = {
  namespaced: true,
  state: {
    name: "hamid",
    user: {},
    myUsers: [],
    formData: {},
    errors: {},
  },
  mutations: {
    setUser: (state, user) => {
      state.user = user;
    },
    setMyUsers: (state, myUsers) => {
      state.myUsers = myUsers;
    },
    setErrors: async (state, errors) => {
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
    handleLogin: ({}, payload) => {
      axios
        .post("/login_check", {
          username: payload.username,
          password: payload.password,
        })
        .then((res) => {
          localStorage.setItem("token", res.data.token);
          router.push({ name: "home" });
        })
        .catch((e) => alert(e));
    },
    getUser: async ({ commit }) => {
      const { data } = await axios.get("/users/current-user", {
        headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
      });
      commit("setUser", data);
    },
    getMyUsers: async ({ commit }) => {
      const { data } = await axios.get("/users/users-current-organization", {
        headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
      });
      commit("setMyUsers", data);
    },
    createUser: async ({ dispatch, commit }, payload) => {
      // console.log(payload.user.email)
      const { data } = await axios.post(
        "/users",
        { ...payload },
        {
          headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
        }
      );
      console.log(data);
      data.violations && commit("setErrors", data.violations);
      dispatch("getMyUsers");
    },
    handleLogout: () => {
      localStorage.removeItem("token");
      window.location = "http://127.0.0.1:3000/login";
      // fetch("http://127.0.0.1:8000/logout", {
      //   method: "POST",
      //   headers: { Authorization: `bearer ${localStorage.getItem("token")}` },
      // })
      //   .then((res) => res)
      //   .then((data) => console.log(data));
    },
  },
};

export default user;
