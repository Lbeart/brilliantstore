@php
  $businessId = url('/').'#localbusiness';
  $businessSchema = [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'WebSite',
        '@id' => url('/').'#website',
        'name' => 'B-Brillant',
        'url' => url('/'),
        'inLanguage' => ['sq-XK', 'en', 'sr'],
        'publisher' => ['@id' => $businessId],
      ],
      [
        '@type' => 'LocalBusiness',
        '@id' => $businessId,
        'name' => 'B-Brillant',
        'description' => 'Tepiha, perde dhe tekstil për shtëpi nga dyqani B-Brillant në Lipjan, Kosovë.',
        'url' => url('/'),
        'image' => asset('images/home/hero-luxury-curtains.jpg'),
        'logo' => asset('images/brillant.png'),
        'telephone' => '+383 44 960 661',
        'email' => 'leart.bytyqii98@gmail.com',
        'address' => [
      '@type' => 'PostalAddress',
      'streetAddress' => 'Rruga Gjergj Fishta',
      'postalCode' => '14000',
      'addressLocality' => 'Lipjan',
      'addressCountry' => 'XK',
        ],
        'geo' => [
      '@type' => 'GeoCoordinates',
      'latitude' => 42.522523,
      'longitude' => 21.121330,
        ],
        'areaServed' => [
      '@type' => 'Country',
      'name' => 'Kosovo',
        ],
        'contactPoint' => [
      '@type' => 'ContactPoint',
      'telephone' => '+383 44 960 661',
      'contactType' => 'customer service',
      'availableLanguage' => ['Albanian', 'English', 'Serbian'],
        ],
      ],
    ],
  ];
@endphp
<script type="application/ld+json">{!! json_encode($businessSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
