<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Tailwind versi terbaru via CDN -->
    {{--
    <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite('resources/css/app.css')


    <style>
        /* Background Image + Blur */
        .background-body {
            position: relative;
            overflow: hidden;
        }

        .background-image {
            background-image: url('../assets/images/gdungjti.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(5px);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
        }

        /* Gray overlay */
        .gray-overlay {
            background-color: rgba(139, 178, 255, 0.2);
            /* Tailwind's gray-100 with opacity */
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* Your content */
        .content {
            position: relative;
            z-index: 10;
        }
    </style>
</head>


<body class="background-body">
    <!-- Background Image + Blur -->
    <div class="background-image"></div>

    <!-- Gray overlay -->
    <div class="gray-overlay"></div>

    <div class="min-h-screen text-gray-900 flex justify-center">
        <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
            <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">

                <div class="mt-12 flex flex-col items-center">
                    <h1 class="text-2xl xl:text-3xl font-extrabold">
                        Login
                    </h1>

                    <div class="w-full flex-1 mt-8">
                        <div>
                            <img src="../assets/images/logo-dbs-black.png" alt="Logo" class="w-32 mx-auto" />
                        </div>

                        <div class="my-12 border-b text-center">
                            <div
                                class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                                Log in using your account
                            </div>
                        </div>

                        <div class="mx-auto max-w-xs">

                            <form id="loginForm" onsubmit="return validateForm(event)"
                                action="{{ route('custom.login') }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <input id="identifier" name="identifier"
                                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                                        type="text" placeholder="NIM/NIP/Username" />
                                </div>
                                <p id="identifierError" class="text-red-500 text-sm mt-1 hidden">NIM/NIP/Username harus diisi.
                                </p>

                                <div class="relative w-full mt-5 mb-2">
                                    <input id="password" name="password"
                                        class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                                        type="password" placeholder="Password" />
                                    <button type="button" onclick="togglePassword()"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-600 focus:outline-none">
                                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                <p id="passwordError" class="text-red-500 text-sm mt-1 hidden">Password harus diisi.</p>

                                @if (session()->has('loginError'))
                                    <div id="alert-2"
                                        class="relative w-full mt-5 flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 transition-opacity duration-500 ease-in-out"
                                        role="alert">
                                        <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                        </svg>
                                        <span class="sr-only">Info</span>
                                        <div class="ms-3 text-sm font-medium">
                                            {{ session('loginError') }}
                                        </div>
                                        <button id="close-alert"
                                            class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"
                                            aria-label="Close">
                                            <span class="sr-only">Close</span>
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif


                                <button type="submit"
                                    class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                    <span class="ml-3">Log In</span>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 bg-indigo-100 text-center hidden lg:flex sm:rounded-r-lg">
                <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
                    style="background-image: url('https://storage.googleapis.com/devitary-image-host.appspot.com/15848031292911696601-undraw_designer_life_w96d.svg');">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const alertBox = document.getElementById("alert-2");
            const closeBtn = document.getElementById("close-alert");

            if (alertBox && closeBtn) {
                function fadeOutAndRemove() {
                    alertBox.classList.add("opacity-0");
                    setTimeout(() => {
                        alertBox.remove();
                    }, 500); // harus sesuai dengan transition duration (500ms)
                }

                // Klik manual
                closeBtn.addEventListener("click", fadeOutAndRemove);

                // Auto hilang dalam 7 detik (7000ms)
                setTimeout(fadeOutAndRemove, 7000);
            }
        });

        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.innerHTML = `
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.956 9.956 0 012.124-3.293M6.417 6.417A9.956 9.956 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.961 9.961 0 01-4.148 5.182M6.417 6.417L3 3m0 0l18 18" />
            `;
            } else {
                passwordInput.type = "password";
                eyeIcon.innerHTML = `
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
            }
        }

        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.classList.add('text-indigo-600');
            } else {
                password.type = 'password';
                eyeIcon.classList.remove('text-indigo-600');
            }
        }

        function validateForm(event) {
            event.preventDefault();

            const identifier = document.getElementById('identifier');
            const password = document.getElementById('password');
            const identifierError = document.getElementById('identifierError');
            const passwordError = document.getElementById('passwordError');

            let valid = true;

            // Reset error messages
            identifierError.classList.add('hidden');
            passwordError.classList.add('hidden');

            if (!identifier.value.trim()) {
                identifierError.classList.remove('hidden');
                valid = false;
            }

            if (!password.value.trim()) {
                passwordError.classList.remove('hidden');
                valid = false;
            }

            if (valid) {
                document.getElementById('loginForm').submit(); // Proceed with form submission
            }
        }
    </script>
</body>

</html>