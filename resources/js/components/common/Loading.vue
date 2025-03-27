<script setup lang="ts">
import { LoaderCircle } from 'lucide-vue-next'

interface ILoadingProps {
  styleClass?: string
}

const { styleClass } = defineProps<ILoadingProps>()
</script>

<template>
  <div class="animate-spin">
    <LoaderCircle :class="styleClass" />
  </div>
</template>

<style scoped>
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
