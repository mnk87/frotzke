<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home - Frotzke.nl</title>
    @vite(["resources/css/test.scss", "resources/js/test.js"])
</head>
<body>
    <h1>Dit is een <span>Test</span></h1>
    @foreach ($tests as $test)
    <div class="testdiv">
        <p>{{ $test->content }}</p>
    </div>
    @endforeach
</body>
</html>