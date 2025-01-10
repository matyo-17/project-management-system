<!DOCTYPE html>
<html lang="en">
<head>
    <x-common.meta />
    <x-common.styles />
    @yield("styles")
</head>
<body>
    <x-common.loader />
    <x-common.navbar />
    
    @yield("content")

    <x-common.scripts />
    @yield("scripts")
</body>
</html>