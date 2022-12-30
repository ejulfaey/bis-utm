<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIS System | Login</title>
    @vite('resources/css/app.css')
</head>

<body class="antialiased">
    <div class="bg-gray-100 h-screen flex justify-center items-center">

        <div class="p-6 max-w-md w-full bg-white rounded shadow border">
            <form method="post" action="{{ route('login_post') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="text-xs text-gray-600">Email Address</label>
                    <input id="email" name="email" type="text" placeholder="Enter an email address" @class(['mt-1 text-sm block px-4 py-1.5 w-full rounded focus:outline-none', 'bg-red-100 border-red-500' => $errors->has('email')])>
                    @error('email')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label for="password" class="text-xs text-gray-600">Password</label>
                    <input id="password" name="password" type="password" placeholder="Enter password" autocomplete="no-password" @class(['mt-1 text-sm block px-4 py-1.5 w-full rounded focus:outline-none', 'bg-red-100 border-red-500' => $errors->has('password')])>
                    @error('password')<span class="text-xs text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="flex justify-between items-end">
                    <div class="flex items-center gap-x-2">
                        <input type="checkbox" name="remember" id="remember" class="focus:outline-none">
                        <label for="remember" class="text-xs cursor-pointer">Remember me</label>
                    </div>
                    <a href="#" class="text-xs hover:text-amber-500">Forgot Password</a>
                </div>
                <button type="submit" class="w-full px-6 py-2 text-sm text-white font-medium bg-blue-600 hover:bg-gray-700 rounded">Log In</button>
            </form>

        </div>

    </div>
</body>

</html>