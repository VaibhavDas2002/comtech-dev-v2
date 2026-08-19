<?php

use App\Models\Enquiry;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.app.sidebar')] #[Title('Enquiries & Leads CRM | Comtech Admin')] class extends Component {
    public string $search = '';
    public string $statusFilter = 'all';
    public string $urgencyFilter = 'all';

    public ?Enquiry $selectedEnquiry = null;
    public bool $showModal = false;
    public string $adminNotes = '';

    public function openEnquiry(int $id): void
    {
        $this->selectedEnquiry = Enquiry::with(['service', 'product'])->findOrFail($id);
        $this->adminNotes = $this->selectedEnquiry->admin_notes ?? '';
        $this->showModal = true;
    }

    public function updateStatus(int $id, string $status): void
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->update(['status' => $status]);
        if ($this->selectedEnquiry && $this->selectedEnquiry->id === $id) {
            $this->selectedEnquiry->status = $status;
        }
    }

    public function saveNotes(): void
    {
        if ($this->selectedEnquiry) {
            $this->selectedEnquiry->update(['admin_notes' => $this->adminNotes]);
        }
    }

    public function delete(int $id): void
    {
        Enquiry::findOrFail($id)->delete();
        if ($this->selectedEnquiry && $this->selectedEnquiry->id === $id) {
            $this->showModal = false;
        }
    }

    public function with(): array
    {
        $query = Enquiry::with(['service', 'product'])->latest();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('ticket_number', 'like', "%{$this->search}%")
                  ->orWhere('name', 'like', "%{$this->search}%")
                  ->orWhere('phone', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('company', 'like', "%{$this->search}%")
                  ->orWhere('subject', 'like', "%{$this->search}%");
            });
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->urgencyFilter !== 'all') {
            $query->where('urgency', $this->urgencyFilter);
        }

        return [
            'enquiries' => $query->paginate(20),
            'counts' => [
                'all' => Enquiry::count(),
                'pending' => Enquiry::where('status', 'pending')->count(),
                'contacted' => Enquiry::where('status', 'contacted')->count(),
                'quoted' => Enquiry::where('status', 'quoted')->count(),
                'resolved' => Enquiry::where('status', 'resolved')->count(),
            ]
        ];
    }
};
?>

