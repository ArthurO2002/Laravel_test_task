<script setup>

import Tasks from "./Tasks.vue";
import {useTaskStore} from "../store/taskStore.js";
import {onMounted} from "vue";
import {LoaderCircle} from "lucide-vue-next";


const taskStore = useTaskStore();


onMounted(async () => {
    await taskStore.getTasks()
})

</script>

<template>
    <div class="w-full bg-white dark:bg-gray-700 shadow rounded-lg p-6 mb-6">
        <div>
            <h1 class="text-2xl dark:text-white">All Tasks</h1>
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
