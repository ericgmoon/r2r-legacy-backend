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
        <li><a href="{{ url('admin/manage-user-performance')}}">User Performance List</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Question List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @if(Session::has('success'))
            <p class="alert alert-success">{{ Session::get('success') }}</p>
            @endif

            <p class="alert alert-success" id="success_mgs" style="display: none;">Status updated successfully</p>
           
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  @php
                  $i = 1;
                  @endphp
                <tr>
                  <th># ID</th>
                  <th>Zone</th>
                  <th>Question</th>
                  <th>Correct Answer</th>
                  <th>User Answer</th>
                  <th>Points</th>
                  <th>Available Hints</th>
                  <th>Hints Used</th>
                  <th>Earn Points</th>
                  <th>Tokens Wons</th>
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
                  <td>{{ $v1->user_answer }}</td>
                  <td>{{ $v1->points }}</td>
                  <td>{{ $v1->hints_per_challenge }}</td>
                  <td>{{ $v1->hint_used }}</td>
                  <td>{{ $v1->earn_points }}</td>
                  <td>{{ $v1->tokens_wons }}</td>
                  
                  <td>@if($v1->task_completed == 0){{ 'Not Opened'}} @elseif($v1->task_completed == 1) {{ 'Opened'}} @else {{ 'Completed'}} @endif</td>
                  <td>
                    <select name="action" id="change_status_{{$v1->id}}">
                      <option value="0" {{ ($v1->is_correct==0) ? 'selected' : ''}}>Pending</option>
                      <option value="1" {{ ($v1->is_correct==1) ? 'selected' : ''}}>Correct</option>
                    </select>
                  </td>
                  <!-- <td>
                    <a href="{{ url('admin/manage-zone-questions/add'.'/'.@$zone_id.'/'.$v1->id) }}" title="Edit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>

                    <a href="{{url('admin/manage-zone-questions/add'.'/'.@$zone_id.'/'.$v1->id) }}" title="Remove" data-toggle="tooltip" onclick="return confirm('Are you sure do you want to delete?')"><i class="fa fa-remove text-danger"></i></a>
                  </td> -->
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
     $('#example1').DataTable({
      "stateSave": true
    })
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
  <script type="text/javascript">
@foreach($question_list as $k => $v1)
    $('#change_status_'+"{{$v1->id}}").on('change', function() {
      var val =  this.value;
      //alert(val);
      var id =  "{{$v1->id}}";
      var _token  = "{{ csrf_token() }}";
      $.ajax({
        url: "{{ url('admin/change-question-performance-status')}}",
        dataType:"json",
        type: "post",
        data:{"status": val,"id": id, "_token": _token},
        success: function(data){
           console.log(data);
           if(data)
           {
            $('#success_mgs').css('display','block');
           }

        }
    });
    });
    @endforeach
</script>

</body>
</html>
