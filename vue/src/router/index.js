import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import Home from "../views/Home.vue";
import Organizations from "../views/organizations/Organizations.vue";
import CreateOrganization from "../views/organizations/CreateOrganization.vue";
import CreateUser from "../views/users/CreateUser.vue";
import Users from "../views/users/Users.vue";
// import CreateAction from "../views/actions/CreateAction.vue";
import Actions from "../views/actions/Actions.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/login",
      name: "login",
      component: Login,
      meta: { auth: false },
    },
    {
      path: "/home",
      name: "home",
      component: Home,
      meta: { auth: true },
    },
    {
      path: "/",
      component: Home,
      meta: { auth: true },
    },
    {
      path: "/organizations",
      name: "organizations",
      component: Organizations,
      meta: { auth: true },
    },
    {
      path: "/organizations/create",
      name: "organizations.create",
      component: CreateOrganization,
      meta: { auth: true },
    },
    {
      path: "/users/create",
      name: "createUser",
      component: CreateUser,
      meta: { auth: true },
    },
    {
      path: "/users",
      name: "users",
      component: Users,
      meta: { auth: true },
    },
    // {
    //   path: "/actions/create",
    //   name: "createAction",
    //   component: CreateAction,
    //   meta: { auth: true },
    // },
    {
      path: "/actions",
      name: "actions",
      component: Actions,
      meta: { auth: true },
    },
  ],
});

router.beforeEach((to, from, next) => {
  if (to.meta.auth && !localStorage.getItem("token")) {
    next("login");
  } else if (to.meta.auth === false && localStorage.getItem("token")) {
    next("home");
  } else {
    next();
  }
});

export default router;
