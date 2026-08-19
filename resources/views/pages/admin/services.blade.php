<?php

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Manage Services | Comtech Admin')] class extends Component {
    public bool $showModal = false;
    public ?int $editingId = null;

    #[Validate('required')]
    public string $division = 'service';

    #[Validate('required|min:3')]
    public string $title = '';

    #[Validate('required')]
    public string $category = 'CCTV Installation';

    #[Validate('required')]
    public string $short_description = '';

    public string $description = '';
    public string $features_text = '';
    public string $starting_price = '';
    public string $image_url = '';
    public bool $is_featured = false;
    public bool $is_active = true;
    public int $sort_order = 0;

    public function openCreateModal(): void
    {
        $this->reset(['editingId', 'division', 'title', 'category', 'short_description', 'description', 'features_text', 'starting_price', 'image_url', 'is_featured', 'is_active', 'sort_order']);
        $this->division = 'service';
        $this->category = 'CCTV Installation';
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $svc = Service::findOrFail($id);
        $this->editingId = $svc->id;
        $this->division = $svc->division;
        $this->title = $svc->title;
        $this->category = $svc->category;
        $this->short_description = $svc->short_description;
        $this->description = $svc->description ?? '';
        $this->features_text = is_array($svc->features) ? implode("\n", $svc->features) : '';
        $this->starting_price = $svc->starting_price ?? '';
        $this->image_url = $svc->image_url ?? '';
        $this->is_featured = (bool) $svc->is_featured;
        $this->is_active = (bool) $svc->is_active;
        $this->sort_order = (int) $svc->sort_order;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $featuresArray = array_filter(array_map('trim', explode("\n", $this->features_text)));

        $data = [
            'division' => $this->division,
            'title' => $this->title,
            'category' => $this->category,
            'short_description' => $this->short_description,
            'description' => $this->description ?: null,
            'features' => array_values($featuresArray),
            'starting_price' => $this->starting_price ?: null,
            'image_url' => $this->image_url ?: 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80',
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->editingId) {
            Service::findOrFail($this->editingId)->update($data);
        } else {
            Service::create($data);
        }

        $this->showModal = false;
    }

    public function delete(int $id): void
    {
        Service::findOrFail($id)->delete();
    }

    public function toggleActive(int $id): void
    {
        $svc = Service::findOrFail($id);
        $svc->update(['is_active' => !$svc->is_active]);
    }

    public function with(): array
    {
        return [
            'services' => Service::query()->orderBy('sort_order')->get(),
        ];
    }
};
?>

<div class="p-6 space-y-6">
    
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Manage IT Services</h1>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                Add, edit, or toggle visibility of your CCTV, Tally, Repair, and Web Development services.
            </p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-xs transition flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-plus"></i> Add New Service
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/80 dark:border-zinc-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="py-3 px-4">Service</th>
                        <th class="py-3 px-4">Category / Division</th>
                        <th class="py-3 px-4">Starting Price</th>
                        <th class="py-3 px-4">Featured</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($services as $svc)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $svc->image_url }}" alt="{{ $svc->title }}" class="w-10 h-10 rounded-lg object-cover border border-zinc-200 dark:border-zinc-700">
                                    <div>
                                        <div class="font-bold text-zinc-900 dark:text-white">{{ $svc->title }}</div>
                                        <div class="text-[10px] text-zinc-400 font-mono">/services/{{ $svc->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300">
                                    {{ $svc->category }}
                                </span>
                                <span class="text-[10px] text-zinc-400 block mt-0.5 capitalize">Division: {{ $svc->division }}</span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-zinc-800 dark:text-zinc-200">
                                {{ $svc->starting_price ?: 'Custom Quote' }}
                            </td>
                            <td class="py-3 px-4">
                                @if($svc->is_featured)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300">
                                        Featured
                                    </span>
                                @else
                                    <span class="text-zinc-400 text-[10px]">Standard</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <button wire:click="toggleActive({{ $svc->id }})" class="px-2.5 py-1 rounded-full text-[10px] font-bold cursor-pointer transition {{ $svc->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' }}">
                                    {{ $svc->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">
                                <button wire:click="edit({{ $svc->id }})" class="p-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-indigo-100 text-zinc-700 dark:text-zinc-300 transition" title="Edit Service">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button wire:click="delete({{ $svc->id }})" wire:confirm="Are you sure you want to delete this service?" class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-950/60 hover:bg-rose-100 text-rose-600 dark:text-rose-400 transition" title="Delete">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-zinc-500">
                                No services found. Add your first service above!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl max-w-2xl w-full p-6 space-y-4 shadow-2xl border border-zinc-200 dark:border-zinc-800 my-8">
                
                <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <h3 class="font-bold text-base text-zinc-900 dark:text-white">
                        {{ $editingId ? 'Edit Service' : 'Add New Service' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4 text-xs">
                    
                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Service Title *</label>
                        <input type="text" wire:model="title" placeholder="e.g. CCTV Surveillance Installation" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                        @error('title') <span class="text-rose-500 mt-0.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Category *</label>
                            <input type="text" wire:model="category" placeholder="e.g. CCTV Installation, Tally Services, Web Development" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Division *</label>
                            <select wire:model="division" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                                <option value="service">Service (Comtech Infosys)</option>
                                <option value="sales">Sales (Comtech Information Services)</option>
                                <option value="both">Both Divisions</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Starting Price (Optional)</label>
                            <input type="text" wire:model="starting_price" placeholder="e.g. ₹7,999 or ₹1,499 / PC / Year" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Cover Image URL</label>
                            <input type="text" wire:model="image_url" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Short Description *</label>
                        <textarea wire:model="short_description" rows="2" placeholder="Brief 1-2 sentence overview for cards..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm"></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Detailed Description</label>
                        <textarea wire:model="description" rows="3" placeholder="Full service explanation..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm"></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Key Features (One per line)</label>
                        <textarea wire:model="features_text" rows="3" placeholder="24/7 Color Night Vision&#10;Remote Mobile App Live View&#10;Guaranteed 2-Hour Suri SLA" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm font-mono"></textarea>
                    </div>

                    <div class="flex items-center gap-6 pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_featured" class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span class="font-semibold text-zinc-700 dark:text-zinc-300">Feature on Home Page</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span class="font-semibold text-zinc-700 dark:text-zinc-300">Active (Visible)</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-200 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold shadow-xs transition">
                            Save Service
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif

</div>
