<script lang="ts" setup>
import { useTaskStore } from '@/store/taskStore'
import { useForm } from 'vee-validate'
import { storeToRefs } from 'pinia'
import * as yup from 'yup'
import Loading from '@/components/common/Loading.vue'
import { TaskFormErrorsEnum } from '@/Enums/TaskFormErrorsEnum'

const taskStore = useTaskStore()
const { createTask } = taskStore
const { creationLoading } = storeToRefs(taskStore)
const schema = yup.object({
  title: yup.string().required(TaskFormErrorsEnum.Title),
  description: yup.string().max(500, TaskFormErrorsEnum.Description).nullable()
})

const {
  handleSubmit,
  errors: formErrors,
  resetForm,
  defineInputBinds
} = useForm({
  validationSchema: schema,
  initialValues: {
    title: '',
    description: ''
  }
})

const title = defineInputBinds('title')
const description = defineInputBinds('description')

const onSubmit = handleSubmit(values => {
  createTask({
    title: values.title,
    description: values.description || '',
    status: null
  })

  resetForm()
})
</script>

<template>
  <div class="w-full bg-white dark:bg-gray-700 shadow rounded-lg p-6 mb-6">
    <form @submit.prevent="onSubmit">
      <div class="mb-3">
        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
          Task Title
        </label>
        <input
          v-bind="title"
          id="title"
          type="text"
          name="title"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          placeholder="Task title"
          :disabled="creationLoading"
        />
        <span v-if="formErrors.title" class="text-red-500 text-sm">{{ formErrors.title }}</span>
      </div>
      <div class="mb-3">
        <label
          for="description"
          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        >
          Description
        </label>
        <textarea
          v-bind="description"
          id="description"
          name="description"
          rows="4"
          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          placeholder="Description"
          :disabled="creationLoading"
        />
        <div class="flex justify-between mt-3">
          <span v-if="formErrors.description" class="text-red-500 text-sm">{{
            formErrors.description
          }}</span>
          <span class="text-sm text-gray-500 dark:text-gray-400 ml-auto">
            {{ description.value?.length || 0 }}/500 characters
          </span>
        </div>
      </div>
      <button
        type="submit"
        :disabled="creationLoading"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
      >
        <span v-if="!creationLoading">Add Task</span>
        <span v-else class="flex items-center">
          <Loading />
          Loading...
        </span>
      </button>
    </form>
  </div>
</template>
