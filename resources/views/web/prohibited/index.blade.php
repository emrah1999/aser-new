@extends('backend.app')
@section('title')
    Home Page Text
@endsection
@section('actions')
    <li>
        <a onclick="show_add_modal();" class="action-btn"><span class="glyphicon glyphicon-plus-sign"></span> Add</a>
    </li>
    <li>
        <a onclick="show_update_modal();" class="action-btn"><span class="glyphicon glyphicon-edit"></span> Edit</a>
    </li>
@endsection
@section('content')
    <div class="col-md-12">
        @if(session('display') == 'block')
            <div class="alert alert-{{session('class')}}" role="alert">
                {{session('message')}}
            </div>
        @endif
               <div class="references-in">
            <table class="references-table">
                <thead>
                <tr>
                    <th class="columns" onclick="sort_by('id')">#</th>
                    <th class="columns" onclick="sort_by('name_az')">Title</th>
                    <th class="columns" onclick="sort_by('content_az')">Description</th></tr>
                </thead>
                <tbody>
                @if($homeText)
                    <tr class="rows" id="row_{{$homeText->id}}" onclick="select_row({{$homeText->id}})">
                        <td>{{$homeText->id}}</td>
                        <td id="name_{{$homeText->id}}" name_en="{{$homeText->name_en}}" name_az="{{$homeText->name_az}}"
                            name_ru="{{$homeText->name_ru}}">{{$homeText->name_az}}</td>
                        <td id="content_{{$homeText->id}}" content_en="{{$homeText->content_en}}" content_az="{{$homeText->content_az}}"
                            content_ru="{{$homeText->content_ru}}">{{$homeText->content_az}}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- start add modal-->
    <div class="modal fade" id="add-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div style="clear: both;"></div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modal-heading">
                        <span class="masha_index masha_index1" rel="1"></span><span
                                class="modal-title"></span>
                    </div>
                </div>
                <form id="form" class="add_or_update_form" action="" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div id="form_item_id"></div>
                    <div class="modal-body">
                        <div class="form row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#azerbaijan">Azerbaijan</a></li>
                                    <li ><a data-toggle="tab" href="#english">English</a></li>
                                    <li><a data-toggle="tab" href="#russian">Russian</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="azerbaijan" class="tab-pane fade in active">
                                        <p class="name">
                                            <label for="name_az">Name: <font color="red">*</font></label>
                                            <input type="text" name="name_az" id="name_az" required="" maxlength="255">
                                        </p>
                                        <p class="content">
                                            <label for="content_az">Content: <font color="red">*</font></label><br><br>
                                            <textarea type="text" name="content_az" id="content_az" required="" maxlength="1800" class="content_news" class="height=20% , width=20% " ></textarea>
                                        </p>
                                    </div>
                                    <div id="english" class="tab-pane fade">
                                        <p class="name">
                                            <label for="name_en">Name: <font color="red">*</font></label>
                                            <input type="text" name="name_en" id="name_en" required="" maxlength="255">
                                        </p>
                                        <p class="content">
                                            <label for="content_en">Content: <font color="red">*</font></label>
                                            <textarea type="text" name="content_en" id="content_en" required="" maxlength="1800" class="content_news" class="height=20% , width=20% " ></textarea>
                                        </p>
                                    </div>

                                    <div id="russian" class="tab-pane fade">
                                        <p class="name">
                                            <label for="name_ru">Name: <font color="red">*</font></label>
                                            <input type="text" name="name_ru" id="name_ru" required="" maxlength="255">
                                        </p>
                                        <p class="content">
                                            <label for="content_ru">Content: <font color="red">*</font></label>
                                            <textarea type="text" name="content_ru" id="content_ru" required="" maxlength="1800" class="content_news" class="height=20% , width=20% " ></textarea>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="modal-footer">
                        <p class="submit">
                            <input type="reset" data-dismiss="modal" value="Cancel">
                            <input type="submit" value="Save" style=" margin-right: 25px;">
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.end add modal-->
@endsection

@section('css')
    <style>
        .content_news{
            float: right;
            width: 60% !important;
            height: 150px;
        }

        .modal-body{
            height: 400px; !important;
        }
        .submit input {
            vertical-align:  bottom   ;
        }
        .modal-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .modal-body {
            flex-grow: 1;
            overflow-y: auto;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $('#add-modal').on('shown.bs.modal', function () {
                if (!CKEDITOR.instances['content_ru']) {
                    CKEDITOR.replace('content_ru');
                }
            });

            $('#add-modal').on('hidden.bs.modal', function () {
                if (CKEDITOR.instances['content_ru']) {
                    CKEDITOR.instances['content_ru'].destroy(true);
                }
            });
            $('#add-modal').on('shown.bs.modal', function () {
                if (!CKEDITOR.instances['content_az']) {
                    CKEDITOR.replace('content_az');
                }
            });

            $('#add-modal').on('hidden.bs.modal', function () {
                if (CKEDITOR.instances['content_az']) {
                    CKEDITOR.instances['content_az'].destroy(true);
                }
            });
            $('#add-modal').on('shown.bs.modal', function () {
                if (!CKEDITOR.instances['content_en']) {
                    CKEDITOR.replace('content_en');
                }
            });

            $('#add-modal').on('hidden.bs.modal', function () {
                if (CKEDITOR.instances['content_en']) {
                    CKEDITOR.instances['content_en'].destroy(true);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('form').ajaxForm({
                beforeSubmit: function () {
                    //loading
                    swal({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                        text: 'Loading, please wait...',
                        showConfirmButton: false
                    });
                },
                success: function (response) {
                    form_submit_message(response);
                }
            });
        });

        function show_add_modal() {
            $('#form_item_id').html("");
            $(".add_or_update_form").prop("action", "{{route("homeText.store")}}");
            $('.modal-title').html('Add carousel');

            $("#name_en").val("");
            $("#name_az").val("");
            $("#name_ru").val("");
            $("#content_en").val("");
            $("#content_az").val("");
            $("#content_ru").val("");
            $("#icon").val("");

            $('#add-modal').modal('show');
        }

        function show_update_modal() {
            let id = 0;
            id = row_id;
            if (id === 0) {
                swal(
                    'Warning',
                    'Please select item!',
                    'warning'
                );
                return false;
            }

            let id_input = '<input type="hidden" name="id" value="' + row_id + '">';

            $('#form_item_id').html(id_input);
            $(".add_or_update_form").prop("action", "{{route('homeText.update')}}");
            $('.modal-title').html('Update Home Page Text');

            $("#name_en").val($("#name_" + row_id).attr("name_en"));
            $("#name_az").val($("#name_" + row_id).attr("name_az"));
            $("#name_ru").val($("#name_" + row_id).attr("name_ru"));
            $("#content_en").val($("#content_" + row_id).attr("content_en"));
            $("#content_az").val($("#content_" + row_id).attr("content_az"));
            $("#content_ru").val($("#content_" + row_id).attr("content_ru"));
            $('#icon').val("");
            $('#add-modal').modal('show');
        }
    </script>
@endsection
