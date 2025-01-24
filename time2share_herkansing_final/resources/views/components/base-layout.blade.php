<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/favicon.ico" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#4A90E2",  /* soft blue */
                        secondary: "#F1F1F1",  /* light gray */
                        accent: "#FF6F61",  /* coral red */
                        dark: "#2A2A2A",  /* dark gray */
                        lightGray: "#F7F7F7",  /* very light gray */
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        heading: ['Quicksand', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <title>Time2Share</title>
</head>

<body class="bg-lightGray text-dark font-sans leading-relaxed tracking-wide">

    <!-- Navigation Bar -->
    <nav class="bg-white shadow-lg px-8 py-6 fixed w-full z-10 top-0 left-0 border-b-2 border-primary">
        <div class="flex justify-between items-center max-w-screen-xl mx-auto">
            <a href="/" class="flex items-center space-x-3">
                <span class="text-3xl font-heading text-primary">Time2Share</span>
            </a>
            <div class="flex items-center space-x-8">

                <ul class="flex space-x-6 text-lg font-semibold">
                    @auth
                    @if(auth()->user()->blocked)
                        <!-- Show blocked account message, but still allow logout -->
                        <li>
                            <span class="text-red-500">Your account has been blocked.</span>
                        </li>
                    @else
                        <li>
                            <span class="text-primary">Hello, {{auth()->user()->name}}!</span>
                        </li>
                        <li>
                            <a href="/profile" class="hover:text-accent transition-colors"><i class="fa-solid fa-user"></i> Profile</a>
                        </li>
                    @endif
                    <!-- Always show logout button -->
                    <li>
                        <form class="inline" method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="text-primary hover:text-accent transition-colors"><i class="fa-solid fa-sign-out-alt"></i> Log Out</button>
                        </form>
                    </li>
                    @else
                    <li>
                        <a href="/register" class="hover:text-accent transition-colors"><i class="fa-solid fa-user-plus"></i> Sign Up</a>
                    </li>
                    <li>
                        <a href="/login" class="hover:text-accent transition-colors"><i class="fa-solid fa-sign-in-alt"></i> Log In</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-28 pb-24 px-8">
        <div class="w-[80%] mx-auto">
            {{$slot}}
        </div>
    </main>

    <!-- Floating Post Product Button -->
    @if(!auth()->user() || !auth()->user()->blocked)
    <a href="/products/create" class="fixed bottom-10 right-10 bg-accent text-white text-xl py-4 px-8 rounded-full shadow-lg hover:bg-primary transition-colors flex items-center justify-center z-20">
        <i class="fa-solid fa-plus-circle mr-2"></i> Post Product
    </a>
    @endif

    <!-- Notifications (Hidden by default) -->
    <x-notification />
</body>

</html>
