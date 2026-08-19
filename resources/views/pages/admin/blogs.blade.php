<?php

use App\Models\Blog;
use App\Models\BlogCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Manage Blogs & Articles | Comtech Admin')] class extends Component {
    public bool $showModal = false;
    public ?int $editingId = null;

    #[Validate('required')]
    public int $blog_category_id = 1;

    #[Validate('required|min:3')]
    public string $title = '';

    public string $author = 'Comtech Team';

    #[Validate('required')]
    public string $excerpt = '';

    #[Validate('required')]
    public string $content = '';

    public string $cover_image_url = '';
    public string $tags_text = '';
    public int $read_time_minutes = 5;
    public bool $is_published = true;
    public bool $is_featured = false;

    public function openCreateModal(): void
    {
        $this->reset(['editingId', 'title', 'excerpt', 'content', 'cover_image_url', 'tags_text', 'read_time_minutes', 'is_published', 'is_featured']);
        $firstCat = BlogCategory::first();
        $this->blog_category_id = $firstCat ? $firstCat->id : 1;
        $this->author = 'Comtech Team';
        $this->is_published = true;
        $this->read_time_minutes = 5;
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $blog = Blog::findOrFail($id);
        $this->editingId = $blog->id;
        $this->blog_category_id = $blog->blog_category_id ?? 1;
        $this->title = $blog->title;
        $this->author = $blog->author;
        $this->excerpt = $blog->excerpt;
        $this->content = $blog->content;
        $this->cover_image_url = $blog->cover_image_url ?? '';
        $this->tags_text = is_array($blog->tags) ? implode(', ', $blog->tags) : '';
        $this->read_time_minutes = (int) $blog->read_time_minutes;
        $this->is_published = (bool) $blog->is_published;
        $this->is_featured = (bool) $blog->is_featured;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $tagsArray = array_filter(array_map('trim', explode(',', $this->tags_text)));

        $data = [
            'blog_category_id' => $this->blog_category_id,
            'title' => $this->title,
            'author' => $this->author ?: 'Comtech Team',
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'cover_image_url' => $this->cover_image_url ?: 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=1000&q=80',
            'tags' => array_values($tagsArray),
            'read_time_minutes' => $this->read_time_minutes,
            'is_published' => $this->is_published,
            'is_featured' => $this->is_featured,
        ];

        if ($this->editingId) {
            Blog::findOrFail($this->editingId)->update($data);
        } else {
            Blog::create($data);
        }

        $this->showModal = false;
    }

    public function delete(int $id): void
    {
        Blog::findOrFail($id)->delete();
    }

    public function togglePublish(int $id): void
    {
        $b = Blog::findOrFail($id);
        $b->update(['is_published' => !$b->is_published]);
    }

    public function with(): array
    {
        return [
            'blogs' => Blog::with('category')->orderByDesc('created_at')->get(),
            'categories' => BlogCategory::all(),
        ];
    }
};
?>

<div class="p-6 space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Blog & Tech Articles</h1>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                Publish tutorials, CCTV guides, Tally accounting news, and hardware tips.
            </p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-xs transition flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-plus"></i> Write New Article
        </button>
    </div>

    <!-- Blogs Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/80 dark:border-zinc-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="py-3 px-4">Article Title</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Author</th>
                        <th class="py-3 px-4">Views</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Published Date</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($blogs as $blog)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                            <td class="py-3 px-4">
                                <div class="font-bold text-zinc-900 dark:text-white max-w-sm line-clamp-1">{{ $blog->title }}</div>
                                <div class="text-[10px] text-zinc-400 font-mono">/blogs/{{ $blog->slug }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300">
                                    {{ $blog->category?->name ?? 'General' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-zinc-700 dark:text-zinc-300">
                                {{ $blog->author }}
                            </td>
                            <td class="py-3 px-4 font-mono font-semibold text-zinc-700 dark:text-zinc-300">
                                {{ number_format($blog->views_count) }}
                            </td>
                            <td class="py-3 px-4">
                                <button wire:click="togglePublish({{ $blog->id }})" class="px-2 py-0.5 rounded-full text-[10px] font-bold cursor-pointer {{ $blog->is_published ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' }}">
                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </td>
                            <td class="py-3 px-4 text-zinc-400 whitespace-nowrap">
                                {{ $blog->published_at?->format('M d, Y') ?? 'Not yet' }}
                            </td>
                            <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" class="p-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 text-zinc-700 dark:text-zinc-300 transition inline-block" title="Preview">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </a>
                                <button wire:click="edit({{ $blog->id }})" class="p-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-indigo-100 text-zinc-700 dark:text-zinc-300 transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button wire:click="delete({{ $blog->id }})" wire:confirm="Delete article?" class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-950/60 hover:bg-rose-100 text-rose-600 dark:text-rose-400 transition" title="Delete">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-zinc-500">
                                No blog posts written yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Blog Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl max-w-3xl w-full p-6 space-y-4 shadow-2xl border border-zinc-200 dark:border-zinc-800 my-8">
                
                <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <h3 class="font-bold text-base text-zinc-900 dark:text-white">
                        {{ $editingId ? 'Edit Article' : 'Write New Article' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4 text-xs">
                    
                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Article Title *</label>
                        <input type="text" wire:model="title" placeholder="e.g. Complete CCTV Camera Buying Guide for Birbhum" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                        @error('title') <span class="text-rose-500 mt-0.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Category *</label>
                            <select wire:model="blog_category_id" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Author Name</label>
                            <input type="text" wire:model="author" placeholder="Comtech Team" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Read Time (Mins)</label>
                            <input type="number" wire:model="read_time_minutes" placeholder="5" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Cover Image URL</label>
                        <input type="text" wire:model="cover_image_url" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Short Excerpt *</label>
                        <textarea wire:model="excerpt" rows="2" placeholder="Summary shown on article cards and search previews..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm"></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Full Article Content (Markdown / Text) *</label>
                        <textarea wire:model="content" rows="8" placeholder="Write full article here..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm font-mono"></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Tags (Comma-separated)</label>
                        <input type="text" wire:model="tags_text" placeholder="CCTV, Tally, Suri, Birbhum, Cybersecurity" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                    </div>

                    <div class="flex items-center gap-6 pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_published" class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span class="font-semibold text-zinc-700 dark:text-zinc-300">Published Live</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_featured" class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span class="font-semibold text-zinc-700 dark:text-zinc-300">Featured on Home</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-200 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold shadow-xs transition">
                            Save Article
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif

</div>
