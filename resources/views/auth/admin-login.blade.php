<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Gari Bondhu</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body { background-color: #f8f9fa; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow border-0" style="width: 400px;">
        <div class="card-body p-5">
            <h3 class="text-center fw-bold mb-4">Admin Login</h3>            <form action="{{ route('admin.login') }}" method="POST" class="no-confirm">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', 'admin@rentacar.com') }}" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" value="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Login</button>
            </form>
        </div>
    </div>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if($errors->any())
                let errorHtml = '<ul class="text-start mb-0">';
                @foreach($errors->all() as $error)
                    errorHtml += '<li>{{ $error }}</li>';
                @endforeach
                errorHtml += '</ul>';
                
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorHtml,
                    showConfirmButton: true,
                    confirmButtonColor: '#fff',
                    background: '#dc3545',
                    color: '#fff',
                    iconColor: '#fff',
                    customClass: { confirmButton: 'btn btn-outline-light' },
                    showClass: { popup: 'animate__animated animate__shakeX' }
                });
            @endif
        });
    </script>
</body>
</html>
