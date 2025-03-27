import { ITaskState } from '@/types/ITaskState'

export interface IState {
  payload: ITaskState
  creationLoading: boolean
  fetchLoading: boolean
  filterStatus: boolean | null
  editingTaskId: number | null
}
