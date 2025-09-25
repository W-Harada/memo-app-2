<script setup lang="ts">
import Trash from "@/components/svgs/TrashSvg.vue";
import Pen from "@/components/svgs/PenSvg.vue";
import {ref} from "vue";
import axios from "axios"
const memos = defineModel<{id:number, text:string, created_at:string}[]>({default: []})
const props = defineProps<{fetchMemos:() => void}>()

const editingId = ref<number | null>(null);
const editText = ref('');

interface Memo {
    id: number;
    text: string;
    created_at: string;
}

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

function startEdit(memo:Memo) {
    editingId.value = memo.id;
    editText.value = memo.text;
}

function cancelEdit() {
    editingId.value = null;
    editText.value = '';
}

async function updateMemo(id: number) {
    try {
        await axios.patch(`http://localhost:48080/api/memos/${id}`, {text: editText.value});
        const target = memos.value.find(m => m.id === id);
        if (target) target.text = editText.value;
        cancelEdit();
    } catch (error) {
        console.error('error',error);
    }
}
</script>

<template>
<div v-for="memo in memos.slice().reverse()" :key="memo.id"
     class="w-full border-solid border-2 rounded-lg border-gray-200 bg-white mt-2 mb-4 p-4 pl-6 pr-6 flex flex-col group/memo">
    <div v-if="editingId === memo.id">
        <input v-model="editText" class="border-solid border-2 border-gray-200 rounded-lg w-full text-gray-800 text-lg font-medium px-4 py-2 focus:border-blue-200 focus:outline-none"/>
        <div class="flex flex-row gap-2 justify-end mt-2">
            <button @click="updateMemo(memo.id)"
                    class="bg-orange-500 text-white px-2 py-1 rounded-lg">保存</button>
            <button @click="cancelEdit"
                    class="bg-gray-300 px-2 py-1 rounded-lg">キャンセル</button>
        </div>
    </div>
    <div v-else
         class="text-gray-800 text-lg font-medium flex flex-row justify-between items-center">
        {{memo.text}}
        <div class="flex flex-row gap-3 items-center">
            <button type="button"
                    @click="startEdit(memo)">
                <Pen class="text-white group-hover/memo:text-gray-400"/>
            </button>
            <button type="button"
                    @click="deleteMemo(memo.id)">
                <Trash class="text-white group-hover/memo:text-gray-400 h-6 w-6"/>
            </button>
        </div>
    </div>
    <div class="text-xs text-gray-400 pt-2">
        {{formatDate(memo.created_at)}}
    </div>
</div>
</template>

<style scoped>

</style>
