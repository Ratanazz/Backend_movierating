<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->name }} - Movie Details</title>
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $movie->name }}" />
    <meta property="og:description" content="{{ Str::limit($movie->summary, 100) }}" />
    <meta property="og:image" content="{{ asset($movie->image_poster) }}" />
    <!-- Add other meta tags as needed -->
</head>
<body>
    <div id="root"></div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>