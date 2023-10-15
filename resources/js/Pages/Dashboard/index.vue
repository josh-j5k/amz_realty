<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Listings } from '@/types/listings';
import Card from '@/Components/Card.vue';

const props = defineProps<{
    listings: Listings
}>()

console.log(props.listings);

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-if="listings.length === 0" class="p-6 text-center text-gray-900">
                        <h2 class="text-2xl mb-4 font-bold">
                            You have no listings
                        </h2>
                        <Link :href="route('listings.create')" class="text-accent">
                        <span>
                            Create your first listing
                        </span>
                        <span>
                            <i class="fas fa-circle-arrow-right"></i>
                        </span>
                        </Link>
                    </div>
                    <div v-else class="p-6 text-gray-900 lg:grid grid-cols-[45%_55%]">
                        <div>
                            <template v-for="(listing, index) in listings">
                                <Card class="bg-white relative flex gap-4">
                                    <div>
                                        <img v-if="listing.listing_image?.length !== 0"
                                            :src="listing.listing_image[0].listing_image" alt=""
                                            class="max-w-[200px] h-full object-cover -md:max-w-[150px]">
                                        <img v-else src="/images/no_image_placeholder.jpg" alt=""
                                            class="h-full object-cover max-w-[200px] -md:max-w-[150px]">
                                    </div>
                                    <div class="p-4">
                                        <p class="font-bold flex gap-1 mb-3 text-sm text-accent">
                                            <span>
                                                FCFA
                                            </span>
                                            <span>

                                                <span v-if="listing.property_status === 'rent'">
                                                    <span>{{ listing.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                                        ",").concat('.00') }}</span>/Month
                                                </span>
                                                <span v-else>
                                                    {{ listing.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                                        ",").concat('.00') }}
                                                </span>
                                            </span>
                                        </p>
                                        <div>

                                            <div>

                                                <p class="font-bold mb-1">
                                                    {{ listing.title.slice(0, 35) }}
                                                </p>
                                            </div>
                                        </div>
                                        <p class="text-sm opacity-75 mb-3 capitalize">
                                            {{ listing.property_type }}
                                        </p>
                                        <hr class="w-full h-[1px] bg-slate-100 mb-3">

                                        <div class="flex gap-2 text-sm">
                                            <span>
                                                <i class="fas fa-location-dot text-accent"></i>
                                            </span>

                                            <p class="">{{ listing.location.slice(0, 30) }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="capitalize rounded py-1 px-2 absolute top-3 left-3 text-white text-sm cursor-default"
                                        :class="[listing.property_status === 'rent' ? 'bg-green-500' : 'bg-orange-500']">
                                        for {{ listing.property_status }}
                                    </span>
                                </Card>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
