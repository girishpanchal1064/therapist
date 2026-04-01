@php
  /** @var int|null $height Max logo height (px). */
  /** @var int|null $maxWidth Max logo width (px); keeps sidebar/nav layouts from overflowing. */
  $logoHeight = isset($height) ? (int) $height : 36;
  $logoMaxWidth = isset($maxWidth) ? (int) $maxWidth : 220;
@endphp
<img src="{{ asset('assets/img/logo/APNIPSYCHOLOGY-(dark).png') }}" alt="{{ config('variables.templateName', 'Apni Psychology') }}"
     style="display: block; max-height: {{ $logoHeight }}px; max-width: min(100%, {{ $logoMaxWidth }}px); width: auto; height: auto; margin-top: 0; background: transparent !important; object-fit: contain;"
     class="app-brand-logo">
