import {defineStore} from "pinia";
import axios from "axios";


export const useTaskStore = defineStore('task', {
    state: () => ({
        tasks: [],
        loading: false,
    }),

    actions: {
       async createTask(taskData) {
           try {
               this.loading = true
               const response = await axios.post('/api/tasks', taskData);
               this.tasks.push(response.data)
               this.loading = false;
               return response.data;
           } catch (error) {
               this.loading = false;
               throw error;
           }
       }
    }
})
