<?php $this->layout('layoutAdmin', ['title' => 'Create post']) ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content container-fluid">

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Admin panel</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="">
                        <div class="box-header">
                            <h2 class="box-title">Add Post</h2>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                                <form action="/admin/store" enctype="multipart/form-data" method="post">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title (English)</label>
                                        <input name="title" type="text" class="form-control" id="exampleInputEmail1" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title (Polish)</label>
                                        <input name="title_pl" type="text" class="form-control" id="exampleInputEmail1">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title (Russian)</label>
                                        <input name="title_ru" type="text" class="form-control" id="exampleInputEmail1">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Title (Germany)</label>
                                        <input name="title_de" type="text" class="form-control" id="exampleInputEmail1">
                                    </div>
                                </div>


                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Slug</label>
                                        <input name="slug" type="text" class="form-control" id="exampleInputEmail1">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date</label>
                                        <input name="date" type="date" class="form-control" id="exampleInputEmail1" autocomplete>
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">All description (English)</label>
                                        <textarea name="all_desc" class="form-control" id="editor" style="height: 200px;"></textarea>
                                    </div>
                                </div>
                                
                                <button class="btn btn-primary" id="toggle-button">Show fields for other languages</button>
                                <hr>
                                    <div class="target">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">All description (Polish)</label>
                                        <textarea name="all_desc_pl" class="form-control" id="" style="height: 100px;"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">All description (Russian)</label>
                                        <textarea name="all_desc_ru" class="form-control" id="" style="height: 100px;"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">All description (Germany)</label>
                                        <textarea name="all_desc_de" class="form-control" id="" style="height: 100px;"></textarea>
                                    </div>
                                </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input name="file" type="file" required>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name picture</label>
                                        <input name="title_img" type="text" class="form-control" id="exampleInputEmail1" value="<?=$article->author;?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select value="<?=$category?>" name="category" class="form-control select2" style="width: 100%;">



                                            <?php foreach ($categories as $item):?>
                                                <option <?php if($category == $item['title']) echo 'selected="selected"'; ?>>
                                                    <?=$item['title']?>
                                                </option>
                                            <?php endforeach;?>


                                        </select>
                                    </div>
                                </div>




                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit">Create Post</button>
                                    </div>
                                </form>
                        </div>


                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    For questions to the main administrator.
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016 <a href="#">Company</a>.</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:;">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:;">
                        <h4 class="control-sidebar-subheading">
                            Custom Template Design
                            <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Some information about this general settings option
                    </p>
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="/assets_admin/js/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/assets_admin/js/bootstrap.min.js"></script>
<script src="/assets_admin/js/select2.full.min.js"></script>
<script src="/assets_admin/js/jquery.dataTables.min.js"></script>
<script src="/assets_admin/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets_admin/js/adminlte.min.js"></script>
<!--<script src="/assets_admin/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>-->
<!--<script>-->
<!--    ClassicEditor-->
<!--        .create( document.querySelector( '#editor' ) )-->
<!--        .catch( error => {-->
<!--            console.error( error );-->
<!--        } );-->
<!--</script>-->
<script>document.getElementById('toggle-button').addEventListener('click', function () {
    toggle(document.querySelectorAll('.target'));
});

function toggle (elements, specifiedDisplay) {
  var element, index;

  elements = elements.length ? elements : [elements];
  for (index = 0; index < elements.length; index++) {
    element = elements[index];

    if (isElementHidden(element)) {
      element.style.display = '';

      // If the element is still hidden after removing the inline display
      if (isElementHidden(element)) {
        element.style.display = specifiedDisplay || 'block';
      }
    } else {
      element.style.display = 'none';
    }
  }
  function isElementHidden (element) {
    return window.getComputedStyle(element, null).getPropertyValue('display') === 'none';
  }
}</script>


<script>
    CKEDITOR.replace( 'all_desc', {
        height: 400,
        filebrowserUploadUrl: "/upload"
    });
</script>
<script>
    CKEDITOR.replace( 'all_desc_pl', {
        height: 400,
        filebrowserUploadUrl: "/upload"
    });
</script>
<script>
    CKEDITOR.replace( 'all_desc_de', {
        height: 400,
        filebrowserUploadUrl: "/upload"
    });
</script>
<script>
    CKEDITOR.replace( 'all_desc_ru', {
        height: 400,
        filebrowserUploadUrl: "/upload"
    });
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
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
</body>
</html>
