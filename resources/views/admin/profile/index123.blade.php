@include('admin/includes/headerscript')
<body class="skin-blue sidebar-mini">
<div class="wrapper boxed-wrapper">
  <header class="main-header">
    @include('admin/includes/header')
  </header>
  
  <aside class="main-sidebar"> 
    
    <div class="sidebar">
      @include('admin/includes/sidebar')
    </div>
     
  </aside>
  
  
  <div class="content-wrapper"> 
    
    <div class="content-header sty-one">
      <h1>Admin Profile</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin')}}">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Admin Profile</li>
      </ol>
    </div>
    
    
    <div class="content">
      @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
    @endif
      <div class="card">
      <div class="card-body">
        <div class="row">
          
        <div class="col-sm-3">
         <h4 class="page-title" >Update Profile Picture</h4>
          <div class="panel panel-default">            
             
            <div class="panel-body text-center clearfix">
               <?php 
                $profile = Auth::User()->profile;
               ?>
               <div class="col-md-12">
                <img src="{{ asset('src/storage/app/public').'/'.$profile }}" alt="" style="width: 100%;">
               </div>
               <div class="clearfix"></div>
               <div class="col-md-12">
               <form action="{{ url('admin/manage-profile-details') }}" method="POST" enctype="multipart/form-data">
                @csrf
                 <div class="form-group">
                   <input type="hidden" class="form-control" name="old_profile" value="{{ $profile }}">
                   <input type="file" name="profile" class="form-control {{ $errors->has('profile') ? ' is-invalid' : '' }}">
                   @if ($errors->has('profile'))
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('profile') }}</strong>
                                    </span>
                    @endif
                 </div>
                 <div class="form-group">
                   <button type="submit" class="btn btn-success btn-block">Update Profile</button> 
                 </div>
               </form>
               </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <h4 class="page-title" >Change Password</h4>

          <div class="panel panel-default" style="margin-top: 54px">            
            

            <div class="panel-body clearfix">
              <div class="table-responsive">
                <form action="{{ url('admin/manage-login-details') }}" method="POST">
                  @csrf
                 <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" required="">
                    @if ($errors->has('password'))
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                 </div>
                 <div class="form-group">
                    <label for="">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required="">
                 </div>
                 <div class="form-group">
                   <button type="submit" class="btn btn-success btn-block">Update Password</button> 
                 </div>
               </form>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6">
          <h4 class="page-title" >Update Personal Details</h4>

          <div class="panel panel-default" style="margin-top: 54px">            
             

            <div class="panel-body clearfix">
              <div class="table-responsive">
                <form action="{{ url('admin/manage-personal-details') }}" method="POST">
                  @csrf
                 <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" >
                    @if ($errors->has('name'))
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                 </div>
                 <div class="form-group">
                    <label for="">Email Address</label>
                    <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
                    @if ($errors->has('email'))
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                 </div>
                 <div class="form-group">
                   <button type="submit" class="btn btn-success btn-block">Update Personal Details</button> 
                 </div>
               </form>
              </div>
            </div>
          </div>
        </div>

      
          
        </div>
        
        <hr class="m-t-3 m-b-3">
       
      </div></div>
       
    </div>
     
  </div>
  
  <footer class="main-footer">
    @include('admin/includes/footer')
    </footer>
</div>
 
@include('admin/includes/footerscript')
</body>


</html>
