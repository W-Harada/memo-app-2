<script setup lang="ts">
import Trash from "@/components/svgs/TrashSvg.vue";
import Pen from "@/components/svgs/PenSvg.vue";
import {ref,computed} from "vue";
import axios from "axios"
const memos = defineModel<{id:number, text:string, created_at:string, isPinned?: boolean;}[]>({default: []})
const props = defineProps<{fetchMemos:() => void}>()
const keyword = defineModel<string>('keyword')

const editingId = ref<number | null>(null);
const editText = ref('');

const showModal = ref(false)
const deleteId = ref<number | null>(null)

const isUpdating = ref(false)
const isDeleting = ref(false)

type Memo ={
    id:number;
    text: string;
    created_at: string;
    isPinned?: boolean;
}

function togglePin(memo:Memo) {
    memo.isPinned = !memo.isPinned;
}

const filteredMemos = computed(() => {
    if (!keyword.value) {
        return memos.value;
    }
    return memos.value.filter(memo =>
        memo.text.toLowerCase().includes((keyword.value ?? "").toLowerCase())
    );
});

const sortedMemos = computed(() => {
    return [...filteredMemos.value].sort((a, b) => {
        const aPinned = a.isPinned ?? false;
        const bPinned = b.isPinned ?? false;

        if (aPinned && !bPinned) return 1;
        if (!aPinned && bPinned) return -1;

        return new Date(b.created_at).getTime() - new Date(a.created_at).getTime();
    });
});

function formatDate(datetime: string): string {
    const date = new Date(datetime);
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, '0');
    const d = String(date.getDate()).padStart(2, '0');
    const hh = String(date.getHours()).padStart(2, '0');
    const mm = String(date.getMinutes()).padStart(2, '0');
    return `${y}/${m}/${d} ${hh}:${mm}`;
}

function confirmDelete(id: number) {
    deleteId.value = id
    showModal.value = true
}

function cancelDelete(){
    deleteId.value = null
    showModal.value = false
}
async function deleteMemo(){
    isDeleting.value = true
    try{
        await axios.delete(`http://localhost:48080/api/memos/${deleteId.value}`)
        props.fetchMemos()
        cancelDelete()
    }catch(error){
        console.error('削除失敗',error)
    }finally{
        isDeleting.value = false
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
    isUpdating.value = true
    try {
        await axios.patch(`http://localhost:48080/api/memos/${id}`, {text: editText.value});
        const target = memos.value.find(m => m.id === id);
        if (target) target.text = editText.value;
        cancelEdit();
    } catch (error) {
        console.error('編集失敗',error);
    }finally{
        isUpdating.value = false
    }
}
</script>

<template>
    <div v-for="memo in sortedMemos.slice().reverse()" :key="memo.id"
        class="w-full border-solid border-2 rounded-lg border-orange-100 shadow-lg bg-white mt-2 mb-4 py-4 px-6 flex flex-row group/memo">
        <div class="w-full flex justify-stretch gap-4">
            <button @click="togglePin(memo)"
                    class="text-lg flex justify-start"
                    :class="memo.isPinned ? 'text-yellow-300' : 'text-gray-200'">
                ★
            </button>
            <div class="flex flex-col w-11/12">
                <div v-if="editingId === memo.id">
                    <input v-model="editText" class="flex justify-between border-solid border-2 border-gray-200 rounded-lg w-full text-gray-800 text-lg font-medium px-4 py-2 focus:border-blue-200 focus:outline-none" :disabled="isUpdating"/>
                    <div class="flex flex-row gap-2 justify-end mt-2">
                        <button @click="updateMemo(memo.id)" class="bg-orange-400 hover:bg-orange-500 text-white px-2 py-1 rounded-lg" :disabled="isUpdating">保存</button>
                        <button @click="cancelEdit" class="bg-gray-300 hover:bg-gray-400 px-2 py-1 rounded-lg" :disabled="isUpdating">キャンセル</button>
                    </div>
                </div>
                <div v-else
                     class="text-gray-800 text-lg font-medium flex flex-row justify-between items-center">
                    {{memo.text}}
                    <div class="flex flex-row gap-3 items-center">
                        <button type="button" @click="startEdit(memo)">
                            <Pen class="text-white group-hover/memo:text-gray-400"/>
                        </button>
                        <button type="button" @click="confirmDelete(memo.id)">
                            <Trash class="text-white group-hover/memo:text-gray-400 h-6 w-6"/>
                        </button>
                    </div>
                </div>
                <div class="text-xs text-gray-400 pt-2">
                    {{formatDate(memo.created_at)}}
                </div>
            </div>
        </div>
    </div>
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="flex flex-col bg-white p-6 rounded-lg w-80">
            <p class="mb-4 text-gray-800 font-medium text-center">本当にこのメモを削除しますか？</p>
            <div class="flex flex-row justify-between gap-4">
                <button @click="cancelDelete" class="basis-1/2 py-2 bg-gray-300 rounded-lg hover:bg-gray-400" :disabled="isDeleting">キャンセル</button>
                <button @click="deleteMemo" class="basis-1/2 py-2 bg-orange-400 text-white rounded-lg hover:bg-orange-500" :disabled="isDeleting">削除</button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
