<template>
  <NavigationComponent />
  <img src="@/assets/landingPage.png" />

  <div class="landing-page">
    <div class="landing-page-box">
      <h3 class="heading-3 landing-page-box-title">Summer Tires</h3>
      <p class="body-text">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
        standard dummy text ever since the 1500s.
      </p>
      <router-link
        :to="{
          name: 'TiresView',
        }"
        class="button"
      >
        See all
        <img src="@/assets/icons/rightIcon.svg" />
      </router-link>

      <img src="@/assets/icons/tirePhoto.png" class="tire-photo" alt="" />
    </div>
    <div class="landing-page-box">
      <h3 class="heading-3 landing-page-box-title">Winter Tires</h3>
      <img src="@/assets/icons/tirePhoto.png" class="tire-photo" alt="" />
      <p class="body-text">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
        standard dummy text ever since the 1500s.
      </p>
      <router-link
        :to="{
          name: 'TiresView',
        }"
        class="button"
      >
        See all
        <img src="@/assets/icons/rightIcon.svg" />
      </router-link>

    </div>

    <div class="landing-page-box">
      <h3 class="heading-3 landing-page-box-title">Custom Tires</h3>
      <p class="body-text">
        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
        standard dummy text ever since the 1500s.
      </p>
      <router-link
        :to="{
          name: 'TiresView',
        }"
        class="button"
      >
        See all
        <img src="@/assets/icons/rightIcon.svg" />
      </router-link>


      <img src="@/assets/icons/tirePhoto.png" class="tire-photo" alt="" />
    </div>
  </div>
</template>

<script lang="ts"></script>
