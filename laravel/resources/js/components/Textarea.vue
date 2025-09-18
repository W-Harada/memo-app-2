<script setup lang="ts">
const memo = defineModel<string>();
</script>

<template>
<textarea placeholder="メモを入力して下さい…
（Enterで保存、Shift＋Enterで改行）"
          class="w-11/12 h-40 border-solid border-2 border-gray-300 rounded-md p-4 m-2"
          v-model="memo"
          ></textarea>
</template>

<style scoped>

</style>
