<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const form = useForm({
    full_name: '',
    email: '',
    category: '',
    description: ''
})

const limit = ref(140)
const charactersRemaining = computed(() => limit.value - form.description.length)
</script>

<template>
    <Head>
        <title>Get in touch with us</title>
    </Head>
    <AppLayout>
        <section class="p-10 pt-12 lg:pb-52 ">
            <div class="grid md:grid-cols-[60%_40%] grid-cols-1 gap-16">
                <div>
                    <h1 class="capitalize text-4xl font-bold mb-12">
                        contact us
                    </h1>

                    <form action="">
                        <div class="flex flex-col gap-8">
                            <div class="flex gap-4 -md:flex-col">
                                <div class="flex flex-col gap-1 w-full">
                                    <label for="full_name" class="capitalize">
                                        name
                                    </label>
                                    <input type="text" name="full_name" id="full_name" class="rounded "
                                        :class="[form.errors.full_name ? 'border-red-500' : '']">
                                    <p v-if="form.errors.full_name" class="text-red-500">
                                        This field is required
                                    </p>
                                </div>
                                <div class="flex flex-col gap-1 w-full">
                                    <label for="email" class="capitalize">
                                        email
                                    </label>
                                    <input type="email" name="email" id="email" class="rounded"
                                        :class="[form.errors.email ? 'border-red-500' : '']">
                                    <p v-if="form.errors.email" class="text-red-500">
                                        This field is required
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label for="category" class="capitalize">category</label>
                                <select v-model="form.category" name="category" id="category" class="rounded"
                                    :class="[form.errors.category ? 'border-red-500' : '']">
                                    <option value="" disabled>Please select</option>
                                    <option value="ideas_improvements">
                                        Ideas/improvements
                                    </option>
                                    <option value="report a problem with location">
                                        Report a problem with a location
                                    </option>
                                    <option value="report problem with functionality">
                                        Report a problem with functionality
                                    </option>
                                    <option value="other">
                                        Other
                                    </option>
                                </select>
                                <p v-if="form.errors.category" class="text-red-500">
                                    This field is required
                                </p>
                            </div>
                            <div class="flex flex-col">
                                <label for="description">
                                    Message
                                </label>
                                <textarea v-model="form.description" name="description" id="description" rows="5"
                                    placeholder="Please enter any useful details" class="rounded"
                                    :class="[form.errors.description ? 'border-red-500' : '']"></textarea>
                                <p class="text-sm text-gray-600">Characters remaining: {{ charactersRemaining }}</p>
                                <p v-if="form.errors.description" class="text-red-500">
                                    This field is required
                                </p>
                            </div>
                            <div>
                                If you’re interested in more information or arranging a viewing for any property listed
                                with us, please contact the agent or new home developer directly for the relevant
                                property rather than using this form.
                            </div>
                            <button
                                class="flex py-4 justify-center items-center bg-accent rounded hover:bg-accent-hover text-white text-lg font-bold">
                                Send message
                            </button>
                        </div>
                    </form>
                </div>
                <div>
                    <div class="sticky top-0 md:p-4">
                        <h2 class="font-bold text-lg">
                            Registered office address:
                        </h2>
                        <p class="mb-4">
                            RGRG+VG5, Yaoundé, Cameroon 00237
                        </p>
                        <p>
                            Please note that we do not accept direct advertising from private sellers or landlords.
                        </p>
                    </div>
                </div>

            </div>
    </section>
</AppLayout></template>