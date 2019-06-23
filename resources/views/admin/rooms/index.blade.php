@extends('admin.layouts.main')

@section('title')Manage Hotels
@endsection

@section('inlinestyle')
.tools .btn {
    float:right;
    margin-left:8px;
}
.hidden {display:none;}
.submitting {position:relative;}
.submitting::after{position:absolute;top:0;left:0;width:100%;height:100%;display:block;content:"";z-index:99;background:rgba(255,255,255,0.5);}
.imageList {
    margin:0;
    padding:0;
    list-style:none;
    display:float;
    align-items:center;
    justify-content:space-between;
}
.imageList li {
    display:inline-block;
    position:relative;
    width:48px;
    height:48px;
    overflow:hidden;
    border-radius:3px;
    background-size:cover;
    background-repeat:no-repeat;
}
.imageList li a:not(.deleteImage) {
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
}
.imageList li a.deleteImage {
    position:absolute;
    right:0;
    top:-4px;
    z-index:2;
    opacity:0.7;
    font-size:15px;
}
.imageList li a.deleteImage:hover,
.imageList li a.deleteImage:active {
    opacity:1;
}
.imageList li a.deleteImage i.fas {
    color:red;
}
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-left"><h4>Rooms</h4></div>
                    <div class="float-right">
                        <button type="button" class="btn btn-success btn-small" data-toggle="modal" data-target="#createNewHotel" data-create="true"> + Add New Room </button>
                    </div>
                </div>
                @if ($rooms->isEmpty())
                    <div class="card-body">
                        <div class="emptyMessage">No Rooms found.</div>
                        <table id="listTable" class="table table-striped">
                            <thead class="hidden">
                                <th>{{__('Name') }}</th>
                                <th>{{__('Type') }}</th>
                                <th>{{__('Capacity') }}</th>
                                <th>{{ __('Images') }}</th>
                                <th class="text-right">{{ __('Options') }}</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="card-body">
                        <table id="listTable" class="table table-striped">
                            <thead>
                                <th>{{__('Name') }}</th>
                                <th>{{__('Type') }}</th>
                                <th>{{__('Capacity') }}</th>
                                <th>{{ __('Images') }}</th>
                                <th class="text-right">{{ __('Options') }}</th>
                            <tbody>
                                @foreach($rooms as $room)
                                    <tr id="roominfo-{{$room->id}}" data-id="{{$room->id}}" data-name="{{$room->name}}" data-type="{{$room->room_type_id}}" data-capacity="{{$room->room_capacity_id}}" 
                                        @if($room->images) 
                                            data-images="{{ $room->images }}"
                                        @endif >
                                        <td class="align-middle">
                                            {{ $room->name }}
                                        </td>
                                        <td class="align-middle">{{ $room->type }}</td>
                                        <td class="align-middle">{{ $room->capacity }}</td>
                                        <td class="align-middle">
                                            @if($room->images)
                                                <ul class="imageList">
                                                    @php
                                                        $imagelist = json_decode($room->images);
                                                    @endphp
                                                    @foreach($imagelist as $image)
                                                        <li style="background-image:url({{asset('/storage/rooms/'.$room->id.'/'.$image)}});">
                                                            <a href="{{asset('/storage/rooms/'.$room->id.'/'.$image)}}" target="__blank"></a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div class="clearfix tools">
                                                <button type="button" class="btn btn-danger btn-sm">{{__('Delete') }}</button>
                                                <button type="button" class="btn btn-primary btn-sm mr-left-10 editdata">{{ __('Edit') }}</button>
                                                <a href="{{ route('room.show', $room->id) }}" class="btn btn-success btn-sm mr-left-10">{{__('View') }}</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    
@endsection


@section('pageFooter')
    
<div class="modal" tabindex="-1" role="dialog" id="editModal" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalBody" class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>


