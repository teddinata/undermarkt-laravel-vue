@extends('layouts.admin')

@section('title')
    Undermarkt Dashboard
@endsection

@section('content')
        <div
        class="section-content section-dashboard-home"
        data-aos="fade-up"
        >
        <div class="container-fluid">
            <div class="dashboard-heading">
            <h2 class="dashboard-title">Admin Dashboard</h2>
            <p class="dashboard-subtitle">
                Undermarkt Administrator
            </p>
            </div>
            <div class="dashboard-content">
            <div class="row">
                <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-body">
                    <div class="dashboard-card-title">
                        Jumlah Customer
                    </div>
                    <div class="dashboard-card-subtitle">
                        {{$customer}}
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-body">
                    <div class="dashboard-card-title">
                        Revenue / Jumlah Pendapatan
                    </div>
                    <div class="dashboard-card-subtitle">
                        {{'Rp ' . number_format($revenue, 0, ".", "." )}}
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-body">
                    <div class="dashboard-card-title">
                        Jumlah Transaksi
                    </div>
                    <div class="dashboard-card-subtitle">
                         {{$transaction}}
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 mt-2">
                <h5 class="mb-3">Recent Transactions</h5>
              @foreach ($all_transaction as $all)
              <a
              class="card card-list d-block"
              href="/dashboard-transactions-details.html"
          >
              <div class="card-body">
              <div class="row">
                  <div class="col-md-1">
                  <img
                      src="{{ Storage::url($all->product->galleries->first()->photos ?? '') }}"
                     class="w-75"
                  />
                  </div>
                  <div class="col-md-3">
                  {{ $all->product->name }}
                  </div>
                  <div class="col-md-3">
                  {{ $all->product->user->name }}
                  </div>
                  <div class="col-md-3">
                    {{ $all->product->user->phone_number }}
                    </div>
                  <div class="col-md-2">
                  {{ $all->created_at }}
                  </div>
                  <div class="col-md-1 d-none d-md-block">
                  {{-- <img
                      src="/images/dashboard-arrow-right.svg"
                      alt=""
                  /> --}}

                  </div>
              </div>
              </div>
          </a>
              @endforeach
              {{-- {{ $all->transaction->links() }} --}}

                </div>
            </div>
            </div>
        </div>
        </div>
@endsection
