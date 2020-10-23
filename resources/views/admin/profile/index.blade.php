@include('admin.includes.header')
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      @include('admin.includes.sidebar')
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Zone Question List

      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">manage-profile</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
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
                $profile = Auth::User()->profile_image;
               ?>
               <div class="col-md-12">
                <img src="{{ asset('storage/app/public').'/'.$profile }}" alt="" style="width: 100%;">
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

          <div class="panel panel-default">            
            

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

          <div class="panel panel-default">            
             

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
       
    
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    @include('admin.includes.footer2')
  </footer>

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
@include('admin.includes.footer')

<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>


</body>
</html>
