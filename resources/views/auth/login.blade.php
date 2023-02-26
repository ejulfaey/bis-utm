<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIS System | Login</title>
    @vite('resources/css/app.css')
</head>

<body class="antialiased h-screen">
    <div class="p-4 xl:p-10 h-full container mx-auto bg-white">
        <div class="h-full flex rounded-xl">
            <div class="hidden md:block bg-gray-800 text-white w-1/2 rounded-2xl">
                <div class="md:p-4 xl:p-10 h-full flex flex-col justify-center">
                    <h1 class="md:text-2xl xl:text-4xl font-bold">
                        <span class="text-sm">
                            Welcome to
                        </span>
                        <br>
                        Building Condition Assessment - <br>Life Cycle Calculator Analysis
                    </h1>
                    <div class="mt-10 grid grid-cols-2 lg:grid-cols-3 gap-2">
                        <img class="w-auto h-24 md:h-auto object-cover rounded" src="/images/bg-1.png" alt="bg-1">
                        <img class="w-auto h-24 md:h-auto object-cover rounded" src="/images/bg-2.png" alt="bg-2">
                        <img class="w-auto h-24 md:h-auto object-cover rounded" src="/images/bg-3.png" alt="bg-3">
                        <img class="w-auto h-24 md:h-auto object-cover rounded" src="/images/bg-4.png" alt="bg-4">
                        <img class="w-auto h-24 md:h-auto object-cover rounded" src="/images/bg-5.png" alt="bg-5">
                        <img class="w-auto h-24 md:h-auto object-cover rounded" src="/images/bg-6.png" alt="bg-6">
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 h-full flex justify-center items-center">
                <div class="p-6 max-w-md w-full">
                    <h2>
                        Please log in to access your account
                    </h2>
                    <form method="post" action="{{ route('login_post') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="text-xs text-gray-600 font-medium">Email Address</label>
                            <input id="email" name="email" type="text" placeholder="Enter an email address" @class(['mt-1 text-sm block px-4 py-1.5 w-full rounded border-2 border-gray-300 focus:outline-none', 'bg-red-100 border-red-500'=> $errors->has('email')])>
                            @error('email')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label for="password" class="text-xs text-gray-600">Password</label>
                            <input id="password" name="password" type="password" placeholder="Enter password" autocomplete="no-password" @class(['mt-1 text-sm block px-4 py-1.5 w-full rounded border-2 border-gray-300 focus:outline-none', 'bg-red-100 border-red-500'=> $errors->has('password')])>
                            @error('password')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="flex justify-between items-end">
                            <div class="flex items-center gap-x-2">
                                <input type="checkbox" name="remember" id="remember" class="focus:outline-none">
                                <label for="remember" class="text-xs cursor-pointer">Remember me</label>
                            </div>
                        </div>
                        <button type="submit" class="w-full px-6 py-2 text-sm text-white font-medium bg-gray-800 hover:bg-gray-900 rounded">Log In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>