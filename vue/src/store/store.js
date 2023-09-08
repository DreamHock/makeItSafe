import { createStore } from "vuex";
import user from "./modules/user";
import organization from "./modules/organization";

const store = createStore({ modules: { user, organization } });
export default store;
