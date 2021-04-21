<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{csrf_token()}}">
      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
      <title>Hello, world!</title>
   </head>
   <body>
      <br>
      <br>
      <div class="container">
         <div class="row">
            <div class="col-md-8">
                <div class="card">
                <h5 class="card-header">Featured</h5>
                 <table class="table table-bordered border-primary">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Qualification</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                </table>
                </div>
               
            </div>
            
            <div class="col-md-4">
               <div class="card">
                  <h5 id="addT" class="card-header">Add New</h5>
                  <h5 id="updatT" class="card-header">Update New</h5>
                  <div class="card-body">
                  
                   
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name </label>
                        <input type="text" id="name" class="form-control">
                        <span class="text-danger" id="nameErr"></span>
                        
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Qualification</label>
                        <input type="text"  id="qualification" class="form-control">
                        <span class="text-danger" id="quaErr"></span>
                    </div>
                    <input type="hidden" id="id">
                   
                    
                    <button  id="addBtn" onclick="addData()" class="btn btn-primary">Save</button>
                    <button  id="updateBtn" class="btn btn-primary" onclick="dataUpdate()">Update</button>
                    
                  </div>
               </div>
            </div>
           
         </div>
      </div>
      <!-- Optional JavaScript; choose one of the two! -->
      <!-- Option 1: Bootstrap Bundle with Popper -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
      <!-- Option 2: Separate Popper and Bootstrap JS -->
      <!--
         <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
         -->

    <script>
           $('#addBtn').show();
           $('#updateBtn').hide();
           $('#addT').show();
           $('#updatT').hide();

           $.ajaxSetup({
               headers:{
                   'X-CSRF-TOKEN':$(' meta[name="csrf-token"]').attr('content')
               }
           })
        //=============== start reading data=============
           function allData(){
              $.ajax({
                  type:"GET",
                  dataType:"json",
                  url:"/allData",
                  success:function(data){
                      var html=""
                      $.each(data,function(key,value){
                          html= html+"<tr>";
                          html= html+"<th scope='row'>"+value.id+"</th>";
                          html= html+ "<td>"+value.name+"</td>";
                          html= html+ "<td>"+value.qualification+"</td>";
                          html= html+ "<td>";
                          html= html+ "<button class='btn btn-success' onclick='editData("+value.id+")'>Edit</button>";
                          html= html+ "<button class='btn btn-danger' onclick='dataDelete("+value.id+")'>Delete</button>";
                          html= html+ "</td>";
                          html= html+"</tr>";
                      })
                      $('tbody').html(html);
                  }
              })
              
           }
           allData();
 //=============== end reading data=============
        


//=============== start clear data=============
           function clearData(){
               $('#name').val('');
               $('#qualification').val('');
               $('#nameErr').text('');
                $('#quaErr').text('');
           }

 //=============== end clear data=============


//  ================start store data==============
           
           function addData(){
               var name = $('#name').val();
               var qualification = $('#qualification').val();
               
               $.ajax({
                   type:"POST",
                   dataType:"json",
                   data:{name:name,qualification:qualification},
                   url:"/data/store",
                   success:function(data){
                    clearData();
                    allData();
                    const msg = Swal.mixin({
                                    toast:true,
                                    position:'top-end',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000,
                        });
                        msg.fire({
                                type: 'success',
                                title: 'Data added Successfully !!',     
                        })
                   },
                   error:function(error){
                        $('#nameErr').text(error.responseJSON.errors.name)
                        $('#quaErr').text(error.responseJSON.errors.qualification)
                       console.log(error.responseJSON.errors.name)
                   }
               })
               
           }

        //    ================end store data==============


 //    ================start edit data==============       
           function editData(id){
               $.ajax({
                   type:"GET",
                   dataType:"json",
                   url:"/editData/"+id,
                   success:function(data){
                    clearData();
                    $('#addBtn').hide();
                    $('#updateBtn').show();
                    $('#addT').hide();
                    $('#updatT').show();
                    $('#name').val(data.name);
                    $('#qualification').val(data.qualification);
                    $('#id').val(data.id);
                   }
               })
           
           }

//    ================end edit data==============



//    ================start update data==============
           function dataUpdate(){
                var name = $('#name').val();
                var qualification = $('#qualification').val();
                var id = $('#id').val();

                $.ajax({
                    type:"POST",
                    dataType:"json",
                    data:{name:name,qualification:qualification},
                    url:"/data/update/"+id,
                    success:function(data){
                        $('#addBtn').show();
                        $('#updateBtn').hide();
                        $('#addT').show();
                        $('#updatT').hide();

                        clearData();
                        allData();
                        const msg = Swal.mixin({
                                    toast:true,
                                    position:'top-end',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000,
                        });
                        msg.fire({
                                type: 'success',
                                title: 'Data Updated Successfully !!',     
                        })
                    },
                    error:function(error){
                        $('#nameErr').text(error.responseJSON.errors.name)
                        $('#quaErr').text(error.responseJSON.errors.qualification)
                       
                    }
                })
           }

//    ================end update data==============


//    ================start delete data==============
           function dataDelete(id){
                     swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover this imaginary file!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                            })
                            .then((willDelete) => {

                               
                            if (willDelete) {
                                $.ajax({
                                    type:"GET",
                                    dataType:"json",
                                    url:"/data/delete/"+id,
                                    success:function(data){
                                        $('#addBtn').show();
                                        $('#updateBtn').hide();
                                        $('#addT').show();
                                        $('#updatT').hide();

                                        clearData();
                                        allData();
                                        const msg = Swal.mixin({
                                                    toast:true,
                                                    position:'top-end',
                                                    icon: 'success',
                                                    showConfirmButton: false,
                                                    timer: 2000,
                                        });
                                        msg.fire({
                                                type: 'success',
                                                title: 'Data Deleted Successfully !!',     
                                        })
                                    }
                                })
                                swal("Poof! Your imaginary file has been deleted!", {
                                icon: "success",
                                });
                            } else {
                                swal("Your imaginary file is safe!");
                            }
                            });
               
           }
        //    ================end delete data==============    

    </script>
    
   </body>
</html>