@include('layouts.header')

@include('layouts.sidebar')

<div id="main" class="layout-navbar">
    @include('layouts.nav')
    
    <div class="content" id="main-content">
        <div class="container-fluid">
            <form action="/admin/update/{{$admin->admin_id}}" method="post" enctype="multipart/form-data" >
                @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-profile">
                        <div class="card-avatar bg-danger" style="overflow: hidden">
                            <img id="avatar" class="img-fluid" src="@php echo $admin->avatar ? json_decode($admin->avatar)[0]->url : asset('/images/faces/1.jpg') @endphp">
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="mb-2">Upload Image</label>
                                <input type="file" name="avatar" class="form-control form-control-file" onchange="setImage()" >
                                @error('avatar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-primary">
                    <h5 class="card-title">User Profile Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="badge badge-shadow bg-dark">
                                    {{ $admin->role }}
                                </div>
                            </div>

                            <div class="my-3">
                                <small>Fields marked <span class="text-danger">*</span> are required</small>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Firstname <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light-secondary" name="firstname" value="{{$admin->firstname}}" />
                                @error('firstname')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                              <label>Lastname <span class="text-danger">*</span></label>
                              <input type="text" class="form-control bg-light-secondary" name="lastname" value="{{$admin->lastname}}" />
                              @error('lastname')
                                  <p class="text-danger">{{ $message }}</p>
                              @enderror
                          </div>

                            <div class="form-group col-12">
                                <label>Email Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light-secondary" name="email" value="{{$admin->email}}" />
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-6"> 
                                <label>Update Password</label>
                                <input type="text" class="form-control bg-light-secondary" name="password" placeholder="Create a new Password" />
                            </div>

                            <div class="col-6">
                                <label>Confirm Password</label>
                                <input type="text" class="form-control bg-light-secondary" name="password_confirmation" placeholder="Confirm Password" />
                            </div>

                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <hr/>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-round">Update Profile</button>
                            <a href="/logout" class="btn btn-round">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

              
<!-- filepond validation -->
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

<!-- image editor -->
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-filter/dist/filepond-plugin-image-filter.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>

<!-- filepond -->
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script>
    // register desired plugins...
	FilePond.registerPlugin(
        // validates the size of the file...
        FilePondPluginFileValidateSize,
        // validates the file type...
        FilePondPluginFileValidateType,

        // calculates & dds cropping info based on the input image dimensions and the set crop ratio...
        FilePondPluginImageCrop,
        // preview the image file type...
        FilePondPluginImagePreview,
        // filter the image file
        FilePondPluginImageFilter,
        // corrects mobile image orientation...
        FilePondPluginImageExifOrientation,
        // calculates & adds resize information...
        FilePondPluginImageResize,
    );
    
    // Filepond: Basic
    FilePond.create( document.querySelector('.basic-filepond'), { 
        allowImagePreview: false,
        allowMultiple: false,
        allowFileEncode: false,
        required: false
    });

    function setImage(e){
        console.log(e)
        console.log(document.getElementById('avatar').src);
        // document.getElementById('avatar').src = URL.createObjectURL(e.target.files[0]);
    }
</script>
@include('layouts.footer')