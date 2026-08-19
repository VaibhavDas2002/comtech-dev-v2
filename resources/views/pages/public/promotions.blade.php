<?php

use App\Models\Promotion;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.public')] #[Title('Special Offers & Discounts | Comtech (Suri, Birbhum)')] class extends Component {
    public function with(): array
    {
        return [
            'promotions' => Promotion::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ];
    }
};
?>

<div>
    <!-- Banner -->
    <section class="bg-gradient-to-b from-slate-900 via-indigo-950 to-slate-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="px-3.5 py-1.5 rounded-full bg-rose-900/80 border border-rose-700 text-rose-300 text-xs font-semibold">
                Limited Period Deals & Packages
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                Special Promotions & Offers
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
                Exclusive CCTV bundle discounts, Tally upgrade offers, and hardware deals for businesses in Suri & Birbhum.
            </p>
        </div>
    </section>

    <!-- Promotions Cards -->
    <section class="py-16 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-8">
                @foreach ($promotions as $promo)
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all overflow-hidden grid grid-cols-1 lg:grid-cols-12 gap-8 items-center p-6 sm:p-8">
                        
                        <!-- Image -->
                        <div class="lg:col-span-4 h-64 rounded-2xl overflow-hidden relative">
                            <img src="{{ $promo->image_url }}" alt="{{ $promo->title }}" class="w-full h-full object-cover">
                            <div class="absolute top-3 left-3 px-3 py-1 bg-rose-500 text-white text-xs font-bold rounded-lg shadow-md">
                                {{ $promo->badge_text }}
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="lg:col-span-8 space-y-4">
                            <div class="space-y-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                                    {{ $promo->discount_text }}
                                </span>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">
                                    {{ $promo->title }}
                                </h2>
                                <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                                    {{ $promo->description }}
                                </p>
                            </div>

                            @if($promo->terms)
                                <div class="p-3.5 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 text-xs text-slate-500 dark:text-slate-400">
                                    <strong class="text-slate-700 dark:text-slate-300">Terms & Conditions:</strong> {{ $promo->terms }}
                                </div>
                            @endif

                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    @if($promo->end_date)
                                        <i class="fa-solid fa-clock text-rose-500"></i> Valid until: <strong>{{ $promo->end_date->format('M d, Y') }}</strong>
                                    @else
                                        <i class="fa-solid fa-bolt text-amber-500"></i> Limited Time Offer
                                    @endif
                                </div>

                                <div class="flex items-center gap-3 w-full sm:w-auto">
                                    <a href="https://wa.me/919434197268?text={{ urlencode('Hello Comtech, I would like to claim offer: ' . $promo->title) }}" target="_blank" class="flex-1 sm:flex-none px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold transition flex items-center justify-center gap-1.5">
                                        <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp Claim
                                    </a>
                                    <a href="{{ route('contact', ['subject' => 'Claim Promotion: ' . $promo->title]) }}" wire:navigate class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold transition text-center">
                                        {{ $promo->cta_text }}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
