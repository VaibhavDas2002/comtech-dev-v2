<?php

use App\Models\Enquiry;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts.public')] #[Title('Contact & Service Enquiry | Comtech (Suri, Birbhum)')] class extends Component {
    #[Validate('required|min:3')]
    public string $name = '';

    #[Validate('required|min:10')]
    public string $phone = '';

    #[Validate('nullable|email')]
    public string $email = '';

    public string $company = '';

    #[Url]
    public string $type = 'general';

    #[Url]
    public string $service = '';

    #[Url]
    public string $product = '';

    #[Url]
    public string $subject = '';

    #[Validate('required|min:5')]
    public string $message = '';

    public string $urgency = 'normal';
    public string $preferred_contact = 'phone';

    public bool $submitted = false;
    public ?string $generatedTicket = null;

    public function mount(): void
    {
        if ($this->service && empty($this->subject)) {
            $this->subject = "Enquiry regarding Service: {$this->service}";
            $this->type = 'service';
        } elseif ($this->product && empty($this->subject)) {
            $this->subject = "Price Quote Request for: {$this->product}";
            $this->type = 'product';
        }
    }

    public function submitEnquiry(): void
    {
        $this->validate();

        $enquiry = Enquiry::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email ?: null,
            'company' => $this->company ?: null,
            'type' => $this->type,
            'subject' => $this->subject ?: 'General Web Enquiry',
            'message' => $this->message,
            'urgency' => $this->urgency,
            'preferred_contact' => $this->preferred_contact,
            'status' => 'pending',
            'ip_address' => request()->ip(),
        ]);

        $this->generatedTicket = $enquiry->ticket_number;
        $this->submitted = true;

        $this->reset(['name', 'phone', 'email', 'company', 'message']);
    }
};
?>

