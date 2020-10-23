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
        <?php if(isset($rs->id) && $rs->id!=''){echo "Modify [#$rs->id]";}else{echo "  Add New Question";}?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('admin/manage-questions')}}">Question List</a></li>
        <li>Add Question</li>
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
              <h3 class="box-title">Add Question</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            @if(Session::has('warning'))
              <p class="alert alert-warning">{{ Session::get('warning') }}</p>
            @endif
            
             <form method="post" action="{{ url('admin/manage-questions/add') }}" enctype="multipart/form-data">
              <input type="hidden" id="id" name="id" value="{{@$rs->id}}">
              <input type="hidden" id="con" name="con" value="<?php if(isset($rs->id) && $rs->id!=''){echo "edit";}else{echo "add";}?>">
                  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
              <div class="box-body">
                <div class="form-group">
                  <label for="zone_id">Select Zone</label>
                  
                  <select class="form-control" name="zone_id">
                    <option>Select Zone</option>
                    @if($zone_list)
                    @foreach($zone_list as $zone)
                    <option value="{{ $zone->id }}" {{ (old("zone_id",@$rs->zone_id) == $zone->id ? "selected":"") }}>{{ $zone->zone_name}}</option>
                    @endforeach
                    @endif
                  </select>
                  <span class="text-danger">{{ $errors->first('zone_id') }}</span>
                </div>
                <div class="form-group">
                  <label for="points">Select Points</label>
                  
                  <select class="form-control" name="points" id="choose-points">
                    <option value="">Select Points</option>
                    
                    <option value="10" {{ (old("points",@$rs->points) == 10 ? "selected":"") }}>10 Points</option>
                    <option value="20" {{ (old("points",@$rs->points) == 20 ? "selected":"") }}>20 Points</option>
                    <option value="30" {{ (old("points",@$rs->points) == 30 ? "selected":"") }}>30 Points</option>
                    <option value="40" {{ (old("points",@$rs->points) == 40 ? "selected":"") }}>40 Points</option>
                    
                  </select>
                  <span class="text-danger">{{ $errors->first('points') }}</span>
                </div>
                <!-- <div class="form-group">
                  <label for="hints_per_challenge">Hints per Challenge</label>
                  
                  <select class="form-control" name="hints_per_challenge">
                    <option>Select Hints</option>
                    
                    <option value="0" {{ (old("hints_per_challenge") == 0 ? "selected":"") }}>0 Hint</option>
                    <option value="1" {{ (old("hints_per_challenge") == 1 ? "selected":"") }}>1 Hint</option>
                    <option value="2" {{ (old("hints_per_challenge") == 2 ? "selected":"") }}>2 Hints</option>
                    <option value="3" {{ (old("hints_per_challenge") == 3 ? "selected":"") }}>3 Hints</option>
                    
                  </select>
                  <span class="text-danger">{{ $errors->first('hints_per_challenge') }}</span>
                </div> -->
                <div class="form-group">
                  <label for="question">Question</label>
                  <input type="text" name="question" class="form-control" value="{{ old('question',@$rs->question)}}">
                  <span class="text-danger">{{ $errors->first('question') }}</span>
                </div>

                <div class="form-group">
                  <label for="answer">Answer</label>
                  <input type="text" name="answer" class="form-control" value="{{ old('answer',@$rs->answer)}}">
                  <span class="text-danger">{{ $errors->first('answer') }}</span>
                </div>
                
                <div class="form-group show-hints-1" style="display: none;">
                  <label for="hint_1">Hint 1</label>
                  <input type="text" name="hint_1" id="hint_1" class="form-control" value="{{ old('hint_1',@$hints[0]->hint)}}">
                  <span class="text-danger">{{ $errors->first('hint_1') }}</span>
                  <input type="hidden" name="hint_id_1" value="{{ @$hints[0]->id }}">
                </div>


                <div class="form-group show-hints-2" style="display: none;">
                  <label for="hint_2">Hint 2</label>
                  <input type="text" name="hint_2" id="hint_2" class="form-control" value="{{ old('hint_2',@$hints[1]->hint)}}">
                  <span class="text-danger">{{ $errors->first('hint_2') }}</span>
                  <input type="hidden" name="hint_id_2" value="{{ @$hints[1]->id }}">
                </div>
                <div class="form-group show-hints-3" style="display: none;">
                  <label for="hint_3">Hint 3</label>
                  <input type="text" name="hint_3" id="hint_3" class="form-control" value="{{ old('hint_3',@$hints[2]->hint)}}">
                  <span class="text-danger">{{ $errors->first('hint_3') }}</span>
                  <input type="hidden" name="hint_id_3" value="{{ @$hints[2]->id }}">
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
<script type="text/javascript">
  jQuery(document).ready(function($) {
    var points =$("#choose-points").val();
   //alert($("#choose-points").val());
   if(points==10)
    {
      $(".show-hints-1").hide();
      $(".show-hints-2").hide();
      $(".show-hints-3").hide();
    }
    if(points==20)
    {
      $(".show-hints-1").show();
      $(".show-hints-2").hide();
      $(".show-hints-3").hide();
    }
    if(points==30)
    {
      $(".show-hints-1").show();
      $(".show-hints-2").show();
      $(".show-hints-3").hide();
    }
    if(points==40)
    {
      $(".show-hints-1").show();
      $(".show-hints-2").show();
      $(".show-hints-3").show();
    }
    $('#choose-points').change(function() {
    var points = $(this).val();
    
    if(points==10)
    {
      $(".show-hints-1").hide();
      $(".show-hints-2").hide();
      $(".show-hints-3").hide();
    }
    if(points==20)
    {
      $(".show-hints-1").show();
      $(".show-hints-2").hide();
      $(".show-hints-3").hide();
    }
    if(points==30)
    {
      $(".show-hints-1").show();
      $(".show-hints-2").show();
      $(".show-hints-3").hide();
    }
    if(points==40)
    {
      $(".show-hints-1").show();
      $(".show-hints-2").show();
      $(".show-hints-3").show();
    }
});
  });
</script>

</body>
</html>
