@extends('DashboardModule::dashboard.index', ['title' => 'Miasta'])

@section('navbar-actions')
    <b-nav-form>
        <b-button size="sm" class="my-2 my-sm-0" type="button" variant="success" to="{{ route('CityModule::create') }}">
            <b-icon-plus></b-icon-plus> Dodaj
        </b-button>
    </b-nav-form>
    <b-nav-form>
        <b-button size="sm" class="my-2 my-sm-0" type="button" variant="primary" to="{{ route('CityModule::sort') }}">
            <b-icon-sort-down></b-icon-sort-down> Sortuj
        </b-button>
    </b-nav-form>
@endsection

@section('content')
    <b-container fluid>
        <index
                route="{{ route('CityModule::api.cities') }}"
                edit-route="{{ route('CityModule::edit', ['city' => 'id']) }}"
                remove-route="{{ route('CityModule::api.remove', ['city' => 'id']) }}"
                csrf="{{ csrf_token() }}"
        >
        </index>
    </b-container>
@endsection

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ mix('vendor/css/CityModule.css') }}">
@endsection

@section('javascripts')
    <script src="{{ mix("vendor/js/CityModule.js") }}"></script>
@endsection