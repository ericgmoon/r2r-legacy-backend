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
        <?php if(isset($rs->id) && $rs->id!=''){echo "Modify [#$rs->id]";}else{echo "  Add New Content";}?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('admin/content-list').'/'.@$cat_id.'/'.@$subcat_id}}">Content List</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <div class="content">
      <div class="card">
      <div class="card-body">
        <form method="post" action="{{ url('admin/manage-content/add') }}" enctype="multipart/form-data">
          <input type="hidden" id="id" name="id" value="{{@$rs->id}}">
          <input type="hidden" id="cat_id" name="cat_id" value="{{@$cat_id}}">
          <input type="hidden" id="subcat_id" name="subcat_id" value="{{@$subcat_id}}">
          <input type="hidden" id="con" name="con" value="<?php if(isset($rs->id) && $rs->id!=''){echo "edit";}else{echo "add";}?>">
              <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="row">
         
         <div class="col-lg-6">
            <fieldset class="form-group">
              <label>Content</label>
              <textarea class="form-control" name="desp" id="editor1" rows="5">{{ old('desp',@$rs->desp)}}</textarea>
              <span class="text-danger">{{ $errors->first('desp') }}</span>
            </fieldset>
          </div>
      </div>
      <div class="row">
         
         <div class="col-lg-6">
            <fieldset class="form-group">
              <label>Section</label>
              <input type="text" class="form-control" name="section" value="{{ old('section',@$rs->section)}}">
              <span class="text-danger">{{ $errors->first('section') }}</span>
            </fieldset>
          </div>
      </div>
        <div class="row">
            <div class="col-lg-6">
            <fieldset class="form-group">
              <button id="" class="btn btn-success" type="submit">Save</button>
            </fieldset>
          </div>
          </div>
      </form>
        <hr class="m-t-3 m-b-3">
       
      </div></div>
       
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
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
