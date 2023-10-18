<script setup lang="ts">
import { ref } from 'vue';

const items = document.querySelectorAll(".color")

const duration = 1500
const delay = 1000
let count = 0

function animateForwards() {

    items.forEach((item, index) => {
        if (index === 1) {
            item.animate([
                { height: '100%' }
            ], {
                duration: duration,
                delay: delay * index,
                fill: 'forwards'
            })
        } else if (index === 2 || index === 3) {
            item.animate([
                { width: '0' }
            ], {
                duration: duration,
                delay: delay * index,
                fill: 'forwards'
            })
        } else if (index === 4) {
            item.animate([
                { height: '0' }
            ], {
                duration: duration,
                delay: delay * index,
                fill: 'forwards',
            })
        } else {
            item.animate([
                { width: '100%' }
            ], {
                duration: duration,
                delay: delay * index,
                fill: 'forwards',
            })
        }
    })
}
function animateBackwards() {


    items[0].animate([
        { height: '100%' }
    ], {
        duration: duration,
        delay: delay * items.length,
        fill: 'forwards',

    })
    items[1].animate([
        { height: '100%' }
    ], {
        duration: duration,
        delay: delay * items.length - 1,
        fill: 'forwards',

    })
    items[2].animate([
        { height: '100%' }
    ], {
        duration: duration,
        delay: delay * items.length - 2,
        fill: 'forwards',

    })
    items[3].animate([
        { height: '100%' }
    ], {
        duration: duration,
        delay: delay * items.length - 3,
        fill: 'forwards',

    })
    items[4].animate([
        { height: '100%' }
    ], {
        duration: duration,
        delay: delay * items.length - 4,
        fill: 'forwards',

    })
    items[5].animate([
        { height: '100%' }
    ], {
        duration: duration,
        delay: delay * items.length - 5,
        fill: 'forwards',

    })

}


animateForwards()

setInterval(() => {
    count++
    if (count % 2 === 0) {
        animateForwards()
    } else {
        animateBackwards()
    }

}, 10000)

</script>

<template>
    <h1>hi</h1>
</template>