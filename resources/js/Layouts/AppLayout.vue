<template>
    <div>
        <jet-banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link :href="route('dashboard')" class="focus:outline-none rounded focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-white focus-visible:ring-green-500 transition">
                                    <jet-application-mark class="block h-9 w-auto" />
                                </inertia-link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </jet-nav-link>
                            </div>
                        </div>

                        <div class="-mr-2 flex items-center">
                            <div class="relative">
                                <Menu>
                                    <MenuButton v-slot="{ open }" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                            <path :class="{'hidden': ! open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </MenuButton>

                                    <MenuItems class="bg-white absolute z-50 mt-2 rounded-md shadow-lg w-72 origin-top-right right-0 rounded-md ring-1 ring-black ring-opacity-5 outline-none">
                                        <MenuItem as="div" v-slot="{ active }" class="pt-2 pb-3 space-y-1">
                                            <inertia-link
                                                :href="route('dashboard')"
                                                :class="[
                                                    route().current('dashboard')
                                                    ? (active ? 'block pl-3 pr-4 py-2 border-l-4 border-green-400 text-base font-medium text-green-700 bg-green-50 outline-none text-green-800 bg-green-100 border-green-700 transition' : 'block pl-3 pr-4 py-2 border-l-4 border-green-400 text-base font-medium text-green-700 bg-green-50 transition')
                                                    : (active ? 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 text-gray-800 bg-gray-50 border-gray-300 transition' : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 transition'),
                                                ]"
                                            >
                                                Dashboard
                                            </inertia-link>
                                        </MenuItem>

                                        <div class="pt-4 pb-1 border-t border-gray-200">
                                            <div class="flex items-center px-4">
                                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3" >
                                                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                                </div>

                                                <div>
                                                    <div class="font-medium text-base text-gray-800">{{ $page.props.user.name }}</div>
                                                    <div class="font-medium text-sm text-gray-500">{{ $page.props.user.email }}</div>
                                                </div>
                                            </div>

                                            <div class="mt-3 space-y-1">
                                                <MenuItem v-slot="{ active }">
                                                    <inertia-link
                                                        :href="route('profile.show')"
                                                        :class="[
                                                            route().current('profile.show')
                                                            ? (active ? 'block pl-3 pr-4 py-2 border-l-4 border-green-400 text-base font-medium text-green-700 bg-green-50 outline-none text-green-800 bg-green-100 border-green-700 transition' : 'block pl-3 pr-4 py-2 border-l-4 border-green-400 text-base font-medium text-green-700 bg-green-50 transition')
                                                            : (active ? 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 text-gray-800 bg-gray-50 border-gray-300 transition' : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 transition'),
                                                        ]"
                                                    >
                                                        Profile
                                                    </inertia-link>
                                                </MenuItem>

                                                <MenuItem v-slot="{ active }" v-if="$page.props.jetstream.hasApiFeatures">
                                                    <inertia-link
                                                        :href="route('api-tokens.index')"
                                                        :class="[
                                                            route().current('api-tokens.index')
                                                            ? (active ? 'block pl-3 pr-4 py-2 border-l-4 border-green-400 text-base font-medium text-green-700 bg-green-50 outline-none text-green-800 bg-green-100 border-green-700 transition' : 'block pl-3 pr-4 py-2 border-l-4 border-green-400 text-base font-medium text-green-700 bg-green-50 transition')
                                                            : (active ? 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 text-gray-800 bg-gray-50 border-gray-300 transition' : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 transition'),
                                                        ]"
                                                    >
                                                        API Tokens
                                                    </inertia-link>
                                                </MenuItem>

                                                <form @submit.prevent="logout">
                                                    <MenuItem v-slot="{ active }">
                                                        <button @click="logout" :class="[
                                                            'w-full text-left',
                                                            active
                                                            ? 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 text-gray-800 bg-gray-50 border-gray-300 transition'
                                                            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 transition',
                                                        ]">
                                                            Log Out
                                                        </button>
                                                    </MenuItem>
                                                </form>
                                            </div>
                                        </div>
                                    </MenuItems>
                                </Menu>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
    import JetApplicationMark from '../Jetstream/ApplicationMark.vue'
    import JetBanner from '../Jetstream/Banner.vue'
    import JetDropdown from '../Jetstream/Dropdown.vue'
    import JetNavLink from '../Jetstream/NavLink.vue'
    import JetResponsiveNavLink from '../Jetstream/ResponsiveNavLink.vue'
    import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'

    export default {
        components: {
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetNavLink,
            JetResponsiveNavLink,
            Menu,
            MenuButton,
            MenuItems,
            MenuItem,
        },

        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>
