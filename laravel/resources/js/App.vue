<script setup lang="ts">
import Plus from "@/components/svgs/PlusSvg.vue";
import Header from "@/components/Header.vue";
import Textarea from "@/components/Textarea.vue";
import MemoButton from "@/components/MemoButton.vue";
</script>
<template>
    <div class="min-h-screen bg-orange-50">
        <Header/>
        <div class="flex flex-col items-center">
            <div class="w-1/3 border-solid border-2 border-orange-100 rounded-md bg-white shadow-lg m-4 p-2 flex flex-col">
                <div class="flex flex-row gap-2 items-center m-2 pl-2">
                    <Plus class="w-6 h-6"/>
                    <p class="font-semibold text-lg">新しいメモ</p>
                </div>
                <div class="flex flex-col items-center">
                    <Textarea/>
                    <MemoButton/>
                </div>
            </div>
        </div>
    </div>
</template>
