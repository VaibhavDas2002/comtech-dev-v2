<?php

use App\Models\Blog;
use App\Models\Enquiry;
use App\Models\GalleryItem;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Admin Dashboard | Comtech')] class extends Component {
    public ?Enquiry $selectedEnquiry = null;
    public bool $showEnquiryModal = false;

    public function viewEnquiry(int $id): void
    {
        $this->selectedEnquiry = Enquiry::with(['service', 'product'])->find($id);
        $this->showEnquiryModal = true;
    }

    public function updateStatus(int $id, string $status): void
    {
        $enquiry = Enquiry::find($id);
        if ($enquiry) {
            $enquiry->update(['status' => $status]);
            if ($this->selectedEnquiry && $this->selectedEnquiry->id === $id) {
                $this->selectedEnquiry->status = $status;
            }
        }
    }

    public function with(): array
    {
        return [
            'stats' => [
                'total_enquiries' => Enquiry::count(),
                'pending_enquiries' => Enquiry::where('status', 'pending')->count(),
                'total_services' => Service::count(),
                'active_services' => Service::where('is_active', true)->count(),
                'total_products' => Product::count(),
                'in_stock_products' => Product::where('in_stock', true)->count(),
                'total_blogs' => Blog::count(),
                'total_blog_views' => Blog::sum('views_count'),
                'active_promotions' => Promotion::where('is_active', true)->count(),
                'total_gallery' => GalleryItem::count(),
                'total_testimonials' => Testimonial::count(),
            ],
            'recentEnquiries' => Enquiry::with(['service', 'product'])->latest()->take(8)->get(),
        ];
    }
};
?>

