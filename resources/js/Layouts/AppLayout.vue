<script setup>

import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

defineProps({
    title: String,
});

const citySearch = defineModel({default: 'Curitiba'});

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const getWeather = () => {
    router.get(route('dashboard', citySearch.value));
}

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <!-- component -->
                <header class="bg-white">
                    <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:divide-y lg:divide-gray-500 lg:px-8">
                        <div class="relative flex h-16 justify-between">
                            <div class="relative z-10 flex mt-7 lg:px-0">
                                Dashboard
                            </div>
                            <div class="relative z-0 flex flex-1 items-center justify-center px-2 sm:absolute sm:inset-0">
                                <div class="w-full sm:max-w-xs">
                                    <label for="search" class="sr-only">Buscar Cidade</label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 z-50 left-0 flex items-center pl-3">
                                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input id="search" tabindex="0" v-model="citySearch" name="search" class="block w-full rounded-md border-gray-400 py-1.5 pl-10 pr-3 text-black-300 placeholder:text-black-400 focus:text-gray-900 focus:ring-0 focus:placeholder:text-gray-500 sm:text-sm sm:leading-6" placeholder="Buscar cidade" @blur="getWeather" type="search">
                                    </div>
                                </div>
                            </div>
                            <div class="hidden lg:relative lg:z-10 lg:ml-4 lg:flex lg:items-center">
                                <div class="ms-3 relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                            </button>

                                            <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Manage Account
                                            </div>

                                            <DropdownLink :href="route('profile.show')">
                                                Profile
                                            </DropdownLink>

                                            <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                                API Tokens
                                            </DropdownLink>

                                            <div class="border-t border-gray-200" />

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <DropdownLink as="button">
                                                    Log Out
                                                </DropdownLink>
                                            </form>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                        </div>
                        <nav class="w-full z-30 top-10 py-1 mt-2">
                            <div class="w-full flex items-center justify-between mt-0 px-6 py-2">
                                <div class="hidden md:flex md:items-center md:w-auto w-full order-3 md:order-1" id="menu">
                                    <nav>
                                        <ul class="md:flex items-center justify-between text-base text-gray-500 pt-4 md:pt-0">
                                            <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" :href="route('dashboard', citySearch)">Dashboard</a></li>
                                            <li><a class="inline-block no-underline hover:text-black font-medium text-lg py-2 px-4 lg:-ml-2" :href="route('weathers.index')">Salvos</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </nav>
                    </div>
                </header>
            </nav>
            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
