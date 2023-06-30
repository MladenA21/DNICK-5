<template>
  <NavigationComponent />
  <div class="page-title">
    <h2 class="heading-2">Admin</h2>
    <router-link
      :to="{
        name: 'ProductView',
      }"
      class="button"
    >
      <img src="@/assets/icons/plusIcon.svg" alt="" />
      Create a product
    </router-link>
  </div>
  <div class="tire-wrapper">
    <div class="tire-box" v-for="tire in tires" :key="tire.id">
      <img src="@/assets/greenBackground.png" class="green-background" />
      <img :src="tire.image_url" class="tire-box-image" />
      <div class="tire-box-title">
        <p class="heading-4 tire-box-title-name">
          {{ tire.name }}
        </p>
        <p class="heading-5">
          {{ tire.type }}
        </p>
      </div>
      <div class="tire-box-row">
        <p class="heading-5">{{ tire.price }} €</p>
        <router-link
          :to="{
            name: 'ProductEdit',
            params: { id: tire.id },
          }"
          class="button"
          >Edit</router-link
        >
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { Product } from "@/types";
import { ref, onMounted } from "vue";
import axios from "axios";
import router from "@/router";

const tires = ref<Product[]>([]);

onMounted(() => {
  if (!window.isAuthenticated) {
    router.push({ name: "LoginView" });
  }

  getProducts();
});

function getProducts() {
  axios
    .get("/api/tires")
    .then((response) => {
      tires.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
}
</script>
