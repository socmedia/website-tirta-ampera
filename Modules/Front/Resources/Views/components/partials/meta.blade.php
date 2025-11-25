@php
    $page_title = isset($title) ? ($title ?: getContent('seo.homepage.title')) : getContent('seo.homepage.title');
    $page_description = isset($description)
        ? ($description ?:
        getContent('seo.homepage.description'))
        : getContent('seo.homepage.description');
    $page_keywords = isset($keywords)
        ? ($keywords ?:
        getContent('seo.homepage.keywords'))
        : getContent('seo.homepage.keywords');
    $page_image = isset($image) ? ($image ?: getContent('seo.homepage.image')) : getContent('seo.homepage.image');
    $page_url = request()->fullUrl();
    $site_name = getSetting('site_name');
    $locale = app()->getLocale();
@endphp

@env('production')
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
@else
    <meta name="robots" content="noindex, nofollow">
@endenv

<!-- Primary Meta Tags -->
<meta name="description" content="{{ $page_description }}" />
<meta name="keywords" content="{{ $page_keywords }}" />
<link href="{{ $page_url }}" rel="canonical" />
<meta name="author" content="{{ $site_name }}">
<meta name="publisher" content="{{ $site_name }}">
<meta name="language" content="{{ $locale }}">
<meta name="distribution" content="global">
<meta name="rating" content="general">
<meta name="revisit-after" content="7 days">
<meta name="expires" content="never">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website" />
<meta property="og:site_name" content="{{ $site_name }}" />
<meta property="og:locale" content="{{ $locale }}" />
<meta property="og:url" content="{{ $page_url }}" />
<meta property="og:title" content="{{ $page_title }}" />
<meta property="og:description" content="{{ $page_description }}" />
<meta property="og:image" content="{{ $page_image }}" />

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@{{ str_replace(' ', '', strtolower($site_name)) }}">
<meta name="twitter:creator" content="@{{ str_replace(' ', '', strtolower($site_name)) }}">
<meta name="twitter:url" content="{{ $page_url }}" />
<meta name="twitter:title" content="{{ $page_title }}" />
<meta name="twitter:description" content="{{ $page_description }}" />
<meta name="twitter:image" content="{{ $page_image }}" />

<!-- Dublin Core Metadata for better crawling -->
<meta name="DC.title" content="{{ $page_title }}">
<meta name="DC.creator" content="{{ $site_name }}">
<meta name="DC.description" content="{{ $page_description }}">
<meta name="DC.language" content="{{ $locale }}">
<meta name="DC.publisher" content="{{ $site_name }}">
<meta name="DC.identifier" content="{{ $page_url }}">

<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ $page_title }}">
<meta itemprop="description" content="{{ $page_description }}">
<meta itemprop="image" content="{{ $page_image }}">
