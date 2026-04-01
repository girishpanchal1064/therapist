@php
$height = 200;
@endphp
<img src="{{ asset('assets/img/logo/APNIPSYCHOLOGY-(dark).png') }}" alt="{{ config('variables.templateName', 'Apni Psychology') }}" style="margin-top:10px;height: {{ $height }}px; width: auto; max-width: 250px; background: transparent !important; object-fit: contain;" class="app-brand-logo">
