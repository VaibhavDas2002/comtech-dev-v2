<?php

use App\Models\Promotion;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Manage Promotions | Comtech Admin')] class extends Component {
    public bool $showModal = false;
    public ?int $editingId = null;

    #[Validate('required|min:3')]
    public string $title = '';

    public string $badge_text = 'Special Offer';

    #[Validate('required')]
    public string $discount_text = '';

    #[Validate('required')]
    public string $description = '';

    public string $terms = '';
    public string $image_url = '';
    public string $cta_text = 'Claim Offer';
    public ?string $start_date = null;
    public ?string $end_date = null;
    public bool $is_active = true;

    public function openCreateModal(): void
    {
        $this->reset(['editingId', 'title', 'badge_text', 'discount_text', 'description', 'terms', 'image_url', 'cta_text', 'start_date', 'end_date', 'is_active']);
        $this->badge_text = 'Special Offer';
        $this->cta_text = 'Claim Offer';
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $promo = Promotion::findOrFail($id);
        $this->editingId = $promo->id;
        $this->title = $promo->title;
        $this->badge_text = $promo->badge_text;
        $this->discount_text = $promo->discount_text;
        $this->description = $promo->description;
        $this->terms = $promo->terms ?? '';
        $this->image_url = $promo->image_url ?? '';
        $this->cta_text = $promo->cta_text;
        $this->start_date = $promo->start_date?->format('Y-m-d');
        $this->end_date = $promo->end_date?->format('Y-m-d');
        $this->is_active = (bool) $promo->is_active;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'badge_text' => $this->badge_text,
            'discount_text' => $this->discount_text,
            'description' => $this->description,
            'terms' => $this->terms ?: null,
            'image_url' => $this->image_url ?: 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80',
            'cta_text' => $this->cta_text,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->end_date ?: null,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            Promotion::findOrFail($this->editingId)->update($data);
        } else {
            Promotion::create($data);
        }

        $this->showModal = false;
    }

    public function delete(int $id): void
    {
        Promotion::findOrFail($id)->delete();
    }

    public function toggleActive(int $id): void
    {
        $p = Promotion::findOrFail($id);
        $p->update(['is_active' => !$p->is_active]);
    }

    public function with(): array
    {
        return [
            'promotions' => Promotion::orderBy('sort_order')->get(),
        ];
    }
};
?>

<div class="p-6 space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Promotions & Marketing Offers</h1>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                Manage discounts, holiday specials, and package bundle deals shown on public pages.
            </p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-xs transition flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-plus"></i> Add New Promotion
        </button>
    </div>

    <!-- Promotions Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/80 dark:border-zinc-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="py-3 px-4">Offer Title</th>
                        <th class="py-3 px-4">Badge</th>
                        <th class="py-3 px-4">Discount Highlight</th>
                        <th class="py-3 px-4">Validity</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($promotions as $promo)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                            <td class="py-3 px-4 font-bold text-zinc-900 dark:text-white max-w-sm line-clamp-1">
                                {{ $promo->title }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 dark:bg-rose-950 text-rose-800 dark:text-rose-300">
                                    {{ $promo->badge_text }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-indigo-600 dark:text-indigo-400">
                                {{ $promo->discount_text }}
                            </td>
                            <td class="py-3 px-4 text-zinc-400">
                                {{ $promo->end_date?->format('M d, Y') ?? 'Ongoing' }}
                            </td>
                            <td class="py-3 px-4">
                                <button wire:click="toggleActive({{ $promo->id }})" class="px-2 py-0.5 rounded-full text-[10px] font-bold cursor-pointer {{ $promo->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-zinc-200 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                    {{ $promo->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">
                                <button wire:click="edit({{ $promo->id }})" class="p-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-indigo-100 text-zinc-700 dark:text-zinc-300 transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button wire:click="delete({{ $promo->id }})" wire:confirm="Delete offer?" class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-950/60 hover:bg-rose-100 text-rose-600 dark:text-rose-400 transition" title="Delete">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-zinc-500">
                                No active promotions right now.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl max-w-xl w-full p-6 space-y-4 shadow-2xl border border-zinc-200 dark:border-zinc-800 my-8">
                
                <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <h3 class="font-bold text-base text-zinc-900 dark:text-white">
                        {{ $editingId ? 'Edit Promotion' : 'Add New Promotion' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4 text-xs">
                    
                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Offer Title *</label>
                        <input type="text" wire:model="title" placeholder="e.g. Suri Business Special: 4 HD CCTV Kit" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Badge Tag</label>
                            <input type="text" wire:model="badge_text" placeholder="e.g. 20% Off, Limited Offer" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Discount Headline *</label>
                            <input type="text" wire:model="discount_text" placeholder="e.g. Installed @ ₹11,999 (Save ₹3,500)" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Offer Image URL</label>
                        <input type="text" wire:model="image_url" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Description *</label>
                        <textarea wire:model="description" rows="3" placeholder="What is included in this offer..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm"></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Terms & Conditions</label>
                        <input type="text" wire:model="terms" placeholder="e.g. Valid till stock lasts in Suri" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">End Date</label>
                            <input type="date" wire:model="end_date" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                        <div class="flex items-center pt-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="is_active" class="rounded text-indigo-600">
                                <span class="font-semibold text-zinc-700 dark:text-zinc-300">Active Live</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-200 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold shadow-xs transition">
                            Save Promotion
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif

</div>
