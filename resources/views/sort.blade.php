@extends('DashboardModule::dashboard.index', ['title' => 'Sortuj miasta'])

@section('navbar-actions')
    <b-nav-form>
        <b-button size="sm" class="my-2 my-sm-0" type="button" to="{{ route('CityModule::index') }}">
            <b-icon-arrow-left></b-icon-arrow-left> Do listy
        </b-button>
    </b-nav-form>
@endsection

@section('content')
    <b-container fluid>
        <sort
            :cities="{{ json_encode($cities) }}"
            csrf="{{ csrf_token() }}"
            route="{{ route('CityModule::api.sort') }}"
        >
        </sort>
    </b-container>
@endsection

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ mix('vendor/css/CityModule.css') }}">
@endsection

@section('javascripts')
    <script src="{{ mix("vendor/js/CityModule.js") }}"></script>
@endsection