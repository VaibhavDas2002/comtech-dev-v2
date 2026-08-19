<?php

use App\Models\Blog;
use App\Models\BlogCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.public')] #[Title('Tech Blog & Knowledge Base | Comtech (Suri, Birbhum)')] class extends Component {
    public string $search = '';
    public string $category = 'all';

    public function with(): array
    {
        $query = Blog::query()->with('category')->where('is_published', true)->orderByDesc('published_at');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('excerpt', 'like', "%{$this->search}%")
                  ->orWhere('content', 'like', "%{$this->search}%");
            });
        }

        if ($this->category !== 'all') {
            $query->whereHas('category', function ($q) {
                $q->where('slug', $this->category);
            });
        }

        $categories = BlogCategory::query()->get();

        return [
            'blogs' => $query->get(),
            'categories' => $categories,
        ];
    }
};
?>

<div>
    <!-- Banner -->
    <section class="bg-gradient-to-b from-slate-900 via-indigo-950 to-slate-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="px-3.5 py-1.5 rounded-full bg-indigo-900/80 border border-indigo-700 text-indigo-300 text-xs font-semibold">
                Tech Advice, Tutorials & News
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                IT Knowledge Base & Blog
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
                Practical tips on surveillance camera selection, Tally Prime accounting features, antivirus protection, and PC performance tuning.
            </p>
        </div>
    </section>

    <!-- Filter & Search Toolbar -->
    <section class="py-6 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- Search -->
            <div class="relative w-full md:w-80">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search blog articles..." class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
            </div>

            <!-- Categories -->
            <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 scrollbar-none">
                <button wire:click="$set('category', 'all')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition {{ $category === 'all' ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200' }}">
                    All Categories
                </button>
                @foreach ($categories as $cat)
                    <button wire:click="$set('category', '{{ $cat->slug }}')" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold whitespace-nowrap transition {{ $category === $cat->slug ? 'bg-indigo-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200' }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Blogs List -->
    <section class="py-16 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($blogs->isEmpty())
                <div class="text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 space-y-3">
                    <div class="w-12 h-12 rounded-full bg-indigo-50 dark:bg-indigo-950 text-indigo-500 mx-auto flex items-center justify-center text-xl">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">No articles found</h3>
                    <p class="text-xs text-slate-500">Try changing your search terms or category selection.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($blogs as $blog)
                        <article class="bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group hover:-translate-y-1">
                            <div>
                                <div class="h-48 overflow-hidden relative">
                                    <img src="{{ $blog->cover_image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-bold bg-indigo-600 text-white shadow-xs">
                                        {{ $blog->category?->name }}
                                    </span>
                                </div>

                                <div class="p-6 space-y-3">
                                    <div class="flex items-center gap-2 text-[11px] text-slate-500 dark:text-slate-400">
                                        <i class="fa-regular fa-calendar"></i>
                                        <span>{{ $blog->published_at?->format('M d, Y') }}</span>
                                        <span>&bull;</span>
                                        <i class="fa-regular fa-clock"></i>
                                        <span>{{ $blog->read_time_minutes }} min read</span>
                                    </div>

                                    <h3 class="font-bold text-base text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2">
                                        <a href="{{ route('blogs.show', $blog->slug) }}" wire:navigate>
                                            {{ $blog->title }}
                                        </a>
                                    </h3>

                                    <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 leading-relaxed">
                                        {{ $blog->excerpt }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-6 pt-0 flex items-center justify-between border-t border-slate-100 dark:border-slate-800 mt-2">
                                <span class="text-xs font-medium text-slate-500 dark:text-slate-400">By {{ $blog->author }}</span>
                                <a href="{{ route('blogs.show', $blog->slug) }}" wire:navigate class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                                    Read Full Post &rarr;
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</div>
