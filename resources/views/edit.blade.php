@extends('DashboardModule::base')

@section('title','Dashboard')

@section('stylesheets')
    <link rel="stylesheet" href="{{ mix('vendor/css/CityModule.css','') }}">
@endsection

@section('sidebar')
    @include('DashboardModule::sidebar.index', ['menu' => Selene\Support\Facades\MenuRepository::getPresences()])
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('DashboardModule::partials.alerts')

                        <h4 class="card-title">
                            {{ isset($city) ? 'Edytowanie' : 'Dodawanie nowego' }} miasta
                        </h4>
                        <form method="POST" action="{{ isset($city) ? route('CityModule::update', ['city' => $city]) : route('CityModule::store') }}" enctype="multipart/form-data">
                            @csrf
                            @if (isset($city))
                                @method('PUT')
                            @endif

                            <div class="d-flex justify-content-center">
                                <div class="form-group @error('name') has-danger @enderror col-12">
                                    <label for="">Nazwa</label>
                                    <input type="text" class="form-control" name="name" placeholder="Wpisz nazwe" value="{{ isset($city) ? $city->name : old('name') }}">
                                    @error('name')
                                        <small class="error mt-1 text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="float-right mt-2 btn btn-success mr-2">Zapisz</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
