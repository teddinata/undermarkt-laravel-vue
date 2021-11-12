@extends('layouts.laravel-default')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Link verifikasi baru saja dikirim ke email anda.') }}
                        </div>
                    @endif

                    {{ __('Sebelum Belanja Anda diproses, mohon verifikasikan email anda.') }}
                    {{ __('Jika anda tidak menerima email,') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('klik disini untuk request lagi.') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
