<?php

use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Manage Testimonials | Comtech Admin')] class extends Component {
    public bool $showModal = false;
    public ?int $editingId = null;

    #[Validate('required|min:3')]
    public string $client_name = '';

    public string $company_name = '';
    public string $designation = '';
    public string $location = 'Suri, Birbhum';
    public int $rating = 5;

    #[Validate('required|min:5')]
    public string $feedback = '';

    public string $service_availed = '';
    public string $avatar_url = '';
    public bool $is_featured = true;
    public bool $is_active = true;

    public function openCreateModal(): void
    {
        $this->reset(['editingId', 'client_name', 'company_name', 'designation', 'location', 'rating', 'feedback', 'service_availed', 'avatar_url', 'is_featured', 'is_active']);
        $this->location = 'Suri, Birbhum';
        $this->rating = 5;
        $this->is_featured = true;
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $testi = Testimonial::findOrFail($id);
        $this->editingId = $testi->id;
        $this->client_name = $testi->client_name;
        $this->company_name = $testi->company_name ?? '';
        $this->designation = $testi->designation ?? '';
        $this->location = $testi->location;
        $this->rating = (int) $testi->rating;
        $this->feedback = $testi->feedback;
        $this->service_availed = $testi->service_availed ?? '';
        $this->avatar_url = $testi->avatar_url ?? '';
        $this->is_featured = (bool) $testi->is_featured;
        $this->is_active = (bool) $testi->is_active;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'client_name' => $this->client_name,
            'company_name' => $this->company_name ?: null,
            'designation' => $this->designation ?: null,
            'location' => $this->location,
            'rating' => $this->rating,
            'feedback' => $this->feedback,
            'service_availed' => $this->service_availed ?: null,
            'avatar_url' => $this->avatar_url ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            Testimonial::findOrFail($this->editingId)->update($data);
        } else {
            Testimonial::create($data);
        }

        $this->showModal = false;
    }

    public function delete(int $id): void
    {
        Testimonial::findOrFail($id)->delete();
    }

    public function toggleActive(int $id): void
    {
        $t = Testimonial::findOrFail($id);
        $t->update(['is_active' => !$t->is_active]);
    }

    public function with(): array
    {
        return [
            'testimonials' => Testimonial::orderBy('sort_order')->get(),
        ];
    }
};
?>

<div class="p-6 space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Customer Reviews & Testimonials</h1>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                Manage verified client feedback from Suri, Bolpur, and Birbhum district.
            </p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-xs transition flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-plus"></i> Add Testimonial
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/80 dark:border-zinc-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="py-3 px-4">Client</th>
                        <th class="py-3 px-4">Rating</th>
                        <th class="py-3 px-4">Feedback Quote</th>
                        <th class="py-3 px-4">Service Availed</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($testimonials as $t)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $t->avatar_url }}" alt="{{ $t->client_name }}" class="w-9 h-9 rounded-full object-cover border border-zinc-200 dark:border-zinc-700">
                                    <div>
                                        <div class="font-bold text-zinc-900 dark:text-white">{{ $t->client_name }}</div>
                                        <div class="text-[10px] text-zinc-400">{{ $t->company_name ?? $t->location }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-amber-400 whitespace-nowrap">
                                @for($i = 0; $i < $t->rating; $i++)
                                    <i class="fa-solid fa-star text-[10px]"></i>
                                @endfor
                            </td>
                            <td class="py-3 px-4 max-w-sm text-zinc-600 dark:text-zinc-300 italic line-clamp-2">
                                "{{ $t->feedback }}"
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300">
                                    {{ $t->service_availed }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <button wire:click="toggleActive({{ $t->id }})" class="px-2.5 py-1 rounded-full text-[10px] font-bold cursor-pointer {{ $t->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-zinc-200 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                    {{ $t->is_active ? 'Active' : 'Hidden' }}
                                </button>
                            </td>
                            <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">
                                <button wire:click="edit({{ $t->id }})" class="p-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-indigo-100 text-zinc-700 dark:text-zinc-300 transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button wire:click="delete({{ $t->id }})" wire:confirm="Delete review?" class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-950/60 hover:bg-rose-100 text-rose-600 dark:text-rose-400 transition" title="Delete">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-zinc-500">
                                No reviews recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-zinc-200 dark:border-zinc-800">
                
                <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <h3 class="font-bold text-base text-zinc-900 dark:text-white">
                        {{ $editingId ? 'Edit Testimonial' : 'Add Testimonial' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4 text-xs">
                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Client Name *</label>
                        <input type="text" wire:model="client_name" placeholder="e.g. Prabir Bhattacharya" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Company / Organization</label>
                            <input type="text" wire:model="company_name" placeholder="e.g. Bhattacharya Traders" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Service Availed</label>
                            <input type="text" wire:model="service_availed" placeholder="e.g. Tally Prime Gold & TDL" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Location</label>
                            <input type="text" wire:model="location" placeholder="Suri, Birbhum" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Star Rating (1-5)</label>
                            <select wire:model="rating" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                                <option value="5">5 Stars (Excellent)</option>
                                <option value="4">4 Stars (Very Good)</option>
                                <option value="3">3 Stars (Average)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Avatar / Photo URL</label>
                        <input type="text" wire:model="avatar_url" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Review Feedback *</label>
                        <textarea wire:model="feedback" rows="3" placeholder="Client review quote..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-200 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold shadow-xs transition">
                            Save Testimonial
                        </button>
                    </div>
                </form>

            </div>
        </div>
    @endif

</div>
