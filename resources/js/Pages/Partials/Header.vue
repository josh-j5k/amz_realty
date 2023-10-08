<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { usePage } from '@inertiajs/vue3';
const page = usePage()
const user = computed(() => page.props.auth.user)
const toggled = ref(false)

</script>

<template>
    <header class="h-24 w-screen flex flex-col justify-center md:px-16 px-8 overflow-x-hidden"
        :class="route().current('Home') ? 'absolute inset-0 bg-transparent z-50 text-white' : 'bg-white text-black relative z-50'">
        <div class=" md:grid grid-20-80 grid-cols-2 -md:flex -md:justify-between items-center">
            <ApplicationLogo width="50" />
            <button id="nav-toggle" type="button" @click="toggled = !toggled" class="md:hidden z-[990] relative "
                :class="toggled ? 'text-white' : 'text-black'" title="nav toggle" aria-controls="primary-nav"
                :aria-expanded="toggled" aria-haspopup="true">
                <span :class="toggled ? 'opacity-0' : 'opacity-100'"><i
                        class="fas fa-bars fa-2xl text-secondary"></i></span>
                <span :class="toggled ? 'opacity-100' : 'opacity-0'"><i class="fas fa-xmark fa-xl"></i></span>
            </button>
            <div
                class="md:items-center -md:fixed inset-y-0 right-6 left-0 -md:bg-black flex md:justify-between -md:text-white transition-transform duration-500 -md:flex-col -md:p-4 -md:-translate-x-full">
                <nav id="primary-nav" class="flex gap-4 h-full -md:flex-col -md:justify-center -md:items-center">
                    <Link class="font-bold" :href="route('Home')" :active="route().current('Home')">
                    Home
                    </Link>
                    <Link :href="route('listings.index')" :active="route().current('Home')">
                    Listings
                    </Link>
                    <Link :href="route('Home')" :active="route().current('Home')">
                    Home
                    </Link>
                    <Link :href="route('Home')" :active="route().current('Home')">
                    Home
                    </Link>
                    <Link :href="route('Home')" :active="route().current('Home')">
                    Home
                    </Link>
                </nav>
                <div class="flex gap-4">
                    <button v-if="!user" type="button" title="login/register" @click="router.get(route('login'))"
                        class="flex gap-2 px-4 py-2">
                        <span>
                            <i class="fas fa-user"></i>
                        </span>
                        <span>
                            Register/Login
                        </span>
                    </button>
                    <button type="button" title="New listing" @click=" router.get('listings/create')"
                        class="text-white hover:bg-accent-hover bg-accent flex gap-2 px-3 py-2 rounded-md">
                        <span>
                            <i class="fas fa-circle-plus"></i>
                        </span>
                        <span class="capitalize">
                            new listing
                        </span>
                    </button>
                </div>
            </div>
        </div>

    </header>
</template>

<style scoped>
    @media (width <=769px) {
        #nav-toggle {
            transition: transform 100ms ease-in;
        }

        #nav-toggle[aria-expanded="false"] {
            transform: translateX(0);
        }

        #nav-toggle[aria-expanded="true"] {
            transform: translateX(-20px);
        }

        #nav-toggle~div {
            transition: transform 300ms ease-in;
        }

        #nav-toggle[aria-expanded="false"]~div {
            transform: translateX(-100%);
        }

        #nav-toggle[aria-expanded="true"]~div {
            transform: translateX(0);
        }
    }

    @media (min-width: 769px) {
        .grid-20-80 {
            grid-template-columns: 20% 80%;
        }
    }
</style>