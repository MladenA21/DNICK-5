<template>
  <NavigationComponent />

  <div class="product-page">
    <div class="product-page-box">
      <div class="tire-box">
        <img src="@/assets/greenBackground.png" class="green-background" />
        <img :src="product.image_url" class="tire-box-image" v-if="product.image_url" />
        <div class="tire-box-title">
          <p class="heading-4 tire-box-title-name">
            {{ product.name ? product.name : "Name" }}
          </p>
          <p class="heading-5">
            {{ product.type ? product.type : "Type" }}
          </p>
        </div>
        <p class="heading-5">{{ product.price ? product.price + "€" : "Price" }}</p>
      </div>
    </div>
    <div class="product-page-box">
      <div class="product-page-box-form">
        <h5 class="product-page-box-form-title heading-5">
          {{ router.currentRoute.value.params.id ? "Edit product" : "Add product" }}
        </h5>
        <div class="product-page-box-form-fields">
          <InputComponent
            v-model="product.name"
            :class="{
              'is-invalid': validation.name.$error,
            }"
            :error-message="validation.name.$error ? 'Required' : ''"
            :place-holder="'Name'"
          />

          <InputComponent
            v-model="product.image_url"
            :class="{
              'is-invalid': validation.image_url.$error,
            }"
            :error-message="validation.image_url.$error ? 'Required' : ''"
            :place-holder="'Image'"
          />

          <InputComponent
            v-model="product.brand"
            :class="{
              'is-invalid': validation.brand.$error,
            }"
            :error-message="validation.brand.$error ? 'Required' : ''"
            :place-holder="'Brand'"
          />

          <InputComponent
            v-model="product.type"
            :class="{
              'is-invalid': validation.type.$error,
            }"
            :error-message="validation.type.$error ? 'Required' : ''"
            :place-holder="'Type'"
          />
          <InputComponent
            v-model="product.price"
            :class="{
              'is-invalid': validation.price.$error,
            }"
            :error-message="validation.price.$error ? 'Required' : ''"
            :place-holder="'Price'"
          />
        </div>
        <button class="button is-invalid" v-if="router.currentRoute.value.params.id" @click="deleteProduct">
          Delete
        </button>

        <button class="button" @click="submit">
          <img src="@/assets/icons/plusIcon.svg" alt="" />

          {{ router.currentRoute.value.params.id ? "Edit Product" : "Create Product" }}
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { Product } from "@/types";
import { ref, computed, onMounted } from "vue";
import { useVuelidate, ValidationRule } from "@vuelidate/core";
import { required } from "@vuelidate/validators";
import axios from "axios";
import router from "@/router";

const product = ref<Product>({
  name: "",
  price: 0,
  image_url: "",
  brand: "",
  type: "",
});

const validationRules = computed(() => {
  const localRules: Record<string, Record<string, ValidationRule | Record<string, ValidationRule>>> = {};
  localRules.name = {
    required,
  };

  localRules.price = {
    required,
  };

  localRules.image_url = {
    required,
  };

  localRules.brand = {
    required,
  };

  localRules.type = {
    required,
  };

  return localRules;
});

const validation = useVuelidate(validationRules, product);
const submitted = ref(false);

onMounted(() => {
  if (!window.isAuthenticated) {
    router.push({ name: "LandingPage" });
  }

  if (router.currentRoute.value.params.id) {
    axios.get(`/api/tires/${router.currentRoute.value.params.id}`).then((response) => {
      product.value = response.data;
    });
  }
});

function deleteProduct() {
  axios.delete(`/api/tires/${router.currentRoute.value.params.id}`).then(() => {
    router.push({ name: "AdminView" });
    alert("deleted tire");
  });
}

function submit() {
  if (submitted.value) {
    return;
  }

  validation.value.$touch();

  if (validation.value.$error) {
    return;
  }
  submitted.value = true;

  if (router.currentRoute.value.params.id) {
    axios.post(`/api/tires/${router.currentRoute.value.params.id}`, product.value).then(() => {
      router.push({ name: "AdminView" });
    });
  } else {
    axios.post("/api/tires", product.value).then(() => {
      router.push({ name: "AdminView" });
    });
  }
}
</script>
