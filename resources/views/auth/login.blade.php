<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-card {
            max-width: 400px; /* Ukuran kartu login */
            width: 100%;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Bayangan lembut */
            background-color: #ffffff; /* Warna latar kartu */
        }
        .logo img {
            max-width: 150px; /* Ukuran logo */
            height: auto; /* Jaga rasio logo */
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-card">
            <!-- Logo -->
            <div class="text-center mb-4">
                <img 
                    src="{{ asset('img/fiinventory.svg') }}" 
                    alt="Logo" 
                    class="img-fluid"
                >
            </div>

            @if (session('error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            <!-- Title -->
            <h2 class="text-center mb-4">Login</h2>

            <!-- Form -->
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Username Input -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        class="form-control" 
                        placeholder="Enter your username" 
                        required
                    >
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-control" 
                        placeholder="Enter your password" 
                        required
                    >
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="btn btn-primary w-100"
                >
                    Login
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
