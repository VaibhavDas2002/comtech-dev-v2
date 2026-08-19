<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.public')] #[Title('About Us | Comtech Information Services & Comtech Infosys (Suri)')] class extends Component {
    //
};
?>

<div>
    <!-- Hero Banner -->
    <section class="bg-gradient-to-b from-slate-900 via-indigo-950 to-slate-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="px-3.5 py-1.5 rounded-full bg-indigo-900/80 border border-indigo-700 text-indigo-300 text-xs font-semibold">
                Established 2009 &bull; Suri, Birbhum
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                About <span class="gradient-text">Comtech</span>
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
                Birbhum's leading technology provider for IT hardware sales, enterprise CCTV security, Tally Prime solutions, and chip-level technical services.
            </p>
        </div>
    </section>

    <!-- Dual Business Model -->
    <section class="py-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Division 1: Sales -->
                <div class="p-8 rounded-2xl bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-slate-800 dark:to-indigo-950/40 border border-indigo-100 dark:border-indigo-900/50 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-2xl shadow-md">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Sales Division</span>
                        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Comtech Information Services</h2>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        Focused on offering premier IT hardware, authorized software licenses, and genuine networking equipment. We deliver branded business laptops, assembled workstations, Hikvision CCTV kits, TVS POS printers, and Quick Heal / Seqrite enterprise endpoint security to retail, medical, and education sectors.
                    </p>
                    <ul class="space-y-2 text-xs font-medium text-slate-700 dark:text-slate-300">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-indigo-600"></i> Authorized Tally Prime Silver & Gold Partner</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-indigo-600"></i> Hikvision & CP Plus Direct Sourcing</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-indigo-600"></i> HP, Dell, Lenovo Business Laptops & Desktops</li>
                    </ul>
                </div>

                <!-- Division 2: Services -->
                <div class="p-8 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-slate-800 dark:to-emerald-950/40 border border-emerald-100 dark:border-emerald-900/50 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-2xl shadow-md">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Service Division</span>
                        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Comtech Infosys</h2>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        Our specialized engineering division handling precision chip-level motherboard repairing, on-site CCTV deployment, structured fiber networking, custom web/software development, and corporate Annual Maintenance Contracts (AMC).
                    </p>
                    <ul class="space-y-2 text-xs font-medium text-slate-700 dark:text-slate-300">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-600"></i> Precision BGA & Chip-Level Motherboard Lab</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-600"></i> Certified Surveillance Cable & Camera Engineers</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-600"></i> 24/7 Corporate AMC & Dedicated Local SLA</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- Company Story & Mission -->
    <section class="py-20 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="space-y-6">
                    <div class="space-y-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Our Journey</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">
                            Building Birbhum's Digital Backbone for Over 15 Years
                        </h2>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        Started with a mission to deliver world-class IT products and prompt service support right in Suri, <strong>Comtech</strong> has grown into the district's most dependable technology partner. 
                    </p>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        We recognized early that businesses and institutions in regional Bengal needed not just equipment, but comprehensive lifecycle support: expert consultation, flawless installation, immediate troubleshooting, and genuine warranty fulfillment.
                    </p>

                    <!-- Mission & Vision Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                            <h3 class="font-bold text-sm text-slate-900 dark:text-white flex items-center gap-2 mb-1">
                                <i class="fa-solid fa-bullseye text-indigo-500"></i> Our Mission
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                Empower every shop, enterprise, hospital, and school in Birbhum with seamless, affordable, and high-performance IT solutions.
                            </p>
                        </div>
                        <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                            <h3 class="font-bold text-sm text-slate-900 dark:text-white flex items-center gap-2 mb-1">
                                <i class="fa-solid fa-eye text-emerald-500"></i> Our Vision
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                Be the benchmark for technological excellence, speed of service, and customer trust across West Bengal.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Showcase Image Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <img src="https://images.unsplash.com/photo-1588508065123-287b28e013da?auto=format&fit=crop&w=600&q=80" alt="Lab" class="rounded-2xl shadow-md object-cover h-56 w-full">
                        <img src="https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=600&q=80" alt="CCTV" class="rounded-2xl shadow-md object-cover h-40 w-full">
                    </div>
                    <div class="space-y-4 pt-8">
                        <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=600&q=80" alt="Tally" class="rounded-2xl shadow-md object-cover h-40 w-full">
                        <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=600&q=80" alt="Office" class="rounded-2xl shadow-md object-cover h-56 w-full">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Location & Contact Summary -->
    <section class="py-16 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 text-center">
        <div class="max-w-4xl mx-auto px-4 space-y-4">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Visit Our Facility in Suri</h2>
            <p class="text-sm text-slate-600 dark:text-slate-400">
                <strong>Address:</strong> Beside A.B.T.A Building, New DangalPara, Suri, Birbhum, West Bengal, India – 731101
            </p>
            <div class="pt-2 flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}" wire:navigate class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold text-sm hover:bg-indigo-500 transition">
                    Contact Us Today
                </a>
                <a href="tel:+919434197268" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 font-semibold text-sm hover:bg-slate-200 transition">
                    Call: +91 94341 97268
                </a>
            </div>
        </div>
    </section>
</div>
