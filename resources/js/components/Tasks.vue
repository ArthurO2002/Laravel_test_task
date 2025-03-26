<script setup>

import { Pencil, Trash2 } from "lucide-vue-next";


</script>

<template>
    <li class="w-full">
        <div class="flex gap-3 dark:text-white border-b-1 p-3">
            <div>
                <input type="checkbox">
            </div>
            <div>
                <h2 class="text-xl font-bold">Testing Task</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet cum eaque earum error obcaecati, porro possimus? Assumenda, dolores error explicabo iusto labore modi non placeat quas, quisquam rerum sunt unde?</p>
            </div>
            <div>
                <div class="ml-4 flex-shrink-0 flex space-x-2">
                    <button class="text-gray-500 dark:text-white hover:text-gray-700 dark:hover:text-blue-500 focus:outline-none cursor-pointer">
                        <Pencil />
                    </button>
                    <button class="text-red-500 hover:text-red-700 focus:outline-none cursor-pointer">
                        <Trash2 />
                    </button>
                </div>
            </div>
        </div>
    </li>
</template>

<style scoped>

</style>
