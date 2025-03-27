<script setup>

import { Pencil, Trash2 } from "lucide-vue-next";
import {useTaskStore} from "../store/taskStore.js";
import {useToast} from "vue-toastification";
import {ref} from "vue";
import * as yup from 'yup';
import {useForm} from "vee-validate";


const taskStore = useTaskStore();
const toast = useToast();

const props = defineProps({
    task: {
        type: Object,
        required: true
    }
})

const editSchema = yup.object({
    title: yup.string().required('Task title is required'),
    description: yup.string()
        .max(500, 'Description cannot exceed 500 characters')
        .nullable()
});

const { handleSubmit, errors: formErrors, defineInputBinds } = useForm({
    validationSchema: editSchema,
    initialValues: {
        title: props.task.title,
        description: props.task.description
    }
});

const isEditing = ref(false);
const editedTitle = defineInputBinds("title");
const editedDescription = defineInputBinds("description");

async function changeTaskStatus(event){
    try {
        const status = event.target.checked;
        await taskStore.updateTask({...props.task, status});
        if (taskStore.filterStatus !== null && taskStore.filterStatus !== status) {
            taskStore.tasks = taskStore.tasks.filter(t => t.id !== props.task.id);
            taskStore.totalTasks--;
            taskStore.totalPages = Math.ceil(taskStore.totalTasks / taskStore.perPage);

            if (taskStore.tasks.length === 0 && taskStore.currentPage > 1) {
                await taskStore.getTasks(taskStore.currentPage - 1, taskStore.filterStatus);
            }
        }
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

const onSave = handleSubmit(async (values) => {
    try {
        const updatedTask = {
            ...props.task,
            title: values.title,
            description: values.description
        };
        await taskStore.updateTask(updatedTask);
        isEditing.value = false;
        toast.success("Task updated successfully!");
    } catch (error) {
        toast.error("Something went wrong while updating the task.");
    }
});

</script>

<template>
    <li class="w-full">
        <div class="flex gap-3 dark:text-white border-b-1 p-3">
            <div class="flex items-center">
                <input
                    :checked="props.task.status"
                    @change="changeTaskStatus"
                    type="checkbox"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                />
            </div>
            <div class="w-full">
                <div v-if="!isEditing" :class="{ 'line-through text-gray-400 dark:text-gray-200': props.task.status }">
                    <h2 class="text-xl font-bold">{{ props.task.title }}</h2>
                    <p>{{ props.task.description }}</p>
                </div>
                <template v-else>
                    <input v-bind="editedTitle" class="bg-gray-50 border mb-3 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    <span v-if="formErrors.title" class="text-red-500 text-sm">{{ formErrors.title }}</span>

                    <textarea v-bind="editedDescription" class="block p-2.5 w-full mb-3 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    <span v-if="formErrors.description" class="text-red-500 text-sm">{{ formErrors.description }}</span>

                    <button @click="onSave" class="text-white bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">Save</button>
                    <button @click="isEditing = false" class="text-white bg-red-400 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">Cancel</button>
                </template>
            </div>
            <div>
                <div class="ml-4 flex-shrink-0 flex space-x-2">
                    <button
                        @click="isEditing = true"
                        class="text-gray-500 dark:text-white hover:text-gray-700 dark:hover:text-blue-500 focus:outline-none cursor-pointer">
                        <Pencil />
                    </button>
                    <button @click="deleteTask"
                        class="text-red-500 hover:text-red-700 focus:outline-none cursor-pointer">
                        <Trash2 />
                    </button>
                </div>
            </div>
        </div>
    </li>
</template>

<style scoped>

</style>
