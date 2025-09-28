<script setup lang="ts">
import Plus from "@/components/svgs/PlusSvg.vue";
import DocumentSvg from "@/components/svgs/DocumentSvg.vue";
import Header from "@/components/Header.vue";
import Textarea from "@/components/Textarea.vue";
import MemoButton from "@/components/MemoButton.vue";
import MemoCard from "@/components/MemoCard.vue";
import {ref, onMounted} from "vue"
import axios from "axios"

const memo = ref('')
const memos = ref([])
const isSaving = ref(false)

const keyword = ref('')
async function fetchMemos(){
    try{
        const response = await axios.get("http://localhost:48080/api/memos")
        memos.value = response.data
    }catch(error){
        console.error('更新失敗',error)
    }
}

async function store(){
    isSaving.value = true
    const text = memo.value.trim()
    if (text.length ===0) return;
    try{
        await axios.post('http://localhost:48080/api/memos',{text})
        memo.value=""
        await fetchMemos()
    }catch(error){
        console.error('保存失敗',error)
    }finally{
        isSaving.value = false
    }
}

onMounted(() => {
    fetchMemos()
})
</script>
<template>
    <div class="min-h-screen bg-orange-50">
        <Header/>
        <div class="flex flex-col items-center">
            <div class="w-1/3 border-solid border-2 border-orange-100 rounded-md bg-white shadow-lg m-6 p-2 flex flex-col">
                <div class="flex flex-row gap-2 items-center m-2 pl-2">
                    <Plus class="w-6 h-6"/>
                    <p class="font-semibold text-lg">新しいメモ</p>
                </div>
                <div class="flex flex-col items-center">
                    <Textarea v-model="memo"
                              :disabled="isSaving"
                              @keyup.enter.exact.prevent="store"
                              @keyup.shift.enter="memo += '\n'"/>
                    <MemoButton @push="store"
                                :memo="memo"
                                :disabled="isSaving"/>
                </div>
            </div>
            <div class="flex flex-row justify-stretch items-center w-1/3">
                <div class="flex flex-row gap-2 items-center text-lg font-semibold m-2">
                    <DocumentSvg/>
                    <p>保存されたメモ</p>
                </div>
                <input v-model="keyword"
                       type="text"
                       placeholder="検索..."
                       class="w-1/2 border-solid border-2 rounded-lg border-gray-200 bg-white p-2 m-2 focus:border-blue-200 focus:outline-none"/>
                <div class="bg-orange-100 text-sm rounded-full p-2 m-2">
                    {{memos.length}}件
                </div>
            </div>
            <div class="w-1/3">
                <MemoCard v-model="memos"
                          v-model:keyword="keyword"
                          :fetchMemos="fetchMemos"/>
            </div>
        </div>
    </div>
</template>
