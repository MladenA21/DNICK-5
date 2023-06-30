<template>
  <NavigationComponent />

  <div class="payment-page">
    <div class="filters-wrapper">
      <h4 class="heading-4">Checkout</h4>

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
      </div>
    </div>
    <div class="payment-page-box">
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
    <div class="payment-page-box">
      <div class="payment-page-box-form">
        <h5 class="heading-5 payment-page-box-title">Your Information</h5>
        <div class="payment-page-box-fields">
          <InputComponent
            v-model="customer.name"
            :class="{
              'is-invalid': validation.name.$error,
            }"
            :error-message="validation.name.$error ? 'Required' : ''"
            :place-holder="'Name'"
          />

          <InputComponent
            v-model="customer.email"
            :class="{
              'is-invalid': validation.email.$error,
            }"
            :error-message="validation.email.$error ? 'Required' : ''"
            :place-holder="'Email'"
          />

          <InputComponent
            v-model="customer.address"
            :class="{
              'is-invalid': validation.address.$error,
            }"
            :error-message="validation.address.$error ? 'Required' : ''"
            :place-holder="'Address'"
          />

          <InputComponent
            v-model="customer.cardHolder"
            :class="{
              'is-invalid': validation.cardHolder.$error,
            }"
            :error-message="validation.cardHolder.$error ? 'Required' : ''"
            :place-holder="'Card Holder'"
          />

          <InputComponent
            v-model="customer.cardNumber"
            :class="{
              'is-invalid': validation.cardNumber.$error,
            }"
            :error-message="validation.cardNumber.$error ? 'Required' : ''"
            :place-holder="'Card Number'"
          />

          <InputComponent
            v-model="customer.cardExpiration"
            :class="{
              'is-invalid': validation.cardExpiration.$error,
            }"
            :error-message="validation.cardExpiration.$error ? 'Required' : ''"
            :place-holder="'Card Expiration'"
          />

          <InputComponent
            v-model="customer.cardCvv"
            :class="{
              'is-invalid': validation.cardCvv.$error,
            }"
            :error-message="validation.cardCvv.$error ? 'Required' : ''"
            :place-holder="'Card CVV'"
          />
        </div>
        <button class="button" @click="pay">
          <img src="@/assets/icons/cartIcon.svg" />
          Pay Now
        </button>
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { Product } from "@/types";
import { ref, computed, onMounted } from "vue";
import { useVuelidate, ValidationRule } from "@vuelidate/core";
import { required, email } from "@vuelidate/validators";
import router from "@/router";

onMounted(() => {
  getTires();
});

const tires = ref<Product[]>([]);

const customer = ref({
  name: "",
  email: "",
  address: "",
  cardHolder: "",
  cardNumber: "",
  cardExpiration: "",
  cardCvv: "",
});

const validationRules = computed(() => {
  const localRules: Record<string, Record<string, ValidationRule | Record<string, ValidationRule>>> = {};
  localRules.name = {
    required,
  };

  localRules.email = {
    required,
    email,
  };

  localRules.address = {
    required,
  };

  localRules.cardHolder = {
    required,
  };

  localRules.cardNumber = {
    required,
  };

  localRules.cardExpiration = {
    required,
  };

  localRules.cardCvv = {
    required,
  };

  return localRules;
});

const validation = useVuelidate(validationRules, customer);

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
}

function pay() {
  validation.value.$touch();

  if (validation.value.$error) {
    return;
  }
  localStorage.removeItem("cart");
  router.push({ name: "ConfirmationView" });
}
</script>
