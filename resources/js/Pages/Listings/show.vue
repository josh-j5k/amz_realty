<script setup lang="ts">
import CloseButton from '@/Components/CloseButton.vue';


</script>

<template>
    <section class="md:h-screen min-h-screen w-screen overflow-x-hidden">
        <CloseButton route-name="listings.index" position="top-8 left-8" />
        <div class="grid lg:grid-cols-[75%_25%] grid-cols-1">
            <div class="min-h-screen relative flex justify-center items-center bg-slate-500">
                <img src="" alt="">
                <button type="button" title="click to get previous image"
                    class="w-12 aspect-square rounded-full bg-white absolute left-4 top-1/2 -translate-y-1/2">
                    <span>
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </button>
                <button type="button" title="click to get next image"
                    class="w-12 aspect-square rounded-full bg-white absolute right-4 top-1/2 -translate-y-1/2">
                    <span>
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </button>
                <div class="absolute bottom-0 ">

                </div>
            </div>
            <div class="bg-white py-12 px-8 shadow md:h-screen ">
                <div>
                    <h1 class="capitalize font-bold text-3xl mb-4">
                        listing name
                    </h1>
                    <p class="font-bold mb-3">
                        price
                    </p>
                    <p class="font-bold mb-6">
                        date listed
                    </p>
                    <div class="flex gap-4">
                        <button type="button" title="message"
                            class="flex gap-3 bg-secondary text-white py-1 px-3 rounded-lg">
                            <span>
                                <i class="fa-regular fa-comments"></i>
                            </span>
                            <span class="capitalize">
                                message
                            </span>
                        </button>
                        <button type="button" title="like" class="flex gap-3 bg-secondary text-white py-1 px-3 rounded-lg">
                            <span>
                                <i class="fa-regular fa-heart"></i>
                            </span>
                        </button>
                        <button type="button" title="share" class="flex gap-3 bg-secondary text-white py-1 px-3 rounded-lg">
                            <span>
                                <i class="fa-solid fa-share"></i>
                            </span>
                        </button>
                        <button type="button" title="share" class="flex gap-3 bg-secondary text-white py-1 px-3 rounded-lg">
                            <span>
                                <i class="fa-solid fa-ellipsis"></i>
                            </span>
                        </button>
                    </div>
                </div>
                <hr class="w-5/6 mx-auto bg-slate-300 my-4">
                <div>

                </div>
            </div>
        </div>
    </section>
</template>