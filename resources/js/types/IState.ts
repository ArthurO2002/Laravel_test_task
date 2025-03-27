import { ITaskState } from '@/types/ITaskState'
import { SortingEnum } from '@/enums/SortingEnum'

export interface IState {
  payload: ITaskState
  creationLoading: boolean
  fetchLoading: boolean
  filterStatus: boolean | null
  editingTaskId: number | null
  sortOrder: SortingEnum
}
