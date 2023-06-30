<template>
  <NavigationComponent />

  <div class="basket-page">
    <div class="filters-wrapper">
      <h4 class="heading-4">Cart</h4>

      <div class="filters-wrapper-box">
        <p class="body-text-bold filters-wrapper-box-title">Receipt</p>

        <p class="body-text" v-for="tire in tires" :key="tire.id">
          {{ tire.name }}
        </p>
      </div>
      <div class="filters-wrapper-bottom">
        <div class="filters-wrapper-bottom-title">
          <p class="body-text">Total</p>
          <p class="body-text" v-if="totalCalculated">{{ totalCalculated }} €</p>
        </div>

        <router-link
          :to="{
            name: 'PaymentView',
          }"
          class="button"
        >
        <img src="@/assets/icons/cartIcon.svg" alt="">
          Proceed to payment
        </router-link>
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
          <button @click="removeCar(tire)" class="button is-invalid">
            <img src="@/assets/icons/cartIcon.svg" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { Product } from "@/types";
import { ref, computed, onMounted } from "vue";

onMounted(() => {
  getTires();
});

const tires = ref<Product[]>([]);

const totalCalculated = computed(() => {
  return tires.value.reduce((acc, car) => {
    return acc + car.price;
  }, 0);
});

function getTires() {
  const tiresFromStorage = localStorage.getItem("cart");
  if (tiresFromStorage) {
    tires.value = JSON.parse(tiresFromStorage);
  }
}

function removeCar(car: Product) {
  const index = tires.value.findIndex((c) => c.id === car.id);
  tires.value.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(tires.value));
  alert("Tire removed from cart");
}
</script>
