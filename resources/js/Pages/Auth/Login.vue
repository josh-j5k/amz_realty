<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import LoginWithSocials from '@/Components/LoginWithSocials.vue'
import { Head, router, useForm, Link } from '@inertiajs/vue3';
import CloseButton from '@/Components/CloseButton.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();
const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <Head title="Log in" />
    <CloseButton route-name="Home" position="top-8 -md:top-8 -md:right-8 right-20" />
    <!-- <ApplicationLogo class="w-16 absolute top-8 left-8" /> -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-8 sm:pt-0 bg-gray-100 -sm:pt-24">
        <div>
            <Link href="/">
            <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>


            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                        autocomplete="username" />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                        autocomplete="current-password" />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Forgot your password?
                    </Link>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Log in
                    </PrimaryButton>
                </div>
            </form>

            <LoginWithSocials />
            <div class="grid grid-cols-[20%_60%_20%] items-center mb-4">
                <hr class="w-full bg-slate-200">
                <p class="flex justify-center capitalize">Don't have an account?</p>
                <hr class="w-full bg-slate-200">
            </div>
            <div class="pb-12">
                <button @click="router.get(route('register'))" type="button" title="sign up"
                    class="w-40 mx-auto flex justify-center items-center h-8 rounded-3xl border border-secondary capitalize">
                    sign up
                </button>
            </div>
        </div>

    </div>
</template>
