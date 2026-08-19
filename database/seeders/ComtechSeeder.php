<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\GalleryItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ComtechSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create or update Default Admin User
        User::firstOrCreate(
            ['email' => 'admin@comtech.com'],
            [
                'name' => 'Comtech Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed Site Settings
        $settings = [
            'company_name_sales' => 'Comtech Information Services',
            'company_name_service' => 'Comtech Infosys',
            'address' => 'Beside A.B.T.A Building, New DangalPara, Suri, Birbhum, West Bengal, India – 731101',
            'phone_primary' => '+91 94341 97268',
            'phone_secondary' => '+91 94743 06951',
            'phone_landline' => '03462-255555',
            'email_sales' => 'sales@comtechis.in',
            'email_service' => 'service@comtechinfosys.in',
            'email_general' => 'info@comtechis.in',
            'whatsapp_number' => '919434197268',
            'business_hours' => 'Mon - Sat: 9:30 AM – 8:30 PM (Sunday by Appointment)',
            'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14603.20864380183!2d87.5256247!3d23.9073287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f9dd5a4f7e21a3%3A0x6b77ff3ef7db4df6!2sSuri%2C%20West%20Bengal%20731101!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin',
            'meta_title' => 'Comtech - Premier IT Sales, Services & Solutions in Suri, Birbhum',
            'meta_description' => 'Comtech Information Services & Comtech Infosys provide CCTV installation, Tally Prime licensing, laptop/desktop repair, custom web development, antivirus and corporate AMC in Suri, Birbhum, WB.',
        ];

        foreach ($settings as $key => $val) {
            SiteSetting::set($key, $val);
        }

        // 3. Seed Services
        $services = [
            [
                'division' => 'service',
                'title' => 'CCTV Surveillance & Security Systems',
                'slug' => 'cctv-surveillance-installation',
                'category' => 'CCTV Installation',
                'short_description' => 'Complete end-to-end HD & IP CCTV camera installation, remote mobile view setup, biometrics, and maintenance for homes, shops, and institutions.',
                'description' => 'Comtech Infosys delivers high-performance video surveillance solutions across Birbhum. From 2MP full-color Night Vision cameras to 4K PTZ IP systems with NVR and cloud backup, we design, install, and service security infrastructures with 100% genuine Hikvision and CP Plus equipment.',
                'features' => [
                    'Full Color 24/7 Night Vision Cameras',
                    'Remote Live Monitoring on Android & iOS Smartphones',
                    'Motion Detection & Instant Push Alerts',
                    'Institutional & Commercial Multi-Site NVR Deployments',
                    'Biometric Attendance & Access Control Integration',
                    'Annual Maintenance Contracts (AMC) with guaranteed SLA',
                ],
                'icon' => 'video-camera',
                'image_url' => 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80',
                'starting_price' => '₹7,999 (4-Cam Setup)',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'division' => 'both',
                'title' => 'Tally Prime Sales, Customization & Support',
                'slug' => 'tally-prime-solutions-support',
                'category' => 'Tally Services',
                'short_description' => 'Authorized Tally Partner providing Silver/Gold licenses, TDL customization, GST invoice formatting, data migration, and multi-user on cloud.',
                'description' => 'Maximize your business accounting with Comtech. As certified Tally experts, we handle new license issuance, Tally Software Services (TSS) renewals, complex TDL invoice customizations, barcode printing, and secure Tally on Cloud configuration for anywhere accounting.',
                'features' => [
                    'Tally Prime Silver (Single User) & Gold (Multi User) Sales',
                    'Custom TDL Development & Invoice Templates',
                    'Automated E-way Bill & E-Invoicing Setup',
                    'Tally on Cloud (Access Tally from Anywhere, Anytime)',
                    'Data Synchronization across multiple branch locations',
                    'Dedicated Phone & On-Site Support in Suri & Birbhum',
                ],
                'icon' => 'calculator',
                'image_url' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=800&q=80',
                'starting_price' => '₹22,500 + GST',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'division' => 'service',
                'title' => 'IT Consultancy & Corporate AMC Support',
                'slug' => 'it-consultancy-amc-support',
                'category' => 'IT Consultancy',
                'short_description' => 'Preventive maintenance, dedicated on-site IT engineers, network upkeep, and rapid disaster recovery for offices, schools, and businesses.',
                'description' => 'Keep your operations running 24/7 with Comtech comprehensive Annual Maintenance Contracts (AMC). We take care of computers, servers, printers, UPS systems, firewalls, and local area networks so you can focus 100% on your business growth.',
                'features' => [
                    'Comprehensive & Non-Comprehensive AMC packages',
                    'Guaranteed 2-hour on-site response time in Suri town',
                    'Quarterly preventive health checkups & thermal cleaning',
                    'Automated daily data backups & disaster recovery planning',
                    'Network security auditing and firewall deployment',
                    'Emergency stand-by hardware replacement support',
                ],
                'icon' => 'briefcase',
                'image_url' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&w=800&q=80',
                'starting_price' => '₹1,499 / PC / Year',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'division' => 'both',
                'title' => 'Custom Website Design & Web Development',
                'slug' => 'website-design-development',
                'category' => 'Website Development',
                'short_description' => 'High-conversion, ultra-fast modern websites, e-commerce stores, and custom business portals designed to turn local visitors into paying customers.',
                'description' => 'Comtech crafts custom web applications tailored to your business needs. Using modern stacks (Laravel, Livewire, React, Tailwind CSS), we build blazing-fast, mobile-friendly websites with integrated WhatsApp chat, payment gateways, and search engine optimization.',
                'features' => [
                    '100% Mobile Responsive, Fast Loading Architecture',
                    'Search Engine Optimization (SEO) & Google My Business Setup',
                    'Custom Content Management System (CMS) & Lead Capture',
                    'E-commerce Portals with UPI / Razorpay / Net Banking',
                    'Secure HTTPS SSL & Free 1st Year Domain + Cloud Hosting',
                    'Regular Maintenance & Feature Upgrades',
                ],
                'icon' => 'globe-alt',
                'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
                'starting_price' => '₹8,999',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'division' => 'sales',
                'title' => 'Antivirus & Cybersecurity Solutions',
                'slug' => 'antivirus-cybersecurity-solutions',
                'category' => 'Antivirus Solutions',
                'short_description' => 'Enterprise endpoint security, ransomware defense, web protection, and genuine antivirus software from Quick Heal, Seqrite, and Kaspersky.',
                'description' => 'Safeguard your valuable accounts and company databases against malware, zero-day vulnerabilities, phishing, and ransomware. We provide genuine license keys, cloud console management, and complete virus removal services.',
                'features' => [
                    'Quick Heal Total Security & Internet Security (Single / Multi-user)',
                    'Seqrite Endpoint Security with centralized cloud console for offices',
                    'Kaspersky Enterprise & Small Office Security',
                    'Real-time ransomware shielding and external USB encryption',
                    'Deep system scanning, Trojan removal & OS sanitization',
                    'Instant digital activation and on-spot installation',
                ],
                'icon' => 'shield-check',
                'image_url' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=800&q=80',
                'starting_price' => '₹499 (1-Year 1-PC)',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'division' => 'service',
                'title' => 'Chip-Level Laptop, Desktop & Printer Repair',
                'slug' => 'laptop-desktop-printer-repair',
                'category' => 'Hardware Repair',
                'short_description' => 'Advanced chip-level motherboard repairing, BGA soldering, display replacement, hinge repairs, SSD upgrades, and toner refills.',
                'description' => 'Equipped with precision diagnostic tools, BGA rework stations, and oscilloscope equipment at our Suri workshop, Comtech Infosys fixes laptop motherboards, water-damaged boards, broken screens, dead power supplies, and dot matrix/laser printers.',
                'features' => [
                    'Motherboard chip-level diagnosis & IC/Capacitor replacement',
                    'Broken laptop body, hinge fabrication & bezel replacement',
                    'Same-day SSD & High-Speed RAM upgrades with OS cloning',
                    'Laptop LCD/LED/OLED original panel replacements',
                    'Laser printer cartridge refilling & Teflon/Logic board repairs',
                    'Transparent pricing with 30-day service warranty',
                ],
                'icon' => 'wrench-screwdriver',
                'image_url' => 'https://images.unsplash.com/photo-1588508065123-287b28e013da?auto=format&fit=crop&w=800&q=80',
                'starting_price' => '₹350 (Diagnosis)',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'division' => 'both',
                'title' => 'Custom Software, Billing & ERP Solutions',
                'slug' => 'custom-software-erp-solutions',
                'category' => 'Software Solutions',
                'short_description' => 'Tailored desktop and cloud billing software for retail shops, pharmacies, hotels, schools, and distribution businesses with GST support.',
                'description' => 'Streamline inventory, invoicing, barcode scanning, and multi-counter billing. We provide industry-specialized billing software that works online and offline with receipt printer support and automated accounting exports.',
                'features' => [
                    'Retail Supermarket & Grocery Barcode Billing',
                    'Pharmacy Management with Batch Number & Expiry Alerts',
                    'Restaurant POS with Kitchen Order Ticket (KOT) printing',
                    'School & College Management Software with fee tracking',
                    'Custom Inventory & Warehouse Management Systems',
                    'Easy GST Return Generation (GSTR-1, GSTR-3B)',
                ],
                'icon' => 'cpu-chip',
                'image_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80',
                'starting_price' => '₹6,500',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'division' => 'service',
                'title' => 'Structured Networking, Wi-Fi & Server Setups',
                'slug' => 'structured-networking-server-setup',
                'category' => 'Networking Solutions',
                'short_description' => 'Cat6/Fiber optic structured cabling, managed server racks, mesh Wi-Fi deployments, load-balancing routers, and VPN connectivity.',
                'description' => 'Build high-speed, zero-downtime network backbones for schools, bank branches, hospitals, and corporate offices across Suri and Birbhum. We install managed switches, Ubiquiti access points, and rackmount Windows/Linux servers.',
                'features' => [
                    'D-Link / Molex Cat6 Gigabit structured cabling with patch panels',
                    'Optical Fiber splicing and high-bandwidth media converters',
                    'Long-range outdoor Point-to-Point (P2P) wireless bridges',
                    'Enterprise Mesh Wi-Fi with seamless roaming',
                    'Windows Server Active Directory & centralized file storage',
                    'Router / Firewall bandwidth management & VPN remote access',
                ],
                'icon' => 'server-stack',
                'image_url' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=800&q=80',
                'starting_price' => '₹4,999',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($services as $svcData) {
            Service::updateOrCreate(['slug' => $svcData['slug']], $svcData);
        }

        // 4. Seed Product Categories
        $categoriesData = [
            [
                'name' => 'CCTV & Security Systems',
                'slug' => 'cctv-security-systems',
                'description' => 'Hikvision, CP Plus, Dahua HD/IP cameras, DVRs, NVRs, hard disks, and smart biometric devices.',
                'image_url' => 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 1,
            ],
            [
                'name' => 'Tally & Business Software',
                'slug' => 'tally-business-software',
                'description' => 'Original Tally Prime single/multi-user licenses, cloud hosting, and add-on modules.',
                'image_url' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 2,
            ],
            [
                'name' => 'Desktops & Laptops',
                'slug' => 'desktops-laptops',
                'description' => 'Branded HP, Dell, Lenovo business laptops, gaming PCs, assembled desktops, and workstations.',
                'image_url' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 3,
            ],
            [
                'name' => 'Antivirus & Cybersecurity',
                'slug' => 'antivirus-cybersecurity',
                'description' => 'Quick Heal Total Security, Seqrite Endpoint, Kaspersky antivirus licenses for home and enterprise.',
                'image_url' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 4,
            ],
            [
                'name' => 'Networking & Accessories',
                'slug' => 'networking-accessories',
                'description' => 'Gigabit routers, Cat6 cables, Wi-Fi adapters, server racks, UPS systems, SSDs, and RAM.',
                'image_url' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 5,
            ],
            [
                'name' => 'Printers & POS Peripherals',
                'slug' => 'printers-pos-peripherals',
                'description' => 'Laser printers, thermal receipt printers, 2D barcode scanners, cash drawers, and toners.',
                'image_url' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?auto=format&fit=crop&w=600&q=80',
                'sort_order' => 6,
            ],
        ];

        $categoryMap = [];
        foreach ($categoriesData as $c) {
            $cat = ProductCategory::updateOrCreate(['slug' => $c['slug']], $c);
            $categoryMap[$c['slug']] = $cat->id;
        }

        // 5. Seed Products
        $products = [
            [
                'product_category_id' => $categoryMap['cctv-security-systems'],
                'name' => 'Hikvision 4-Channel 1080P Full Color Night Vision CCTV Combo Kit',
                'slug' => 'hikvision-4-channel-full-color-cctv-kit',
                'brand' => 'Hikvision',
                'model_number' => 'DS-2CE10DF0T-F + DS-7104HQHI-K1',
                'short_description' => 'Complete surveillance bundle including 4 Full Color 2MP cameras, 4-Channel DVR, 1TB Seagate SkyHawk HDD, power supply, and BNC connectors.',
                'description' => 'Experience vivid color imaging even in pitch darkness with Hikvision ColorVu technology. Ideal for shop fronts, residences, and warehouses in Suri and Birbhum. Comes with complimentary mobile app configuration.',
                'features' => ['4x 2MP ColorVu Bullet/Dome Cameras', '1x 4-Channel AcuSense HD DVR', '1TB Surveillance Grade Hard Drive', '12V 5A Centralized SMPS Power Supply', 'Full Audio Over Coaxial Cable Support'],
                'specs' => ['Resolution' => '1920x1080 Full HD', 'Night Vision' => 'Up to 20 meters Color', 'Storage' => '1TB Surveillance HDD', 'Warranty' => '2 Years Brand Warranty'],
                'price' => 14500.00,
                'discount_price' => 11999.00,
                'discount_percentage' => 17,
                'image_url' => 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80',
                'in_stock' => true,
                'is_featured' => true,
                'warranty_info' => '2 Years Manufacturer Replacement Warranty',
            ],
            [
                'product_category_id' => $categoryMap['tally-business-software'],
                'name' => 'Tally Prime Silver (Single User) Perpetual License',
                'slug' => 'tally-prime-silver-single-user',
                'brand' => 'Tally Solutions',
                'model_number' => 'TP-SILVER-v4',
                'short_description' => 'Official perpetual standalone license for Tally Prime with 12 months free TSS, e-invoicing, e-way bill generation, and GST compliance.',
                'description' => 'Empower your single-counter retail store or trading firm with Tally Prime Silver. Enjoy straightforward accounting, inventory tracking, bank reconciliation, and automated GST return filing.',
                'features' => ['Complete Invoicing, Billing & Inventory', 'Direct E-Way Bill & E-Invoice Integration', 'Bank Reconciliation & Cheque Management', '12 Months Free Tally Software Services (TSS)', 'Free Installation & Basic Training from Comtech'],
                'specs' => ['User Type' => 'Single User (1 PC)', 'License Type' => 'Perpetual (Lifetime)', 'Platform' => 'Windows 10 / 11 / Server'],
                'price' => 26550.00,
                'discount_price' => 22500.00,
                'discount_percentage' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=800&q=80',
                'in_stock' => true,
                'is_featured' => true,
                'warranty_info' => 'Official Tally Warranty & 1 Year Comtech Support',
            ],
            [
                'product_category_id' => $categoryMap['tally-business-software'],
                'name' => 'Tally Prime Gold (Multi-User) Unlimited Network License',
                'slug' => 'tally-prime-gold-multi-user',
                'brand' => 'Tally Solutions',
                'model_number' => 'TP-GOLD-v4',
                'short_description' => 'Multi-user unlimited client license for corporate offices, distributors, factories, and schools on local area network or private cloud.',
                'description' => 'Allow multiple accounts staff, billing executives, and administrators to work concurrently on the same company database with advanced security and permission controls.',
                'features' => ['Unlimited LAN / WAN Network Users', 'Concurrent Data Entry & Reporting', 'Advanced User Security Controls & Audit Trail', 'Multi-Currency & Cost Center Accounting', '12 Months Free TSS + Remote Setup'],
                'specs' => ['User Type' => 'Multi-User (Unlimited LAN)', 'License Type' => 'Perpetual', 'Platform' => 'Windows 10 / 11 / Server'],
                'price' => 79650.00,
                'discount_price' => 67500.00,
                'discount_percentage' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
                'in_stock' => true,
                'is_featured' => true,
                'warranty_info' => 'Official Tally Warranty & 1 Year Comtech Support',
            ],
            [
                'product_category_id' => $categoryMap['desktops-laptops'],
                'name' => 'HP 250 G9 Business Laptop (Intel Core i5 12th Gen / 16GB / 512GB SSD)',
                'slug' => 'hp-250-g9-business-laptop-core-i5',
                'brand' => 'HP',
                'model_number' => 'HP-250G9-i5',
                'short_description' => 'Durable 15.6" Full HD business laptop designed for high productivity, accounting software, multitasking, and office operations.',
                'description' => 'Equipped with a powerful 12th Gen Intel Core i5 processor, 16GB DDR4 RAM, and ultra-responsive 512GB NVMe SSD, this HP laptop boots in seconds and handles demanding Tally, Office, and browser workloads with ease.',
                'features' => ['Intel Core i5-1235U (10 Cores, up to 4.4 GHz)', '16GB DDR4 RAM (Expandable to 32GB)', '512GB PCIe NVMe M.2 High-Speed SSD', '15.6" Anti-Glare FHD (1920x1080) Narrow Bezel Screen', 'Fast Charge (50% in 45 mins) & Numeric Keypad'],
                'specs' => ['Processor' => 'Intel Core i5 12th Gen', 'RAM' => '16GB DDR4', 'Storage' => '512GB NVMe SSD', 'Display' => '15.6 Inch FHD', 'OS' => 'Windows 11 Home + MS Office Genuine'],
                'price' => 54990.00,
                'discount_price' => 47499.00,
                'discount_percentage' => 14,
                'image_url' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=800&q=80',
                'in_stock' => true,
                'is_featured' => true,
                'warranty_info' => '1 Year HP On-Site Warranty + Comtech Support',
            ],
            [
                'product_category_id' => $categoryMap['desktops-laptops'],
                'name' => 'Comtech Custom Commercial Intel Core i3 12th Gen Desktop PC',
                'slug' => 'comtech-custom-commercial-i3-desktop-pc',
                'brand' => 'Comtech Built',
                'model_number' => 'COM-DESK-i3-12G',
                'short_description' => 'Reliable, energy-efficient workstation with Intel Core i3 12th Gen, 8GB DDR4, 256GB SSD, Zebronics cabinet with SMPS, and 19" LED Monitor.',
                'description' => 'Tailored for retail billing counters, school labs, and office workstations in Suri. Built using high-grade Gigabyte/Asus motherboards and Crucial RAM for non-stop longevity.',
                'features' => ['Intel Core i3-12100 Processor with UHD 730 Graphics', 'H610 Gigabyte / Asus Motherboard', '8GB DDR4 3200MHz RAM', '256GB NVMe M.2 SSD', 'Frontech / Zebronics 19" HD LED Monitor & USB Keyboard Mouse Set'],
                'specs' => ['Processor' => 'Intel Core i3 12th Gen', 'Motherboard' => 'H610M Ultra Durable', 'Memory' => '8GB DDR4', 'Storage' => '256GB NVMe SSD', 'Monitor' => '19 Inch Wide LED'],
                'price' => 26500.00,
                'discount_price' => 22999.00,
                'discount_percentage' => 13,
                'image_url' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=800&q=80',
                'in_stock' => true,
                'is_featured' => false,
                'warranty_info' => '3 Years Component Warranty + 1 Year Free Service',
            ],
            [
                'product_category_id' => $categoryMap['antivirus-cybersecurity'],
                'name' => 'Quick Heal Total Security (3-Year / 1-PC) Genuine License',
                'slug' => 'quick-heal-total-security-3-year-1-pc',
                'brand' => 'Quick Heal',
                'model_number' => 'QHTS-3Y-1U',
                'short_description' => 'Maximum protection against ransomware, phishing websites, spyware, malware, and financial fraud for 3 full years.',
                'description' => 'Never worry about malware corrupting your business documents or Tally database. Quick Heal Total Security provides deep heuristic analysis, USB drive disinfection, and secure banking browser shields.',
                'features' => ['Ransomware Protection with automatic backup rollback', 'Safe Banking & Web Security shield', 'External USB Drive Auto-Scan & Vaccination', 'Parental Controls & Data Theft Prevention', 'Zero-Lag Gaming & Silent Mode'],
                'specs' => ['Duration' => '3 Years (1095 Days)', 'Device Count' => '1 PC', 'Delivery' => 'Physical Box & Instant Email Key'],
                'price' => 2499.00,
                'discount_price' => 1699.00,
                'discount_percentage' => 32,
                'image_url' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=800&q=80',
                'in_stock' => true,
                'is_featured' => true,
                'warranty_info' => '100% Genuine License Guarantee',
            ],
            [
                'product_category_id' => $categoryMap['networking-accessories'],
                'name' => 'TP-Link Archer AX12 Wi-Fi 6 Gigabit Dual-Band Router',
                'slug' => 'tp-link-archer-ax12-wifi6-gigabit-router',
                'brand' => 'TP-Link',
                'model_number' => 'Archer-AX12',
                'short_description' => 'Next-gen Wi-Fi 6 speeds up to 1.5 Gbps, Beamforming antennas, OFDMA tech, and WPA3 security for offices and multi-device households.',
                'description' => 'Eliminate buffering and dead zones in your shop or office. Delivers rock-solid speeds for CCTV streaming, video conferencing, and multi-user data transfers.',
                'features' => ['Next-Gen Wi-Fi 6 (1201 Mbps on 5GHz + 300 Mbps on 2.4GHz)', '4 High-Gain External Antennas with Beamforming', 'Gigabit WAN & 3 Gigabit LAN Ports', 'WPA3 Advanced Cybersecurity Protocol', 'Easy Tether App Setup & Parental Controls'],
                'specs' => ['Speed' => 'AX1500 (1500 Mbps)', 'Bands' => 'Dual Band 2.4GHz & 5GHz', 'Ports' => '4x Gigabit Ethernet Ports'],
                'price' => 3899.00,
                'discount_price' => 2799.00,
                'discount_percentage' => 28,
                'image_url' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=800&q=80',
                'in_stock' => true,
                'is_featured' => false,
                'warranty_info' => '3 Years Manufacturer Replacement Warranty',
            ],
            [
                'product_category_id' => $categoryMap['printers-pos-peripherals'],
                'name' => 'TVS RP-3200 Star 3-Inch High Speed Thermal POS Receipt Printer',
                'slug' => 'tvs-rp-3200-thermal-pos-receipt-printer',
                'brand' => 'TVS Electronics',
                'model_number' => 'RP-3200-STAR',
                'short_description' => 'Heavy-duty 260 mm/sec thermal receipt printer with auto-cutter, USB + Ethernet + Serial interface, compatible with Tally & all billing software.',
                'description' => 'Engineered for relentless retail environments such as supermarkets, restaurants, and wholesale counters. Jam-free auto-cutter and crystal-clear thermal printing.',
                'features' => ['Superfast 260 mm/second print speed', 'Drop-in 80mm thermal paper roll loading', 'Durable Auto-Cutter with 1.5 Million cut life', 'USB, Serial and Ethernet interfaces built-in', 'Cash drawer kick-out port (RJ11)'],
                'specs' => ['Print Speed' => '260 mm/sec', 'Paper Width' => '80mm (3 Inch)', 'Connectivity' => 'USB + LAN + RS232', 'Cutter' => 'Auto-Cutter Included'],
                'price' => 9500.00,
                'discount_price' => 7499.00,
                'discount_percentage' => 21,
                'image_url' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?auto=format&fit=crop&w=800&q=80',
                'in_stock' => true,
                'is_featured' => true,
                'warranty_info' => '1 Year TVS Official Warranty',
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }

        // 6. Seed Blog Categories & Blogs
        $blogCategories = [
            ['name' => 'Tally & Accounting', 'slug' => 'tally-accounting', 'description' => 'Guides, GST updates, and tips for Tally Prime.'],
            ['name' => 'CCTV & Security', 'slug' => 'cctv-security', 'description' => 'Surveillance advice, camera selection, and setup tutorials.'],
            ['name' => 'Cybersecurity & Antivirus', 'slug' => 'cybersecurity-antivirus', 'description' => 'Protecting systems against threats, ransomware, and scams.'],
            ['name' => 'Hardware & IT Tips', 'slug' => 'hardware-it-tips', 'description' => 'Maintenance guides for laptops, desktops, and office IT.'],
        ];

        $blogCatMap = [];
        foreach ($blogCategories as $bc) {
            $cat = BlogCategory::updateOrCreate(['slug' => $bc['slug']], $bc);
            $blogCatMap[$bc['slug']] = $cat->id;
        }

        $blogs = [
            [
                'blog_category_id' => $blogCatMap['cctv-security'],
                'title' => 'Complete CCTV Camera Buying Guide for Businesses and Residences in Birbhum',
                'slug' => 'complete-cctv-camera-buying-guide-birbhum',
                'author' => 'Comtech Technical Team',
                'excerpt' => 'Discover how to choose between HD Analog vs IP cameras, understand night vision capabilities, and calculate storage requirements for your CCTV installation.',
                'content' => "Installing a CCTV surveillance system is one of the most critical security decisions for shop owners, institutions, and homeowners in Suri and across Birbhum district. With a wide array of options in the market—from 2MP HD cameras to 4K IP cameras with AI human detection—selecting the right configuration ensures maximum protection without unnecessary costs.\n\n### 1. HD Analog vs. IP Cameras: Which One Should You Pick?\n- **HD Analog (TVI/CVI/AHD):** Perfect for small-to-medium retail shops, residential buildings, and warehouses up to 16 cameras. It offers cost-effective 1080p to 5MP resolution over coaxial cables.\n- **IP Surveillance (PoE):** Recommended for large institutions, multi-floor complexes, banks, and schools. IP cameras use ethernet cables, transmit crystal-clear audio, and allow centralized management across distributed branches.\n\n### 2. Why ColorVu / Full-Color Night Vision is Essential\nTraditional infrared (IR) cameras switch to black-and-white mode in the dark, losing crucial details such as vehicle color, shirt color, and license plate recognition. Modern ColorVu cameras from Hikvision maintain vivid full-color recording 24 hours a day with supplementary soft warm lighting.\n\n### 3. Calculating Surveillance Storage (Hard Disk)\nNever use ordinary desktop hard drives in a DVR or NVR. Desktop hard drives are engineered for 8 hours of daily use, whereas surveillance DVRs write data continuously 24/7. Always opt for dedicated surveillance-grade drives such as **Seagate SkyHawk** or **Western Digital Purple**.\n\nAt **Comtech Infosys**, our certified security engineers perform free site surveys in Suri, Bolpur, Sainthia, Rampurhat, and surrounding areas to map exact camera angles and blind spots.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=1000&q=80',
                'tags' => ['CCTV', 'Hikvision', 'Security', 'Suri', 'Surveillance'],
                'read_time_minutes' => 6,
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(3),
                'views_count' => 342,
            ],
            [
                'blog_category_id' => $blogCatMap['tally-accounting'],
                'title' => 'Top 7 Features in Tally Prime 4.0 Every Business Owner Must Utilize',
                'slug' => 'top-7-features-in-tally-prime-4-for-business',
                'author' => 'Soumen Mukherjee (Tally Certified Specialist)',
                'excerpt' => 'Learn how Tally Prime 4.0 transforms WhatsApp messaging, connected e-invoicing, graphical dashboards, and Excel data import to save hours of manual data entry.',
                'content' => "Tally Prime continues to set the benchmark for business accounting in India. With the release of version 4.0, Tally Solutions has introduced game-changing capabilities designed for modern business workflows.\n\n### 1. Instant WhatsApp Integration for Invoices & Outstanding Reminders\nYou can now share invoices, receipts, payment reminders, and financial reports directly with your clients over official WhatsApp API with a single click inside Tally Prime.\n\n### 2. Intuitive Graphical Dashboards\nGain real-time visual insights into cash flow, sales trends, top customers, and pending liabilities through customizable visual widgets.\n\n### 3. Frictionless Excel Data Import\nImporting bank statements, vendor bills, and inventory masters from Excel sheets into Tally no longer requires complex programming. The built-in Excel import wizard handles column mapping effortlessly.\n\n### 4. Seamless E-Invoicing & E-Way Bill Generation\nGenerate QR code e-invoices and IRN numbers directly within seconds without ever visiting the GST portal manually.\n\nNeed assistance upgrading your Tally Prime or setting up customized TDL invoices? Contact **Comtech Information Services**, the authorized Tally partner in Suri.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=1000&q=80',
                'tags' => ['Tally', 'TallyPrime', 'GST', 'Accounting', 'Business'],
                'read_time_minutes' => 5,
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(7),
                'views_count' => 580,
            ],
            [
                'blog_category_id' => $blogCatMap['cybersecurity-antivirus'],
                'title' => 'How to Protect Your Company Database from Modern Ransomware Attacks',
                'slug' => 'how-to-protect-company-database-from-ransomware',
                'author' => 'Comtech Security Team',
                'excerpt' => 'Crucial security steps to safeguard Tally data, SQL databases, and client records against malicious ransomware encryption and extortion.',
                'content' => "Ransomware threats have grown significantly, targeting small and medium enterprises with vulnerable network ports and outdated antivirus software. Once attacked, all data files are encrypted with military-grade ciphers, halting business operations completely.\n\n### Essential Ransomware Defense Checklist:\n1. **Maintain 3-2-1 Backups:** Keep 3 copies of your data on 2 different media types, with at least 1 copy kept completely offline or on a secure cloud storage location.\n2. **Deploy Endpoint Security with Heuristic Rollback:** Solutions like Quick Heal Total Security and Seqrite EPS continuously monitor file activity. If ransomware attempts to encrypt a folder, the software immediately blocks the process and automatically rolls back modified files from a shadow cache.\n3. **Disable Default RDP (Remote Desktop) Ports:** Never expose standard port 3389 directly to the internet without a VPN or strict IP whitelisting.\n4. **Keep Operating Systems & Firmware Patched:** Regularly update Windows security patches and router firmware.\n\nComtech Infosys provides full cybersecurity audits and managed data backup services for commercial setups across Birbhum.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1000&q=80',
                'tags' => ['Cybersecurity', 'Antivirus', 'Ransomware', 'DataBackup'],
                'read_time_minutes' => 4,
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(12),
                'views_count' => 290,
            ],
            [
                'blog_category_id' => $blogCatMap['hardware-it-tips'],
                'title' => '5 Signs Your Office Laptop or Desktop Needs an SSD Upgrade Immediately',
                'slug' => '5-signs-your-pc-needs-ssd-upgrade',
                'author' => 'Comtech Hardware Lab',
                'excerpt' => 'Is your computer taking 5 minutes to boot or freezing on Tally? An NVMe or SATA SSD upgrade can give your old machine 10x faster performance at a fraction of a new PC price.',
                'content' => "Mechanical hard drives (HDDs) suffer from physical wear and slow read/write speeds, causing severe system bottlenecks. Upgrading to a Solid State Drive (SSD) is the single most cost-effective hardware enhancement you can perform.\n\n### Key Symptoms of a Bottlenecked Hard Drive:\n1. Boot times exceeding 2 to 5 minutes\n2. 100% Disk Usage displayed constantly in Windows Task Manager\n3. Frequent application freezing when launching Tally, Chrome, or Microsoft Excel\n4. Strange clicking or grinding noises coming from the laptop body\n5. Sluggish file search and slow copy speeds\n\nAt our Suri service facility, we clone your entire operating system, software, and accounting data to a high-speed SSD within 2 hours without losing a single file.",
                'cover_image_url' => 'https://images.unsplash.com/photo-1588508065123-287b28e013da?auto=format&fit=crop&w=1000&q=80',
                'tags' => ['Hardware', 'SSD', 'LaptopRepair', 'Performance'],
                'read_time_minutes' => 4,
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(16),
                'views_count' => 415,
            ],
        ];

        foreach ($blogs as $b) {
            Blog::updateOrCreate(['slug' => $b['slug']], $b);
        }

        // 7. Seed Promotions
        $promotions = [
            [
                'title' => 'Suri Business Special: 4 HD Hikvision CCTV Package with Installation',
                'badge_text' => 'Bestseller Package',
                'discount_text' => 'Complete Setup @ ₹11,999 (Save ₹3,500)',
                'description' => 'Includes 4 Full Color 2MP Cameras, 4-Channel DVR, 1TB Seagate SkyHawk Surveillance HDD, Power Supply, Connectors, and Free Professional On-Site Installation in Suri & Birbhum.',
                'terms' => 'Standard cable included up to 60 meters. Additional conduit and wiring charged as per actual consumption.',
                'image_url' => 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80',
                'cta_text' => 'Book Free Site Survey',
                'cta_link' => '#enquiry',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(30),
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Tally Prime Gold Multi-User Corporate Upgrade Fest',
                'badge_text' => '15% Off + Free Setup',
                'discount_text' => 'Flat 15% Discount on Multi-User Licensing & Free Remote Training',
                'description' => 'Equip your accountants and sales teams with seamless multi-counter billing. Includes 1-year free Tally Software Services (TSS) and customized GST invoice layout.',
                'terms' => 'Valid on new Gold licenses and Silver to Gold upgrades.',
                'image_url' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=800&q=80',
                'cta_text' => 'Claim Tally Offer',
                'cta_link' => '#enquiry',
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(20),
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Free 1-Year Quick Heal Total Security with Every Business Laptop',
                'badge_text' => 'Bundle Deal',
                'discount_text' => 'Get ₹1,299 Value Antivirus 100% Free',
                'description' => 'Purchase any HP, Dell, or Lenovo laptop from Comtech Information Services and receive an authentic Quick Heal Total Security 1-Year license plus complimentary laptop backpack.',
                'terms' => 'Offer valid till stock lasts at our Suri showroom.',
                'image_url' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=800&q=80',
                'cta_text' => 'Enquire Laptop Stocks',
                'cta_link' => '#enquiry',
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(45),
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($promotions as $promo) {
            Promotion::updateOrCreate(['title' => $promo['title']], $promo);
        }

        // 8. Seed Gallery Items
        $gallery = [
            [
                'title' => 'Commercial 16-Camera HD Surveillance Deployment',
                'category' => 'CCTV Installations',
                'image_url' => 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&w=800&q=80',
                'caption' => 'Installed for a major wholesale distributor in Suri with central monitor station and mobile sync.',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Corporate Server Rack & Gigabit Cabling Setup',
                'category' => 'Networking & Servers',
                'image_url' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=800&q=80',
                'caption' => 'Cat6 structured cabling with 24-port patch panel and managed D-Link gigabit switch in Birbhum.',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Precision Motherboard & BGA Chip-Level Lab',
                'category' => 'Repairs & Services',
                'image_url' => 'https://images.unsplash.com/photo-1588508065123-287b28e013da?auto=format&fit=crop&w=800&q=80',
                'caption' => 'Chip-level diagnostic workstation equipped with digital microscope and soldering stations.',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Comtech IT Showroom & Hardware Display',
                'category' => 'Office & Showroom',
                'image_url' => 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=800&q=80',
                'caption' => 'Customer consultation counter and product showroom beside A.B.T.A Building, Suri.',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Institutional Computer Lab Setup & Networking',
                'category' => 'Networking & Servers',
                'image_url' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=800&q=80',
                'caption' => '30-seat computer lab deployed for a prestigious higher secondary institution in Suri.',
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'title' => 'Outdoor High-Range Bullet Camera Installation',
                'category' => 'CCTV Installations',
                'image_url' => 'https://images.unsplash.com/photo-1508739773434-c26b3d09e071?auto=format&fit=crop&w=800&q=80',
                'caption' => 'Weatherproof IP67 security camera overlooking warehouse perimeter with lightning surge protection.',
                'is_featured' => false,
                'sort_order' => 6,
            ],
            [
                'title' => 'Multi-Counter Retail POS & Barcode Deployment',
                'category' => 'Office & Showroom',
                'image_url' => 'https://images.unsplash.com/photo-1556742049-0a67c5574f73?auto=format&fit=crop&w=800&q=80',
                'caption' => 'High-throughput supermarket billing setup with thermal printers and 2D handheld scanners.',
                'is_featured' => false,
                'sort_order' => 7,
            ],
            [
                'title' => 'Tally Prime Workshop & Client Training Session',
                'category' => 'Repairs & Services',
                'image_url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=800&q=80',
                'caption' => 'Conducting hands-on accounting and GST compliance training for local business accountants.',
                'is_featured' => false,
                'sort_order' => 8,
            ],
        ];

        foreach ($gallery as $g) {
            GalleryItem::updateOrCreate(['title' => $g['title']], $g);
        }

        // 9. Seed Testimonials
        $testimonials = [
            [
                'client_name' => 'Prabir Bhattacharya',
                'company_name' => 'Bhattacharya Brothers & Traders',
                'designation' => 'Managing Director',
                'location' => 'Suri, Birbhum',
                'rating' => 5,
                'feedback' => 'Comtech transformed our accounting operations. We upgraded to Tally Prime Gold and their custom invoice templates matched our exact billing format. Their on-site support team in Suri is always just a phone call away.',
                'service_availed' => 'Tally Prime Gold & TDL Customization',
                'avatar_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Dr. Anirban Sen',
                'company_name' => 'Sen Diagnostic & PolyClinic',
                'designation' => 'Chief Medical Administrator',
                'location' => 'New DangalPara, Suri',
                'rating' => 5,
                'feedback' => 'We installed 12 Hikvision ColorVu cameras and biometric attendance across our clinic. Comtech Infosys completed the neat cabling and mobile configuration within 2 days. The color night vision is phenomenal!',
                'service_availed' => 'CCTV Surveillance & Biometric Systems',
                'avatar_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Moumita Das',
                'company_name' => 'Birbhum Heritage Academy',
                'designation' => 'Principal',
                'location' => 'Suri, WB',
                'rating' => 5,
                'feedback' => 'Comtech handles our school computer lab AMC, Wi-Fi networking, and website development. Fast response, transparent estimates, and genuine parts every single time.',
                'service_availed' => 'Annual Maintenance Contract & Web Development',
                'avatar_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'client_name' => 'Subhashish Ghosh',
                'company_name' => 'Ghosh Auto & Spares',
                'designation' => 'Proprietor',
                'location' => 'Sainthia Road, Suri',
                'rating' => 5,
                'feedback' => 'My HP laptop motherboard had a power failure that two other shops declared unfixable. Comtech Infosys did a chip-level repair in 24 hours at a very reasonable price. Extremely professional engineers.',
                'service_availed' => 'Chip-Level Motherboard Repair',
                'avatar_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=200&q=80',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($testimonials as $testi) {
            Testimonial::updateOrCreate(['client_name' => $testi['client_name']], $testi);
        }
    }
}
