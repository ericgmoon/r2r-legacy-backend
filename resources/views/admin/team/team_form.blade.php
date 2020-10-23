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
        <?php if(isset($rs->id) && $rs->id!=''){echo "Modify [#$rs->id]";}else{echo "  Add New Team";}?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('admin/manage-zone')}}">Zone List</a></li>
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
              <h3 class="box-title"><?php if(isset($rs->id) && $rs->id!=''){echo "Edit";}else{echo "Add";}?> Team</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form method="post" action="{{ url('admin/manage-teams/add') }}" enctype="multipart/form-data">
              <input type="hidden" id="id" name="id" value="{{@$rs->id}}">
              <input type="hidden" id="con" name="con" value="<?php if(isset($rs->id) && $rs->id!=''){echo "edit";}else{echo "add";}?>">
                  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Team Name</label>
                  <input type="text" class="form-control" id="team_name" placeholder="Enter Zone" name="team_name" value="{{ old('team_name',@$rs->team_name)}}">
                  <span class="text-danger">{{ $errors->first('team_name') }}</span>
                </div>
                
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
