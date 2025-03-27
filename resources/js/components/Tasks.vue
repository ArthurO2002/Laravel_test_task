<script lang="ts" setup>
import { Pencil, Trash2 } from 'lucide-vue-next'
import { useTaskStore } from '@/store/taskStore'
import * as yup from 'yup'
import { useForm } from 'vee-validate'
import { ITaskProps } from '@/types/ITaskProps'

const { payload, updateTask, filterStatus, getTasks, deleteTask, isEditingTask, setEditingTask } =
  useTaskStore()

const props = defineProps<ITaskProps>()

const editSchema = yup.object({
  title: yup.string().required('Task title is required'),
  description: yup.string().max(500, 'Description cannot exceed 500 characters').nullable()
})

const {
  handleSubmit,
  errors: formErrors,
  defineInputBinds,
  resetForm
} = useForm({
  validationSchema: editSchema,
  initialValues: {
    title: props.task.title,
    description: props.task.description
  }
})

const editedTitle = defineInputBinds('title')
const editedDescription = defineInputBinds('description')

async function changeTaskStatus(event: Event) {
  const target = event.target as HTMLInputElement
  const status = target.checked
  await updateTask({ ...props.task, status })
  if (filterStatus !== null && filterStatus !== status) {
    payload.tasks = payload.tasks.filter(t => t.id !== props.task.id)
    payload.totalTasks--
    payload.totalPages = Math.ceil(payload.totalTasks / payload.perPage)

    if (payload.tasks.length === 0 && payload.currentPage > 1) {
      await getTasks(payload.currentPage - 1, filterStatus)
    }
  }
}

async function onDeleteTask() {
  await deleteTask(props.task.id)
}

const onSave = handleSubmit(async values => {
  try {
    const taskData = {
      ...props.task,
      title: values.title,
      description: values.description
    }
    await updateTask(taskData)
  } catch (error) {
    console.error('Failed to save task:', error)
  }
})

function cancelEdit() {
  resetForm()
  setEditingTask(null)
}

function startEditing() {
  setEditingTask(props.task.id)
}
</script>

<template>
  <li class="w-full">
    <div class="flex gap-3 dark:text-white border-b-1 p-3">
      <div class="flex items-center">
        <input
          :disabled="isEditingTask(task.id)"
          :checked="task.status ?? false"
          type="checkbox"
          class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
          @change="changeTaskStatus"
        />
      </div>
      <div class="w-full">
        <div
          v-if="!isEditingTask(task.id)"
          :class="{ 'line-through text-gray-400 dark:text-gray-200': task.status }"
        >
          <h2 class="text-xl font-bold">{{ task.title }}</h2>
          <p>{{ task.description }}</p>
        </div>
        <div v-else>
          <input
            v-bind="editedTitle"
            class="bg-gray-50 border mb-3 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          />
          <span v-if="formErrors.title" class="text-red-500 text-sm">{{ formErrors.title }}</span>

          <textarea
            v-bind="editedDescription"
            class="block p-2.5 w-full mb-3 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          />
          <span v-if="formErrors.description" class="text-red-500 text-sm">{{
            formErrors.description
          }}</span>

          <button
            class="text-white bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800 cursor-pointer"
            @click="onSave"
          >
            Save
          </button>
          <button
            class="text-white bg-red-400 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800 cursor-pointer"
            @click="cancelEdit"
          >
            Cancel
          </button>
        </div>
      </div>
      <div>
        <div class="ml-4 flex-shrink-0 flex space-x-2">
          <button
            v-if="!isEditingTask(task.id)"
            class="text-gray-500 dark:text-white hover:text-gray-700 dark:hover:text-blue-500 focus:outline-none cursor-pointer"
            @click="startEditing"
          >
            <Pencil />
          </button>
          <button
            class="text-red-500 hover:text-red-700 focus:outline-none cursor-pointer"
            @click="onDeleteTask"
          >
            <Trash2 />
          </button>
        </div>
      </div>
    </div>
  </li>
</template>
