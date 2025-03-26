<script setup>

import {useTaskStore} from "../store/taskStore.js";
import {useToast} from "vue-toastification";
import {ref} from "vue";

const taskStore = useTaskStore()
const toast = useToast()

const task = ref({
    title: '',
    description: ''
})

const isSubmitting = ref(false)
const errors = ref({});
const resetForm = () => {
    task.value = {
        title: '',
        description: '',
    };
    errors.value = {};
};

const createTask = async () => {
    try {
        isSubmitting.value = true;
        errors.value = {};

        // TODO replace with package validation
        if (!task.value.title.trim()) {
            errors.value.title = 'Title is required';
            isSubmitting.value = false;
            return;
        }

        const response = await taskStore.createTask(task.value);

        toast.success('Task created successfully');
        resetForm();

    } catch (error) {
        console.log(error)
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors;
        }
        toast.error(error.message || 'Failed to create task');
    } finally {
        isSubmitting.value = false;
    }
}

</script>

<template>
    <div class="w-full bg-white dark:bg-gray-700 shadow rounded-lg p-6 mb-6">
        <form @submit.prevent="createTask()">
            <div class="mb-3">
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                    name</label>
                <input
                    v-model="task.title" type="text" id="title"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Task title"
                    :disabled="isSubmitting"
                    required />
            </div>
            <div class="mb-3">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                    message</label>
                <textarea v-model="task.description" id="message" rows="4"
                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                          placeholder="Description"
                          :disabled="isSubmitting"
                ></textarea>

            </div>
            <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 cursor-pointer">
                Add Task
            </button>
        </form>
    </div>
</template>

<style scoped>

</style>
