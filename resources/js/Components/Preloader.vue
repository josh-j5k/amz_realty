<script setup lang="ts">
import { ref, onMounted, Teleport } from 'vue';

const duration = 500
const delay = 500
let count = ref(0)


onMounted(() => {
    const items = document.querySelectorAll(".color")
    function animateForwards() {

        items.forEach((item, index) => {
            if (index === 1) {
                item.animate([
                    { height: '100%' }
                ], {
                    duration: duration,
                    delay: delay * (index + 1),
                    fill: 'forwards'
                })
            } else if (index === 2 || index === 3) {
                item.animate([
                    { width: '0' }
                ], {
                    duration: duration,
                    delay: delay * (index + 1),
                    fill: 'forwards'
                })
            } else if (index === 4) {
                item.animate([
                    { height: '0' }
                ], {
                    duration: duration,
                    delay: delay * (index + 1),
                    fill: 'forwards',
                })
            } else {
                item.animate([
                    { width: '100%' }
                ], {
                    duration: duration,
                    delay: delay * (index + 1),
                    fill: 'forwards',
                })
            }
        })
    }
    function animateBackwards() {


        items[0].animate([
            { width: '0' }
        ], {
            duration: duration,
            delay: delay * 6,
            fill: 'forwards',

        })
        items[1].animate([
            { height: '0' }
        ], {
            duration: duration,
            delay: delay * 5,
            fill: 'forwards',

        })
        items[2].animate([
            { width: '100%' }
        ], {
            duration: duration,
            delay: delay * 4,
            fill: 'forwards',

        })
        items[3].animate([
            { width: '100%' }
        ], {
            duration: duration,
            delay: delay * 3,
            fill: 'forwards',

        })
        items[4].animate([
            { height: '100%' }
        ], {
            duration: duration,
            delay: delay * 2,
            fill: 'forwards',

        })
        items[5].animate([
            { width: '0' }
        ], {
            duration: duration,
            delay: delay * 1,
            fill: 'forwards',

        })
    }

    animateForwards()

    setInterval(() => {
        count.value++
        if (count.value++ % 2 === 0) {
            animateForwards()
        } else {
            animateBackwards()
        }

    }, 4000)
})
</script>
<template>
    <div
        class="w-screen h-screen z-max fixed isolate flex bg-transparent justify-center items-center before:content-emptystring before:absolute before:inset-0 before:w-full before:h-full before:bg-[rgba(255,_255,_255,_0.3)] before:-z-[1px]">
        <div class="container">
            <div data-index="1">
                <div class="color"></div>
            </div>
            <div data-index="2">
                <div class="color"></div>
            </div>
            <div data-index="3">
                <div class="color"></div>
            </div>
            <div data-index="4">
                <div class="color"></div>
            </div>
            <div data-index="5">
                <div class="color"></div>
            </div>
            <div data-index="6">
                <div class="color"></div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    body {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        height: 100vh;
        width: 100vw;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        --delay: 2000ms;
        width: 100px;
        aspect-ratio: 1;
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-template-rows: repeat(4, 1fr);
    }

    .container [data-index="1"] {
        --color: #0096c7;
        grid-column: 1 / 5;
        grid-row: 1;
    }

    .container [data-index="1"] .color {
        width: 0;
        height: 100%;
        background-color: var(--color);
    }

    .container [data-index="2"] {
        --color: #00b4d8;
        grid-column: 5 / 6;
        grid-row: 1 / 4;
    }

    .container [data-index="2"] .color {
        height: 0;
        width: 100%;
        background-color: var(--color);

    }

    .container [data-index="3"] {
        --color: #48cae4;
        grid-column: 4 / 6;
        grid-row: 4 /5;
        background-color: var(--color);
    }

    .container [data-index="3"] .color {
        height: 100%;
        width: 100%;
        background-color: transparent;

    }

    .container [data-index="4"] {
        --color: #0096c7;
        grid-column: 1/4;
        grid-row: 4/5;
        background-color: var(--color);

    }

    .container [data-index="4"] .color {
        height: 100%;
        width: 100%;
        background-color: transparent;
    }

    .container [data-index="5"] {
        --color: #00b4d8;
        grid-column: 1 / 3;
        grid-row: 2 / 4;
        background-color: var(--color);
    }

    .container [data-index="5"] .color {
        height: 100%;
        width: 100%;
        background-color: transparent;
    }

    .container [data-index="6"] {
        --color: #90e0ef;
        grid-column: 3 / 5;
        grid-row: 2 / 4;
    }

    .container [data-index="6"] .color {
        height: 100%;
        width: 0;
        background-color: var(--color);
    }
</style>