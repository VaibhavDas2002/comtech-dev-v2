<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-2 py-1 group" wire:navigate>
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-xs">
                        <i class="fa-solid fa-microchip"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold tracking-tight text-zinc-900 dark:text-white leading-tight">COMTECH</div>
                        <div class="text-[10px] text-zinc-500 dark:text-zinc-400 leading-none">Admin Portal</div>
                    </div>
                </a>
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Overview')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="inbox" :href="route('admin.enquiries')" :current="request()->routeIs('admin.enquiries')" wire:navigate>
                        {{ __('Enquiries & Leads') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Catalog & Sales')" class="grid">
                    <flux:sidebar.item icon="wrench" :href="route('admin.services')" :current="request()->routeIs('admin.services')" wire:navigate>
                        {{ __('Services') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="shopping-bag" :href="route('admin.products')" :current="request()->routeIs('admin.products')" wire:navigate>
                        {{ __('Products Store') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="tag" :href="route('admin.promotions')" :current="request()->routeIs('admin.promotions')" wire:navigate>
                        {{ __('Promotions & Deals') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Content & Media')" class="grid">
                    <flux:sidebar.item icon="document-text" :href="route('admin.blogs')" :current="request()->routeIs('admin.blogs')" wire:navigate>
                        {{ __('Blogs & Guides') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="photo" :href="route('admin.gallery')" :current="request()->routeIs('admin.gallery')" wire:navigate>
                        {{ __('Gallery Images') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="chat-bubble-left-right" :href="route('admin.testimonials')" :current="request()->routeIs('admin.testimonials')" wire:navigate>
                        {{ __('Testimonials') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Navigation')" class="grid">
                    <flux:sidebar.item icon="arrow-top-right-on-square" :href="route('home')" target="_blank">
                        {{ __('View Public Site') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
