<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white">
    <!-- Header -->
    <div class="bg-blue-600 py-4 px-6">
        <h1 class="text-white text-3xl font-bold">Create Post</h1>
    </div>

    <!-- Form -->
    <div class="max-w-xl mx-auto mt-8">
        <form id="addform" class="space-y-4">
            @csrf

            <!-- Title -->
            <input type="text" id="title" name="title" placeholder="Title"
                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <!-- Description -->
            <textarea id="description" name="description" placeholder="Description" rows="4"
                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

            <!-- File Upload -->
            <input type="file" id="image" name="image"
                class="block w-full text-sm text-gray-700 border border-gray-300 rounded cursor-pointer focus:outline-none">

            <!-- Buttons -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit</button>
                <a href="/posts"
                    class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Back</a>
            </div>
        </form>
    </div>


    <script>
        var addform = document.querySelector('#addform');
addform.onsubmit =  async function (e) {
    e.preventDefault();
    const token = localStorage.getItem('api_token');
    const title = document.querySelector('#title').value;
    const description = document.querySelector('#description').value;
    const image = document.querySelector('#image').files[0];


    var formData = new FormData();
    formData.append('title', title);
    formData.append('description', description);
    formData.append('image', image); 

    let response = await  fetch('/api/posts',({
            method: 'POST',
            body:formData ,
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }))
    .then(response => response.json()) 
    .then(data => {
        console.log(data);
       window.location.href = "http://127.0.0.1:8000/posts";
 

    })


}

    </script>

</body>

</html>