<script setup>

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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </button>
                    <button class="text-red-500 hover:text-red-700 focus:outline-none cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"></path>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </li>
</template>

<style scoped>

</style>
