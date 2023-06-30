<template>
  <NavigationComponent />

  <div class="tires-page">
    <div class="filters-wrapper">
      <h4 class="heading-4">Filter by</h4>

      <div class="filters-wrapper-box">
        <p class="body-text-bold filters-wrapper-box-title">Brand</p>

        <div class="checkbox" v-for="brand in brands" :key="brand.value">
          <input type="checkbox" :id="brand.value" name="bmw" :value="brand.value" />
          <label class="body-text" :for="brand.value">{{ brand.name }}</label>
        </div>
      </div>

      <div class="filters-wrapper-box">
        <p class="body-text-bold filters-wrapper-box-title">Type</p>

        <div class="checkbox" v-for="tireType in types" :key="tireType.value">
          <input type="checkbox" :id="tireType.value" name="bmw" :value="tireType.value" />
          <label class="body-text" :for="tireType.value">{{ tireType.name }}</label>
        </div>
      </div>
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
          <button @click="addToCart(tire)" class="button">
            <img src="@/assets/icons/cartIcon.svg" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { Product } from "@/types";
import { ref, onMounted } from "vue";
import axios from "axios";

const tires = ref<Product[]>([]);

const brands = [
  {
    name: "Aeolus",
    value: "aeolus",
  },
  {
    name: "Birla Tyre",
    value: "birla",
  },
  {
    name: "Diamond Tyres Ltd",
    value: "diamond",
  },
  {
    name: "Continental AG",
    value: "continental",
  },
  {
    name: "Goodyear",
    value: "goodyear",
  },
];

const types = [
  {
    name: "Summer",
    value: "summer",
  },
  {
    name: "Winter",
    value: "winter",
  },
  {
    name: "All Season",
    value: "all-season",
  },
];

onMounted(() => {
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

function addToCart(tire: Product) {
  const cart = localStorage.getItem("cart");
  if (cart) {
    const parsedCart = JSON.parse(cart);
    parsedCart.push(tire);
    localStorage.setItem("cart", JSON.stringify(parsedCart));
    alert("Tire added to cart");
  } else {
    localStorage.setItem("cart", JSON.stringify([tire]));
  }
}
</script>
