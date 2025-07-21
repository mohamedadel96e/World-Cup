<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<!-- <link rel="icon" href="/favicon.ico" sizes="any"> -->
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<style>
        body {
            font-family: 'Roboto Condensed', sans-serif;
            background-color: #0a0a0a;
            color: #e5e5e5;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCI+CjxyZWN0IHdpZHRoPSI1MCIgaGVpZ2h0PSI1MCIgZmlsbD0iIzA4MDgwOCIgLz4KPHBhdGggZD0iTTAgMEw1MCA1ME0yNSAwTDAgMjVNNTAgMjVMMjUgNTAiIHN0cm9rZT0iIzE0MTQxNCIgc3Ryb2tlLXdpZHRoPSIxIi8+Cjwvc3ZnPg==');
        }

    </style>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
