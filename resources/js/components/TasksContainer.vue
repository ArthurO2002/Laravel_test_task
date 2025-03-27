<script setup>

import Tasks from "./Tasks.vue";
import {useTaskStore} from "../store/taskStore.js";
import {onMounted} from "vue";
import {LoaderCircle, ChevronRight, ChevronLeft} from "lucide-vue-next";


const taskStore = useTaskStore();

const nextPage = async () => {
    if (taskStore.currentPage < taskStore.totalPages) {
        await taskStore.getTasks(taskStore.currentPage + 1);
    }
};

const prevPage = async () => {
    if (taskStore.currentPage > 1) {
        await taskStore.getTasks(taskStore.currentPage - 1);
    }
};

</script>

<template>
    <div class="w-full bg-white dark:bg-gray-700 shadow rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl dark:text-white">All Tasks</h1>
            <p class="dark:text-white">Total Tasks: {{ taskStore.totalTasks }}</p>
        </div>
        <div class="mt-3">
            <div v-if="taskStore.fetchLoading" class="flex justify-center items-center py-4">
                <div class="animate-spin">
                    <LoaderCircle color="#2b7fff" />
                </div>
            </div>
            <div v-else>
                <div v-if="!taskStore.tasks.length">
                    <p class="text-gray-300">No tasks available</p>
                </div>
                <ul v-else>
                    <Tasks
                        v-for="task in taskStore.tasks"
                        :key="task.id"
                        :task="task"
                    />
                </ul>
                <div class="mt-4 flex justify-between items-center">
                    <button
                        @click="prevPage"
                        :disabled="taskStore.currentPage === 1"
                        class="px-4 py-2 flex justify-center items-center  bg-blue-500 rounded disabled:opacity-50 cursor-pointer"
                    >
                        <ChevronLeft color="#ffffff" />
                    </button>
                    <span class="dark:text-white">
                        Page {{ taskStore.currentPage }} of {{ taskStore.totalPages }}
                    </span>
                    <button
                        @click="nextPage"
                        :disabled="taskStore.currentPage === taskStore.totalPages"
                        class="flex justify-center items-center px-4 py-2 bg-blue-500 rounded disabled:opacity-50 cursor-pointer"
                    >
                        <ChevronRight color="#ffffff" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>
