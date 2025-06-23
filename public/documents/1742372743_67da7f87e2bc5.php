@extends ('layouts.admin_layouts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" />
@section('main-contant')
@include('admin.include.sidebar')


<main class="main-content position-relative border-radius-lg ">
   <div class="container-fluid py-4">
	  @include('admin.include.header')
	  
    <div class="row mt-5">
      <div class="col-12">

        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Create News & Update</h6>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            
            <div class="card-body">
              <form action="{{ route('store.news') }}" method="POST" enctype="multipart/form-data" role="form">
                @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Title</label>
                    <input type="text" name="title" class="form-control" >
                     @error('title')
                          <div class="alert text-danger">{{ $message }}</div>
                      @enderror
                    
                  </div>
                </div>
                </div>

                <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Featured Image</label>
                    <input type="file" name="feature_img" class="form-control" required>
                  </div>
                </div>
                
					 <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Description</label>
                    <!--<input type="file" name="click_img" class="form-control" required>-->
                    <textarea name="click_img" class="summernote"></textarea>
                  </div>
                </div>
               
              
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('news.index') }}" class="btn btn-danger">Back</a>
              </div>
            </div>

          </form>
          </div>
        </div>
      </div>
    </div>
    {{-- <footer class="footer pt-3  ">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              © <script>
                document.write(new Date().getFullYear())
              </script>,
              made with <i class="fa fa-heart"></i> by
              <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
              for a better web.
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer> --}}
  </div>

</main>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script type="text/javascript">
  $(document).ready(function () {
      $('.summernote').summernote();
  });
</script>

@endsection

         