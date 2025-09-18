<script setup lang="ts">
import Plus from "@/components/svgs/PlusSvg.vue";

const emit = defineEmits(['push'])
</script>

<template>
<button type="button"
        class="w-11/12 bg-orange-300 rounded-md gap-2 flex flex-row justify-center items-center p-2 m-2 text-white"
        @click="emit('push')">
    <Plus class="text-white"/>
    メモを保存
</button>
</template>

<style scoped>

</style>
