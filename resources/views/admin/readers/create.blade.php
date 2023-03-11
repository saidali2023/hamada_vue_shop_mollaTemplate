
@extends('layout.admin_main')
@section('content') 

  <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">إضافة دورة جديدة</h3><br>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-6">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('instructor/dashboard')}}">الرئيسية</a>
            </li>
            <li class="breadcrumb-item active">الدورات
            </li>
            </ol> 
            </div>
          @if(session()->has('message'))
            @include('admin.includes.alerts.success')
          @endif
        </div>
      </div>     
  </div>
<style type="text/css">
  .hidden1{
    /*display: none;*/
  }
</style>
  <section id="basic-form-layouts">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                </div>
                <div class="card-content collpase show">
                  
                    <div class="card-body">
                        <form action="{{route('readers.store')}}" method="POST" name="le_form"  enctype="multipart/form-data">
                          @csrf
                          <div class="row form-row">
                            <div class="form-group col-md-6 col-sm-6">
                              <label>الديوان</label>
                              <select name="categoryId" class="form-control select2-diacritics "  placeholder="Select Category" id="get_sub_category_name">
                                <option  value=""  selected>اختار</option>  
                                
                                @foreach($categories['data'] as $i => $v)
                                  <option value="{{$v['id']}}" {{ old('categoryId') == $v['id'] ? "selected" : "" }}>
                                     {{ $v['name']}}
                                  </option>
                                @endforeach

                              </select>
                              @error('categoryId')
                                <span class="text-danger">{{$message}}</span>
                              @enderror
                              <span id="categoryError" style="color: red;"></span>
                            </div>
                            <div class="form-group col-md-6 col-sm-6">               
                                <label>القصيدة </label>
                                <select name="subCategoryId" class="form-control formselect"  id="get_sub_category" >
                                    <option  value="" selected>اختار </option>  
                                </select>
                                <span id="subcategoryError" style="color: red;"></span>
                            </div>
                            <!-- <div class="form-group col-md-4 col-sm-6">
                              <label> أسم القارئ</label>
                              <input type="text" name="title" class="form-control " id="titleid" >
                                @error('title')
                                  <span class="text-danger">{{$message}}</span>
                                @enderror
                                <span id="titleError" style="color: red;"></span>
                            </div> -->
                           
                           
                           
                          </div>
                          <div class="col-md-12"><hr/></div>

                          <div class="col-md-2">
                            <a href="#Save-btn-scroll" onclick="addVideo()" class="btn btn-primary btn-block">إضافة قارئ </a>
                          </div>
                          <div class="education-info" id="addvideo">
                              <div class="row form-row education-cont" style="background-color: #f0f1f6;border-bottom-color: red; padding: 10px;    margin: 24px;">
                                <div class="row form-row col-md-12">
                                    <div class=" col-md-6">
                                      <div class=" col-md-12">
                                        <div class="form-group">
                                          <label>اسم القارئ</label>
                                          <input type="text" name="name[]" class="form-control nameId">
                                          <span id="nameError" style="color: red;"></span>
                                        </div> 
                                      </div>
                                     
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class=" col-md-12">
                                            <div class="form-group">
                                              <label> تحميل المف الصوتي الذي يخص هذا القارئ ويجب أن يكون الأمتداد من نوع (.MP3) </label>
                                              <input type="file" name="file" id="video1" onchange="saveVideo(video1,'1','videopath1','progress-bar1','hidden1','videovalue1','videotime1','videosize1')" class="form-control fileId" accept=".MP3">
                                              <span id="fileError" style="color: red;"></span>
                                            </div> 
                                        </div>
                                         
                                        <div class="col-md-12 hidden1" id="hidden1" >
                                            <video controls="controls" id="videopath1" width="200">
                                               <source  src="" type="video/mp4">
                                            </video> 
                                            <input type="hidden" name="videovalue[]" class="videovalue" id="videovalue1" >
                                            <input type="hidden" name="videotime[]" class="videotime" id="videotime1" >
                                            <input type="hidden" name="videosize[]" class="videosize" id="videosize1" >
                                          </div> 
                                        <div class="col-md-12 ">
                                            <div class="form-group">
                                              <div class="progress prog1">
                                                <div class="progress-bar progress-bar1 prog-bar1 progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                          </div>
                          <div class="col-md-12" style="color: #FF4961; padding-right: 23px;padding-left: 23px" id="upload-error">  </div>
                          <br>
                           

                          <div class="form-group col-12 col-sm-12">
                              <button type="submit" id="Save-btn-scroll" class="btn btn-primary btn-block" onclick="return Validateallinput()">حفظ </button>
                              
                            <div class="loader-wrapper">
                                <div class="loader-container">
                                  <div class="ball-spin-fade-loader loader-blue">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                  </div>
                                </div>
                            </div>

                          </div>
                        </form>
                   
                      </div>
                  
                  
                </div>
              </div>
            </div>
          </div>
  </section>
    <?php 
       $videos=session()->get('videos_sessions');
    ?>
