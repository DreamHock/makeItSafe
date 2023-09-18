import { createStore } from "vuex";
import user from "./modules/user";
import organization from "./modules/organization";
import action from "./modules/action";

const store = createStore({ modules: { user, organization, action } });
export default store;
