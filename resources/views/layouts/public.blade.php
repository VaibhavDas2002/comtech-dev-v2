<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    @include('partials.head', [
        'title' => $title ?? null,
        'metaDescription' => $metaDescription ?? null
    ])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased selection:bg-indigo-500 selection:text-white dark:bg-slate-950 dark:text-slate-100 flex flex-col justify-between">
    
    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white text-xs py-2 px-4 border-b border-indigo-900/40">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4 flex-wrap justify-center sm:justify-start">
                <span class="flex items-center gap-1 text-slate-300">
                    <i class="fa-solid fa-location-dot text-indigo-400"></i>
                    Beside A.B.T.A Building, New DangalPara, Suri, Birbhum – 731101
                </span>
                <span class="hidden md:inline-block text-slate-600">|</span>
                <span class="hidden md:flex items-center gap-1 text-slate-300">
                    <i class="fa-solid fa-clock text-indigo-400"></i>
                    Mon - Sat: 9:30 AM – 8:30 PM
                </span>
            </div>
            <div class="flex items-center gap-4 text-xs">
                <a href="tel:+919434197268" class="flex items-center gap-1 hover:text-indigo-300 transition-colors font-medium">
                    <i class="fa-solid fa-phone text-emerald-400"></i> +91 94341 97268
                </a>
                <a href="https://wa.me/919434197268?text=Hello%20Comtech%2C%20I%20have%20an%20enquiry" target="_blank" class="flex items-center gap-1 text-emerald-400 hover:text-emerald-300 transition-colors font-medium">
                    <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp Support
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 w-full glass-panel border-b border-slate-200/80 dark:border-slate-800/80 transition-all shadow-xs" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Dual Brand Header -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group" wire:navigate>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-600 to-blue-600 flex items-center justify-center text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-microchip text-2xl"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">COMTECH</span>
                            <span class="px-1.5 py-0.5 text-[10px] font-bold uppercase rounded bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">SURI</span>
                        </div>
                        <p class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 leading-none mt-0.5">
                            Information Services &bull; Infosys
                        </p>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-1 font-medium text-sm text-slate-700 dark:text-slate-200">
                    <a href="{{ route('home') }}" wire:navigate class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 font-semibold' : 'hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                        Home
                    </a>
                    <a href="{{ route('about') }}" wire:navigate class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('about') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 font-semibold' : 'hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                        About Us
                    </a>
                    <a href="{{ route('services') }}" wire:navigate class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('services*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 font-semibold' : 'hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                        Services
                    </a>
                    <a href="{{ route('products') }}" wire:navigate class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('products*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 font-semibold' : 'hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                        Products & Sales
                    </a>
                    <a href="{{ route('promotions') }}" wire:navigate class="px-3 py-2 rounded-lg transition-colors relative {{ request()->routeIs('promotions') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 font-semibold' : 'hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                        Offers
                        <span class="absolute -top-1 -right-1 flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                        </span>
                    </a>
                    <a href="{{ route('gallery') }}" wire:navigate class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('gallery') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 font-semibold' : 'hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                        Gallery
                    </a>
                    <a href="{{ route('blogs') }}" wire:navigate class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('blogs*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 font-semibold' : 'hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                        Blog
                    </a>
                    <a href="{{ route('contact') }}" wire:navigate class="px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('contact') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/50 font-semibold' : 'hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800/60' }}">
                        Contact
                    </a>
                </nav>

                <!-- Action CTAs -->
                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ route('contact') }}#enquiry-form" wire:navigate class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white text-sm font-semibold shadow-md shadow-indigo-500/25 hover:shadow-lg hover:shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Get Free Quote</span>
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" wire:navigate class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition-colors" title="Admin Dashboard">
                            <i class="fa-solid fa-gauge-high"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 transition-colors" title="Admin Login">
                            <i class="fa-solid fa-lock"></i>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center gap-2 lg:hidden">
                    <a href="{{ route('contact') }}" wire:navigate class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white text-xs font-semibold">
                        Quote
                    </a>
                    <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <i class="fa-solid text-xl" :class="mobileOpen ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer -->
        <div x-show="mobileOpen" x-collapse x-cloak class="lg:hidden border-t border-slate-200 dark:border-slate-800 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md px-4 pt-2 pb-6 space-y-2">
            <a href="{{ route('home') }}" @click="mobileOpen = false" wire:navigate class="block px-3 py-2 rounded-lg font-medium text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-slate-800">
                <i class="fa-solid fa-home w-5 text-indigo-500"></i> Home
            </a>
            <a href="{{ route('about') }}" @click="mobileOpen = false" wire:navigate class="block px-3 py-2 rounded-lg font-medium text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-slate-800">
                <i class="fa-solid fa-building w-5 text-indigo-500"></i> About Us
            </a>
            <a href="{{ route('services') }}" @click="mobileOpen = false" wire:navigate class="block px-3 py-2 rounded-lg font-medium text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-slate-800">
                <i class="fa-solid fa-gears w-5 text-indigo-500"></i> Services (CCTV, Tally, Web, Repair)
            </a>
            <a href="{{ route('products') }}" @click="mobileOpen = false" wire:navigate class="block px-3 py-2 rounded-lg font-medium text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-slate-800">
                <i class="fa-solid fa-cart-shopping w-5 text-indigo-500"></i> Products & Sales
            </a>
            <a href="{{ route('promotions') }}" @click="mobileOpen = false" wire:navigate class="block px-3 py-2 rounded-lg font-medium text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-slate-800">
                <i class="fa-solid fa-tags w-5 text-rose-500"></i> Special Deals & Offers
            </a>
            <a href="{{ route('gallery') }}" @click="mobileOpen = false" wire:navigate class="block px-3 py-2 rounded-lg font-medium text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-slate-800">
                <i class="fa-solid fa-images w-5 text-indigo-500"></i> Gallery & Deployments
            </a>
            <a href="{{ route('blogs') }}" @click="mobileOpen = false" wire:navigate class="block px-3 py-2 rounded-lg font-medium text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-slate-800">
                <i class="fa-solid fa-newspaper w-5 text-indigo-500"></i> Tech Guides & Blog
            </a>
            <a href="{{ route('contact') }}" @click="mobileOpen = false" wire:navigate class="block px-3 py-2 rounded-lg font-medium text-slate-700 dark:text-slate-200 hover:bg-indigo-50 dark:hover:bg-slate-800">
                <i class="fa-solid fa-phone w-5 text-indigo-500"></i> Contact & Support
            </a>
            
            <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex gap-2">
                <a href="tel:+919434197268" class="flex-1 py-2.5 text-center rounded-xl bg-slate-100 dark:bg-slate-800 font-semibold text-xs text-slate-800 dark:text-slate-200">
                    <i class="fa-solid fa-phone text-emerald-500"></i> Call Sales
                </a>
                <a href="https://wa.me/919434197268" target="_blank" class="flex-1 py-2.5 text-center rounded-xl bg-emerald-600 font-semibold text-xs text-white">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Floating WhatsApp CTA Widget -->
    <a href="https://wa.me/919434197268?text=Hello%20Comtech%2C%20I%20would%20like%20to%20enquire%20about%20your%20services" 
       target="_blank" 
       class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 px-4 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full shadow-xl shadow-emerald-500/30 hover:scale-105 transition-all group font-semibold text-sm">
        <i class="fa-brands fa-whatsapp text-2xl"></i>
        <span class="hidden sm:inline-block">Chat on WhatsApp</span>
    </a>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 pt-16 pb-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                
                <!-- Col 1: Brand & Identity -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-md">
                            <i class="fa-solid fa-microchip text-xl"></i>
                        </div>
                        <div>
                            <span class="text-lg font-bold text-white tracking-wide">COMTECH</span>
                            <p class="text-xs text-slate-400">Information Services &bull; Infosys</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed pr-6">
                        Birbhum's trusted technology partner for 15+ years. Providing genuine IT Hardware sales, Hikvision CCTV surveillance systems, Tally Prime solutions, custom web & software development, and certified chip-level repairs.
                    </p>
                    <div class="space-y-2 text-xs text-slate-300 pt-2">
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-indigo-400 mt-1"></i>
                            <span>Beside A.B.T.A Building, New DangalPara, Suri, Birbhum, West Bengal – 731101</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-emerald-400"></i>
                            <span>+91 94341 97268 (Sales) / +91 94743 06951 (Service) / 03462-255555</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-indigo-400"></i>
                            <span>sales@comtechis.in / service@comtechinfosys.in</span>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Quick Navigation</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" wire:navigate class="hover:text-indigo-400 transition-colors">Home</a></li>
                        <li><a href="{{ route('about') }}" wire:navigate class="hover:text-indigo-400 transition-colors">About Us</a></li>
                        <li><a href="{{ route('services') }}" wire:navigate class="hover:text-indigo-400 transition-colors">Services Catalog</a></li>
                        <li><a href="{{ route('products') }}" wire:navigate class="hover:text-indigo-400 transition-colors">Product Store</a></li>
                        <li><a href="{{ route('promotions') }}" wire:navigate class="hover:text-indigo-400 transition-colors">Current Deals</a></li>
                        <li><a href="{{ route('gallery') }}" wire:navigate class="hover:text-indigo-400 transition-colors">Project Gallery</a></li>
                        <li><a href="{{ route('blogs') }}" wire:navigate class="hover:text-indigo-400 transition-colors">Tech Articles</a></li>
                        <li><a href="{{ route('contact') }}" wire:navigate class="hover:text-indigo-400 transition-colors">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Col 3: Key Solutions -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Core IT Services</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('services') }}#cctv" wire:navigate class="hover:text-indigo-400 transition-colors">CCTV Camera Installation</a></li>
                        <li><a href="{{ route('services') }}#tally" wire:navigate class="hover:text-indigo-400 transition-colors">Tally Prime Licensing & TDL</a></li>
                        <li><a href="{{ route('services') }}#laptop" wire:navigate class="hover:text-indigo-400 transition-colors">Chip-Level Laptop Repair</a></li>
                        <li><a href="{{ route('services') }}#web" wire:navigate class="hover:text-indigo-400 transition-colors">Website & App Development</a></li>
                        <li><a href="{{ route('services') }}#amc" wire:navigate class="hover:text-indigo-400 transition-colors">Corporate IT AMC & Networking</a></li>
                        <li><a href="{{ route('services') }}#antivirus" wire:navigate class="hover:text-indigo-400 transition-colors">Quick Heal & Seqrite Antivirus</a></li>
                    </ul>
                </div>

                <!-- Col 4: Suri Location & Hours -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Locate Our Office</h3>
                    <div class="rounded-xl overflow-hidden border border-slate-700 h-32 mb-3">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14603.20864380183!2d87.5256247!3d23.9073287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f9dd5a4f7e21a3%3A0x6b77ff3ef7db4df6!2sSuri%2C%20West%20Bengal%20731101!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <p class="text-xs text-slate-400">
                        <strong class="text-slate-200">Business Hours:</strong><br>
                        Monday – Saturday: 9:30 AM – 8:30 PM<br>
                        Sunday: Closed (Emergency AMC open)
                    </p>
                </div>

            </div>

            <!-- Bottom Subfooter -->
            <div class="mt-12 pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} <strong>Comtech Information Services</strong> & <strong>Comtech Infosys</strong>. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <span>Suri &bull; Birbhum &bull; West Bengal &bull; India</span>
                    <a href="{{ route('login') }}" class="text-slate-400 hover:text-white transition-colors" wire:navigate>Admin Access</a>
                </div>
            </div>
        </div>
    </footer>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>
</html>
