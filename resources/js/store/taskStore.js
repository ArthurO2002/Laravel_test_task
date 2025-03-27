import {defineStore} from "pinia";
import axios from "axios";


export const useTaskStore = defineStore('task', {
    state: () => ({
        tasks: [],
        creationLoading: false,
        fetchLoading: false
    }),

    actions: {
       async createTask(taskData) {
           try {
               this.creationLoading = true
               const response = await axios.post('/api/tasks', taskData);
               this.tasks.push(response.data)
               this.creationLoading = false;
               return response.data;
           } catch (error) {
               this.creationLoading = false;
               throw error;
           }
       },
        async getTasks() {
           try {
               this.fetchLoading = true
               const response = await axios.get('/api/tasks')
               this.tasks = response.data
               this.fetchLoading = false;
               return response.data;
           } catch (error) {
               this.fetchLoading = false;
               throw error;
           }
        },
        async updateTask(taskData) {
           try {
               const response = await axios.put(`/api/tasks/${taskData.id}`, taskData);
               const updatedTask = response.data;
               const index = this.tasks.findIndex((task) => task.id === updatedTask.id);
               if (index !== -1) {
                   this.tasks[index] = updatedTask;
               }
               return updatedTask;
           } catch (error) {
               throw error;
           }
        },
        async deleteTask(taskId) {
           try {
               await axios.delete(`/api/tasks/${taskId}`)
               this.tasks = this.tasks.filter(task => task.id !== taskId);
           } catch (error) {
               throw error
           }
        }
    }
})
