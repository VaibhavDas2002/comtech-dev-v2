<?php

use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.public')] #[Title('Products & Hardware Sales | Comtech Information Services (Suri)')] class extends Component {
    public string $search = '';
    public string $category = 'all';
    public string $selectedBrand = 'all';

    public function with(): array
    {
        $query = Product::query()->with('category')->where('is_active', true)->orderBy('sort_order');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('brand', 'like', "%{$this->search}%")
                  ->orWhere('model_number', 'like', "%{$this->search}%")
                  ->orWhere('short_description', 'like', "%{$this->search}%");
            });
        }

        if ($this->category !== 'all') {
            $query->whereHas('category', function ($q) {
                $q->where('slug', $this->category);
            });
        }

        if ($this->selectedBrand !== 'all') {
            $query->where('brand', $this->selectedBrand);
        }

        $categories = ProductCategory::query()->where('is_active', true)->orderBy('sort_order')->get();
        $brands = Product::query()->where('is_active', true)->whereNotNull('brand')->distinct()->pluck('brand')->filter()->values();

        return [
            'products' => $query->get(),
            'categories' => $categories,
            'brands' => $brands,
        ];
    }
};
?>

<div>
    <!-- Banner -->
    <section class="bg-gradient-to-b from-slate-900 via-indigo-950 to-slate-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="px-3.5 py-1.5 rounded-full bg-indigo-900/80 border border-indigo-700 text-indigo-300 text-xs font-semibold">
                Sales Division &bull; Comtech Information Services
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                IT Hardware & Software Store
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
                Explore authentic CCTV packages, Tally Prime software, branded laptops, workstations, antivirus keys, and thermal POS printers in Suri.
            </p>
        </div>
    </section>

    <!-- Filter & Search Toolbar -->
    <section class="py-8 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 sticky top-20 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                
                <!-- Search -->
                <div class="relative w-full lg:w-80">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search products, brands, model..." class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                    @if($search)
                        <button wire:click="$set('search', '')" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-xs">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    @endif
                </div>

                <!-- Category Pills (Scrollable) -->
                <div class="flex items-center gap-2 overflow-x-auto w-full lg:w-auto pb-2 lg:pb-0 scrollbar-none">
                    <button wire:click="$set('category', 'all')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition {{ $category === 'all' ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                        All Products
                    </button>
                    @foreach ($categories as $cat)
                        <button wire:click="$set('category', '{{ $cat->slug }}')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition {{ $category === $cat->slug ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Brand Filter Dropdown -->
                <div class="w-full lg:w-48 shrink-0">
                    <select wire:model.live="selectedBrand" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-300">
                        <option value="all">Filter by Brand (All)</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand }}">{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
    </section>

    <!-- Product Grid -->
    <section class="py-16 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if ($products->isEmpty())
                <div class="text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 space-y-3">
                    <div class="w-12 h-12 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-500 mx-auto flex items-center justify-center text-xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">No products found</h3>
                    <p class="text-xs text-slate-500">Try changing your search terms or category selection.</p>
                    <button wire:click="$set('category', 'all'); $set('search', ''); $set('selectedBrand', 'all')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold">
                        Reset All Filters
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($products as $product)
                        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between group hover:-translate-y-1">
                            
                            <div>
                                <!-- Image & Tags -->
                                <div class="relative h-56 bg-slate-100 dark:bg-slate-800/50 p-4 flex items-center justify-center overflow-hidden">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                    
                                    @if($product->discount_percentage)
                                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md bg-rose-500 text-white text-xs font-extrabold shadow-sm">
                                            {{ $product->discount_percentage }}% OFF
                                        </span>
                                    @endif

                                    <div class="absolute top-3 right-3 flex flex-col gap-1 items-end">
                                        <span class="px-2.5 py-1 rounded-md bg-white/90 dark:bg-slate-900/90 text-slate-800 dark:text-slate-200 text-[10px] font-bold shadow-xs border border-slate-200 dark:border-slate-700">
                                            {{ $product->brand ?? $product->category?->name }}
                                        </span>
                                        @if($product->in_stock)
                                            <span class="px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-semibold">
                                                In Stock (Suri)
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="p-6 space-y-3">
                                    <h3 class="font-bold text-base text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    @if($product->model_number)
                                        <p class="text-[11px] font-mono text-slate-400">Model: {{ $product->model_number }}</p>
                                    @endif

                                    <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 leading-relaxed">
                                        {{ $product->short_description }}
                                    </p>

                                    @if($product->features && count($product->features))
                                        <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-1">
                                            @foreach(array_slice($product->features, 0, 3) as $feat)
                                                <div class="flex items-center gap-2 text-[11px] text-slate-700 dark:text-slate-300">
                                                    <i class="fa-solid fa-check text-emerald-500 text-[10px]"></i>
                                                    <span class="truncate">{{ $feat }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($product->warranty_info)
                                        <div class="text-[11px] text-indigo-600 dark:text-indigo-400 font-medium flex items-center gap-1.5 pt-1">
                                            <i class="fa-solid fa-shield-halved"></i>
                                            <span>{{ $product->warranty_info }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Price & CTA -->
                            <div class="p-6 pt-0 flex items-center justify-between gap-3 border-t border-slate-100 dark:border-slate-800 mt-4">
                                <div>
                                    @if($product->discount_price)
                                        <div class="text-lg font-extrabold text-indigo-600 dark:text-indigo-400">
                                            ₹{{ number_format((float) $product->discount_price) }}
                                        </div>
                                        @if($product->price)
                                            <div class="text-xs text-slate-400 line-through">
                                                ₹{{ number_format((float) $product->price) }}
                                            </div>
                                        @endif
                                    @elseif($product->price)
                                        <div class="text-lg font-extrabold text-slate-900 dark:text-white">
                                            ₹{{ number_format((float) $product->price) }}
                                        </div>
                                    @else
                                        <div class="text-xs font-bold text-indigo-600 dark:text-indigo-400">
                                            Special Deal / Quote
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="https://wa.me/919434197268?text={{ urlencode('Hello Comtech, I am interested in: ' . $product->name) }}" target="_blank" class="p-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-100 transition" title="Ask on WhatsApp">
                                        <i class="fa-brands fa-whatsapp text-base"></i>
                                    </a>
                                    <a href="{{ route('contact', ['product' => $product->name]) }}" wire:navigate class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shadow-xs transition">
                                        Request Quote
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>

    <!-- Bulk Purchase / Institution Quote -->
    <section class="py-12 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center md:text-left">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Looking for Bulk Purchases for Schools, Offices, or Institutions?</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400">We offer specialized GST invoices, institutional discounts, and free delivery in Suri & Birbhum.</p>
            </div>
            <a href="{{ route('contact') }}" wire:navigate class="px-6 py-3 rounded-xl bg-slate-900 dark:bg-slate-800 text-white font-semibold text-xs hover:bg-indigo-600 transition shrink-0">
                Contact Corporate Desk
            </a>
        </div>
    </section>
</div>
