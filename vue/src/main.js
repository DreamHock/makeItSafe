import { createApp } from "vue";
import "./style.css";
import "./axios";
import App from "./App.vue";
import router from "./router";
import store from "./store/store";
import { OhVueIcon, addIcons } from "oh-vue-icons";
import { BiPlusCircle } from "oh-vue-icons/icons";
import { BiExclamationCircleFill } from "oh-vue-icons/icons";

const app = createApp(App);
app.use(router);
app.use(store);

addIcons(BiPlusCircle, BiExclamationCircleFill);
app.component("v-icon", OhVueIcon);

app.mount("#app");
