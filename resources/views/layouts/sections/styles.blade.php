<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

{{-- Single bundle: Tailwind + Apni tokens + Materio (core, theme, demo, Remixicon, perfect-scrollbar) --}}
@vite(['resources/css/app.css'])
@yield('vendor-style')

<!-- Page Styles -->
@yield('page-style')
