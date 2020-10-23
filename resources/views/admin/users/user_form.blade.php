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
        <?php if(isset($rs->id) && $rs->id!=''){echo "Modify [#$rs->id]";}else{echo "  Add New User";}?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('admin/manage-users')}}">User List</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php if(isset($rs->id) && $rs->id!=''){echo "Edit";}else{echo "Add";}?> User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form method="post" action="{{ url('admin/manage-users/add') }}" enctype="multipart/form-data">
              <input type="hidden" id="id" name="id" value="{{@$rs->id}}">
              <input type="hidden" id="con" name="con" value="<?php if(isset($rs->id) && $rs->id!=''){echo "edit";}else{echo "add";}?>">
                  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">User Name</label>
                  <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Full Name" value="{{ old('full_name',@$rs->full_name)}}">
                  <span class="text-danger">{{ $errors->first('full_name') }}</span>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="text" class="form-control" id="email" value="{{ old('email',@$rs->email)}}" name="email" placeholder="Enter email" {{(@$rs->id!='' OR @$rs->id!=null) ?'disabled' :'' }}>
                  <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                @if(@$rs->id=='' OR @$rs->id==null)
                <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                  <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Confirm Password</label>
                  <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Enter Confirm Password">
                </div>
                @endif
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
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
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
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
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>

</body>
</html>
