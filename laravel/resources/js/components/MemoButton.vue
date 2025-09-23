<script setup lang="ts">
import Plus from "@/components/svgs/PlusSvg.vue";

const emit = defineEmits(['push'])
const props = defineProps<{memo:string}>()
</script>

<template>
<button type="button"
        @click="emit('push')"
        :disabled="props.memo.trim().length ===0"
        :class="['w-11/12 rounded-md gap-2 flex flex-row justify-center items-center p-2 m-2 text-white',props.memo.trim().length > 0?'bg-orange-500':'bg-orange-300']">
    <Plus class="text-white"/>
    メモを保存
</button>
</template>

<style scoped>

</style>
