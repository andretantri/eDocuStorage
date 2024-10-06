@extends('layouts.auth')

@section('title', 'Login Admin ')

@section('konten')
    <div class="bg-image" style="background-image: url('{{ asset('assets/media/photos/photo9@2x.jpg') }}');">
        <div class="row g-0 justify-content-center bg-black-75">
            <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                <!-- Lock Block -->
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
                        </div>
                        <form class="js-validation-lock" action="{{ route('login.submit') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <div class="input-group input-group-lg">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Email" autofocus required>
                                    <span class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-0">
                                <div class="input-group input-group-lg">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Password.."
                                        autocomplete="current-password">
                                    <span class="input-group-text">
                                        <i class="fa fa-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-1">
                                <div class="input-group input-group-lg">
                                    <div class="g-recaptcha mt-4" data-sitekey={{ config('services.recaptcha.key') }}></div>
                                </div>
                            </div>

                            @if (count($errors) > 0)
                                @foreach ($errors->all() as $message)
                                    <div class="alert alert-danger" role="alert">
                                        <p class="mb-0">{{ $message }}</p>
                                    </div>
                                @endforeach
                            @endif

                            <div class="text-center mb-0">
                                <button type="submit" class="btn btn-hero btn-primary">
                                    <i class="fa fa-fw fa-sign-in opacity-50 me-1"></i> Login
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="block-content block-content-full text-center bg-body-light">
                        <small class="text-muted">
                            Politeknik Indonusa Surakarta © 2024
                        </small>
                    </div>
                    <!-- END Footer -->
                </div>
                <!-- END Lock Block -->
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script async src="https://www.google.com/recaptcha/api.js"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
