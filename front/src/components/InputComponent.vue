<template>
  <div class="input-component">
    <input :type="inputType" placeholder=" " :id="'input' + id" v-model="val" ref="inputComponent" />
    <label :for="'input' + id"
      >{{ placeHolder }} <template v-if="errorMessage">- {{ errorMessage }}</template></label
    >
    <div class="clear-input" :class="{ show: modelValue }" @click="clearModelValue"></div>
  </div>
</template>
<script setup lang="ts">
import { computed, defineEmits, defineProps, withDefaults, ref } from "vue";

const emit = defineEmits(["update:modelValue"]);
const inputComponent = ref<HTMLInputElement | null>(null);

const props = withDefaults(
  defineProps<{
    inputType?: string;
    placeHolder?: string;
    errorMessage?: string;
    modelValue?: unknown;
  }>(),
  {
    inputType: "text",
  }
);

const id = Math.random().toString(36).slice(2);

const val = computed({
  get: () => props.modelValue,
  set: (val) => {
    emit("update:modelValue", val);
  },
});

function clearModelValue() {
  val.value = "";
}
</script>