<script>
		$(document).ready(function () {
		    
			$('#get_sub_category_name').on('change', function () {
	        	console.log("welcome sub"); 
	        	let id = $(this).val();
	        		console.log(id); 
	        		console.log(id); 
			    $.ajax({
				    type: 'GET',
				    url: "{{url('admin/getsubcategory')}}/"+id,
				    success: function (response) {
				        console.log("welcome subxxx"); 
				        var response = JSON.parse(response)
				        console.log(response);   
					    $('#get_sub_category').empty();
					    $('#get_sub_category').append(`<option  value="" selected>اختار </option>`);
					    response.forEach(element => {
					        console.log(element);   
					        $('#get_sub_category').append(`<option value="${element['id']}">
					        ${element['name']} 
					        </option>`);
					    });
					}
				});
			});
			
			
			
	    });

	</script>


<script>
    $('.loader-container').hide();
  let videoid = 1;
   $('.hidden1').hide();
   
  function saveVideo(video,id,videopath,progres,hiddenclassss,videovalue,videotime,videosize){
    $(function () {
        $.ajaxSetup({
          headers: {'X-CSRF-Token': '{{csrf_token()}}'}
        });

        var photo = $(video)[0].files[0];
    //   var photoooo = $(video)[0].files[0].size;
    //   console.log(photoooo);
        var formData = new FormData();
        formData.append('file', photo);
        formData.append('id', id);
        $.ajax({
          // start for progress par
            xhr: function() {
              var xhr = new window.XMLHttpRequest();
              xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                  var percentComplete = evt.loaded / evt.total;
                  percentComplete = parseInt(percentComplete * 100);

                  $('.'+progres).width(percentComplete+'%');
                  $('.'+progres).html(percentComplete+'%');

                }
              }, false);
              return xhr;
            },
          // end for progress par

            url: "{{route('savevideo')}}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log('ffffffsaid');
                console.log(data+'>>>>>>>>>>>>>>>>>>>>><<<<'+hiddenclassss);
                $('.'+hiddenclassss).show();
                $('#'+videopath).attr('src', "https://elnamat.com/poems/poems/assets_admin/videos/"+ data);
                document.getElementById(videovalue).value = data;
                var getVieovalue = document.getElementById(videopath);
                
                getVieovalue.onloadedmetadata = function() {
                    var onevide=Math.round(this.duration / 60);  
                    document.getElementById(videotime).value = onevide;
                };
                
                var videokb= photo.size/1024;
                var videomb=videokb/1024;
                var videosizee=Math.round(videomb, 1);
                document.getElementById(videosize).value =videosizee ;
              document.getElementById(video).value = 'video.png';
              // $('#'+videovalue).append('eeeeeee');
            }
        });
        
    });
    
    
  }




 /// remove video from list and session
  function removevideo(videoId,id) {
      var myobj = document.getElementById(videoId);
      myobj.remove();
      if(confirm("Are you sure")) {
        $.ajax({
              type: 'GET',
              url: "{{url('removeVideoSessionItem')}}/"+id,
              success: function (response) {
                console.log(response+'nnnnnnn>>>>>>>>');   
            }
        });
      } 
  }
    
    

  function addVideo(){
        videoid += 1;
        
        const itemid = Math.random();
        $('#addvideo').append(`<div class="row form-row education-cont" id="itemid${itemid}" style="background-color: #f0f1f6;border-bottom-color: red; padding: 10px;margin: 24px;">
                            <div class="row form-row col-md-12 ">

                              <div class="col-md-6" >

                                  <div class=" col-md-12">
                                    <div class="form-group">
                                      <label>اسم القارئ</label>
                                      <input type="text" name="name[]"  class="form-control nameId">
                                      <span id="nameError" style="color: red;"></span>
                                    </div>
                                  </div>
                                  
                              </div>
                              <div class="col-md-6">
                                <div class=" row form-row">
                                  <div class="col-md-10">
                                      <div class="form-group">
                                      <label> تحميل المف الصوتي الذي يخص هذا القارئ ويجب أن يكون الأمتداد من نوع (.MP3) </label>                  
                                        <input type="file" name="file" id="video${videoid}" onchange="saveVideo(video${videoid},'${videoid}','videopath${videoid}','progress-bar${videoid}','hidden${videoid}','videovalue${videoid}','videotime${videoid}','videosize${videoid}')" class="form-control fileId" accept=".MP3">
                                        <span id="fileError" style="color: red;"></span>
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                      <label class="d-md-block d-sm-none d-none">&nbsp;</label>
                                      <a href="#" class="btn btn-danger trash" id="itemid${itemid}" onClick="removevideo(this.id,'${videoid}')"><i class="far fa-trash-alt"></i>X</a>
                                  </div>
                                </div>
                                <div class="col-md-12 hidden${videoid}" id="hidden${videoid}">
                                      <video controls="controls" id="videopath${videoid}" width="200">
                                        <source  src="" type="video/mp4">
                                      </video> 
                                       <input type="hidden" name="videovalue[]" class="videovalue" id="videovalue${videoid}" >
                                       <input type="hidden" name="videotime[]" class="videotime" id="videotime${videoid}" >
                                       <input type="hidden" name="videosize[]" class="videosize" id="videosize${videoid}" >

                                </div> 
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                      <div class="progress prog1">
                                        <div class="progress-bar progress-bar${videoid} prog-bar1 progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                      </div>
                                    </div>
                                </div>
                              </div>
                              
                            </div>
                          </div>`); 
        $('.hidden'+videoid).hide(); 
  }
  
  function Validateallinput() {
    
    
    var categoryid = document.getElementById("get_sub_category_name");
    var categoryError = document.getElementById("categoryError");
    
    var subcategoryid = document.getElementById("get_sub_category");
    var subcategoryError = document.getElementById("subcategoryError");
    
   
    if (categoryid.value == "") {
        categoryError.innerHTML = "يرجى ادخال المستوى الرئيسي";
            // titleid.focus(); 
            return false;
    }
    categoryError.innerHTML = "";
    
    if (subcategoryid.value == "") {
        subcategoryError.innerHTML = "يرجي إدخال المستوى الفرعي";
            // titleid.focus(); 
            return false;
    }
    subcategoryError.innerHTML = "";
    
    
    
    
    
    
    


    var nameId = document.querySelectorAll(".nameId");
    var nameError = document.getElementById("nameError");
    let fileId = document.querySelectorAll(".fileId");
    var fileError = document.getElementById("fileError");
    let videovalue = document.querySelectorAll(".videovalue");
    
    let videotime = document.querySelectorAll(".videotime");
    
    
    for (let i = 0; i < nameId.length; i++) { 

        if (nameId[i].value == "") {
             $('#upload-error').empty();
        // nameError.innerHTML = "ادخل عنوان الفيديو  <b>";
        $('#upload-error').append(` <div class="bs-callout-pink callout-border-left mt-1 p-1 error-upload" >
                            <strong></strong>
                            <p>ادخل عنوان الفيديو </p>
                          </div>`);
            nameId[i].focus(); 
            return false;
        }
        
    
        if (fileId[i].value == "") {
            $('#upload-error').empty();
            
            $('#upload-error').append(`<div class="bs-callout-pink callout-border-left mt-1 p-1 error-upload" >
                                <strong></strong>
                                <p>يرجى إرفاق فيديو </p>
                              </div>`);
            fileId[i].focus(); 
            return false;
        }
       
       
        var filePath = fileId[i].value;
        // var allowedExtensions = /(\.MP4|\.FLV|\.ogg|\.webm|\.mov)$/i;
        var allowedExtensions = /(\.MP3)$/i;
        if(!allowedExtensions.exec(filePath)){
            $('#upload-error').append(`<div class="bs-callout-pink callout-border-left mt-1 p-1 error-upload" >
                                <strong> </strong>
                                <p> يجب أن يكون الأمتداد من نوع (.MP4,.FLV,.ogg,.webm.)فقط </p>
                              </div>`);
           
            fileId[i].value = '';
            fileId[i].focus(); 
            return false;
        }
        
        
      
        if (videovalue[i].value == "") {
             $('#upload-error').empty();
            $('#upload-error').append(` <div class="bs-callout-pink callout-border-left mt-1 p-1 error-upload" >
                                <strong></strong>
                                <p>يرجى الإنتظار حتي يتم التحميل</p>
                              </div>`);
            videovalue[i].focus(); 
            return false;
        }
        
        if (videotime[i].value == "") {
             $('#upload-error').empty();
            $('#upload-error').append(` <div class="bs-callout-pink callout-border-left mt-1 p-1 error-upload" >
                                <strong></strong>
                                <p>يرجى الإنتظار ثواني حتي يتم التحميل</p>
                              </div>`);
            videotime[i].focus(); 
            return false;
        }
        
    }
    for (let i = 0; i < nameId.length; i++) { 

        if (videovalue[i].value == "") {
             $('#upload-error').empty();
            $('#upload-error').append(` <div class="bs-callout-pink callout-border-left mt-1 p-1 error-upload" >
                                <strong></strong>
                                <p>يرجى الإنتظار حتي يتم التحميل</p>
                              </div>`);
            videovalue[i].focus(); 
            return false;
        }else{
            fileId[i].value= null;
        }
        
        if (videotime[i].value == "") {
             $('#upload-error').empty();
            $('#upload-error').append(` <div class="bs-callout-pink callout-border-left mt-1 p-1 error-upload" >
                                <strong></strong>
                                <p>يرجى الإنتظار ثواني حتي يتم التحميل</p>
                              </div>`);
            videotime[i].focus(); 
            return false;
        }else{
            fileId[i].value= null;
        }
        
    }
    
    // for (let i = 0; i < nameId.length; i++) { 
    //     fileId[i].value= null;
        
    // }
    $('.loader-container').show();
    // return false;
  }      
  


</script>

@endsection