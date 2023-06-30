<template>
  <NavigationComponent />

  <div class="confirmation-page">
    <img src="@/assets/icons/paymentSuccessfulyIcon.svg" alt="" />
    <h2 class="heading-2">Payment successful!</h2>
    <router-link
      :to="{
        name: 'LandingPage',
      }"
      class="button"
      >Back to home</router-link
    >
  </div>
</template>
