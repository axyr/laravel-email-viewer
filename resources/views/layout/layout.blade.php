<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ config('app.name') }}</title>
</head>
<body class="bg-gray-100">
<div class="h-screen p-6">
    <div class="flex gap-6 h-full">
        <div class="flex-none bg-white border-b rounded shadow-sm overflow-y-scroll md:w-96">
            <div>
                @include('email-viewer::layout.sidebar')
            </div>
        </div>
        <div class="flex-1 bg-white rounded shadow-sm h-full overflow-y-hidden">
            @yield('main')
        </div>
    </div>
</div>
</body>
</html>
