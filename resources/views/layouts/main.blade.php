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
    <x-common.navbar />
    <x-common.confirm-dialogue />
    
    <div class="container container-lg">
        @yield("content")
    </div>

    <x-common.scripts />
    @yield("scripts")
</body>
</html>