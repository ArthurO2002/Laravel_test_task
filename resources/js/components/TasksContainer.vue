<script lang="ts" setup>
import Tasks from './Tasks.vue'
import { useTaskStore } from '@/store/taskStore'
import { ChevronRight, ChevronLeft, ArrowUpNarrowWide, ArrowDownNarrowWide } from 'lucide-vue-next'
import Loading from '@/components/common/Loading.vue'
import { storeToRefs } from 'pinia'
import { SortingEnum } from '@/Enums/SortingEnum'

const taskStore = useTaskStore()
const { payload, getTasks } = taskStore
const { fetchLoading, sortOrder, filterStatus } = storeToRefs(taskStore)

const toggleSort = async () => {
  sortOrder.value = sortOrder.value === SortingEnum.ASC ? SortingEnum.DESC : SortingEnum.ASC
  await getTasks(payload.currentPage, filterStatus.value, sortOrder.value)
}

const nextPage = async () => {
  if (payload.currentPage < payload.totalPages) {
    await getTasks(payload.currentPage + 1)
  }
}

const prevPage = async () => {
  if (payload.currentPage > 1) {
    await getTasks(payload.currentPage - 1)
  }
}
</script>

<template>
  <div class="w-full bg-white dark:bg-gray-700 shadow rounded-lg p-6 mb-6">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl dark:text-white">All Tasks</h1>
      <div class="flex items-center gap-4">
        <button
          class="flex items-center gap-2 px-3 py-1 bg-gray-200 dark:bg-gray-600 rounded hover:bg-gray-300 dark:hover:bg-gray-500 cursor-pointer"
          title="Toggle sort order"
          @click="toggleSort"
        >
          <div v-if="sortOrder === SortingEnum.ASC">
            <ArrowUpNarrowWide class="dark:text-white" />
          </div>
          <div v-else>
            <ArrowDownNarrowWide class="dark:text-white" />
          </div>
          <span class="dark:text-white">
            Sort by Date ({{ sortOrder === SortingEnum.DESC ? 'Newest' : 'Oldest' }})
          </span>
        </button>
        <p class="dark:text-white">Total Tasks: {{ payload.totalTasks }}</p>
      </div>
    </div>
    <div class="mt-3">
      <div v-if="fetchLoading" class="flex justify-center items-center py-4">
        <Loading :style-class="'text-blue-500'" />
      </div>
      <div v-else>
        <div v-if="!payload.tasks.length">
          <p class="text-gray-300">No tasks available</p>
        </div>
        <ul v-else>
          <Tasks v-for="task in payload.tasks" :key="task.id" :task="task" />
        </ul>
        <div class="mt-4 flex justify-between items-center">
          <button
            :disabled="payload.currentPage === 1"
            class="px-4 py-2 flex justify-center items-center bg-blue-500 rounded disabled:opacity-50 cursor-pointer"
            @click="prevPage"
          >
            <ChevronLeft class="text-white" />
          </button>
          <span class="dark:text-white">
            Page {{ payload.currentPage }} of {{ payload.totalPages }}
          </span>
          <button
            :disabled="payload.currentPage === payload.totalPages"
            class="flex justify-center items-center px-4 py-2 bg-blue-500 rounded disabled:opacity-50 cursor-pointer"
            @click="nextPage"
          >
            <ChevronRight class="text-white" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
