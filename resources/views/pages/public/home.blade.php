<?php

use App\Models\Blog;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts.public')] #[Title('Comtech - IT Sales, CCTV, Tally & Services | Suri, Birbhum')] class extends Component {
    #[Validate('required|min:3')]
    public string $name = '';

    #[Validate('required|min:10')]
    public string $phone = '';

    #[Validate('nullable|email')]
    public string $email = '';

    #[Validate('required')]
    public string $service_type = 'CCTV Surveillance';

    #[Validate('required|min:5')]
    public string $message = '';

    public string $urgency = 'normal';

    public bool $submitted = false;
    public ?string $generatedTicket = null;

    public function submitEnquiry(): void
    {
        $this->validate();

        $enquiry = Enquiry::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email ?: null,
            'type' => 'general',
            'subject' => "Quick Home Enquiry: {$this->service_type}",
            'message' => $this->message,
            'urgency' => $this->urgency,
            'status' => 'pending',
            'ip_address' => request()->ip(),
        ]);

        $this->generatedTicket = $enquiry->ticket_number;
        $this->submitted = true;

        $this->reset(['name', 'phone', 'email', 'message']);
    }

    public function with(): array
    {
        return [
            'services' => Service::query()->where('is_active', true)->orderBy('sort_order')->take(6)->get(),
            'featuredProducts' => Product::query()->with('category')->where('is_active', true)->where('is_featured', true)->take(6)->get(),
            'promotions' => Promotion::query()->where('is_active', true)->orderBy('sort_order')->take(3)->get(),
            'testimonials' => Testimonial::query()->where('is_active', true)->where('is_featured', true)->orderBy('sort_order')->take(4)->get(),
            'blogs' => Blog::query()->with('category')->where('is_published', true)->orderByDesc('published_at')->take(3)->get(),
        ];
    }
};
?>

