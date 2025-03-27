<script lang="ts" setup>
import { useTaskStore } from '@/store/taskStore'

const taskStore = useTaskStore()
const filterTasks = status => {
  taskStore.setStatusFilter(status)
}
</script>

<template>
  <div class="w-full mb-3">
    <button
      :class="{
        'bg-blue-900 dark:bg-blue-900': taskStore.filterStatus === null,
        'bg-blue-600 dark:bg-blue-600': taskStore.filterStatus !== null
      }"
      class="text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer"
      @click="filterTasks(null)"
    >
      All
    </button>
    <button
      :class="{
        'bg-blue-900 dark:bg-blue-900': taskStore.filterStatus === true,
        'bg-blue-600 dark:bg-blue-600': taskStore.filterStatus !== true
      }"
      class="text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer"
      @click="filterTasks(true)"
    >
      Completed
    </button>
    <button
      :class="{
        'bg-blue-900 dark:bg-blue-900': taskStore.filterStatus === false,
        'bg-blue-600 dark:bg-blue-600': taskStore.filterStatus !== false
      }"
      class="text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer"
      @click="filterTasks(false)"
    >
      To Do
    </button>
  </div>
</template>
