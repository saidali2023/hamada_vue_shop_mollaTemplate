
@extends('layout.admin_main')
@section('content') 
@toastr_css


    <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                      <h3 class="content-header-title mb-0 d-inline-block">الدورات المسجلة</h3><br>
                      <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a>
                            </li>
                            
                            <li class="breadcrumb-item active">الدورات المسجلة
                            </li>
                          </ol> 
                        </div>
                      </div>
                    </div>
                    <div class="content-header-right col-md-6 col-12">
                      <div class="dropdown float-md-right">
                           <a href="{{route('readers.create')}}"  class="btn btn-primary float-right mt-2">إضافة جديد </a>
                      </div>
                    </div>
                    
                     
                    @if(session()->has('message'))
                        @include('admin.includes.alerts.success')
                    @endif

                    @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>خطا</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
    </div>
    <section id="keytable">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title"></h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                    <p class="card-text"></p>
                    <table class="table table-striped table-bordered keytable-integration">
                        <thead>
                            <tr>
                                <th>الديوان </th>
                                <th>القصيدة</th>
                                 <!--<th>اسم القارئ</th>-->
                                <!--<th>الملف </th>-->
                                <th class="text-center">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>                     
                            @foreach ($allpoems as $_item)
                            <tr>        
                                <td>
                                    @foreach($categories['data'] as $i => $v)
                                        @if($v['id'] == $_item->categoryId)
                                            {{ $v['name']}}
                                        @endif
                                    @endforeach
                                </td> 

                                <td>
                                    
                                    @foreach($categories['data'] as $i => $v)
                                    
                                        @if($v['id'] == $_item->categoryId)
                                            @foreach($v['poems'] as $i => $item)
                                                @if($item['id'] ==$_item->subCategoryId )
                                                <a href="{{url('admin/get-reader-file',$_item->subCategoryId)}}" class="edit-course" >
                                                    {{ $item['name']}}
                                                </a>
                                                @endif
                                            @endforeach
                                        @endif
                                        
                                    @endforeach
                                </td>
                                <!--<td>-->
                                <!--    <audio controls  >-->
                                <!--        <source src="{{asset('assets_admin/videos/'.$_item->url) }}" type="audio/ogg">-->
                                <!--        <source src="{{asset('assets_admin/videos/'.$_item->url) }}" type="audio/mpeg">-->
                                <!--        Your browser does not support the audio element.-->
                                <!--    </audio>-->
                                <!--</td>         -->
                                <td class="text-center">
                                    <div class="actions">
                                        <a href="{{url('admin/get-reader-file',$_item->subCategoryId)}}" class="edit-course" >
                                            <button type="button" class="btn btn-outline-success "><i class="la la-eye"></i></button>
                                        </a>
                                        <!--<a  data-toggle="modal" data-catid="{{ $_item->id }}" data-target="#delete" class="delete-course">-->
                                        <!--   <button type="button" class=" btn btn-outline-warning"><i class="la la-trash-o"></i></button>-->
                                        <!--   <span class="deletecourse">حذف الدورة</span>-->
                                        <!--</a>-->
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
                </div>
              </div>
            </div>
        

            <div class="modal fade" id="delete" aria-hidden="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document" >
                                                        <div class="modal-content">
                                                    
                                                            <div class="modal-body">
                                                                <div class="form-content p-2">
                                                                    <h4 class="modal-title"></h4>
                                                                    <p class="mb-4">هل انت متأكد من حذف هذا العنصر</p>
                                                                    <div class="row text-center">
                                                                        <div class="col-sm-3">
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <form method="post" action="{{route('courses.destroy','test')}}">
                                                                                 @csrf
                                                                                 @method('delete')
                                                                                 <input type="hidden" name="id" id="cat_id">
                                                                                <button type="submit" class="btn btn-primary">حذف </button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                </div>
        </div>      
    </section>




<style>
    .add-video {
      position: relative;
      display: inline-block;
    }

    .add-video .addvideo {
      visibility: hidden;
      width: 76px;
      font-size: 10px;
      background-color: black;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px 0;
      
      position: absolute;
      z-index: 1;
      bottom: 100%;
      left: 50%;
      margin-left: -35px;
    }

    .add-video:hover .addvideo {
      visibility: visible;
    }
    /*//////////////*/

    .all-video {
      position: relative;
      display: inline-block;
    }

    .all-video .allvideo {
      visibility: hidden;
      width: 75px;
      font-size: 10px;
      background-color: black;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px 0;
      
      position: absolute;
      z-index: 1;
      bottom: 100%;
      left: 50%;
      margin-left: -35px;
    }

    .all-video:hover .allvideo {
      visibility: visible;
    }

    /*//////////////*/

    .edit-course {
      position: relative;
      display: inline-block;
    }

    .edit-course .editcourse {
      visibility: hidden;
      width: 75px;
      font-size: 10px;
      background-color: black;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px 0;
      
      position: absolute;
      z-index: 1;
      bottom: 100%;
      left: 50%;
      margin-left: -35px;
    }

    .edit-course:hover .editcourse {
      visibility: visible;
    }

    /*//////////////*/

    .delete-course {
      position: relative;
      display: inline-block;
    }

    .delete-course .deletecourse {
      visibility: hidden;
      width: 75px;
      font-size: 10px;
      background-color: black;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px 0;
      
      position: absolute;
      z-index: 1;
      bottom: 100%;
      left: 50%;
      margin-left: -35px;
    }

    .delete-course:hover .deletecourse {
      visibility: visible;
    }
</style>

<script> 
        
    $('#delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) 
        var cat_id = button.data('catid') 
        var modal = $(this)
        modal.find('.modal-body #cat_id').val(cat_id);
    })
</script> 
    @toastr_js
    @toastr_render
@endsection