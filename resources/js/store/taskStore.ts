import { defineStore } from 'pinia'
import axios from 'axios'
import { IState } from '@/types/IState'
import { useToast } from 'vue-toastification'
import { ICreateTask } from '@/types/ICreateTask'
import { ITaskResponse } from '@/types/ITaskResponse'
import { ITask } from '@/types/ITask'
import { SortingEnum } from '@/Enums/SortingEnum'

const toast = useToast()

export const useTaskStore = defineStore('task', {
  state: (): IState => ({
    payload: {
      tasks: [],
      currentPage: 1,
      totalPages: 1,
      perPage: 5,
      totalTasks: 0
    },
    creationLoading: false,
    fetchLoading: false,
    filterStatus: null,
    editingTaskId: null as number | null,
    sortOrder: SortingEnum.DESC
  }),

  getters: {
    isEditingTask: state => (taskId: number) => state.editingTaskId === taskId
  },

  actions: {
    async createTask(taskData: ICreateTask) {
      try {
        this.creationLoading = true
        const { data } = await axios.post<ITaskResponse>('/api/tasks', taskData)

        this.payload.tasks.unshift(data)
        if (this.payload.tasks.length > this.payload.perPage) {
          this.payload.tasks.pop()
        }
        this.payload.totalTasks++
        this.payload.totalPages = Math.ceil(this.payload.totalTasks / this.payload.perPage)

        toast.success('Task created successfully')
        return data
      } catch (error) {
        toast.error(error.message || 'Failed to create task')
      } finally {
        this.creationLoading = false
      }
    },
    async getTasks(page = 1, status: boolean | null = null, sort: SortingEnum = SortingEnum.DESC) {
      try {
        this.fetchLoading = true
        let url = `/api/tasks?page=${page}`

        if (status !== null) {
          url += `&status=${status}`
        }
        url += `&sort=${sort}`

        const response = await axios.get(url)
        this.payload.tasks = response.data.data
        this.payload.currentPage = response.data.current_page
        this.payload.totalPages = response.data.last_page
        this.payload.totalTasks = response.data.total
        return response.data
      } catch (error) {
        toast.error(`Unable to fetch tasks: ${error}`)
      } finally {
        this.fetchLoading = false
      }
    },
    async updateTask(taskData: ITask) {
      try {
        const response = await axios.put<ITaskResponse>(`/api/tasks/${taskData.id}`, taskData)
        const updatedTask = response.data
        const index = this.payload.tasks.findIndex(task => task.id === updatedTask.id)
        if (index !== -1) {
          this.payload.tasks[index] = updatedTask
        }
        toast.success('Task has been successfully updated.')
        return updatedTask
      } catch (error) {
        toast.error('Something when Wrong while updating the task.')
      } finally {
        this.setEditingTask(null)
      }
    },
    async deleteTask(taskId: number): Promise<boolean> {
      try {
        await axios.delete(`/api/tasks/${taskId}`)
        this.payload.tasks = this.payload.tasks.filter(task => task.id !== taskId)
        this.payload.totalTasks--
        this.payload.totalPages = Math.ceil(this.payload.totalTasks / this.payload.perPage)

        if (this.payload.tasks.length === 0 && this.payload.currentPage > 1) {
          await this.getTasks(this.payload.currentPage - 1)
        }

        toast.success('Task has been deleted successfully!')
        return true
      } catch (error) {
        toast.error('Something when Wrong while updating the task.')
        return false
      }
    },

    async setStatusFilter(status: boolean | null) {
      this.filterStatus = status
      await this.getTasks(1, status)
    },

    setEditingTask(taskId: number | null) {
      this.editingTaskId = taskId
    }
  }
})
