<?php

use App\Models\GalleryItem;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.public')] #[Title('Project Gallery & Infrastructure | Comtech (Suri)')] class extends Component {
    public string $category = 'all';

    public function with(): array
    {
        $query = GalleryItem::query()->orderBy('sort_order');

        if ($this->category !== 'all') {
            $query->where('category', $this->category);
        }

        $categories = GalleryItem::query()->distinct()->pluck('category')->filter()->values();

        return [
            'items' => $query->get(),
            'categories' => $categories,
        ];
    }
};
?>

<div x-data="{ modalOpen: false, activeImage: '', activeTitle: '', activeCaption: '' }">
    <!-- Header -->
    <section class="bg-gradient-to-b from-slate-900 via-indigo-950 to-slate-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="px-3.5 py-1.5 rounded-full bg-indigo-900/80 border border-indigo-700 text-indigo-300 text-xs font-semibold">
                Real Projects & Workshop
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                Deployments & Workshop Gallery
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
                A glimpse of our surveillance installations, networking server racks, chip-level repair lab, and showroom in Suri.
            </p>
        </div>
    </section>

    <!-- Filter Buttons -->
    <section class="py-6 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center gap-2 flex-wrap">
            <button wire:click="$set('category', 'all')" class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ $category === 'all' ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200' }}">
                All Photos
            </button>
            @foreach ($categories as $cat)
                <button wire:click="$set('category', '{{ $cat }}')" class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ $category === $cat ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200' }}">
                    {{ $cat }}
                </button>
            @endforeach
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="py-16 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($items as $item)
                    <div class="bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm group hover:shadow-xl transition-all cursor-pointer"
                         @click="activeImage = '{{ $item->image_url }}'; activeTitle = '{{ addslashes($item->title) }}'; activeCaption = '{{ addslashes($item->caption ?? '') }}'; modalOpen = true;">
                        
                        <div class="relative h-60 overflow-hidden bg-slate-100 dark:bg-slate-800">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                                <span class="text-white text-xs font-semibold flex items-center gap-1.5">
                                    <i class="fa-solid fa-expand"></i> Click to Zoom
                                </span>
                            </div>
                            <span class="absolute top-3 left-3 px-2 py-0.5 rounded-md bg-indigo-600 text-white text-[10px] font-bold">
                                {{ $item->category }}
                            </span>
                        </div>

                        <div class="p-4 space-y-1">
                            <h3 class="font-bold text-xs text-slate-900 dark:text-white line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                {{ $item->title }}
                            </h3>
                            @if($item->caption)
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                    {{ $item->caption }}
                                </p>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" @click.self="modalOpen = false">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-3xl w-full overflow-hidden shadow-2xl border border-slate-700 relative">
            <button @click="modalOpen = false" class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-black/60 text-white flex items-center justify-center hover:bg-black transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="max-h-[70vh] bg-black flex items-center justify-center overflow-hidden">
                <img :src="activeImage" :alt="activeTitle" class="max-h-[70vh] w-auto object-contain">
            </div>
            <div class="p-6 space-y-1">
                <h4 class="text-base font-bold text-slate-900 dark:text-white" x-text="activeTitle"></h4>
                <p class="text-xs text-slate-500 dark:text-slate-400" x-text="activeCaption"></p>
            </div>
        </div>
    </div>
</div>
