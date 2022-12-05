<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kopi Pas</title>
  </head>
  <body style="margin: 0;">
    <div id="app">
      <app></app>
    </div>
    @vite('resources/js/app.js')
  </body>
</html>