<div>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-b from-slate-900 via-indigo-950/90 to-slate-950 text-white py-20 lg:py-28">
        <!-- Background Glow FX -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 -right-40 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Hero Copy -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-900/60 border border-indigo-700/50 text-indigo-300 text-xs font-semibold backdrop-blur-md">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Trusted IT Sales & Service Leader in Birbhum Since 2009
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                        Empowering Businesses With <span class="gradient-text">Complete IT Solutions</span>
                    </h1>

                    <p class="text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        From <strong>CCTV Surveillance Systems</strong> and <strong>Tally Prime Licensing</strong> to <strong>Chip-Level Laptop Repairs</strong>, custom <strong>Web & Software Development</strong>, and enterprise <strong>AMC</strong>.
                    </p>

                    <!-- Dual Brand Badge -->
                    <div class="flex flex-wrap justify-center lg:justify-start gap-3 pt-2">
                        <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800/80 border border-slate-700/80 text-xs font-medium">
                            <i class="fa-solid fa-cart-shopping text-indigo-400"></i>
                            <span><strong>Sales:</strong> Comtech Information Services</span>
                        </div>
                        <div class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800/80 border border-slate-700/80 text-xs font-medium">
                            <i class="fa-solid fa-screwdriver-wrench text-emerald-400"></i>
                            <span><strong>Services:</strong> Comtech Infosys</span>
                        </div>
                    </div>

                    <!-- Hero CTAs -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                        <a href="{{ route('services') }}" wire:navigate class="w-full sm:w-auto px-7 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 transition-all text-center">
                            Explore Services
                        </a>
                        <a href="#quick-quote" class="w-full sm:w-auto px-7 py-3.5 rounded-xl bg-slate-800/90 hover:bg-slate-800 border border-slate-700 text-slate-200 font-semibold text-sm hover:border-slate-500 transition-all text-center">
                            Request Free Quote
                        </a>
                        <a href="https://wa.me/919434197268" target="_blank" class="w-full sm:w-auto px-5 py-3.5 rounded-xl bg-emerald-600/20 hover:bg-emerald-600/30 border border-emerald-500/40 text-emerald-300 font-semibold text-sm transition-all text-center flex items-center justify-center gap-2">
                            <i class="fa-brands fa-whatsapp text-emerald-400 text-base"></i>
                            <span>WhatsApp</span>
                        </a>
                    </div>

                    <!-- Trust Stats Bar -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-8 border-t border-slate-800/80">
                        <div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-white">15+</div>
                            <div class="text-xs text-slate-400 font-medium">Years Experience</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-indigo-400">2,500+</div>
                            <div class="text-xs text-slate-400 font-medium">Clients in Birbhum</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-blue-400">500+</div>
                            <div class="text-xs text-slate-400 font-medium">CCTV Installations</div>
                        </div>
                        <div>
                            <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400">2-Hour</div>
                            <div class="text-xs text-slate-400 font-medium">Local SLA in Suri</div>
                        </div>
                    </div>
                </div>

                <!-- Right Quick Lead Capture Card -->
                <div class="lg:col-span-5" id="quick-quote">
                    <div class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl p-6 sm:p-8 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
                        
                        <div class="mb-6">
                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Fast Callback</span>
                            <h3 class="text-xl font-bold mt-1">Get an Instant IT Quotation</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                Tell us your requirement in Suri/Birbhum for quick estimates.
                            </p>
                        </div>

                        @if ($submitted)
                            <div class="p-5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-center space-y-3">
                                <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-300 mx-auto flex items-center justify-center text-xl">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <h4 class="font-bold text-emerald-800 dark:text-emerald-200">Enquiry Received!</h4>
                                <p class="text-xs text-emerald-700 dark:text-emerald-300">
                                    Your reference ticket is <strong class="font-mono">{{ $generatedTicket }}</strong>. Our team in Suri will contact you within 2 business hours.
                                </p>
                                <button wire:click="$set('submitted', false)" class="text-xs font-semibold text-emerald-700 dark:text-emerald-300 underline">
                                    Submit another enquiry
                                </button>
                            </div>
                        @else
                            <form wire:submit="submitEnquiry" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Your Full Name *</label>
                                    <input type="text" wire:model="name" placeholder="e.g. Ramesh Ghosh" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden transition">
                                    @error('name') <span class="text-rose-500 text-xs mt-0.5 block">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Phone Number *</label>
                                        <input type="tel" wire:model="phone" placeholder="10-digit Mobile" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden transition">
                                        @error('phone') <span class="text-rose-500 text-xs mt-0.5 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Service Required *</label>
                                        <select wire:model="service_type" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden transition">
                                            <option value="CCTV Surveillance">CCTV Surveillance</option>
                                            <option value="Tally Prime / TDL">Tally Prime / TDL</option>
                                            <option value="Laptop / Desktop Repair">Laptop / PC Repair</option>
                                            <option value="Website / Software">Website / Software</option>
                                            <option value="IT AMC & Networking">IT AMC & Networking</option>
                                            <option value="Antivirus & Security">Antivirus & Security</option>
                                            <option value="New Hardware Purchase">Hardware Purchase</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Requirement Details *</label>
                                    <textarea wire:model="message" rows="3" placeholder="Briefly describe what you need (e.g. 4 CCTV cameras for shop in Suri)..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-sm focus:ring-2 focus:ring-indigo-500 outline-hidden transition"></textarea>
                                    @error('message') <span class="text-rose-500 text-xs mt-0.5 block">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white font-semibold text-sm shadow-md shadow-indigo-600/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
                                    <span wire:loading.remove>Submit Free Enquiry</span>
                                    <span wire:loading class="flex items-center gap-2">
                                        <i class="fa-solid fa-spinner fa-spin"></i> Processing...
                                    </span>
                                </button>
                                <p class="text-[11px] text-center text-slate-500 dark:text-slate-400">
                                    <i class="fa-solid fa-shield-halved text-emerald-500"></i> No spam. 100% privacy guaranteed.
                                </p>
                            </form>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Promotional Deals Bar -->
    @if($promotions->isNotEmpty())
        <section class="bg-indigo-600 text-white py-4 px-4 shadow-inner">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-center md:text-left">
                    <span class="px-2.5 py-1 bg-white text-indigo-700 font-bold text-xs rounded-full uppercase tracking-wider">
                        {{ $promotions->first()->badge_text }}
                    </span>
                    <span class="font-semibold text-sm sm:text-base">
                        {{ $promotions->first()->title }} — <strong>{{ $promotions->first()->discount_text }}</strong>
                    </span>
                </div>
                <a href="{{ route('promotions') }}" wire:navigate class="px-4 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition shrink-0">
                    View All Deals <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </section>
    @endif

    <!-- Core Services Grid -->
    <section class="py-20 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/60 px-3 py-1 rounded-full border border-indigo-200 dark:border-indigo-800">
                    Comprehensive IT Expertise
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">
                    Our Specialized IT Services
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base">
                    From enterprise surveillance setups to accounting software customization, we provide complete on-site and remote technical support across Birbhum.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($services as $service)
                    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group hover:-translate-y-1">
                        
                        <!-- Card Image Preview -->
                        <div class="h-48 overflow-hidden relative">
                            <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[11px] font-bold bg-indigo-600 text-white shadow-sm">
                                {{ $service->category }}
                            </span>
                            @if($service->starting_price)
                                <span class="absolute bottom-3 right-3 px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-900/90 text-emerald-400 border border-slate-700 backdrop-blur-xs">
                                    From {{ $service->starting_price }}
                                </span>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ $service->title }}
                                </h3>
                                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-3">
                                    {{ $service->short_description }}
                                </p>

                                @if($service->features && count($service->features))
                                    <ul class="pt-2 space-y-1.5 text-xs text-slate-700 dark:text-slate-300">
                                        @foreach(array_slice($service->features, 0, 3) as $feat)
                                            <li class="flex items-center gap-2">
                                                <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i>
                                                <span>{{ $feat }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                <a href="{{ route('services') }}" wire:navigate class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                                    Learn More <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                                <a href="{{ route('contact', ['service' => $service->title]) }}" wire:navigate class="px-3 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 hover:bg-indigo-600 hover:text-white text-indigo-700 dark:text-indigo-300 text-xs font-semibold transition">
                                    Enquire Now
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('services') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-900 dark:bg-slate-800 hover:bg-indigo-600 text-white text-sm font-semibold transition-colors">
                    <span>View All Services & AMC Plans</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- Featured Products & IT Hardware Section -->
    <section class="py-20 bg-white dark:bg-slate-900 border-y border-slate-200/80 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                        Sales Division &bull; Comtech Information Services
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1">
                        Featured Products & Commercial Software
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">
                        Genuine brand warranty, authentic licenses, and best commercial pricing in Suri.
                    </p>
                </div>
                <a href="{{ route('products') }}" wire:navigate class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                    Browse All Products <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($featuredProducts as $product)
                    <div class="bg-slate-50 dark:bg-slate-800/60 rounded-2xl border border-slate-200 dark:border-slate-700/80 p-5 flex flex-col justify-between hover:border-indigo-500/50 hover:shadow-lg transition group">
                        
                        <div>
                            <div class="relative h-44 rounded-xl overflow-hidden bg-white dark:bg-slate-900 p-2 mb-4 flex items-center justify-center">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                @if($product->discount_percentage)
                                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-rose-500 text-white text-[10px] font-bold">
                                        {{ $product->discount_percentage }}% OFF
                                    </span>
                                @endif
                                <span class="absolute top-2 right-2 px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-[10px] font-semibold border border-slate-200 dark:border-slate-700">
                                    {{ $product->brand ?? $product->category?->name }}
                                </span>
                            </div>

                            <h4 class="font-bold text-sm text-slate-900 dark:text-white line-clamp-2 mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $product->name }}
                            </h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mb-3">
                                {{ $product->short_description }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-200 dark:border-slate-700 flex items-center justify-between">
                            <div>
                                @if($product->discount_price)
                                    <div class="text-base font-extrabold text-indigo-600 dark:text-indigo-400">
                                        ₹{{ number_format((float) $product->discount_price) }}
                                    </div>
                                    @if($product->price)
                                        <div class="text-[11px] text-slate-400 line-through">
                                            ₹{{ number_format((float) $product->price) }}
                                        </div>
                                    @endif
                                @elseif($product->price)
                                    <div class="text-base font-extrabold text-slate-900 dark:text-white">
                                        ₹{{ number_format((float) $product->price) }}
                                    </div>
                                @else
                                    <div class="text-xs font-bold text-indigo-600 dark:text-indigo-400">
                                        Call for Price
                                    </div>
                                @endif
                            </div>

                            <a href="{{ route('contact', ['product' => $product->name]) }}" wire:navigate class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shadow-xs transition">
                                Request Quote
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Why Choose Comtech Section -->
    <section class="py-20 bg-slate-900 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-400">
                    The Comtech Advantage
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold">
                    Why Birbhum Trusts Comtech
                </h2>
                <p class="text-slate-300 text-sm sm:text-base">
                    Local presence, genuine hardware certifications, fast on-site dispatch, and transparent pricing.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 space-y-3 hover:border-indigo-500 transition">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600/30 text-indigo-400 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h3 class="text-lg font-bold">Authorized Partnerships</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Official partner for Tally Prime, Quick Heal, Seqrite, Hikvision, CP Plus, HP, and Dell with 100% genuine warranty.
                    </p>
                </div>

                <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 space-y-3 hover:border-indigo-500 transition">
                    <div class="w-12 h-12 rounded-xl bg-emerald-600/30 text-emerald-400 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h3 class="text-lg font-bold">2-Hour Rapid On-Site SLA</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Dedicated service engineers ready for immediate on-site inspection in Suri, Bolpur, Rampurhat, and Sainthia.
                    </p>
                </div>

                <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 space-y-3 hover:border-indigo-500 transition">
                    <div class="w-12 h-12 rounded-xl bg-blue-600/30 text-blue-400 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-microchip"></i>
                    </div>
                    <h3 class="text-lg font-bold">Chip-Level Repair Lab</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Advanced BGA rework and motherboard diagnostic tools at our Suri lab for laptop, printer, and DVR repairs.
                    </p>
                </div>

                <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 space-y-3 hover:border-indigo-500 transition">
                    <div class="w-12 h-12 rounded-xl bg-amber-600/30 text-amber-400 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-handshake-angle"></i>
                    </div>
                    <h3 class="text-lg font-bold">Dedicated Account Manager</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Direct WhatsApp & phone lines for billing queries, emergency server downtime, and annual maintenance support.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- Client Testimonials Grid -->
    <section class="py-20 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                    Client Success Stories
                </span>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">
                    What Our Customers Say
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    Verified feedback from business owners, schools, and medical clinics in Suri & Birbhum.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($testimonials as $item)
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="flex items-center gap-1 text-amber-400 text-sm">
                                @for($i = 0; $i < $item->rating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 italic leading-relaxed">
                                "{{ $item->feedback }}"
                            </p>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-3">
                                <img src="{{ $item->avatar_url }}" alt="{{ $item->client_name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-slate-700">
                                <div>
                                    <div class="font-bold text-xs text-slate-900 dark:text-white">{{ $item->client_name }}</div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400">{{ $item->company_name }} &bull; {{ $item->location }}</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-semibold px-2 py-1 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-md">
                                {{ $item->service_availed }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Latest Tech Blog & Guides -->
    <section class="py-20 bg-white dark:bg-slate-900 border-t border-slate-200/80 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                        Tech Insights & Tutorials
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-1">
                        Latest Knowledge Base & Guides
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">
                        Practical tips on CCTV maintenance, Tally GST accounting, and cybersecurity.
                    </p>
                </div>
                <a href="{{ route('blogs') }}" wire:navigate class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                    Read All Articles <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($blogs as $blog)
                    <article class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 flex flex-col justify-between group hover:shadow-lg transition">
                        <div>
                            <div class="h-48 overflow-hidden">
                                <img src="{{ $blog->cover_image_url }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-6 space-y-2">
                                <div class="flex items-center gap-2 text-[11px] text-indigo-600 dark:text-indigo-400 font-semibold">
                                    <span>{{ $blog->category?->name }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $blog->read_time_minutes }} min read</span>
                                </div>
                                <h3 class="font-bold text-base text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2">
                                    <a href="{{ route('blogs.show', $blog->slug) }}" wire:navigate>
                                        {{ $blog->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 leading-relaxed">
                                    {{ $blog->excerpt }}
                                </p>
                            </div>
                        </div>

                        <div class="p-6 pt-0 flex items-center justify-between text-xs font-semibold text-slate-500 dark:text-slate-400 border-t border-slate-200/60 dark:border-slate-700/60">
                            <span>{{ $blog->published_at?->format('M d, Y') }}</span>
                            <a href="{{ route('blogs.show', $blog->slug) }}" wire:navigate class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                Read Article &rarr;
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Bottom Lead Capture Banner -->
    <section class="py-16 bg-gradient-to-r from-indigo-900 via-indigo-800 to-blue-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
            <h2 class="text-3xl sm:text-4xl font-extrabold">Ready to Upgrade Your Business IT Infrastructure?</h2>
            <p class="text-indigo-200 text-sm sm:text-base max-w-2xl mx-auto">
                Visit our showroom beside A.B.T.A Building, New DangalPara, Suri or request our technical team for an on-site consultation.
            </p>
            <div class="flex flex-wrap justify-center gap-4 pt-2">
                <a href="tel:+919434197268" class="px-7 py-3.5 rounded-xl bg-white text-indigo-900 font-bold text-sm shadow-lg hover:bg-slate-100 transition flex items-center gap-2">
                    <i class="fa-solid fa-phone text-emerald-600"></i> Call: +91 94341 97268
                </a>
                <a href="{{ route('contact') }}" wire:navigate class="px-7 py-3.5 rounded-xl bg-indigo-950/80 hover:bg-indigo-950 border border-indigo-500 text-white font-bold text-sm transition">
                    Visit Contact Page
                </a>
            </div>
        </div>
    </section>
</div>
