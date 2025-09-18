<script setup lang="ts">
import Document from "@/components/svgs/DocumentSvg.vue";
</script>

<template>
<div class="h-32 bg-white border-b-4 border-solid border-orange-100">
    <div class="flex flex-col">
        <div class="flex flex-row gap-2 items-center justify-center mt-7 mb-4">
            <Document class="h-9 w-9"/>
            <p class="text-orange-500 text-3xl font-bold">かんたんメモ</p>
        </div>
        <p class="flex justify-center text-gray-700 text-sm">思いついたことをサッと記録しよう</p>
    </div>
</div>
</template>

<style scoped>

</style>
