@extends('layouts.app')

@section('title')
    Undermarkt - Cart
@endsection

@section('content')
    <div class="page-content page-cart">
      <section
        class="store-breadcrumbs"
        data-aos="fade-down"
        data-aos-delay="100"
      >
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Cart
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <section class="store-cart">
        <div class="container">
          <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12 table-responsive">
              <table
                class="table table-borderless table-cart"
                aria-describedby="Cart"
              >
                <thead>
                  <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Name &amp; Seller</th>
                    <th scope="col">Price</th>
                    <th scope="col">Menu</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $totalPrice = 0
                    @endphp
                 @foreach ($cart as $cart)
                 <tr>
                    @if ($cart->product->galleries)
                        <td style="width: 25%;">
                            <img
                            src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                            alt=""
                            class="cart-image"
                            />
                        </td>
                    @endif
                    <td style="width: 35%;">
                      <div class="product-title">{{ $cart->product->name }}</div>
                      <div class="product-subtitle">by {{ $cart->user->store_name }}</div>
                    </td>
                    <td style="width: 35%;">
                      <div class="product-title">{{'Rp ' . number_format($cart->product->price, 0, ".", "." )}}</div>
                      <div class="product-subtitle">Rupiah</div>
                    </td>
                    <td style="width: 20%;">
                        <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-remove-cart">
                                Remove
                            </button>
                        </form>

                    </td>
                  </tr>
                  @php
                      $totalPrice += $cart->product->price
                  @endphp
                 @endforeach

                </tbody>
              </table>
            </div>
          </div>
          <div class="row" data-aos="fade-up" data-aos-delay="150">
            <div class="col-12">
              <hr />
            </div>
            <div class="col-12">
              <h2 class="mb-4">Shipping Details</h2>
            </div>
          </div>
          <form action="{{ route('checkout') }}" id="locations"
                enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" name="total_price" value="{{ $totalPrice }}">
            <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="address_one">Alamat Lengkap</label>
                    <input
                      type="text"
                      class="form-control"
                      id="address_one"
                      aria-describedby="emailHelp"
                      name="address_one"
                      value=""
                      placeholder="Jl. Perintis Kemerdekaan No. 1"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="address_two">Alamat Pendukung</label>
                    <input
                      type="text"
                      class="form-control"
                      id="address_two"
                      aria-describedby="emailHelp"
                      name="address_two"
                      value=""
                      placeholder="Contoh: RT 001 RW 001 Rumah warna biru dekat pasar"
                    />
                  </div>
                </div>
                {{-- API Aziz  --}}
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="provinces_id">Provinsi</label>
                    <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces" v-model="provinces_id">
                      <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                    </select>
                    <select  v-else class="form-control"></select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="regencies_id">Kabupaten</label>
                    <select name="regencies_id" id="regencies_id" class="form-control" v-if="regencies" v-model="regencies_id">
                      <option v-for="regency in regencies" :value="regency.id">@{{ regency.name }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="districts_id">Kecamatan / Kota</label>
                        <select name="districts_id" id="districts_id" class="form-control" v-if="districts" v-model="districts_id">
                        <option v-for="district in districts" :value="district.id">@{{ district.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="villages_id">Kelurahan</label>
                        <select name="villages_id" id="villages_id" class="form-control" v-if="villages" v-model="villages_id">
                        <option v-for="village in villages" :value="village.id">@{{ village.name }}</option>
                        </select>
                    </div>
                </div>

                {{-- API RajaOngkir --}}
                {{-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="provinces_id">Provinsi</label>
                      <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces" v-model="provinces_id">
                        <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                      </select>
                      <select  v-else class="form-control"></select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="regencies_id">Kabupaten</label>
                      <select name="regencies_id" id="regencies_id" class="form-control" v-if="provinces" v-model="regencies_id">
                        <option v-for="city in regencies" :value="city.id">@{{ city.name }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="courier">Kurir Pengiriman</label>
                      <select name="cost" :id="value.service" class="form-control" v-model="courier_type">
                        <option value="jne">JNE</option>
                      </select>
                    </div>
                  </div> --}}
                  {{-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="courier">Service Kurir</label>
                      <select name="courier" id="courier" class="form-control" :value="value.cost[0].value+'|'+value.service" v-model="state.costService">
                        <option v-for="value in service">{{ value.service }} - Rp. {{ moneyFormat(value.cost[0].value) }}</option>
                      </select>
                    </div>
                  </div> --}}

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="zip_code">Kode Pos</label>
                    <input
                      type="text"
                      class="form-control"
                      id="zip_code"
                      name="zip_code"
                      value=""
                    placeholder="Kode Pos wilayah anda"
                    />
                  </div>
                </div>
                {{-- <div class="col-md-4">
                  <div class="form-group">
                    <label for="country">Country</label>
                    <input
                      type="text"
                      class="form-control"
                      id="country"
                      name="country"
                      value="Indonesia"
                    />
                  </div>
                </div> --}}
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone_number">No. Handphone</label>
                    <input
                      type="text"
                      class="form-control"
                      id="phone_number"
                      name="phone_number"
                      value=""
                      placeholder="+628 2020 11111"
                    />
                  </div>
                </div>
              </div>
              <div class="row" data-aos="fade-up" data-aos-delay="150">
                <div class="col-12">
                  <hr />
                </div>
                <div class="col-12">
                  <h2>Payment Informations</h2>
                </div>
              </div>
              <div class="row" data-aos="fade-up" data-aos-delay="200">
                @php
                    // count tax
                    $tax = $totalPrice * (11 / 100);
                    $asuransi = $totalPrice * (0.2 / 100);
                    $ongkir = 10000;
                @endphp
                <div class="col-4 col-md-2">
                    <div class="product-title">{{'Rp' . number_format($totalPrice ?? 0, 0, ".", "." ) }}</div>
                    <div class="product-subtitle">Total</div>
                </div>
                <div class="col-4 col-md-2">
                  <div class="product-title">{{'Rp' . number_format($tax ?? 0, 0, ".", "." ) }}</div>
                  <div class="product-subtitle">PPN (11%)</div>
                </div>
                <div class="col-4 col-md-2">
                  <div class="product-title">{{ 'Rp' . number_format($asuransi ?? 0, 0, ".", "." )  }}</div>
                  <div class="product-subtitle">Asuransi (0,2%)</div>
                </div>
                <div class="col-4 col-md-2">
                  <div class="product-title">{{'Rp' . number_format($ongkir ?? 0, 0, ".", "." )}}</div>
                  <div class="product-subtitle">Ongkos Kirim</div>
                </div>
                <div class="col-4 col-md-2">
                  <div class="product-title text-success">{{'Rp' . number_format($totalPrice + $tax + $asuransi + $ongkir ?? 0, 0, ".", "." ) }}</div>
                  <div class="product-subtitle">Grand Total</div>
                </div>
                <div class="col-lg-2 col-md-12">
                  <button
                    type="submit"
                    class="btn btn-success mt-2 px-4 btn-block"
                  >
                    Checkout Sekarang
                  </button>
                </div>
              </div>
          </form>
        </div>
      </section>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      var locations = new Vue({
        el: "#locations",
        mounted() {
            this.getProvincesData();
          AOS.init();
        },
        data: {
            provinces: null,
            regencies: null,
            districts: null,
            villages: null,
            provinces_id: null,
            regencies_id: null,
            districts_id: null,
            villages_id: null,
            courier: null,
            courier_type: ''
        },
        methods: {
            getProvincesData() {
                var self = this;
                axios.get('{{ route('api-provinces') }}' )
                    .then(function(response){
                        self.provinces = response.data;
                    })
            },
            getRegenciesData(){
                var self = this;
                axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
                    .then(function(response){
                        self.regencies = response.data;
                    })
            },
            // get districts data
            getDistrictsData(){
                var self = this;
                axios.get('{{ url('api/districts') }}/' + self.regencies_id)
                    .then(function(response){
                        self.districts = response.data;
                    })
            },
            // get villages data
            getVillagesData(){
                var self = this;
                axios.get('{{ url('api/villages') }}/' + self.districts_id)
                    .then(function(response){
                        self.villages = response.data;
                    })
            },

            // getProvincesData() {
            //     var self = this;
            //     axios.get('{{ route('customer.rajaongkir.getProvinces') }}' )
            //         .then(function(response){
            //             self.provinces = response.data.data;
            //         })
            // },
            // getRegenciesData(provinces_id){
            //     var self = this;
            //     // axios.get('{{ url('api/rajaongkir/cities') }}/' + self.province_id)
            //     axios.get(`api/rajaongkir/cities?province_id=${this.provinces_id}`)
            //         .then(function(response){
            //             self.regencies = response.data.data;
            //         })
            // },
            // getCouriersData(){
            //     var self = this;
            //     self.courier = true
            // },
            // // get ongkir
            // getOngkirData(){
            //     var self = this;
            //     axios.post(`api/rajaongkir/checkOngkir?city_destination=${this.regencies_id}&weight=1700&courier_type=${this.courier}`)
            //         .then(function(response){
            //             self.ongkir = response.data.data;
            //         })
            // },
        },
        watch: {
            provinces_id: function(val, oldVal){
                this.regencies_id = null;
                this.getRegenciesData(provinces_id);
            },
            regencies_id: function(val, oldVal){
                this.districts_id = null;
                this.getDistrictsData();
            },
            districts_id: function(val, oldVal){
                this.villages_id = null;
                this.getVillagesData();
            },
        }
      });

    </script>
@endpush
