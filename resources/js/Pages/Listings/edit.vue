<script setup lang="ts">
import { ref } from 'vue';

const index = ref(0)
const fruits = ref(['oranges', 'apples', 'bananas', 'watermelons', 'pineapples', 'strawberries'])
function loop() {
    index.value++
    if (index.value > fruits.value.length) {
        return
    }
    setTimeout(() => {
        console.log(fruits.value[index.value])
        loop()
    }, 2000)
}
loop()
</script>

<template>
    <h1>hi</h1>
</template>