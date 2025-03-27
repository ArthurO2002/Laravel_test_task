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
        }
    }
})
