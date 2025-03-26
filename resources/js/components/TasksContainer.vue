<script setup>

import Tasks from "./Tasks.vue";
</script>

<template>
    <div class="w-full bg-white dark:bg-gray-700 shadow rounded-lg p-6 mb-6">
        <div>
            <h1 class="text-2xl  dark:text-white"> All Tasks</h1>
        </div>
        <div class="mt-3">
            <ul>
                <Tasks />
            </ul>
        </div>
    </div>
</template>

<style scoped>

</style>
