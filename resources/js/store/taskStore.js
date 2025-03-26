import {defineStore} from "pinia";
import axios from "axios";


export const useTaskStore = defineStore('task', {
    state: () => ({
        tasks: [],
        loading: false,
        error: null,
    }),

    actions: {
       async createTask(taskData) {
           try {
               this.loading = true
               console.log(taskData)
               const response = await axios.post('/api/tasks', taskData);
               this.tasks.push(response.data)
               this.loading = false;
               return response.data;
           } catch (error) {
               this.error = error.response?.data?.message || 'Something went wrong while creating task';
               this.loading = false;
               throw error;
           }
       }
    }
})
