<!DOCTYPE html>
<html lang="en">
<head>
    <x-common.meta />
    <x-common.styles />
    @yeild("styles")
</head>
<body>
    @yield("content")
    
    <x-common.scripts />
    @yeild("scripts")
</body>
</html>