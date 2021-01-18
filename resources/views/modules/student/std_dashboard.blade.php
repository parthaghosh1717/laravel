@extends('layouts.app')

@section('content')
<div class="container">
    @include('includes.message')
    <div class="row justify-content-center">

        <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="card">
                <div class="card-header">Student Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   Hi {{@$user->name}} !
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-8 col-sm-8 mt-5">
            <div class="card"> 
                <div class="card-header">Student Dashboard</div> 
                <div class="card-body mb-5" id="myDiv">
                    <form   id="project-from" enctype="multipart/form-data">
                         
                         <input type="hidden" name="project_id" value="" id="project_id">
                        <div class="form-group row">
                            <label for="project_title" class="col-md-4 col-form-label text-md-right">Project Title</label>
                            <div class="col-md-6">
                                <input id="project_title" type="text" class="form-control @error('project_title') is-invalid @enderror" name="project_title" value=""   autocomplete="project_title" autofocus> 
                            </div>
                            @error('project_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> 
                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">Project Description</label>

                            <div class="col-md-6">
                                <!-- <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="" required autocomplete="user_name" autofocus> -->
                                <textarea placeholder="Type your Project details here" style="height:190px; width: 100%; resize:none;" name="description" id="description" ></textarea>
                                @error('user_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="form-group row "> 
                            <label for="exampleInputimage" class="col-md-4 col-form-label text-md-right">Project Image</label> 
                            <div>
                                <input type="file" name="image" id="image"   onchange="previewImage(event)">
                                <label for="image" generated="true" class="error" style="display: none;">This field is required.</label> 
                            </div>
                            

                            <div class="polaroid">
                                <img src="{{asset('public/images/Upload_iamge.png')}}" alt="5 Terre" style="" id="imagefields">  
                            </div><span style="color:#cc0000;"><b>{{$errors->first('image')}}</b></span>
                        </div>


                        
                         
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-submit" id="save_project">
                                   Save
                                </button>
                            </div>
                        </div>
                    </form>
                 </div>
            </div>
        </div> 

        <div class="container mt-5">
            <h2>Project Details</h2>
                        
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 20%;">Project itle</th>
                        <th style="width: 45%;">description</th>
                        <th style="width: 20%;">Image</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody class="t-data">  
                    @foreach(@$project as $display)
                        <tr  id="row_{{@$display->id}}">
                            <td>{{@$display->project_title}}</td>
                            <td>{!!nl2br(@$display->description)!!}</td>
                            <td><img src="{{ asset('storage/app/public/images/projectimg/'.@$display->file) }}" style="width: 70px;height: 80px;" id="imagefields"></td>
                            <td><a href="javascript:;" class="btn btn-primary edit-btn" data-id="{{@$display->id}}">Edit</a> <a href="javascript:;" class="btn btn-danger del-btn" data-id="{{@$display->id}}">Delete</a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="clearfix"></div>
            <div class="paginate float-right">
                {{$project->links()}}
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')
@include('includes.scripts')
<!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->
<script type="text/javascript">
    function previewImage(event){
        var reader = new FileReader();
        var imageField = document.getElementById('imagefields')

        reader.onload = function(){
            if(reader.readyState == 2){
                imageField.src = reader.result;
            }
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<script>
        $(document).ready(function(){
            $('#project-from').validate({
                rules:{
                    project_title:{ required:true},
                    description:{ required:true},
                    image:{ required:true} 
                },

                 

                 submitHandler: function (form, e) {
                    e.preventDefault();
                        var project_title = $("input[name=project_title]").val(); 
                        var description = $("#description").val(); 
                        var project_id = $("#project_id").val();  
                        var files = $('#image').prop('files');

                        data = new FormData();
                        data.append('_token', "{{ csrf_token() }}");
                        data.append('project_title',project_title);
                        data.append('project_id',project_id);
                        data.append('description',description);
    
                        console.log(data);

                        $.each(files, function(k,file){
                            data.append('file', file);
                        });


                    //     var reqData = {
                    //     "jsonrpc":"2.0",
                    //     "_token":"{{ csrf_token() }}",
                    //     "project_title":project_title,
                    //     "project_id":project_id,
                    //     "description":description

                    // }; 

                    

                    $.ajax({
                        url:"{{route('store_project_details')}}",
                        type:"post",
                        data: data,
                        enctype: 'multipart/form-data',
                        processData: false,  
                        contentType: false,
                        success:function(response){
                            console.log(response)
                            id=response.id;
                            file=response.file;
                                $("input[name=project_title]").val('');
                                $("#description").val('');
                                $("#project_id").val('');
                                $('#image').val('');
                                $('.polaroid').html('<img src="{{asset('public/images/Upload_iamge.png')}}" alt="5 Terre" style="" id="imagefields">');
                            if(response.status ==  1){
                                
                                alert('Data Updated successfully');
                               $('#row_'+id).html('<td>'+project_title+'</td><td>'+description+'</td><td><img src="{{asset('storage/app/public/images/projectimg/')}}/'+file+'" style="width: 70px;height: 80px;" id="imagefields"></td><td><a href="javascript:;" class="btn btn-primary" data-id='+id+' >Edit</a> <a href="javascript:;" class="btn btn-danger" data-id='+id+'>Delete</a></td></tr>');
                                   
                            }
                            else{
                                $('.t-data').append('<td>'+project_title+'</td><td>'+description+'</td><td><img src="{{asset('storage/app/public/images/projectimg/')}}/'+file+'" style="width: 70px;height: 80px;" id="imagefields"></td><td><a href="javascript:;" class="btn btn-primary" data-id='+id+'>Edit</a> <a href="javascript:;" class="btn btn-danger" data-id='+id+'>Delete</a></td></tr>');
                                    alert('Data insterted successfully');
                            }
                            
                        },
                        error:function(error) 
                        {
                            console.log(error.responseText);
                        }
                    });

                }
                   
            });


             
        });
    </script> 

    <script type="text/javascript">
        $(document).ready(function(){
            $('.edit-btn').click(function(){
               
                var id = $(this).data('id');
                 
                var reqData = {
                    "jsonrpc":"2.0",
                     
                    "data":{
                        id:id
                    }
                };

            $.ajax({
                'url':"{{route('get.project')}}",
                'type':"get",
                'data': reqData,
                success:function(response){
                     console.log(response)
                    $('#project_id').val(response.projectdet.id);
                    $('#project_title').val(response.projectdet.project_title);
                    $('#description').val(response.projectdet.description);                     
                    $('#imagefields').attr('src','storage/app/public/images/projectimg/'+response.projectdet.file);

                    $('html, body').animate({
                        scrollTop: $("#myDiv").offset().top
                    }, 2000);                     
                },

                error:function(error) 
                    {
                        console.log(error.responseText);
                    }
            });

            });
        });
    </script>
    <script type="text/javascript">
         $(document).ready(function(){
           $('body').on('click', '.del-btn', function () {
     
                var id = $(this).data("id");
                 
                confirm("Are You sure want to delete !");

                var reqData = {
                    "jsonrpc":"2.0",
                    "_token":"{{ csrf_token() }}",
                    "data":{
                        id:id
                    }
                };
              
               $.ajax({
                    'url':"{{route('delete.project')}}",
                    'type':"post",
                    'data': reqData,
                    success:function(response){
                        if(response.status ==  1){                             
                            $('#row_'+id).remove();
                        } 
                        
                    }
                });
            });
         });
    </script>
@endsection
