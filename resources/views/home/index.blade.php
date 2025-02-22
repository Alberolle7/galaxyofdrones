@extends('layouts.stage')

@section('content')
    @include('partials.navigation')

    <router-view :width="1920"
                 :height="1080"
                 background-texture="{{ asset('images/planet-__resource__-bg.png') }}"
                 grid-texture-atlas="{{ mix('images/sprite-grid.png') }}"
                 :size="{{ Koodilab\Starmap\Generator::SIZE }}"
                 :max-zoom="{{ Koodilab\Starmap\Renderer::MAX_ZOOM_LEVEL }}"
                 geo-json-url="{{ route('api_starmap_geo_json', ['__zoom__', '__bounds__']) }}"
                 tile-url="{{ asset('tile/{z}/{x}/{y}.png') }}"
                 image-path="{{ asset('images') }}"
                 zoom-in-title="{{ __('messages.zoom_in') }}"
                 zoom-out-title="{{ __('messages.zoom_out') }}"
                 bookmark-title="{{ __('messages.bookmark.plural') }}"></router-view>

    @include('partials.construction')
    @include('partials.upgrade')
    @include('partials.upgrade-all')
    @include('partials.demolish')
    @include('partials.bookmark')
    @include('partials.move')
    @include('partials.planet')
    @include('partials.star')
@endsection
