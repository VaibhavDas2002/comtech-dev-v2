<?php

use App\Models\GalleryItem;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Manage Gallery | Comtech Admin')] class extends Component {
    public bool $showModal = false;
    public ?int $editingId = null;

    #[Validate('required|min:3')]
    public string $title = '';

    #[Validate('required')]
    public string $category = 'CCTV Installations';

    #[Validate('required|url')]
    public string $image_url = '';

    public string $caption = '';
    public bool $is_featured = false;
    public int $sort_order = 0;

    public function openCreateModal(): void
    {
        $this->reset(['editingId', 'title', 'category', 'image_url', 'caption', 'is_featured', 'sort_order']);
        $this->category = 'CCTV Installations';
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $item = GalleryItem::findOrFail($id);
        $this->editingId = $item->id;
        $this->title = $item->title;
        $this->category = $item->category;
        $this->image_url = $item->image_url;
        $this->caption = $item->caption ?? '';
        $this->is_featured = (bool) $item->is_featured;
        $this->sort_order = (int) $item->sort_order;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'category' => $this->category,
            'image_url' => $this->image_url,
            'caption' => $this->caption ?: null,
            'is_featured' => $this->is_featured,
            'sort_order' => $this->sort_order,
        ];

        if ($this->editingId) {
            GalleryItem::findOrFail($this->editingId)->update($data);
        } else {
            GalleryItem::create($data);
        }

        $this->showModal = false;
    }

    public function delete(int $id): void
    {
        GalleryItem::findOrFail($id)->delete();
    }

    public function with(): array
    {
        return [
            'items' => GalleryItem::orderBy('sort_order')->get(),
        ];
    }
};
?>

<div class="p-6 space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Manage Gallery & Project Photos</h1>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                Upload and categorize on-site deployments, server racks, and workshop lab photos.
            </p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-xs transition flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-plus"></i> Add Gallery Image
        </button>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse ($items as $item)
            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/80 dark:border-zinc-800 overflow-hidden shadow-xs flex flex-col justify-between group">
                <div>
                    <div class="h-44 bg-zinc-100 dark:bg-zinc-800 relative overflow-hidden">
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded bg-indigo-600 text-white text-[10px] font-bold">
                            {{ $item->category }}
                        </span>
                    </div>
                    <div class="p-4 space-y-1">
                        <h4 class="font-bold text-xs text-zinc-900 dark:text-white line-clamp-1">{{ $item->title }}</h4>
                        <p class="text-[11px] text-zinc-500 line-clamp-2">{{ $item->caption }}</p>
                    </div>
                </div>

                <div class="p-4 pt-0 flex items-center justify-between border-t border-zinc-100 dark:border-zinc-800 mt-2">
                    <span class="text-[10px] text-zinc-400">Order: {{ $item->sort_order }}</span>
                    <div class="space-x-1">
                        <button wire:click="edit({{ $item->id }})" class="p-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-indigo-100 text-zinc-700 dark:text-zinc-300 transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </button>
                        <button wire:click="delete({{ $item->id }})" wire:confirm="Delete image?" class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-950 hover:bg-rose-100 text-rose-600 dark:text-rose-400 transition" title="Delete">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center py-12 text-zinc-500">
                No gallery images added yet.
            </div>
        @endforelse
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-zinc-200 dark:border-zinc-800">
                
                <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <h3 class="font-bold text-base text-zinc-900 dark:text-white">
                        {{ $editingId ? 'Edit Image' : 'Add Gallery Image' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Image Title *</label>
                        <input type="text" wire:model="title" placeholder="e.g. 16-Camera HD Surveillance Setup in Suri" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Category *</label>
                            <input type="text" wire:model="category" placeholder="e.g. CCTV Installations, Networking & Servers, Repairs" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Sort Order</label>
                            <input type="number" wire:model="sort_order" placeholder="0" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Image URL *</label>
                        <input type="text" wire:model="image_url" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Caption / Description</label>
                        <textarea wire:model="caption" rows="2" placeholder="Brief project summary..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-200 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold shadow-xs transition">
                            Save Image
                        </button>
                    </div>
                </form>

            </div>
        </div>
    @endif

</div>