<div class="p-6 space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Customer Enquiries & Leads CRM</h1>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                Manage incoming tickets, track client follow-ups, and update quote statuses.
            </p>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="flex flex-col lg:flex-row items-center justify-between gap-4 bg-white dark:bg-zinc-900 p-4 rounded-2xl border border-zinc-200/80 dark:border-zinc-800 shadow-xs">
        
        <!-- Search Input -->
        <div class="relative w-full lg:w-80">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search ticket, name, phone..." class="w-full pl-10 pr-4 py-2 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-xs focus:ring-2 focus:ring-indigo-500 outline-hidden">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-zinc-400 text-xs"></i>
        </div>

        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto w-full lg:w-auto pb-1 lg:pb-0 scrollbar-none text-xs">
            <button wire:click="$set('statusFilter', 'all')" class="px-3 py-1.5 rounded-lg font-semibold whitespace-nowrap transition {{ $statusFilter === 'all' ? 'bg-indigo-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200' }}">
                All ({{ $counts['all'] }})
            </button>
            <button wire:click="$set('statusFilter', 'pending')" class="px-3 py-1.5 rounded-lg font-semibold whitespace-nowrap transition {{ $statusFilter === 'pending' ? 'bg-amber-600 text-white' : 'bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300 hover:bg-amber-100' }}">
                Pending ({{ $counts['pending'] }})
            </button>
            <button wire:click="$set('statusFilter', 'contacted')" class="px-3 py-1.5 rounded-lg font-semibold whitespace-nowrap transition {{ $statusFilter === 'contacted' ? 'bg-blue-600 text-white' : 'bg-blue-50 dark:bg-blue-950/50 text-blue-700 dark:text-blue-300 hover:bg-blue-100' }}">
                Contacted ({{ $counts['contacted'] }})
            </button>
            <button wire:click="$set('statusFilter', 'quoted')" class="px-3 py-1.5 rounded-lg font-semibold whitespace-nowrap transition {{ $statusFilter === 'quoted' ? 'bg-purple-600 text-white' : 'bg-purple-50 dark:bg-purple-950/50 text-purple-700 dark:text-purple-300 hover:bg-purple-100' }}">
                Quoted ({{ $counts['quoted'] }})
            </button>
            <button wire:click="$set('statusFilter', 'resolved')" class="px-3 py-1.5 rounded-lg font-semibold whitespace-nowrap transition {{ $statusFilter === 'resolved' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-100' }}">
                Resolved ({{ $counts['resolved'] }})
            </button>
        </div>

    </div>

    <!-- Enquiries Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200/80 dark:border-zinc-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] tracking-wider border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="py-3 px-4">Ticket</th>
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">Contact Info</th>
                        <th class="py-3 px-4">Requirement / Subject</th>
                        <th class="py-3 px-4">Urgency</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse ($enquiries as $lead)
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
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $lead->urgency === 'urgent' ? 'bg-rose-100 text-rose-700' : ($lead->urgency === 'emergency' ? 'bg-red-200 text-red-900' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300') }}">
                                    {{ $lead->urgency }}
                                </span>
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
                                {{ $lead->created_at->format('M d, H:i') }}
                            </td>
                            <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">
                                <button wire:click="openEnquiry({{ $lead->id }})" class="p-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 transition" title="Open CRM View">
                                    <i class="fa-solid fa-eye text-xs"></i>
                                </button>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}?text={{ urlencode('Hello ' . $lead->name . ', thank you for contacting Comtech. Regarding ticket ' . $lead->ticket_number . '...') }}" target="_blank" class="p-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 transition inline-block" title="WhatsApp">
                                    <i class="fa-brands fa-whatsapp text-xs"></i>
                                </a>
                                <button wire:click="delete({{ $lead->id }})" wire:confirm="Delete this enquiry record?" class="p-1.5 rounded-lg bg-rose-50 dark:bg-rose-950/60 hover:bg-rose-100 text-rose-600 dark:text-rose-400 transition" title="Delete">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-zinc-500">
                                No customer enquiries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Details Modal with Internal Notes -->
    @if ($showModal && $selectedEnquiry)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl max-w-xl w-full p-6 space-y-4 shadow-2xl border border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-800">
                    <div>
                        <span class="text-xs font-mono font-bold text-indigo-600 dark:text-indigo-400">{{ $selectedEnquiry->ticket_number }}</span>
                        <h3 class="font-bold text-base text-zinc-900 dark:text-white">{{ $selectedEnquiry->name }}</h3>
                    </div>
                    <button wire:click="$set('showModal', false)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <span class="text-zinc-400 block">Phone:</span>
                        <a href="tel:{{ $selectedEnquiry->phone }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">{{ $selectedEnquiry->phone }}</a>
                    </div>
                    <div>
                        <span class="text-zinc-400 block">Email:</span>
                        <strong class="text-zinc-900 dark:text-white">{{ $selectedEnquiry->email ?: 'N/A' }}</strong>
                    </div>
                    <div>
                        <span class="text-zinc-400 block">Company:</span>
                        <strong class="text-zinc-900 dark:text-white">{{ $selectedEnquiry->company ?: 'N/A' }}</strong>
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
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-800 rounded-xl text-zinc-700 dark:text-zinc-300 leading-relaxed max-h-32 overflow-y-auto">
                        {{ $selectedEnquiry->message }}
                    </div>
                </div>

                <!-- Admin Internal Notes -->
                <div class="space-y-1 text-xs">
                    <span class="text-zinc-400 block">Internal Staff Notes:</span>
                    <textarea wire:model="adminNotes" rows="2" placeholder="e.g. Quoted ₹12,000 for 4 cams, visiting Suri shop tomorrow..." class="w-full px-3 py-2 rounded-xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 text-xs focus:ring-2 focus:ring-indigo-500 outline-hidden"></textarea>
                    <button wire:click="saveNotes" class="px-3 py-1 rounded bg-zinc-200 dark:bg-zinc-800 text-[10px] font-semibold text-zinc-800 dark:text-zinc-200 hover:bg-zinc-300 transition">
                        Save Notes
                    </button>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-zinc-200 dark:border-zinc-800">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-zinc-500">Status:</span>
                        <select wire:change="updateStatus({{ $selectedEnquiry->id }}, $event.target.value)" class="text-xs font-semibold py-1 px-2 rounded-lg bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700">
                            <option value="pending" @selected($selectedEnquiry->status === 'pending')>Pending</option>
                            <option value="contacted" @selected($selectedEnquiry->status === 'contacted')>Contacted</option>
                            <option value="quoted" @selected($selectedEnquiry->status === 'quoted')>Quoted</option>
                            <option value="in_progress" @selected($selectedEnquiry->status === 'in_progress')>In Progress</option>
                            <option value="resolved" @selected($selectedEnquiry->status === 'resolved')>Resolved</option>
                            <option value="cancelled" @selected($selectedEnquiry->status === 'cancelled')>Cancelled</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $selectedEnquiry->phone) }}?text={{ urlencode('Hello ' . $selectedEnquiry->name . ', thank you for contacting Comtech. Regarding ticket ' . $selectedEnquiry->ticket_number . '...') }}" target="_blank" class="px-3.5 py-1.5 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-500 transition flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp"></i> Chat
                        </a>
                        <button wire:click="$set('showModal', false)" class="px-3.5 py-1.5 bg-zinc-200 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 rounded-xl text-xs font-semibold hover:bg-zinc-300 transition">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
