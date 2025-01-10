<!DOCTYPE html>
<html lang="en">
<head>
    <x-common.meta />
    <x-common.styles />
</head>
<body class="d-flex align-items-center justify-content-center p-3 vh-100">
    <div class="card col-12 col-md-6 col-xl-3">
        <div class="card-body">
            @yield("content")
        </div>
    </div>
    
    <x-common.scripts />
</body>
</html>