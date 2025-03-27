import { useTaskStore } from '@/store/taskStore'

export const FetchTasks = () => {
  const taskStore = useTaskStore()
  taskStore.getTasks()
}
