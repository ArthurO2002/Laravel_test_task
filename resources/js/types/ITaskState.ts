import { ITaskResponse } from '@/types/ITaskResponse'

export interface ITaskState {
  tasks: ITaskResponse[]
  currentPage: number
  totalPages: number
  perPage: number
  totalTasks: number
}
