<?php

use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Manage Products | Comtech Admin')] class extends Component {
    public bool $showModal = false;
    public ?int $editingId = null;

    #[Validate('required')]
    public int $product_category_id = 1;

    #[Validate('required|min:3')]
    public string $name = '';

    public string $brand = '';
    public string $model_number = '';
    public string $short_description = '';
    public string $description = '';
    public string $features_text = '';
    public ?float $price = null;
    public ?float $discount_price = null;
    public ?int $discount_percentage = null;
    public string $image_url = '';
    public string $warranty_info = '';
    public bool $in_stock = true;
    public bool $is_featured = false;
    public bool $is_active = true;

    public function openCreateModal(): void
    {
        $this->reset(['editingId', 'name', 'brand', 'model_number', 'short_description', 'description', 'features_text', 'price', 'discount_price', 'discount_percentage', 'image_url', 'warranty_info', 'in_stock', 'is_featured', 'is_active']);
        $firstCat = ProductCategory::first();
        $this->product_category_id = $firstCat ? $firstCat->id : 1;
        $this->in_stock = true;
        $this->is_active = true;
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $prod = Product::findOrFail($id);
        $this->editingId = $prod->id;
        $this->product_category_id = $prod->product_category_id;
        $this->name = $prod->name;
        $this->brand = $prod->brand ?? '';
        $this->model_number = $prod->model_number ?? '';
        $this->short_description = $prod->short_description ?? '';
        $this->description = $prod->description ?? '';
        $this->features_text = is_array($prod->features) ? implode("\n", $prod->features) : '';
        $this->price = $prod->price ? (float) $prod->price : null;
        $this->discount_price = $prod->discount_price ? (float) $prod->discount_price : null;
        $this->discount_percentage = $prod->discount_percentage ? (int) $prod->discount_percentage : null;
        $this->image_url = $prod->image_url ?? '';
        $this->warranty_info = $prod->warranty_info ?? '';
        $this->in_stock = (bool) $prod->in_stock;
        $this->is_featured = (bool) $prod->is_featured;
        $this->is_active = (bool) $prod->is_active;
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $featuresArray = array_filter(array_map('trim', explode("\n", $this->features_text)));

        if ($this->price && $this->discount_price && $this->price > $this->discount_price && empty($this->discount_percentage)) {
            $this->discount_percentage = (int) round((($this->price - $this->discount_price) / $this->price) * 100);
        }

        $data = [
            'product_category_id' => $this->product_category_id,
            'name' => $this->name,
            'brand' => $this->brand ?: null,
            'model_number' => $this->model_number ?: null,
            'short_description' => $this->short_description ?: null,
            'description' => $this->description ?: null,
            'features' => array_values($featuresArray),
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'discount_percentage' => $this->discount_percentage,
            'image_url' => $this->image_url ?: 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80',
            'warranty_info' => $this->warranty_info ?: null,
            'in_stock' => $this->in_stock,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            Product::findOrFail($this->editingId)->update($data);
        } else {
            Product::create($data);
        }

        $this->showModal = false;
    }

    public function delete(int $id): void
    {
        Product::findOrFail($id)->delete();
    }

    public function toggleActive(int $id): void
    {
        $p = Product::findOrFail($id);
        $p->update(['is_active' => !$p->is_active]);
    }

    public function toggleStock(int $id): void
    {
        $p = Product::findOrFail($id);
        $p->update(['in_stock' => !$p->in_stock]);
    }

    public function with(): array
    {
        return [
            'products' => Product::with('category')->orderBy('sort_order')->get(),
            'categories' => ProductCategory::all(),
        ];
    }
};
?>

