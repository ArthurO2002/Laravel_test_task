<script setup>

import { Pencil, Trash2 } from "lucide-vue-next";
import {useTaskStore} from "../store/taskStore.js";
import {useToast} from "vue-toastification";

const taskStore = useTaskStore();
const toast = useToast();

const props = defineProps({
    task: {
        type: Object,
        required: true
    }
})

async function changeTaskStatus(event){
    try {
        const status = event.target.checked;
        await taskStore.updateTask({...props.task, status});
    } catch (error) {
        toast.error("Something when Wrong while updating the task.")
    }
}

async function deleteTask() {
    try {
        await taskStore.deleteTask(props.task.id)
        toast.success("Task deleted successfully!");
    } catch (error) {
        toast.error("Something when Wrong while updating the task.")
    }
}


</script>

<template>
    <li class="w-full">
        <div class="flex gap-3 dark:text-white border-b-1 p-3">
            <div class="flex items-center">
                <input :checked="props.task.status" @change="changeTaskStatus" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div :class="{ 'line-through text-gray-200': props.task.status }">
                <h2 class="text-xl font-bold">{{ props.task.title }}</h2>
                <p>{{ props.task.description }}</p>
            </div>
            <div>
                <div class="ml-4 flex-shrink-0 flex space-x-2">
                    <button class="text-gray-500 dark:text-white hover:text-gray-700 dark:hover:text-blue-500 focus:outline-none cursor-pointer">
                        <Pencil />
                    </button>
                    <button @click="deleteTask" class="text-red-500 hover:text-red-700 focus:outline-none cursor-pointer">
                        <Trash2 />
                    </button>
                </div>
            </div>
        </div>
    </li>
</template>

<style scoped>

</style>
