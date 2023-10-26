<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import { usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { onUnmounted } from 'vue';
const page = usePage()
const user = computed(() => page.props.auth.user)
const userNameArr = ref(<string[]>[])
const userName = ref('')
const toggled = ref(false)
const dropdownToggled = ref(false)
if (user.value) {
    userNameArr.value = user.value.name.split(' ')
    userName.value = userNameArr.value[0]
}
function navToggle() {
    toggled.value = !toggled.value
    if (toggled.value === true) {
        document.body.classList.add('overflow-y-hidden')
    } else {

        document.body.classList.remove('overflow-y-hidden')

    }
}
function closeDropdown(ev: MouseEvent) {
    const element = ev.target as HTMLElement
    if (dropdownToggled.value === true && !element.closest('#dashboard_dropdown-toggle')) {
        dropdownToggled.value = false

    }
}
onMounted(() => {
    document.documentElement.addEventListener('click', closeDropdown)

})
onUnmounted(() => {
    if (toggled.value === true) {
        document.body.classList.remove('overflow-y-hidden')
    }
    document.removeEventListener('click', closeDropdown)
})
</script>

<template>
    <header class="h-24 w-full flex flex-col z-[9990] justify-center lg:px-16 px-8 overflow-x-hidden"
        :class="route().current('Home') ? 'absolute inset-0 bg-transparent text-white' : 'bg-white text-black relative shadow'">
        <div class=" lg:grid lg:grid-cols-[20%_80%] grid-cols-2 -lg:flex -lg:justify-between items-center">
            <ApplicationLogo class="w-16" />
            <button id="nav-toggle" type="button" @click="navToggle" class="lg:hidden z-[990] relative "
                :class="toggled ? 'text-black' : 'text-white'" title="nav toggle" aria-controls="primary-nav"
                :aria-expanded="toggled" aria-haspopup="true">
                <span :class="toggled ? 'opacity-0' : 'opacity-100'"><i class="fas fa-bars fa-2xl text-accent"></i></span>
                <span :class="toggled ? 'opacity-100' : 'opacity-0'"><i class="fas fa-xmark fa-xl"></i></span>
            </button>
            <div
                class="flex lg:items-center lg:justify-between -lg:fixed inset-0 -lg:bg-white -lg:shadow  -lg:text-gray-800 transition-transform duration-500 -lg:flex-col -lg:p-4 -lg:translate-x-full">
                <nav id="primary-nav"
                    class="flex gap-4 h-full -lg:flex-col -lg:pt-16 -lg:px-8 text-sm -lg:text-xl -lg:font-bold">
                    <NavLink :href="route('Home')" :active="route().current('Home')">
                        Home
                    </NavLink>
                    <NavLink :href="route('listings.index')" :active="route().current('listings.index')">
                        Listings
                    </NavLink>
                    <NavLink href="#">
                        New Homes
                    </NavLink>
                    <NavLink href="#">
                        Commercial
                    </NavLink>
                    <NavLink :href="route('Contact')" :active="route().current('Contact')">
                        Contact Us
                    </NavLink>
                    <NavLink :href="route('About')" :active="route().current('About')">
                        About Us
                    </NavLink>
                </nav>
                <div class="flex gap-6 -lg:justify-between -lg:pt-8 -lg:border-t">

                    <div class="flex items-center gap-2 h-12">
                        <button type="button" title="New listing" @click=" router.get('listings/create')"
                            class="text-white hover:bg-accent-hover bg-accent flex items-center justify-center gap-2 h-9 w-32 rounded-md ">
                            <span>
                                <i class="fas fa-circle-plus"></i>
                            </span>
                            <span class="capitalize">
                                new listing
                            </span>
                        </button>
                    </div>
                    <div class="flex items-center relative">
                        <button v-if="!user" type="button" title="login/register" @click="router.get(route('login'))"
                            class="flex items-center gap-2 h-12 ">
                            <span
                                class="w-8 aspect-square rounded-full flex justify-center items-end border-2 border-accent overflow-hidden">
                                <i class="fa-regular fa-user text-2xl text-accent translate-y-1.5"></i>
                            </span>
                            <span>
                                Sign in
                            </span>
                        </button>

                        <button @click="dropdownToggled = !dropdownToggled" id="dashboard_dropdown-toggle" v-else
                            type="button" class="flex gap-2.5 items-center dashboard_dropdown-toggle">
                            <span v-if="user.avatar" id="avatar">
                                <img :src="user.avatar" alt="user avatar" class="w-8 aspect-square rounded-full">
                            </span>
                            <span id="avatar" v-else
                                class="w-8 aspect-square flex justify-center items-center bg-slate-900 rounded-full text-white border border-accent">
                                <i class="fas fa-user"></i>
                            </span>
                            <span id="user_name">
                                {{ userName }}
                            </span>
                            <span id="dropdown-icon" class="text-sm">
                                <i class="fas fa-caret-down"></i>
                            </span>
                        </button>
                        <div v-if="$page.props.auth.user"
                            class="absolute lg:hidden bg-gray-50 shadow py-4 px-8 -top-[450%] right-0 flex-col items-start gap-2 transition-opacity duration-500 ease-in-out"
                            id="dashboard_dropdown " :class="[dropdownToggled ? 'flex opacity-100' : 'hidden opacity-0']">

                            <Link :href="route('user.dashboard', $page.props.auth.user.id)" class="capitalize">
                            dashboard
                            </Link>
                            <Link :href="route('user.profile.edit', $page.props.auth.user.id)" class="capitalize">
                            profile
                            </Link>

                            <Link method="post" as="button" :href="route('logout')" class="capitalize">
                            logout
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="w-[80%] h-[1px] mx-auto bg-white opacity-20 mt-4 -lg:hidden"
            :class="[route().current('Home') ? '' : 'hidden']">
    </header>
    <div class="absolute -lg:hidden bg-white shadow py-4 px-8 top-20 right-4  flex-col items-start z-[9998] gap-2 transition-opacity duration-500 ease-in-out"
        id="dashboard_dropdown " :class="[dropdownToggled ? 'flex opacity-100' : 'hidden opacity-0']">
        <span v-if="$page.props.auth.user" class="flex flex-col items-center gap-3">
            <Link :href="route('user.dashboard', $page.props.auth.user.id)" class="capitalize">
            dashboard
            </Link>
            <Link :href="route('user.profile.edit', $page.props.auth.user.id)" class="capitalize">
            profile
            </Link>
            <Link method="post" as="button" :href="route('logout')" class="capitalize">
            logout
            </Link>
        </span>
    </div>
</template>

<style scoped>
    @media (max-width: 1023px) {
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
            transform: translateX(100%);
        }

        #nav-toggle[aria-expanded="true"]~div {
            transform: translateX(0);
        }
    }
</style>