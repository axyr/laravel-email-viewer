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
    <div class="grid grid-cols-12 gap-6 h-full">
        <div class="col-span-3 bg-white border-b rounded shadow-sm overflow-y-scroll">
            <div>
                @include('email-viewer::layout.sidebar')
            </div>
        </div>
        <div class="col-span-9 bg-white rounded shadow-sm h-full overflow-y-hidden">
            @yield('main')
        </div>
    </div>
</div>
</body>
</html>
