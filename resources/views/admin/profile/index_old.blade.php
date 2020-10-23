@include('admin.includes.header')
<div class="warper">
  <section id="content">
    <div class="container-fluid">
     @if (Session::has('success'))
        <div class="alert alert-success">
                    {{ Session::get('success') }}
        </div>
      @endif
      <div class="row">
        <div class="col-md-12">
        <div class="col-sm-3">
          <h4 class="page-title" style="margin-top: 20px">Manage Profile</h4>
          <div class="panel panel-default">            
            <div class="panel-heading clearfix">
              <div class="pull-left">
               Update Profile
              </div>              
            </div> 
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
                   <input type="file" name="profile" class="form-control">
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
          <h4 class="page-title" ></h4>

          <div class="panel panel-default" style="margin-top: 54px">            
            <div class="panel-heading clearfix">
             <div class="pull-right">
               Change Password
             </div>              
           </div> 

            <div class="panel-body clearfix">
              <div class="table-responsive">
                <form action="{{ url('admin/manage-login-details') }}" method="POST">
                  @csrf
                 <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" name="password" class="form-control" required="">
                 </div>
                 <div class="form-group">
                    <label for="">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required="">
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
          <h4 class="page-title" ></h4>

          <div class="panel panel-default" style="margin-top: 54px">            
            <div class="panel-heading clearfix">
             <div class="pull-right">
               Update Personal Details
             </div>              
           </div> 

            <div class="panel-body clearfix">
              <div class="table-responsive">
                <form action="{{ url('admin/manage-personal-details') }}" method="POST">
                  @csrf
                 <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" required="">
                 </div>
                 <div class="form-group">
                    <label for="">Email Address</label>
                    <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control" required="">
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

      </div>
    </div>
  </section>
</div>
@include('admin.includes.footer')
