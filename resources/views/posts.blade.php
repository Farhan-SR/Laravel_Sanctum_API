<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body class="bg-white">

<!-- View Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">POST</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>



    <!--update  Modal -->
    <div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Update POST</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateform">
                    <div class="modal-body">
                        <input type="hedden" id="postid" name="id">

                        <b>Title</b><br>
                        <input class="border p-2" type="text" id="title" name="title" placeholder="Title">
                        <br>
                        <b>Description</b><br>
                        <input class="border p-2"  type="text" id="description" name="description" placeholder="description">
                        <br>
                        <img class=" m-5"  id="showimage" width="250px">
                        <p>Upload Image</p>
                        <input  type="file" id="uplaodimage" name="image">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Save Changes " class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="bg-blue-600 py-4 px-6">
        <h1 class="text-white text-3xl font-bold">All Posts</h1>
    </div>

    <!-- Actions -->
    <div class="px-6 py-4 flex space-x-2">
        <a href="/addpost" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add New</a>
        <a id="logoutbtn"  href="/login" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
    </div>

    <!-- Table -->
    <div class="px-6 pb-10">
        <div class="overflow-x-auto">
            <table id="postsTable" class="min-w-full border border-gray-300">

            </table>
        </div>
    </div>

    <script>
        document.querySelector('#logoutbtn').addEventListener('click', function(e) {
        e.preventDefault();
        const token = localStorage.getItem('api_token');
        fetch('/api/logout',({
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }))
    .then(response => response.json()) 
    .then(data => {
        console.log(data);
        
        window.location.href = '/posts';
    });
        
    })


    function loadData() {
        const token = localStorage.getItem('api_token');
        fetch('/api/posts',({
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        }))
    .then(response => response.json()) 
    .then(data => {
        console.log(data.data);
        const allpost = data.data;
        const postContainer = document.querySelector('#postsTable');

     var tabldata = `   <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-2 border">Image</th>
                        <th class="px-4 py-2 border">Title</th>
                        <th class="px-4 py-2 border">Description</th>
                        <th class="px-4 py-2 border">View</th>
                        <th class="px-4 py-2 border">Update</th>
                        <th class="px-4 py-2 border">Delete</th>
                    </tr>
                </thead>`;

                allpost.forEach(post => {
                    tabldata +=`  
                    <tbody>
                    <tr class="bg-white text-gray-700">
                        <td class="px-4 py-2 border">
                            <img src="/uploads/${post.image}" alt="image" class="w-32   items-center justify-center"></td>
                        <td class="px-4 py-2 border font-semibold">${post.title}</td>
                        <td class="px-4 py-2 border">
                            ${post.description}
                        </td>
                        <td class="px-4 py-2 border text-center">
                           <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700" data-bs-toggle="modal"  data-bs-postid="${post.id}" data-bs-target="#staticBackdrop">View</button>

                        </td>
                        <td class="px-4 py-2 border text-center">
                            <button href="#" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700"
                            data-bs-toggle="modal"  data-bs-postid="${post.id}" data-bs-target="#updateModal">
                                Update </button>
                        </td>
                        <td class="px-4 py-2 border text-center">
                            <form method="POST" action="#">
                                @csrf
                                @method('DELETE')
                                <button onclick="deletePost(${post.id})" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                </tbody> `
                })  ;

                postContainer.innerHTML = tabldata;
            
    });
        
    }
    loadData();

var singlModel = document.querySelector('#staticBackdrop');

if (singlModel) {
    singlModel.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget
    const id = button.getAttribute('data-bs-postid');
    console.log(id);
     const token = localStorage.getItem('api_token');
        fetch(`/api/posts/${id}`,({
            method: 'GET',
            headers: {  
            'Authorization': `Bearer ${token}`,            
            "Content-Type": "application/json",
            }
            }))
            .then(response => response.json())
            .then(data => {
            console.log(data.post.post[0].title);
           
            console.log("farhan")
            const allpost = data.post.post[0];
            const modelbody = document.querySelector('#staticBackdrop .modal-body');
            modelbody.innerHTML = " ";
            modelbody.innerHTML = `
            <div class="modal-body text-center">
                <img id="modalImage" src="/uploads/${data.post.post[0].image}" alt="Post Image" class="img-fluid mb-3" style="max-height: 200px;">
                  <h2 id="modalTitle" class="mb-3 font-bold">${data.post.post[0].title}</h2>
  
                 <p id="modalDescription" class="text-muted">${data.post.post[0].description}</p>
                </div>
            `;        
        })   
  })
}

var UpdatelModel = document.querySelector('#updateModal');

if (UpdatelModel) {
    UpdatelModel.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget

    const id = button.getAttribute('data-bs-postid');
    console.log(id);
     const token = localStorage.getItem('api_token');
        fetch(`/api/posts/${id}`,({
            method: 'GET',
            headers: {  
            'Authorization': `Bearer ${token}`,            
            "Content-Type": "application/json",
            }
            }))
            .then(response => response.json())
            .then(data => {
                console.log(data.post.post[0].title);
                console.log(data.post.post[0].id);
                const post = data.post.post[0];
                

                document.querySelector("#postid").value = id ;
                document.querySelector("#title").value = post.title ;
                document.querySelector("#description").value = post.description ;
                document.querySelector("#showimage").src = `/uploads/${post.image}` ;
        })  
        
        


  })
}

// update post model 
var updateform = document.querySelector('#updateform');
updateform.onsubmit =  async function (e) {
    e.preventDefault();
    const postid = document.querySelector('#postid').value;
    const token = localStorage.getItem('api_token');
    const title = document.querySelector('#title').value;
    const description = document.querySelector('#description').value;


    var formData = new FormData();
    formData.append('title', title);
    formData.append('id', postid);
    formData.append('description', description);

    if(!document.querySelector('#uplaodimage').files[0] > 0){
        const imagex = document.querySelector('#uplaodimage').files[0];
        formData.append('image', imagex); 
    }
    

    let response = await  fetch(`/api/posts/${postid}`,({
            method: 'POST',
            body:formData ,
            headers: {
                'Authorization': `Bearer ${token}`,
                'X-HTTP-Method-Override': 'PUT'

            }
        }))
    .then(response => response.json()) 
    .then(data => {
        console.log(data);
       window.location.href = "http://127.0.0.1:8000/posts";
 

    })

}


// deletePost 
async function  deletePost(postid){
    const token = localStorage.getItem('api_token');
 let response = await   fetch(`/api/posts/${postid}`,({
        method: 'DELETE',
        headers: {  
        'Authorization': `Bearer ${token}`,            
        
        }
        }))
        .then(response => response.json())
        .then(data => {
            console.log(data);
        //    window.location.href = "http://127.0.0.1:8000/posts";
    
        })
}

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>