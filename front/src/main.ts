import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import NavigationComponent from "./components/NavigationComponent.vue";
import InputComponent from "./components/InputComponent.vue";
import axios from "axios";

const app = createApp(App);

declare global {
  interface Window {
    isAuthenticated: boolean;
    // userData: UserInfo;
  }
}

declare module "vue" {
  interface ComponentCustomProperties {
    window: Window;
  }
}
axios
  .get("/api/user-info/")
  .then((response) => {
    if (response.data) {
      window.isAuthenticated = true;
      // window.userData = response.data;
    }
  })
  .catch(() => {
    window.isAuthenticated = false;
  })
  .finally(() => {
    app.use(router);
    app.component("NavigationComponent", NavigationComponent);
    app.component("InputComponent", InputComponent);

    app.mount("#app");
  });
