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
        <li><a href="{{ url('admin/manage-zone')}}">Zone List</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Zone Question List</h3>
              <a class="btn btn-primary pull-right" href="{{ url('admin/manage-zone-questions/add'.'/'.@$zone_id)}}">Add Question</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @if(Session::has('success'))
            <p class="alert alert-success">{{ Session::get('success') }}</p>
            @endif
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  @php
                  $i = 1;
                  @endphp
                <tr>
                  <th># ID</th>
                  <th>Zone</th>
                  <th>Question</th>
                  <th>Answer</th>
                  <th>Points</th>
                  <th>Available Hints</th>
                  <th>Tokens to Unlock</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @if($question_list)
                  @foreach($question_list as $k => $v1)
                <tr>
                  <td>{{ $i }}</td>
                  <td>{{ $v1->zone_name }}</td>
                  <td>{{ $v1->question }}</td>
                  <td>{{ $v1->answer }}</td>
                  <td>{{ $v1->points }}</td>
                  <td>{{ $v1->hints_per_challenge }}</td>
                  <td>{{ $v1->tokens_to_unlock }}</td>
                  <!-- <td><a href="{{ url('admin/manage-team-users-form').'/'.$v1->id }}" class="btn btn-primary">Manage Team Users</a></td>
                  <td><a href="{{ url('admin/manage-team-zone-form').'/'.$v1->id }}" class="btn btn-primary">Manage Team Zone</a></td> -->
                  <td>{{ $v1->status}}</td>
                  <td>
                    <a href="{{ url('admin/manage-zone-questions/add'.'/'.@$zone_id.'/'.$v1->id) }}" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>

                    <a href="{{url('admin/manage-zone-questions/add'.'/'.@$zone_id.'/'.$v1->id) }}" title="Remove" data-toggle="tooltip" onclick="return confirm('Are you sure do you want to delete?')"><i class="fa fa-remove text-danger"></i></a></td>
                </tr>
                @php
                  $i++;
                @endphp

                @endforeach
                @endif
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
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
