<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login - PamSuCoLo</title>
    <style>
        /* Optional: Apply your custom background color */
        body { 
            background-color: var(--color-pamsucolo-bg); 
            color: var(--color-pamsucolo-text);
            /* Ensure the body takes full viewport height for centering */
            min-height: 100vh;
        }

        /* Custom focus ring using Tailwind classes (needs to be configured in output.css or applied directly) */
        /* To remove default focus and apply custom primary color focus */
        .custom-focus:focus {
            outline: 2px solid transparent; /* Remove default blue/gray outline */
            outline-offset: 2px;
            box-shadow: 0 0 0 3px var(--color-pamsucolo-primary-rgb); /* Use brand color for outline/ring */
        }
        
        /* Disabled input styling for auto-generated fields */
        .disabled-input {
            @apply bg-gray-100 text-gray-500 cursor-not-allowed;
        }
    </style>
</head>
<body class="bg-pamsucolo-bg text-pamsucolo-text font-sans antialiased flex flex-col">

    {{ $slot }}

</body>
</html>