<script id="errors" type="text/x-jsrender">
    <div class="alert alert-danger">
        <strong>@{{:message}}</strong>
        <ul>
        @{{props errors}}
            @{{props prop}}
                <li>@{{:prop}}</li>
            @{{/props}}
        @{{/props}}
        </ul>
    </div>
</script>

<script id="success" type="text/x-jsrender">
    <div class="alert alert-success">
        <strong>@{{:message}}</strong>
    </div>
</script>


<script id="dataTpl" type="text/x-jsrender">
    <div class="row">
        @{{if id}}
            <div class="col-sm-6">
        @{{else}}
            <div class="col-sm-12">
        @{{/if}}
            <form name="formData"
                @{{if id}} action="/admin/rooms/@{{:id}}" onsubmit="return false;" @{{else}} action="/admin/rooms" id="newrowData" enctype="multipart/form-data" @{{/if}}
            >
                <div class="form-group">
                    <label for="roomname" class="control-label">Name</label>
                    <input type="text" id="roomname" name="name" class="form-control" value="@{{:name}}" />
                </div>
                <div class="form-group">
                    <label for="roomtype" class="control-label">Room Type</label>
                    <select class="form-control" id="roomtype" name="room_type_id">
                        <option value="">{{ __("Please Select Room Type")}}</option>
                        @foreach($room_types as $room_type)
                            <option value="{{$room_type->id}}"">{{$room_type->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="roomcapacity" class="control-label">Capacity</label>
                    <select class="form-control" id="roomcapacity" name="room_capacity_id">
                        <option value="">{{ __("Please Select Room Capacity")}}</option>
                        @foreach($room_capacities as $room_capacity)
                            <option value="{{$room_capacity->id}}"">{{$room_capacity->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div id="updatemessage"></div>
                <div class="form-group">
                    @{{if id}}
                        <button type="button" class="btn btn-primary updateData">Save</button>
                    @{{else}}
                        <button type="submit" class="btn btn-primary float-right">Create</button>
                    @{{/if}}
                </div>
            </form>
        </div>
        @{{if id}}
            <div class="col-sm-6" id="uploadList">
                <div class="form-group">
                    <label for="newimage" class="control-label">Images</label>
                    <form method="post" action="/admin/rooms/@{{:id}}/imageupload" enctype="multipart/form-data" id="uploadImage">
                        <input type="hidden" name="room_id" value="@{{:id}}" />
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="file" name="room_image" />
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
                <ul class="imageList" data-id="@{{:id}}">

                    @{{if images}}
                        @{{props images}}
                            <li id="image" class="image-thumb" style="background-image:url({{asset("/storage/rooms")}}/{{$room->id}}/@{{:prop}});">
                                <a href="javascript:void(0)" class="deleteImage" data-image="@{{:prop}}"><i class="fas fa-minus-circle"></i></a>
                            </li>
                        @{{/props}}
                    @{{/if}}
                </ul>
            </div>
        @{{/if}}
    </div>
</script>


@endsection

@section('pageScript')

jQuery(document).on('click', '.deleteImage', function(e){
    e.preventDefault();
    if(confirm('Are you sure to delete this image?')){
        let v = jQuery(this),
            room_id = v.closest('ul').data('id'),
            image = v.data('image');
        jQuery.ajax({
            type: "DELETE",
            url: '/admin/rooms/{{$room->id}}/imageupload',
            data: {imageurl:image},
            beforeSend: function(){
                
            },
            success: function(response){

            },
            error: function(error){
                alert('error');
            }
        });
    }
});

$(document).ready(function(){
});

jQuery(document).on('click', '.editdata', function(e){
    e.preventDefault();
    var tmpl = jQuery.templates("#dataTpl"); // Get compiled template
    let data = jQuery(this).closest('tr').data();
    /* if(data.images){
        let $imagelist = [];
        $.each(data.images, function(index, imagelink){
            $imagelist[index] = '{{asset("/storage/rooms")}}/'+data.id+'/'+imagelink+'';
        });
        data.images = $imagelist;
    } */
    var html = tmpl.render(data); 
    $("#modalBody").html(html);
    if(typeof(data.type) !=='undefined' || data.type !=''){
        $("#roomtype").val(data.type);
    }
    if(typeof(data.capacity) !=='undefined' || data.capacity !=''){
        $("#roomcapacity").val(data.capacity);
    }
    $("#editModal").modal('show');
});

