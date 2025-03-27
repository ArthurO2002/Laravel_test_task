import {defineStore} from "pinia";
import axios from "axios";


export const useTaskStore = defineStore('task', {
    state: () => ({
        tasks: [],
        creationLoading: false,
        fetchLoading: false,
        currentPage: 1,
        totalPages: 1,
        perPage: 5,
        totalTasks: 0,
        filterStatus: null
    }),

    actions: {
       async createTask(taskData) {
           try {
               this.creationLoading = true
               const response = await axios.post('/api/tasks', taskData);
               if (this.tasks.length < this.perPage) {
                   this.tasks.push(response.data);
               }
               this.creationLoading = false;
               this.totalTasks++
               this.totalPages = Math.ceil(this.totalTasks / this.perPage);
               return response.data;
           } catch (error) {
               this.creationLoading = false;
               throw error;
           }
       },
        async getTasks(page = 1, status= null) {
           try {
               this.fetchLoading = true
               let url = `/api/tasks?page=${page}`;

               if(status !== null) {
                   url += `&status=${status}`
               }

               const response = await axios.get(url)
               this.tasks = response.data.data;
               this.currentPage = response.data.current_page;
               this.totalPages = response.data.last_page;
               this.totalTasks = response.data.total;
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
               this.totalTasks--;
               this.totalPages = Math.ceil(this.totalTasks / this.perPage);

               if (this.tasks.length === 0 && this.currentPage > 1) {
                   await this.getTasks(this.currentPage - 1);
               }

               return true

           } catch (error) {
               throw error
           }
        },

        async setStatusFilter(status) {
            this.filterStatus = status
            await this.getTasks(1, status)
        }
    }
})
