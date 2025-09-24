<script setup lang="ts">
import Trash from "@/components/svgs/TrashSvg.vue";
import axios from "axios"
const memos = defineModel<{id:number, text:string, created_at:string}[]>({default: []})
const props = defineProps<{fetchMemos:() => void}>()
function formatDate(datetime: string): string {
    const date = new Date(datetime);
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, '0');
    const d = String(date.getDate()).padStart(2, '0');
    const hh = String(date.getHours()).padStart(2, '0');
    const mm = String(date.getMinutes()).padStart(2, '0');
    return `${y}/${m}/${d} ${hh}:${mm}`;
}

async function deleteMemo(id:number){
    try{
        await axios.delete(`http://localhost:48080/api/memos/${id}`)
        props.fetchMemos()
    }catch(error){
        console.error('error',error)
    }
}
</script>

<template>
<div v-for="memo in memos.slice().reverse()" :key="memo.id"
     class="w-full border-solid border-2 rounded-lg border-gray-200 bg-white mt-2 mb-4 p-4 pl-6 pr-6 flex flex-col group/memo">
    <div class="text-gray-800 text-lg font-medium flex flex-row justify-between items-center">
        {{memo.text}}
        <button type="button"
                @click="deleteMemo(memo.id)">
            <Trash class="text-white group-hover/memo:text-gray-400"/>
        </button>
    </div>
    <div class="text-xs text-gray-400 pt-2">
        {{formatDate(memo.created_at)}}
    </div>
</div>
</template>

<style scoped>

</style>
