@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">USERS</div>

                <div class="card-body">
                   <ul id="users">

                   </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    //hacemos una peticion tipo get al servicio 
    window.axios.get('/api/users')
      //recibe una funcion anonima con una respuesta "response" que contiene la data
      .then((response) =>{
          //accedemos a la lista de usuarios por id
          const usersElement = document.getElementById('users');
           //obtenemos la lista de usuarios que viene de la peticion get en "response"
          let users = response.data;
          //recorremos la lista de usuarios que recibe una funcion anonima con el user y un index que seria el indice
          users.forEach((user, index) =>{
            //creamos el elemento que ira dentro de la lista
             let element = document.createElement('li') ;
            //le ponemos como attribute id el user.id que viene de la lista
             element.setAttribute('id',user.id);
             //le asignamos de texto el nombre del usuario
             element.innerText = user.name;
             //le asignamos el elemento como hijo a la variable que tiene el elemento con id "user"
             usersElement.appendChild(element);
          });
      });
</script>

<script>
    Echo.channel('users')
    .listen('UserCreated', (e) =>{
        const usersElement = document.getElementById('users');
        let element = document.createElement('li') ;
             element.setAttribute('id',e.user.id);
             element.innerText = e.user.name;
             usersElement.appendChild(element);
          
    })
    .listen('UserUpdated', (e) =>{
        
      let element =  document.getElementById(e.user.id);
        element.innerText = e.user.name;            
    })
    .listen('UserDeleted', (e) =>{
        let element =  document.getElementById(e.user.id);
        element.parentNode.removeChild(element);       
    })
</script>
@endpush
