@extends('dosen.layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="" class="logo d-flex align-items-center w-auto">
                                <span class="d-none d-lg-block">Siakad Battuta</span>
                            </a>
                        </div><!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                    <p class="text-center small">Masukkan NIDN dan Password untuk memulai</p>
                                </div>

                                <form class="row g-3 needs-validation" method="POST"
                                    action="{{ route('dosen.login.submit') }}">
                                    @csrf
                                    <div class="col-12">
                                        <label for="nidn" class="form-label">NIDN</label>
                                        <div class="input-group has-validation">
                                            <input type="text" name="nidn" class="form-control" id="nidn"
                                                value="{{ old('nidn') }}" required>
                                            <div class="invalid-feedback">Please enter your NIDN.</div>
                                        </div>
                                        @error('nidn')
                                            <span>{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="password" required>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                        @error('password')
                                            <span>{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Login</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
@endsection
