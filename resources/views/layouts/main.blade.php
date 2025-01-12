<!DOCTYPE html>
<html lang="en">
<head>
    <x-common.meta />
    <x-common.styles />
    @yield("styles")
</head>
<body>
    <x-common.loader />
    <x-common.toaster />
    <x-common.navbar :$user />
    <x-common.confirm-dialogue />
    
    <div class="container container-lg mb-5">
        <div class="row mb-2">
            <h3>@yield("title")</h3>
        </div>
        @yield("content")
    </div>

    <x-common.scripts />
    @yield("scripts")
</body>
</html>