<div class="p-6 space-y-6">
    
    <!-- Top Welcome Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Business Control Center</h1>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                Comtech Information Services (Sales) & Comtech Infosys (Service) &bull; Suri, Birbhum
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.enquiries') }}" wire:navigate class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shadow-xs transition flex items-center gap-1.5">
                <i class="fa-solid fa-inbox"></i> View All Leads
            </a>
            <a href="{{ route('home') }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-800 dark:text-zinc-200 text-xs font-semibold transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Public Website
            </a>
        </div>
    </div>

    <!-- Quick KPI Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Enquiries KPI -->
        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-zinc-500 dark:text-zinc-400">
                <span class="text-xs font-bold uppercase tracking-wider">Customer Enquiries</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-headset"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <div class="text-2xl font-extrabold text-zinc-900 dark:text-white">
                    {{ $stats['total_enquiries'] }}
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300">
                    {{ $stats['pending_enquiries'] }} Pending
                </span>
            </div>
        </div>

        <!-- Services KPI -->
        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-zinc-500 dark:text-zinc-400">
                <span class="text-xs font-bold uppercase tracking-wider">IT Services</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-wrench"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <div class="text-2xl font-extrabold text-zinc-900 dark:text-white">
                    {{ $stats['total_services'] }}
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300">
                    {{ $stats['active_services'] }} Active
                </span>
            </div>
        </div>

        <!-- Products KPI -->
        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-zinc-500 dark:text-zinc-400">
                <span class="text-xs font-bold uppercase tracking-wider">Catalog Products</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-shopping-bag"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <div class="text-2xl font-extrabold text-zinc-900 dark:text-white">
                    {{ $stats['total_products'] }}
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300">
                    {{ $stats['in_stock_products'] }} In Stock
                </span>
            </div>
        </div>

        <!-- Blog Views KPI -->
        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 shadow-xs space-y-2">
            <div class="flex items-center justify-between text-zinc-500 dark:text-zinc-400">
                <span class="text-xs font-bold uppercase tracking-wider">Blog Articles & Views</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
            </div>
            <div class="flex items-baseline justify-between">
                <div class="text-2xl font-extrabold text-zinc-900 dark:text-white">
                    {{ $stats['total_blogs'] }}
                </div>
                <span class="text-xs text-zinc-500 dark:text-zinc-400 font-medium">
                    {{ number_format($stats['total_blog_views']) }} Total Views
                </span>
            </div>
        </div>

    </div>

    <!-- Quick Shortcuts Bar -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <a href="{{ route('admin.services') }}" wire:navigate class="p-3.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-indigo-500 dark:hover:border-indigo-500 text-center space-y-1 transition group">
            <i class="fa-solid fa-plus text-indigo-600 text-sm group-hover:scale-110 transition-transform"></i>
            <div class="text-xs font-bold text-zinc-800 dark:text-zinc-200">Services</div>
        </a>
        <a href="{{ route('admin.products') }}" wire:navigate class="p-3.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-indigo-500 dark:hover:border-indigo-500 text-center space-y-1 transition group">
            <i class="fa-solid fa-cart-plus text-blue-600 text-sm group-hover:scale-110 transition-transform"></i>
            <div class="text-xs font-bold text-zinc-800 dark:text-zinc-200">Products</div>
        </a>
        <a href="{{ route('admin.blogs') }}" wire:navigate class="p-3.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-indigo-500 dark:hover:border-indigo-500 text-center space-y-1 transition group">
            <i class="fa-solid fa-pen-nib text-purple-600 text-sm group-hover:scale-110 transition-transform"></i>
            <div class="text-xs font-bold text-zinc-800 dark:text-zinc-200">Write Blog</div>
        </a>
        <a href="{{ route('admin.promotions') }}" wire:navigate class="p-3.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-indigo-500 dark:hover:border-indigo-500 text-center space-y-1 transition group">
            <i class="fa-solid fa-percent text-rose-600 text-sm group-hover:scale-110 transition-transform"></i>
            <div class="text-xs font-bold text-zinc-800 dark:text-zinc-200">Promotions</div>
        </a>
        <a href="{{ route('admin.gallery') }}" wire:navigate class="p-3.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-indigo-500 dark:hover:border-indigo-500 text-center space-y-1 transition group">
            <i class="fa-solid fa-camera text-amber-600 text-sm group-hover:scale-110 transition-transform"></i>
            <div class="text-xs font-bold text-zinc-800 dark:text-zinc-200">Gallery</div>
        </a>
        <a href="{{ route('admin.testimonials') }}" wire:navigate class="p-3.5 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 hover:border-indigo-500 dark:hover:border-indigo-500 text-center space-y-1 transition group">
            <i class="fa-solid fa-star text-amber-400 text-sm group-hover:scale-110 transition-transform"></i>
            <div class="text-xs font-bold text-zinc-800 dark:text-zinc-200">Testimonials</div>
        </a>
    </div>

    <!-- Recent Enquiries Management Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/80 dark:border-zinc-800 shadow-xs overflow-hidden space-y-4 p-6">
        
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-base text-zinc-900 dark:text-white">Recent Customer Leads & Enquiries</h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">Incoming tickets from web forms, service enquiries, and quote requests.</p>
            </div>
            <a href="{{ route('admin.enquiries') }}" wire:navigate class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                View All &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] tracking-wider border-y border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="py-3 px-4">Ticket</th>
                        <th class="py-3 px-4">Client Name</th>
                        <th class="py-3 px-4">Phone / Email</th>
                        <th class="py-3 px-4">Subject / Service</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($recentEnquiries as $lead)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40 transition">
                            <td class="py-3 px-4 font-mono font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $lead->ticket_number }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-zinc-900 dark:text-white">{{ $lead->name }}</div>
                                @if($lead->company)
                                    <div class="text-[10px] text-zinc-400">{{ $lead->company }}</div>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-medium text-zinc-800 dark:text-zinc-200">{{ $lead->phone }}</div>
                                @if($lead->email)
                                    <div class="text-[10px] text-zinc-400">{{ $lead->email }}</div>
                                @endif
                            </td>
                            <td class="py-3 px-4 max-w-xs truncate text-zinc-600 dark:text-zinc-300">
                                {{ $lead->subject ?: $lead->service?->title ?: $lead->product?->name }}
                            </td>
                            <td class="py-3 px-4">
                                <select wire:change="updateStatus({{ $lead->id }}, $event.target.value)" class="text-[11px] font-semibold py-1 px-2 rounded-lg bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700">
                                    <option value="pending" @selected($lead->status === 'pending')>Pending</option>
                                    <option value="contacted" @selected($lead->status === 'contacted')>Contacted</option>
                                    <option value="quoted" @selected($lead->status === 'quoted')>Quoted</option>
                                    <option value="in_progress" @selected($lead->status === 'in_progress')>In Progress</option>
                                    <option value="resolved" @selected($lead->status === 'resolved')>Resolved</option>
                                    <option value="cancelled" @selected($lead->status === 'cancelled')>Cancelled</option>
                                </select>
                            </td>
                            <td class="py-3 px-4 text-zinc-400 whitespace-nowrap">
                                {{ $lead->created_at->diffForHumans() }}
                            </td>
                            <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">
                                <button wire:click="viewEnquiry({{ $lead->id }})" class="p-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 transition" title="View Message">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </button>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}?text={{ urlencode('Hello ' . $lead->name . ', thank you for contacting Comtech. Regarding your ticket ' . $lead->ticket_number . '...') }}" target="_blank" class="p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 transition inline-block" title="WhatsApp Customer">
                                    <i class="fa-brands fa-whatsapp text-xs"></i>
                                </a>
                                <a href="tel:{{ $lead->phone }}" class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 hover:bg-blue-100 transition inline-block" title="Call Customer">
                                    <i class="fa-solid fa-phone text-xs"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-zinc-500">
                                No enquiries submitted yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Enquiry Details Modal -->
    @if ($showEnquiryModal && $selectedEnquiry)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl max-w-xl w-full p-6 space-y-4 shadow-2xl border border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <div>
                        <span class="text-xs font-mono font-bold text-indigo-600 dark:text-indigo-400">{{ $selectedEnquiry->ticket_number }}</span>
                        <h3 class="font-bold text-base text-zinc-900 dark:text-white">{{ $selectedEnquiry->name }}</h3>
                    </div>
                    <button wire:click="$set('showEnquiryModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <span class="text-zinc-400 block">Phone:</span>
                        <strong class="text-zinc-900 dark:text-white">{{ $selectedEnquiry->phone }}</strong>
                    </div>
                    <div>
                        <span class="text-zinc-400 block">Email:</span>
                        <strong class="text-zinc-900 dark:text-white">{{ $selectedEnquiry->email ?: 'N/A' }}</strong>
                    </div>
                    <div>
                        <span class="text-zinc-400 block">Urgency:</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $selectedEnquiry->urgency === 'urgent' ? 'bg-rose-100 text-rose-700' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300' }}">
                            {{ $selectedEnquiry->urgency }}
                        </span>
                    </div>
                    <div>
                        <span class="text-zinc-400 block">Preferred Callback:</span>
                        <strong class="text-zinc-900 dark:text-white capitalize">{{ $selectedEnquiry->preferred_contact }}</strong>
                    </div>
                </div>

                <div class="space-y-1 text-xs">
                    <span class="text-zinc-400 block">Subject / Service:</span>
                    <p class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $selectedEnquiry->subject }}</p>
                </div>

                <div class="space-y-1 text-xs">
                    <span class="text-zinc-400 block">Customer Message:</span>
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-800 rounded-xl text-zinc-700 dark:text-zinc-300 leading-relaxed">
                        {{ $selectedEnquiry->message }}
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-zinc-200 dark:border-zinc-800">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $selectedEnquiry->phone) }}" target="_blank" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-500 transition flex items-center gap-1.5">
                        <i class="fa-brands fa-whatsapp"></i> Chat WhatsApp
                    </a>
                    <button wire:click="$set('showEnquiryModal', false)" class="px-4 py-2 bg-zinc-200 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 rounded-xl text-xs font-semibold hover:bg-zinc-300 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