$("#createNewHotel").on('show.bs.modal', function (event) {
    var v = $(event.relatedTarget);
    if(v.data('create')){
        var tmpl = jQuery.templates("#HotelTpl"); // Get compiled template
        let data= {name:'', address:'', city:'', state:'', 'phone':'', 'email':''}
        var html = tmpl.render(data); 
        $("#modalBody").html(html);
        var modal = $(this);
        modal.find('.modal-title').text('Create New Hotel');
    }else{
        var modal = $(this);
        modal.find('.modal-title').text('Edit Hotel');
    }   
});


jQuery(document).on('submit', '#uploadImage', function(e){
    e.preventDefault();
    let form = $(this);
    jQuery.ajax({
        type:'POST',
        url: $(this).attr('action'),
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            form.addClass('submitting');
            $("#imagePreview").hide();
        },
        success: function(response){
            form.removeClass('submitting');
            form.find('input[name="hotelimage"]').val('');
            if(response.success){
                $("#imagePreview").find('img').attr('src', response.url).end().show();
            }else {
                alert(response.message);
            }
        }, 
        error: function(error){
            form.removeClass('submitting');
            if(error.responseText){
                let response = JSON.parse(error.responseText);
                let info = response.errors.hotelimage[0];
                alert(info);
            }else {
                alert(error.message);
            }
        }
    });
});


jQuery(document).on('submit', '#newHotelData', function(e){
    e.preventDefault();
    let form = $(this);
    jQuery.ajax({
        type:'POST',
        url: $(this).attr('action'),
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            form.addClass('submitting');
            $("#imagePreview").hide();
        },
        success: function(response){
            if(response.success){
                let data = response.data;
                let rowtmpl = $.templates('#UpdateHotelTpl'),
                    newdata = rowtmpl.render(data);
                $("#listTable tbody").append(newdata);
                $("#createNewHotel .modal-body").html('');
                $("#createNewHotel").modal('hide');
                alert('New Hotel Added');
            }else {
                alert(response.message);
            }
            form.removeClass('submitting');
        }, 
        error: function(error){
            form.removeClass('submitting');
            if(error.responseText){
                let response = JSON.parse(error.responseText);
                let tmpl = jQuery.templates("#errors");
                let html = tmpl.render(response);
                $("#updatemessage").html(html).stop().show();                
            }else {
                alert(error.message);
            }
        }
    });
});


jQuery(document).on('click', '.updateHotel', function(e){
    e.preventDefault();
    let form = $(this).closest('form');
    jQuery.ajax({
        type:'POST',
        url: form.attr('action'),
        data:  form.serialize(),
        beforeSend: function(){
            form.addClass('submitting');
            $("#updatemessage").hide();
        },
        success: function(response){
            form.removeClass('submitting');
            if(response.success){
                let tmpl = $.templates("#success"),
                    html = tmpl.render(response);
                $("#updatemessage").html(html).stop().show();
                let data = response.data;
                let $row = $("#hoteinfo-"+data.id),
                    rowtmpl = $.templates('#UpdateHotelTpl'),
                    newdata = rowtmpl.render(data);

                $row.replaceWith(newdata);
            }else {
                alert(response.message);
            }
        }, 
        error: function(error){
            form.removeClass('submitting');
            if(error.responseText){
                let response = JSON.parse(error.responseText);
                let tmpl = jQuery.templates("#errors");
                let html = tmpl.render(response);
                $("#updatemessage").html(html).stop().show();
            }else {
                alert(error.message);
            }
        }
    });
});



@endsection