<div class="p-6 space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Manage Products & Software</h1>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                Comtech Information Services IT catalog: CCTV kits, laptops, Tally licenses, and antivirus.
            </p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-semibold shadow-xs transition flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-plus"></i> Add New Product
        </button>
    </div>

    <!-- Products Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/80 dark:border-zinc-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="py-3 px-4">Product Name</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Brand</th>
                        <th class="py-3 px-4">Pricing</th>
                        <th class="py-3 px-4">Stock</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($products as $prod)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" class="w-10 h-10 rounded-lg object-contain bg-zinc-100 dark:bg-zinc-800 p-1 border border-zinc-200 dark:border-zinc-700">
                                    <div>
                                        <div class="font-bold text-zinc-900 dark:text-white">{{ $prod->name }}</div>
                                        @if($prod->model_number)
                                            <div class="text-[10px] text-zinc-400 font-mono">{{ $prod->model_number }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                                    {{ $prod->category?->name }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-zinc-700 dark:text-zinc-300">
                                {{ $prod->brand ?: '-' }}
                            </td>
                            <td class="py-3 px-4">
                                @if($prod->discount_price)
                                    <div class="font-bold text-indigo-600 dark:text-indigo-400">₹{{ number_format((float) $prod->discount_price) }}</div>
                                    <div class="text-[10px] text-zinc-400 line-through">₹{{ number_format((float) $prod->price) }}</div>
                                @elseif($prod->price)
                                    <div class="font-bold text-zinc-900 dark:text-white">₹{{ number_format((float) $prod->price) }}</div>
                                @else
                                    <span class="text-zinc-400 text-[10px]">Call for Price</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <button wire:click="toggleStock({{ $prod->id }})" class="px-2 py-0.5 rounded text-[10px] font-bold cursor-pointer {{ $prod->in_stock ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-zinc-200 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                    {{ $prod->in_stock ? 'In Stock' : 'Out of Stock' }}
                                </button>
                            </td>
                            <td class="py-3 px-4">
                                <button wire:click="toggleActive({{ $prod->id }})" class="px-2 py-0.5 rounded-full text-[10px] font-bold cursor-pointer {{ $prod->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' }}">
                                    {{ $prod->is_active ? 'Active' : 'Hidden' }}
                                </button>
                            </td>
                            <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">
                                <button wire:click="edit({{ $prod->id }})" class="p-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 hover:bg-indigo-100 text-zinc-700 dark:text-zinc-300 transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button wire:click="delete({{ $prod->id }})" wire:confirm="Delete this product?" class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-950/60 hover:bg-rose-100 text-rose-600 dark:text-rose-400 transition" title="Delete">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-zinc-500">
                                No products in catalog. Add your first product above.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Product Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl max-w-2xl w-full p-6 space-y-4 shadow-2xl border border-zinc-200 dark:border-zinc-800 my-8">
                
                <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <h3 class="font-bold text-base text-zinc-900 dark:text-white">
                        {{ $editingId ? 'Edit Product' : 'Add New Product' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4 text-xs">
                    
                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Product Title *</label>
                        <input type="text" wire:model="name" placeholder="e.g. Hikvision 4-Channel Full Color Kit" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                        @error('name') <span class="text-rose-500 mt-0.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Category *</label>
                            <select wire:model="product_category_id" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Brand Name</label>
                            <input type="text" wire:model="brand" placeholder="e.g. Hikvision, Tally, HP" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Model / Part No.</label>
                            <input type="text" wire:model="model_number" placeholder="e.g. DS-2CE10DF0T" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">MRP Price (₹)</label>
                            <input type="number" step="0.01" wire:model="price" placeholder="14500" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Special Discount Price (₹)</label>
                            <input type="number" step="0.01" wire:model="discount_price" placeholder="11999" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Warranty Info</label>
                            <input type="text" wire:model="warranty_info" placeholder="2 Years Replacement" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Product Image URL</label>
                        <input type="text" wire:model="image_url" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Short Summary</label>
                        <textarea wire:model="short_description" rows="2" placeholder="Quick 1-2 line summary..." class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm"></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Bullet Features (One per line)</label>
                        <textarea wire:model="features_text" rows="3" placeholder="4x 2MP Color Cameras&#10;1TB Surveillance Hard Drive&#10;Mobile App Setup Free" class="w-full px-3.5 py-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-sm font-mono"></textarea>
                    </div>

                    <div class="flex items-center gap-6 pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="in_stock" class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span class="font-semibold text-zinc-700 dark:text-zinc-300">In Stock</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_featured" class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span class="font-semibold text-zinc-700 dark:text-zinc-300">Feature on Home</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="rounded text-indigo-600 focus:ring-indigo-500">
                            <span class="font-semibold text-zinc-700 dark:text-zinc-300">Active</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-200 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold shadow-xs transition">
                            Save Product
                        </button>
                    </div>

                </form>

            </div>
        </div>
    @endif

</div>
