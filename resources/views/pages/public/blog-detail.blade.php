<?php

use App\Models\Blog;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.public')] class extends Component {
    public Blog $blog;

    public function mount(string $slug): void
    {
        $this->blog = Blog::with('category')->where('slug', $slug)->firstOrFail();
        $this->blog->increment('views_count');
    }

    public function with(): array
    {
        $related = Blog::query()
            ->where('id', '!=', $this->blog->id)
            ->where('is_published', true)
            ->take(3)
            ->get();

        return [
            'relatedBlogs' => $related,
        ];
    }
};
?>

<div>
    <!-- Post Header -->
    <article class="py-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="space-y-4 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 text-xs font-semibold border border-indigo-200 dark:border-indigo-800">
                    <span>{{ $blog->category?->name ?? 'Article' }}</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                    {{ $blog->title }}
                </h1>

                <div class="flex items-center justify-center gap-4 text-xs text-slate-500 dark:text-slate-400 pt-2">
                    <span class="font-medium">By {{ $blog->author }}</span>
                    <span>&bull;</span>
                    <span>{{ $blog->published_at?->format('F d, Y') }}</span>
                    <span>&bull;</span>
                    <span>{{ $blog->read_time_minutes }} min read</span>
                    <span>&bull;</span>
                    <span>{{ $blog->views_count }} views</span>
                </div>
            </div>

            <!-- Featured Cover Image -->
            @if($blog->cover_image_url)
                <div class="mt-8 rounded-3xl overflow-hidden shadow-xl border border-slate-200 dark:border-slate-800 h-[380px]">
                    <img src="{{ $blog->cover_image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Excerpt Callout -->
            <div class="mt-10 p-6 rounded-2xl bg-indigo-50/60 dark:bg-slate-800/60 border-l-4 border-indigo-600 text-slate-700 dark:text-slate-300 text-base italic leading-relaxed">
                {{ $blog->excerpt }}
            </div>

            <!-- Markdown/Text Body Content -->
            <div class="mt-8 prose dark:prose-invert prose-indigo max-w-none text-slate-700 dark:text-slate-300 text-sm sm:text-base leading-relaxed space-y-4">
                {!! nl2br(e($blog->content)) !!}
            </div>

            <!-- Tags -->
            @if($blog->tags && count($blog->tags))
                <div class="mt-10 pt-6 border-t border-slate-200 dark:border-slate-800 flex items-center gap-2 flex-wrap">
                    <span class="text-xs font-bold text-slate-500">Tags:</span>
                    @foreach ($blog->tags as $tag)
                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-medium">
                            #{{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif

            <!-- Share & CTA Bar -->
            <div class="mt-8 p-6 rounded-2xl bg-gradient-to-r from-indigo-900 via-indigo-950 to-slate-900 text-white flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center sm:text-left">
                    <h3 class="font-bold text-base">Need Technical Help or Implementation in Suri?</h3>
                    <p class="text-xs text-slate-300">Our engineers are ready to assist your business with CCTV, Tally or Repairs.</p>
                </div>
                <a href="{{ route('contact', ['subject' => 'Enquiry from Blog: ' . $blog->title]) }}" wire:navigate class="px-5 py-2.5 rounded-xl bg-white text-indigo-900 font-bold text-xs hover:bg-slate-100 transition shrink-0">
                    Contact Comtech Team
                </a>
            </div>

        </div>
    </article>

    <!-- Related Articles -->
    @if($relatedBlogs->isNotEmpty())
        <section class="py-16 bg-slate-50 dark:bg-slate-950">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-8">Related Articles & Guides</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($relatedBlogs as $item)
                        <div class="bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 p-5 space-y-3 group hover:shadow-md transition">
                            <h4 class="font-bold text-sm text-slate-900 dark:text-white group-hover:text-indigo-600 transition line-clamp-2">
                                <a href="{{ route('blogs.show', $item->slug) }}" wire:navigate>{{ $item->title }}</a>
                            </h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2">{{ $item->excerpt }}</p>
                            <a href="{{ route('blogs.show', $item->slug) }}" wire:navigate class="text-xs font-bold text-indigo-600 hover:underline inline-block">Read More &rarr;</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
