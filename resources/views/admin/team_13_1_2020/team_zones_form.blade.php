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
        <?php if(isset($rs->id) && $rs->id!=''){echo "Modify [#$rs->id]";}else{echo "  Add Zones to Team";}?>
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
              <h3 class="box-title">Add Zones</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
             <form method="post" action="{{ url('admin/manage-team-zone-form') }}" enctype="multipart/form-data">
              <input type="hidden" id="id" name="id" value="{{@$rs->id}}">
              <input type="hidden" id="team_id" name="team_id" value="{{@$team_id}}">
              <input type="hidden" id="con" name="con" value="<?php if(isset($rs->id) && $rs->id!=''){echo "edit";}else{echo "add";}?>">
                  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
              <div class="box-body">
                @if(session()->has('message'))
              <div class="alert alert-success">
                  {{ session()->get('message') }}
              </div>
              @endif
                <div class="form-group">
                  
                @if($zone_list)
                @foreach($zone_list as $zone)
                <div class="col-md-4">
                <div class="checkbox">
                    <label>
                      <input type="checkbox" name="zone_id[]" value="{{ $zone->id }}" @foreach($get_team_zones as $team_zone) {{ ($team_zone->id ==$zone->id) ? 'disabled':''}} @endforeach>{{ $zone->zone_name}}
                    </label>
                  </div>
                </div>
                @endforeach
                @endif
                  <span class="text-danger">{{ $errors->first('zone_name') }}</span>
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
        <div class="col-md-6">
          
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Team Name</h3>
              <h3 class="box-title pull-right">{{ $team_name->team_name}}</h3>
            </div>

             <div class="box-body">
              @if(session()->has('delete_message'))
              <div class="alert alert-success">
                  {{ session()->get('delete_message') }}
              </div>
              @endif
            <!-- /.box-header -->
            <!-- form start -->
            @if($get_team_zones)
             
              @foreach($get_team_zones as $get_team_user)
               <div class="col-md-4">
                <div class="row">
                 <div class="col-md-10">
                  {{ $get_team_user->zone_name }}
                 </div>
                 <div class="col-md-2 pull-right">
                   <a href="{{url('admin/manage-team-zone/delete'.'/'.$get_team_user->id)}}"><i class="fa fa-remove text-danger" onclick="return confirm('Are you sure do you want to delete?')"></i></a>
                 </div>
                </div>  
               </div>
               @endforeach
             
             @endif
          </div>
          </div>
          
        
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
    $('.select2').select2()
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
