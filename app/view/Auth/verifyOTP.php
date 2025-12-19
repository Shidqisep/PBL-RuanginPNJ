
<?php Flasher::Flash() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/LOGO PNJ FIX 1.png">
    <title>Lupa Password</title>
    <link href="/css/output.css" rel="stylesheet">

</head>
<body class="font-sf-pro" >
    
    
    <div class="bg-cover bg-center min-h-screen flex flex-col items-center justify-center p-4"
         style="background-image: url('/img/Background 1.png');">

       

        <!-- **************************************************
        INI UNTUK BAGIAN KEDUA YANG UNTUK MENGISI KODE VERIFIKASI
        ******************************************************* -->
        <div class="bg-[#F3F5FA] rounded-2xl shadow-2xl p-8 w-full max-w-md md:h-full sm:h-full mb-5 mt-10">
            <!-- Logo & Header -->
            <div class="text-center mb-6">
                <div class="flex items-start justify-start mb-1">
                    <h1 class="text-4xl font-bold text-gray-800">Verifikasi</h1>
                </div>
                <p class="text-sm text-left text-gray-600">Masukkan kode yang sudah dikirim di email yang kamu berikan</p>
            </div>

            <!-- Form -->
            <form id="" method="POST" action="">
                <div class="flex justify-between lg:gap-3 gap-1 mb-6">
                <input type="text" maxlength="1" name = "otp-1" class="otp-input w-1/5 h-12 lg:h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-transparent transition duration-150" inputmode="numeric">
                <input type="text" maxlength="1" name = "otp-2" class="otp-input w-1/5 h-12 lg:h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-transparent transition duration-150" inputmode="numeric">
                <input type="text" maxlength="1" name = "otp-3" class="otp-input w-1/5 h-12 lg:h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-transparent transition duration-150" inputmode="numeric">
                <input type="text" maxlength="1" name = "otp-4" class="otp-input w-1/5 h-12 lg:h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-transparent transition duration-150" inputmode="numeric">
                <input type="text" maxlength="1" name = "otp-5" class="otp-input w-1/5 h-12 lg:h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-transparent transition duration-150" inputmode="numeric">
                <input type="text" maxlength="1" name = "otp-6" class="otp-input w-1/5 h-12 lg:h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-blue-500 focus:border-transparent transition duration-150" inputmode="numeric">
            </div>

            <div class="text-center text-red-600 font-semibold mb-6" id="timer">
                09:55
            </div>
                <!-- Submit Button -->
                <button type="submit" class="w-full bg-green1 text-white py-2 text-sm rounded-lg font-semibold hover:bg-green-600 transition duration-200 hover:cursor-pointer mb-2">
                    Verifikasi
                </button>
            </form>

            <div class="flex flex-col items-start justify-between text-xs gap-4 mt-4">
                <div>
                    <span class="text-gray-600">Tidak mendapatkan kode? </span>
                    <a href="/auth/resendOTP" id="resendLink" class="text-blue-600 hover:underline font-medium disabled:opacity-50">Kirim ulang kode</a>
                </div>

                <div>
                    <span class="text-gray-600">Email salah? </span>
                    <a href="/Auth/forgetPassword" class="text-blue-600 hover:underline font-medium">Masukkan ulang Email</a>
                </div>
            </div>
        </div>

        <!-- **************************************************
        POP UP SUCCESS MODAL
        ******************************************************* -->
        <div id="successModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl p-8 w-full max-w-sm mx-4 text-center border border-[#8E97A6]">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-green-500 text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Ganti Password Berhasil</h3>
                <p class="text-sm text-gray-600 mb-6">Kamu berhasil mengganti password!</p>
                <button type="button" onclick="window.location.href='/auth/formLogin'"
                        class="w-full px-6 py-2 bg-green1 text-white rounded-lg font-semibold hover:bg-green-600 transition hover:cursor-pointer text-sm">
                    Kembali ke halaman Login
                </button>
            </div>
        </div>
    </div>
    
    <script>
        (function(){
            // OTP inputs auto-focus and paste handling
            const inputs = Array.from(document.querySelectorAll('.otp-input'));
            const form = document.querySelector('form');

            inputs.forEach((input, idx) => {
                input.addEventListener('input', (e) => {
                    const v = e.target.value.replace(/[^0-9]/g,'');
                    if (!v) {
                        e.target.value = '';
                        return;
                    }
                    // If user pasted more than 1 char, distribute
                    if (v.length > 1) {
                        const chars = v.split('');
                        for (let i = 0; i < chars.length && (idx + i) < inputs.length; i++) {
                            inputs[idx + i].value = chars[i];
                        }
                        const nextIndex = Math.min(inputs.length - 1, idx + v.length);
                        if (inputs[nextIndex]) inputs[nextIndex].focus();
                        return;
                    }

                    e.target.value = v.slice(-1);
                    // move focus to next
                    if (v && inputs[idx + 1]) {
                        inputs[idx + 1].focus();
                        inputs[idx + 1].select && inputs[idx + 1].select();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    const key = e.key;
                    if (key === 'Backspace' && !e.target.value && inputs[idx - 1]) {
                        inputs[idx - 1].focus();
                        inputs[idx - 1].value = '';
                    }
                    if (key === 'ArrowLeft' && inputs[idx - 1]) {
                        inputs[idx - 1].focus();
                    }
                    if (key === 'ArrowRight' && inputs[idx + 1]) {
                        inputs[idx + 1].focus();
                    }
                });

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g,'');
                    if (!text) return;
                    for (let i = 0; i < text.length && (idx + i) < inputs.length; i++) {
                        inputs[idx + i].value = text[i];
                    }
                    const next = idx + text.length;
                    if (inputs[next]) inputs[next].focus();
                });
            });

            // Timer for resend (2 minutes)
            const TIMER_KEY = 'otp_timer_expiry';
            const DURATION = 2 * 60; // seconds
            const display = document.getElementById('timer');
            const resendLink = document.getElementById('resendLink');

            function setExpiry(secondsFromNow) {
                const expiry = Date.now() + secondsFromNow * 1000;
                try { sessionStorage.setItem(TIMER_KEY, expiry.toString()); } catch(e){}
                return expiry;
            }

            function getExpiry() {
                try { const v = sessionStorage.getItem(TIMER_KEY); return v ? parseInt(v,10) : null; } catch(e){ return null; }
            }

            function formatTime(s) {
                if (s < 0) s = 0;
                const m = Math.floor(s / 60).toString().padStart(2,'0');
                const sec = Math.floor(s % 60).toString().padStart(2,'0');
                return `${m}:${sec}`;
            }

            function enableResend() {
                resendLink.dataset.disabled = 'false';
                resendLink.classList.remove('opacity-50');
                resendLink.classList.add('text-blue-600');
                display.textContent = '00:00';
            }

            function disableResend() {
                resendLink.dataset.disabled = 'true';
                resendLink.classList.add('opacity-50');
            }

            // Initialize expiry if not set
            let expiry = getExpiry();
            if (!expiry || expiry < Date.now()) {
                expiry = setExpiry(DURATION);
            }

            disableResend();

            const ticker = setInterval(() => {
                const now = Date.now();
                const remaining = Math.round((expiry - now) / 1000);
                if (remaining <= 0) {
                    enableResend();
                    clearInterval(ticker);
                    try { sessionStorage.removeItem(TIMER_KEY); } catch(e){}
                } else {
                    display.textContent = formatTime(remaining);
                }
            }, 250);

            // Resend click handler: only allowed when timer expired
            resendLink.addEventListener('click', function(e){
                if (this.dataset.disabled === 'true') {
                    e.preventDefault();
                    return;
                }
                // Start timer again and disable link
                expiry = setExpiry(DURATION);
                disableResend();
                // restart ticker
                const newTicker = setInterval(() => {
                    const now = Date.now();
                    const remaining = Math.round((expiry - now) / 1000);
                    if (remaining <= 0) {
                        enableResend();
                        clearInterval(newTicker);
                        try { sessionStorage.removeItem(TIMER_KEY); } catch(e){}
                    } else {
                        display.textContent = formatTime(remaining);
                    }
                }, 250);

                // Optional: call backend to actually resend OTP
                // fetch('/Auth/resendOtp', { method: 'POST' }).catch(()=>{});
                alert('Kode OTP dikirim ulang.');
            });

        })();
    </script>