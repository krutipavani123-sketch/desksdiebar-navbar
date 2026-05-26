@extends('layout')

@section('title', 'Edit Category')

@section('main')




<div class="container d-flex justify-content-center">

    <div class="col-md-7">

        <div class="card shadow border-0 rounded-4">

            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Edit Category</h4>
            </div>

            <div class="card-body p-4">
                   <form action="{{ route('categories.update',$categories->id) }}" method="post">
@csrf
  @method('PUT')
                        <div>
                            
                         

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name</label>
<input value="{{ old('name',$categories->name) }}" name="name" type="text" class="form-control">
</div>
                      


                          <button class="btn btn-success w-100">
                        Update Category
                    </button>

                         </form>  
                    
                
                
            </div>
        </div>

    </div>
</div>

@endsection