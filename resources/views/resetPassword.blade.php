<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="antialiased">
        <div class="relative flex justify-center items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

            <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex flex-col  gap-4 motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500 m-8" style="margin:2rem">
                <div class="flex items-center gap-6">
                    <!-- ICONO -->
                    <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ef4444"><path d="M280-400q-33 0-56.5-23.5T200-480q0-33 23.5-56.5T280-560q33 0 56.5 23.5T360-480q0 33-23.5 56.5T280-400Zm0 160q-100 0-170-70T40-480q0-100 70-170t170-70q67 0 121.5 33t86.5 87h352l120 120-180 180-80-60-80 60-85-60h-47q-32 54-86.5 87T280-240Zm0-80q56 0 98.5-34t56.5-86h125l58 41 82-61 71 55 75-75-40-40H435q-14-52-56.5-86T280-640q-66 0-113 47t-47 113q0 66 47 113t113 47Z"/></svg>
                    </div>
                    <!-- TITULO -->
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Reset Password</h2>
                </div>

                <div class="flex items-center">
                    <!-- DESCRIPCION -->
                    <p class=" text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        Enter the new password
                    </p>
                </div>
                <form class="flex flex-col gap-4" action="/api/reset" method="post">
                    <input class="rounded py-1 px-3" name="password" type="password" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,20}$" title="Between 8-20 characters, Min one Uppercase , Min one Lowercase , Min one Number">
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed"> Confirm password</p>
                    <input class="rounded py-1 px-3" name="password_confirmation" required type="password">
                    <input name="id" value={{$id}} type="hidden">
                    <button class="bg-red-800/20 border-2 border-red-500 text-red-500 font-semibold rounded-md px-4 py-2">Reset Password</button>
                </form>
            </div>
        </div>

        
</body>
</html>