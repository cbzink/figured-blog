<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Figured Blog</title>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="container mx-auto my-8">
            <header class="mb-8 text-center">
                <a href="/"><h1 class="text-4xl font-bold text-blue-800">Figured <span class="font-normal text-gray-800">Blog</span></h1></a>
            </header>

            <div class="w-full md:w-1/4 mx-auto bg-white rounded shadow-lg p-8">
                <form method="POST" action="/login">
                    @csrf

                    <div>
                        <label for="email" class="text-xs uppercase text-gray-500 font-bold">Email</label>
                        <input type="text" name="email" class="border-b border-dashed border-gray-500 focus:outline-none w-full @if($errors->has('email')) border-red-500 @endif" autofocus />
                        @if($errors->has('email'))
                            <span class="text-xs text-red-500">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="mt-6">
                        <label for="password" class="text-xs uppercase text-gray-500 font-bold">Password</label>
                        <input type="password" name="password" class="border-b border-dashed border-gray-500 focus:outline-none w-full @if($errors->has('password')) border-red-500 @endif" />
                        @if($errors->has('password'))
                            <span class="text-xs text-red-500">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 border-b-4 border-blue-700 hover:border-blue-500 rounded w-full">Login</button>
                    </div>
                </form>
            </div>
        </div>

        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>