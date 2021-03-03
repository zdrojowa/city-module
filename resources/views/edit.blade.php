@extends('DashboardModule::dashboard.index', ['title' => (isset($city) ? 'Edytowanie' : 'Dodawanie') . ' miasta'])

@section('navbar-actions')
    <b-nav-form>
        <b-button size="sm" class="my-2 my-sm-0" type="button" to="{{ route('CityModule::index') }}">
            <b-icon-arrow-left></b-icon-arrow-left> Do listy
        </b-button>
    </b-nav-form>
@endsection

@section('content')
    <b-container fluid>
        <city-tab
                :city="{{ isset($city) ? json_encode($city) : json_encode(null) }}"
                :languages="{{ json_encode($langs) }}"
                csrf="{{ csrf_token() }}"
                route="{{ isset($city) ? route('CityModule::api.update', ['city' => $city]) : route('CityModule::api.store') }}"
                media-search-route="{{ route('MediaModule::api.files') }}"
                media-route='/media/'
                check-route="{{ route('CityModule::api.check') }}"
        >
        </city-tab>
    </b-container>
@endsection

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ mix('vendor/css/MediaModule.css') }}">
    <link rel="stylesheet" href="{{ mix('vendor/css/CityModule.css') }}">
@endsection

@section('javascripts')
    <script src="{{ mix("vendor/js/CityModule.js") }}"></script>
@endsection
