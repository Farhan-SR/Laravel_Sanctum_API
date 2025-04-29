<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">

        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        <form>
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input id="email" type="email" name="email" id="email" required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input id="password" type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <button id="loginButton" type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">
                Login
            </button>
        </form>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            
        $('#loginButton').on('click', function(e){
            e.preventDefault();
            const email = $('#email').val();
            const password = $('#password').val();

            $.ajax({
                url:'/api/login',
                type : 'POST',
                contentType : 'application/json',
                data: JSON.stringify({email:email, 
                password:password}),
            success:function(response){
                console.log(response);
                localStorage.setItem('api_token', response.token);
                window.location.href = '/posts';
            },
            error:function(error){
                console.log(error);
                alert('Error');
            }
            })
        })
    })

    </script>



</body>

</html>