<div>
    <!-- Header -->
    <section class="bg-gradient-to-b from-slate-900 via-indigo-950 to-slate-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <span class="px-3.5 py-1.5 rounded-full bg-indigo-900/80 border border-indigo-700 text-indigo-300 text-xs font-semibold">
                We're Here to Assist You
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                Contact & Support Hub
            </h1>
            <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
                Reach out to Comtech Information Services (Sales) or Comtech Infosys (Service) for instant quotations, site surveys, or chip-level repair estimates in Suri.
            </p>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="py-12 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Phone -->
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-lg">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white">Call Us Directly</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400">
                        <a href="tel:+919434197268" class="hover:text-indigo-600 font-semibold block">+91 94341 97268 (Sales)</a>
                        <a href="tel:+919474306951" class="hover:text-indigo-600 font-semibold block">+91 94743 06951 (Service)</a>
                        <span class="text-slate-400 block text-[11px]">Landline: 03462-255555</span>
                    </p>
                </div>

                <!-- WhatsApp -->
                <div class="p-6 rounded-2xl bg-emerald-50/60 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-900/50 space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-lg">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white">WhatsApp Support</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400">
                        Instant chat with our technicians for quick quotes & site booking.
                    </p>
                    <a href="https://wa.me/919434197268?text=Hello%20Comtech%2C%20I%20have%20an%20enquiry" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline pt-1">
                        Start WhatsApp Chat &rarr;
                    </a>
                </div>

                <!-- Email -->
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-lg">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white">Email Desks</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400">
                        <span class="block">Sales: sales@comtechis.in</span>
                        <span class="block">Service: service@comtechinfosys.in</span>
                        <span class="block">General: info@comtechis.in</span>
                    </p>
                </div>

                <!-- Location -->
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center text-lg">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white">Showroom & Lab</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Beside A.B.T.A Building, New DangalPara, Suri, Birbhum, West Bengal – 731101
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Main Contact & Form Section -->
    <section class="py-16 bg-slate-50 dark:bg-slate-950" id="enquiry-form">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Left Form -->
                <div class="lg:col-span-7 bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 shadow-sm">
                    <div class="mb-6">
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Direct Enquiry</span>
                        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white mt-1">Send a Message or Request Quote</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            Fill out the form below. We generate a tracking ticket and our technicians will connect with you.
                        </p>
                    </div>

                    @if ($submitted)
                        <div class="p-6 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-center space-y-4">
                            <div class="w-14 h-14 rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-300 mx-auto flex items-center justify-center text-2xl">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <h3 class="text-lg font-bold text-emerald-800 dark:text-emerald-200">Enquiry Submitted Successfully!</h3>
                            <p class="text-xs text-emerald-700 dark:text-emerald-300 max-w-md mx-auto">
                                Your Ticket ID is <strong class="font-mono bg-emerald-200/60 dark:bg-emerald-900 px-2 py-0.5 rounded text-emerald-900 dark:text-emerald-100">{{ $generatedTicket }}</strong>. Our team in Suri will respond promptly.
                            </p>
                            <button wire:click="$set('submitted', false)" class="px-5 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-500 transition">
                                Send Another Message
                            </button>
                        </div>
                    @else
                        <form wire:submit="submitEnquiry" class="space-y-4">
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Your Full Name *</label>
                                    <input type="text" wire:model="name" placeholder="e.g. Ramesh Ghosh" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                                    @error('name') <span class="text-rose-500 text-xs mt-0.5 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Phone Number (10 Digits) *</label>
                                    <input type="tel" wire:model="phone" placeholder="e.g. 9434197268" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                                    @error('phone') <span class="text-rose-500 text-xs mt-0.5 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Email Address (Optional)</label>
                                    <input type="email" wire:model="email" placeholder="e.g. ramesh@example.com" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                                    @error('email') <span class="text-rose-500 text-xs mt-0.5 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Company / Organization</label>
                                    <input type="text" wire:model="company" placeholder="e.g. Ghosh Traders / ABC School" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Enquiry Type</label>
                                    <select wire:model="type" class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs font-medium">
                                        <option value="general">General Query</option>
                                        <option value="service">Service & Repair</option>
                                        <option value="product">Product & Purchase</option>
                                        <option value="amc">AMC & Support</option>
                                        <option value="promotion">Claim Promotion</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Urgency</label>
                                    <select wire:model="urgency" class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs font-medium">
                                        <option value="normal">Normal (Within 24h)</option>
                                        <option value="urgent">Urgent (Within 4h)</option>
                                        <option value="emergency">Emergency Server/CCTV Down</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Preferred Callback</label>
                                    <select wire:model="preferred_contact" class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs font-medium">
                                        <option value="phone">Phone Call</option>
                                        <option value="whatsapp">WhatsApp Message</option>
                                        <option value="email">Email</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Subject / Requirement Heading</label>
                                <input type="text" wire:model="subject" placeholder="e.g. CCTV installation quote for 8 cameras in Suri" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Detailed Message *</label>
                                <textarea wire:model="message" rows="4" placeholder="Describe your requirement, problem, or equipment specifications..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden"></textarea>
                                @error('message') <span class="text-rose-500 text-xs mt-0.5 block">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-semibold text-sm shadow-md shadow-indigo-600/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <span wire:loading.remove>Submit Enquiry Ticket</span>
                                <span wire:loading class="flex items-center gap-2">
                                    <i class="fa-solid fa-spinner fa-spin"></i> Processing Ticket...
                                </span>
                            </button>

                        </form>
                    @endif

                </div>

                <!-- Right Map & Office Info -->
                <div class="lg:col-span-5 space-y-6">
                    
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Our Suri Headquarters</h3>
                        
                        <div class="h-64 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14603.20864380183!2d87.5256247!3d23.9073287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f9dd5a4f7e21a3%3A0x6b77ff3ef7db4df6!2sSuri%2C%20West%20Bengal%20731101!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" 
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy">
                            </iframe>
                        </div>

                        <div class="space-y-2 text-xs text-slate-600 dark:text-slate-300 pt-2">
                            <div class="flex items-start gap-2">
                                <i class="fa-solid fa-location-dot text-indigo-500 mt-0.5"></i>
                                <span>Beside A.B.T.A Building, New DangalPara, Suri, Birbhum, West Bengal – 731101</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-clock text-indigo-500"></i>
                                <span>Monday to Saturday: 9:30 AM to 8:30 PM</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-calendar-xmark text-rose-500"></i>
                                <span>Sunday: Closed (Emergency AMC lines remain active)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Rapid Assistance Box -->
                    <div class="p-6 rounded-3xl bg-gradient-to-br from-indigo-900 to-slate-900 text-white space-y-3">
                        <div class="flex items-center gap-2 text-amber-400 font-bold text-xs">
                            <i class="fa-solid fa-headset"></i> Immediate Assistance Desk
                        </div>
                        <h4 class="text-base font-extrabold">Need On-Site Engineer in Birbhum Today?</h4>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            For urgent network outages, CCTV DVR crashes, or server failures, call our emergency dispatch team immediately.
                        </p>
                        <a href="tel:+919434197268" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-indigo-900 font-bold text-xs hover:bg-slate-100 transition">
                            <i class="fa-solid fa-phone"></i> +91 94341 97268
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>
