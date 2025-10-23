<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{$slot}}
    <meta name="description" content="Admin dashboard for book management system with dark theme interface">
  <link rel="stylesheet" href="{{asset('css/style.css')}}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../image/willan.jpg" type="image/jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                dark: {
                  primary: '#1a1b1e',
                  secondary: '#25262b',
                  card: '#2c2e33',
                  border: '#373a40',
                }
              }
            }
          }
        }
    </script>
</head>

<body class="bg-[#1a1b1e]">