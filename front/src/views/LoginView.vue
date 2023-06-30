<template>
  <NavigationComponent />

  <div class="login-page">
    <form @submit.prevent="login">
      <p class="body-text login-title">Login</p>
      <div class="form-input-fields">
        <InputComponent
          v-model="user.email"
          :class="{
            'is-invalid': validation.email.$error,
          }"
          :error-message="validation.email.$error ? 'Required' : ''"
          :place-holder="'Email'"
          :input-type="'email'"
        />
        <InputComponent
          v-model="user.password"
          :class="{
            'is-invalid': validation.password.$error,
          }"
          :error-message="validation.password.$error ? 'Required' : ''"
          :place-holder="'Password'"
          :input-type="'password'"
        />
        <button class="button" type="submit">
          <img src="@/assets/icons/rightArrow.svg" alt="">
        </button>
      </div>
    </form>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted } from "vue";
import { useVuelidate, ValidationRule } from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import axios from "axios";
import router from "@/router";

onMounted(() => {
  if (window.isAuthenticated) {
    router.push({ name: "LandingPage" });
  }
});

const user = ref({
  email: "",
  password: "",
});
const validationRules = computed(() => {
  const localRules: Record<string, Record<string, ValidationRule | Record<string, ValidationRule>>> = {};
  localRules.email = {
    required,
    email,
  };

  localRules.password = {
    required,
  };

  return localRules;
});

const validation = useVuelidate(validationRules, user);
const submitted = ref(false);

function login() {
  validation.value.$touch();
  if (validation.value.$invalid) {
    alert('invalid credentials');
    return;
  }

  if (submitted.value) {
    return;
  }
  submitted.value = true;

  axios
    .post("/api/login", user.value)
    .then(() => {
      axios
        .get("/api/user-info")
        .then(() => {
          window.isAuthenticated = true;
          router.push({ name: "AdminView" });
        })
        .catch((error) => {
          console.log(error);
        });
    })
    .catch((error) => {
      console.log(error);
    })
    .finally(() => {
      submitted.value = false;
    });
}
</script>
