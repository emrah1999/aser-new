@extends('web.layouts.web')
@section('content')
@if (session('case') === 'warning')
    <div class="alert alert-warning">
        <strong>{{ session('title') }}</strong>
        @if (is_array(session('content')))
            <ul>
                @foreach (session('content') as $field => $errors)
                    @foreach ($errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endforeach
            </ul>
        @else
            <p>{{ session('content') }}</p>
        @endif
    </div>
@endif

@if (session('case') === 'exist')
    <div class="alert alert-warning">
        <strong>{{ session('title') }}</strong>
        <p>{{ session('content') }}</p>
    </div>
@endif

@if (session('case') === 'success')
    <div class="alert alert-success">
        <strong>{{ session('title') }}</strong>
        <p>{{ session('content') }}</p>
    </div>
@endif

@if (session('case') === 'error')
    <div class="alert alert-danger">
        <strong>{{ session('title') }}</strong>
        <p>{{ session('content') }}</p>
    </div>
@endif
<div class="content" id="content">
    <section class="section section-profile-settings">
        <div class="container-lg">
            <div class="row">
                @include("web.account.account_left_bar")

            </div>
        </div>
    </section>
</div>
@endsection