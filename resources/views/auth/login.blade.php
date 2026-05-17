<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/033521daa8.js" crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="background-color: #D2E6D3; min-height: 100vh;">

    <div class="container py-5">

        <!-- Logo / Brand -->
        <div class="text-center mb-5">
            <h1
                class="fw-bold"
                style="
                    color: #355E3B;
                    letter-spacing: 1px;
                ">
                Finance Lens
            </h1>

            <p class="text-muted">
                Track your spending and visualize your goals
            </p>
        </div>

        <div class="row align-items-center justify-content-center g-5">

            <!-- FORM SIDE -->
            <div class="col-lg-5">

                <div
                    class="card border-0 shadow-lg rounded-4"
                    style="background-color: rgba(255,255,255,0.9);">

                    <div class="card-body p-4 p-lg-5">

                        <h2 class="fw-bold mb-2">
                            Login In Account
                        </h2>

                        <p class="text-muted mb-4">
                            Start managing your finances today
                        </p>

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control rounded-pill py-2 px-4"
                                    placeholder="Enter your email">
                                @error('email')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control rounded-pill py-2 px-4"
                                    placeholder="Enter your password">
                                @error('password')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button
                                type="submit"
                                class="btn w-100 rounded-pill text-white fw-bold py-2"
                                style="background-color: #649857;">

                                Log in

                            </button>

                        </form>

                    </div>
                </div>

                <p class="text-center mt-4">
                    Creat a new account?

                    <a
                        href="{{ route('register') }}"
                        class="text-decoration-none fw-bold"
                        style="color: #355E3B;">

                        Sign Up

                    </a>
                </p>

            </div>

        </div>

    </div>

</body>

</html>