<?php

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.public')] #[Title('Services Catalog | Comtech Infosys (Suri, Birbhum)')] class extends Component {
    public string $search = '';
    public string $category = 'all';
    public string $division = 'all';

    public function with(): array
    {
        $query = Service::query()->where('is_active', true)->orderBy('sort_order');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('short_description', 'like', "%{$this->search}%")
                  ->orWhere('category', 'like', "%{$this->search}%");
            });
        }

        if ($this->category !== 'all') {
            $query->where('category', $this->category);
        }

        if ($this->division !== 'all') {
            $query->where(function ($q) {
                $q->where('division', $this->division)
                  ->orWhere('division', 'both');
            });
        }

        $allCategories = Service::query()->where('is_active', true)->distinct()->pluck('category')->filter()->values();

        return [
            'services' => $query->get(),
            'categories' => $allCategories,
        ];
    }
};
?>

<div>
    <!-- Header Banner -->
    <section class="bg-gradient-to-b from-slate-900 via-indigo-950 to-slate-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="px-3.5 py-1.5 rounded-full bg-indigo-900/80 border border-indigo-700 text-indigo-300 text-xs font-semibold">
                Professional Engineering & Consultancy
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                Our IT Services & Solutions
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
                Comprehensive hardware repair, surveillance deployment, Tally customization, and corporate AMC for Suri & Birbhum.
            </p>
        </div>
    </section>

    <!-- Filter & Search Toolbar -->
    <section class="py-8 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 sticky top-20 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                
                <!-- Search Bar -->
                <div class="relative w-full md:w-80">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search services (e.g. CCTV, Tally, Repair)..." class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                    @if($search)
                        <button wire:click="$set('search', '')" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-xs">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    @endif
                </div>

                <!-- Category Filters (Horizontal Scroll on Mobile) -->
                <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 scrollbar-none">
                    <button wire:click="$set('category', 'all')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition {{ $category === 'all' ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                        All Categories
                    </button>
                    @foreach ($categories as $cat)
                        <button wire:click="$set('category', '{{ $cat }}')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition {{ $category === $cat ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

    <!-- Services Grid List -->
    <section class="py-16 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if ($services->isEmpty())
                <div class="text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 space-y-3">
                    <div class="w-12 h-12 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-500 mx-auto flex items-center justify-center text-xl">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">No services found</h3>
                    <p class="text-xs text-slate-500">Try adjusting your search query or category filter.</p>
                    <button wire:click="$set('category', 'all'); $set('search', '')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold">
                        Reset Filters
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($services as $service)
                        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group hover:-translate-y-1">
                            
                            <!-- Image Banner -->
                            <div class="h-52 overflow-hidden relative">
                                <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[11px] font-bold bg-indigo-600 text-white shadow-sm">
                                    {{ $service->category }}
                                </span>
                                @if($service->starting_price)
                                    <span class="absolute bottom-3 right-3 px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-900/90 text-emerald-400 border border-slate-700 backdrop-blur-xs">
                                        {{ $service->starting_price }}
                                    </span>
                                @endif
                            </div>

                            <!-- Body Details -->
                            <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                                <div class="space-y-3">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $service->title }}
                                    </h3>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                        {{ $service->description ?? $service->short_description }}
                                    </p>

                                    @if($service->features && count($service->features))
                                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                                            <h4 class="text-[11px] font-bold text-slate-900 dark:text-slate-200 uppercase tracking-wider mb-2">Key Highlights:</h4>
                                            <ul class="space-y-1.5 text-xs text-slate-700 dark:text-slate-300">
                                                @foreach($service->features as $feat)
                                                    <li class="flex items-start gap-2">
                                                        <i class="fa-solid fa-circle-check text-emerald-500 text-[11px] mt-0.5 shrink-0"></i>
                                                        <span>{{ $feat }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
                                    <a href="https://wa.me/919434197268?text={{ urlencode('Hello Comtech, I would like to enquire about: ' . $service->title) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-100 text-xs font-semibold transition flex items-center gap-1.5">
                                        <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                                    </a>
                                    <a href="{{ route('contact', ['service' => $service->title]) }}" wire:navigate class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shadow-xs transition">
                                        Enquire Now &rarr;
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    <!-- Support Help Box -->
    <section class="py-12 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Need a Customized IT Support or AMC Plan?</h3>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-xl mx-auto">
                We craft tailored maintenance packages for banks, hospitals, schools, and retail chains across Birbhum district.
            </p>
            <div class="pt-2">
                <a href="{{ route('contact') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-500 transition">
                    <i class="fa-solid fa-phone"></i> Schedule Site Consultation
                </a>
            </div>
        </div>
    </section>
</div>
