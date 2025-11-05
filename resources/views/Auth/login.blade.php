<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Kasir | Bako Mart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #f8f9fa, #cce5ff);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
    }
    .login-card {
      background: #163e7d;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      width: 380px;
      padding: 30px;
    }
    .brand-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: #fff;
      text-align: center;
      margin-bottom: 10px;
    }
    .subtitle {
      text-align: center;
      font-size: 0.9rem;
      color: #fff;
      margin-bottom: 25px;
    }
    .form-label {
      color:#fff;
    }
    
    .btn-login {
      width: 100%;
      background-color: #007bff;
      color: white;
      font-weight: 500;
      transition: 0.3s;
    }
    .btn-login:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <div class="brand-title">Bako Mart</div>
    <div class="subtitle">Login untuk melanjutkan</div>

    @if (session('error'))
      <div class="alert alert-danger text-center py-2">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('kasir.login.post') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>

      <button type="submit" class="btn btn-login mt-2">Login</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
