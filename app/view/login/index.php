<?php Flasher::Flash() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="bg-cover bg-center min-h-screen flex items-center justify-center" 
      style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200'); 
             background-color: rgba(139, 92, 113, 0.7); background-blend-mode: multiply;">
    
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md md:h-full sm:h-full">
        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <div class="flex items-start justify-start mb-3">
                <img src="/img/LOGO PNJ FIX 1.png" alt="Logo" class="w-auto h-10 mr-2">
                <h1 class="text-4xl font-bold text-gray-800">ruanginPNJ</h1>
            </div>
            <p class="text-sm text-left  text-gray-600">Temukan, pinjam, dan nikmati fasilitas favortimu dengan mudah.</p>
        </div>

        <!-- Form -->
        <form id="loginForm" method="POST" action="/auth/handleLogin">
            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" placeholder="Input email" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="••••••••"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                        <i class="fas fa-eye hover:cursor-pointer" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="p-4 border border-gray-300 rounded-lg bg-gray-100 text-center">
                <img src="/auth/captchaImage?v=<?php echo microtime(true); ?>" 
                     alt="Kode Captcha" 
                     class="mx-auto border border-gray-400 rounded">
                
                <small class="text-gray-500">Masukkan kode di atas</Hsmall>
            </div>

            <div class="mb-4 mt-4">
                <!-- <label class="block text-sm font-medium text-gray-700 mb-2">Captcha</label> -->
                <input type="captcha" id="captcha" name="captcha" placeholder="Input captcha" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Links Row -->
            <div class="flex items-center justify-between mb-4 text-sm">
                <div>
                    <span class="text-gray-600">Belum punya akun? </span>
                    <a href="/auth/registerForm" class="text-blue-600 hover:underline font-medium">Registrasi</a>
                </div>
                <a href="#" class="text-blue-600 hover:underline font-medium">Lupa Password?</a>
            </div>

            <!-- Remember Me -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Ingat Saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-gradient-to-r from-green-400 to-green-500 text-white py-3 text-sm rounded-lg font-semibold hover:from-green-500 hover:to-green-600 transition duration-200 shadow-lg hover:cursor-pointer">
                Login - Explore Ruangan Sekarang
            </button>

            <!-- Booking Ruang Rapat Link -->
            <div class="text-center mt-4">
                <a href="../Ruang Rapat/index.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition duration-200">
                    Booking Ruang Rapat
                </a>
            </div>
        </form>
    </div>

    <!-- JavaScript -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>