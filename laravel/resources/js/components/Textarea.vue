<script setup lang="ts">
const memo = defineModel<string>();
</script>

<template>
<textarea placeholder="メモを入力して下さい…
（Enterで保存、Shift＋Enterで改行）"
          v-model="memo"
          class="w-11/12 h-40 border-solid border-2 border-gray-200 rounded-md p-4 m-2 focus:border-blue-200 focus:outline-none"
          ></textarea>
</template>

<style scoped>

</style>
