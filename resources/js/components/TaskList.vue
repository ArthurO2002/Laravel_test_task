<script lang="ts" setup>
import TasksContainer from './TasksContainer.vue'
import TaskForm from './TaskForm.vue'
import TaskNavigation from './TaskNavigation.vue'
import { onMounted } from 'vue'
import { FetchTasks } from '@/helpers/FetchTasks'

onMounted(() => {
  FetchTasks()
})
</script>

<template>
  <div class="w-full h-full overflow-scroll bg-white dark:bg-gray-600">
    <div class="w-full h-20 flex items-center justify-center bg-emerald-600 text-white p-3">
      <h1 class="text-2xl">ITask Manager</h1>
    </div>
    <div class="p-5">
      <TaskNavigation />
      <TaskForm />
      <TasksContainer />
    </div>
  </div>
</template>
