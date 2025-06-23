<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <title>UnitC - Reset Password</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login_register.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center ">
            <div class="col-8 col-md-8 p-5">
                <div class="row d-flex justify-content-center ">
                    <div class="col-12 col-md-8 backgroundcolor p-3 ">
                        <p class="text-center unit m-0">Unit<img src="{{ asset('images/logo.png') }}"
                                class="imagesize ms-2 pb-2" alt="...">
                        </p>
                        <div class="row d-flex justify-content-center ">
                            <div class="col-12 col-md-8 pe-0">
                                <P class="forgetsec">Reset Password?</P>
                                <form action="{{ route('password.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ request()->route('token') }}">
                                    <input type="hidden" name="email" value="{{ request()->query('email') }}">

                                    <div class="mb-3 password-toggle">
                                        <div style="position: relative;">
                                            <label class="label mb-2">Password</label><br>
                                            <input type="password" name="password" id="passwordInput"
                                                class="full-width-input mb-2" placeholder="Enter New Password" required>
                                            <span class="toggle-password"
                                                style="position: absolute; top: 42%; right: 25px; transform: translateY(-50%); cursor: pointer;">
                                                <i class="fa fa-eye-slash" id="togglePasswordIcon"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 password-toggle">
                                        <div style="position: relative;">
                                            <label class="label mb-2">Confirm Password</label><br>
                                            <input type="password" name="password_confirmation"
                                                id="confirmPasswordInput" class="full-width-input mb-2"
                                                placeholder="Confirm New Password" required>
                                            <span class="toggle-password"
                                                style="position: absolute; top: 42%; right: 25px; transform: translateY(-50%); cursor: pointer;">
                                                <i class="fa fa-eye-slash" id="toggleConfirmPasswordIcon"></i>
                                            </span>
                                        </div>
                                        @error('password_confirmation')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between mt-3 displlay">
                                        <x-loading-button id="updatePasswordBtn" text="Update Password" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
</body>

</html>
