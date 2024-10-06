@extends('layouts.auth')

@section('title', 'Register')

@section('konten')
    <div class="bg-image" style="background-image: url('{{ asset('assets/media/photos/photo9@2x.jpg') }}');">
        <div class="row g-0 justify-content-center bg-black-75">
            <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                <!-- Register Block -->
                <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                    <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-body-extra-light">
                        <!-- Header -->
                        <div class="mb-2 text-center">
                            <!-- Logo -->
                            <img src="{{ asset('logo-polinus.png') }}" alt="Logo" class="img-fluid mb-3"
                                style="max-height: 150px;">
                            <!-- Title -->
                            <a class="link-fx fw-bold fs-1" href="#">
                                <span class="text-dark">eDocu</span><span class="text-primary">Storage</span>
                            </a>
                            <p>Silahkan Daftar untuk Membuat Akun</p>
                        </div>
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <div class="input-group input-group-lg">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Name" value="{{ old('name') }}"
                                        required>
                                    <span class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="input-group input-group-lg">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Email" value="{{ old('email') }}"
                                        required>
                                    <span class="input-group-text">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="input-group input-group-lg">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Password" required>
                                    <span class="input-group-text">
                                        <i class="fa fa-eye" id="togglePassword"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="input-group input-group-lg">
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation"
                                        placeholder="Confirm Password" required>
                                    <span class="input-group-text">
                                        <i class="fa fa-eye" id="togglePassword2"></i>
                                    </span>
                                </div>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <p class="mb-0">{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif

                            <div class="text-center mb-2">
                                <button type="submit" class="btn btn-hero btn-primary">
                                    <i class="fa fa-fw fa-user-plus opacity-50 me-1"></i> Register
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Register Block -->
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const togglePassword2 = document.querySelector('#togglePassword2');
        const password = document.querySelector('#password');
        const password2 = document.querySelector('#password_confirmation');

        togglePassword.addEventListener('click', function(e) {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        togglePassword2.addEventListener('click', function(e) {
            // Toggle the type attribute
            const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
            password2.setAttribute('type', type);

            // Toggle the icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
