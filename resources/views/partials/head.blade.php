<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' | Comtech - IT Sales & Services (Suri, Birbhum)' : 'Comtech Information Services & Comtech Infosys | IT Sales & Services (Suri, Birbhum)' }}
</title>

<meta name="description" content="{{ $metaDescription ?? 'Comtech Information Services & Comtech Infosys: Leading provider of CCTV Camera Installation, Tally Prime Sales & Customization, Laptop Repair, Web Development & IT AMC in Suri, Birbhum, West Bengal.' }}">
<meta name="keywords" content="CCTV Suri Birbhum, Tally Prime Suri, Laptop Repair Suri, Web Development Birbhum, IT AMC Suri, Quick Heal Antivirus Birbhum, Comtech Infosys, Comtech Information Services">

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<!-- Google Fonts & Font Awesome Icons -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
