@extends('admin.layouts.main')

@section('title')Manage Rooms
@endsection

@section('inlinestyle')
.tools .btn {
    float:right;
    margin-left:8px;
}
.mr-10 {
    margin-right:10px;
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
                        <button type="button" class="btn btn-success btn-small" data-toggle="modal" data-target="#editModal" data-create="true"> + Add New Room </button>
                    </div>
                    <div class="float-right mr-10">
                        <a href="{{route('roomtypes.index')}}" class="btn btn-info btn-small"  data-create="true"> Room Types </a>
                    </div>
                    <div class="float-right mr-10">
                        <a href="{{route('roomcapacity.index')}}" class="btn btn-info btn-small"  data-create="true"> Room Capacities </a>
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
                                    <tr id="roominfo-{{$room->id}}" data-id="{{$room->id}}" data-name="{{$room->name}}" data-type="{{$room->room_type_id}}" data-capacity="{{$room->room_capacity_id}}" data-room_type="{{$room->type}}" data-room_capacity="{{$room->capacity}}"
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
                                                <button type="button" data-id="{{$room->id}}" class="btn btn-danger btn-sm rowDelete">{{__('Delete') }}</button>
                                                <button type="button" class="btn btn-primary btn-sm mr-left-10 editdata">{{ __('Edit') }}</button>
                                                <a href="{{ route('room.show', $room->id) }}" class="btn btn-success btn-sm mr-left-10 rowView">{{__('View') }}</a>
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

<script id="dataView" type="text/x-jsrender">
    <div class="row">
        @{{if id}}
            <div class="col-sm-6">
        @{{else}}
            <div class="col-sm-12">
        @{{/if}}
            <div class="form-group">
                <label for="roomname" class="control-label">Name:</label>
                <strong>@{{:name}}</strong>
            </div>
            <div class="form-group">
                <label for="roomname" class="control-label">Type:</label>
                <strong>@{{:room_type}}</strong>
            </div>
            <div class="form-group">
                <label for="roomname" class="control-label">Capacity:</label>
                <strong>@{{:room_capacity}}</strong>
            </div>
        </div>
        @{{if id}}
            <div class="col-sm-6" id="uploadList">
                <ul id="imageList" class="imageList">
                    @{{if images ~rooomid=id}}
                        @{{props images tmpl="#uploadimage" /}}
                    @{{/if}}
                </ul>
            </div>
        @{{/if}}
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
                <div id="updateimagemessage"></div>
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
                <ul id="imageList" class="imageList">

                    @{{if images ~rooomid=id}}
                        @{{props images tmpl="#uploadimage" /}}
                    @{{/if}}
                </ul>
            </div>
        @{{/if}}
    </div>
</script>

<script id="datarowTpl" type="text/x-jsrender">
    <tr id="roominfo-@{{:id}}" data-id="@{{:id}}" data-name="@{{:name}}" data-type="@{{:room_type_id}}" data-capacity="@{{:room_capacity_id}}" data-room_type="@{{:type}}" data-room_capacity={{@capacity}} 
        @{{if images}}
            data-images="@{{:images }}"
        @{{/if}} >
        <td class="align-middle">
            @{{:name }}
        </td>
        <td class="align-middle">@{{:type }}</td>
        <td class="align-middle">@{{:capacity }}</td>
        <td class="align-middle">
            @{{if images ~rooomid=id}}
                <ul class="imageList">
                    @{{props images tmpl="#inlineimages" /}}
                </ul>
            @{{/if}}
        </td>
        <td class="align-middle">
            <div class="clearfix tools">
                <button type="button" data-id="@{{:id}}" class="btn btn-danger btn-sm rowDelete">Delete</button>
                <button type="button" class="btn btn-primary btn-sm mr-left-10 editdata">Edit</button>
                <a href="javascript:void(0)" class="btn btn-success btn-sm mr-left-10 rowView">{{__('View') }}</a>
            </div>
        </td>
    </tr>
</script>
<script type="text/x-jsrender" id="uploadimage">
    <li class="image-thumb" style="background-image:url({{asset("/storage/rooms")}}/@{{:~rooomid}}@{{:rooomid}}/@{{:prop}});">
        <a href="javascript:void(0)" class="deleteImage" data-id="@{{:~rooomid}}@{{:rooomid}}" data-image="@{{:prop}}"><i class="fas fa-minus-circle"></i></a>
    </li>
</script>
<script type="text/x-jsrender" id="inlineimages">
    <li class="image-thumb" style="background-image:url({{asset("/storage/rooms")}}/@{{:~rooomid}}/@{{:prop}});">
        <a href="{{asset("/storage/rooms")}}/{{$room->id}}/@{{:prop}}" target="__blank"></a>
    </li>
</script>


@endsection

@section('pageScript')

jQuery(document).on('click', '.rowView', function(e){
    e.preventDefault();
    let data = jQuery(this).closest('tr').data(),
        tmpl = $.templates("#dataView"),
        html = tmpl.render(data);
    $("#modalBody").html(html);
    $("#editModal").modal('show');
});

jQuery(document).on('click', '.deleteImage', function(e){
    e.preventDefault();
    if(confirm('Are you sure to delete this image?')){
        let v = jQuery(this),
            room_id = v.closest('ul').data('id'),
            image = v.data('image');
        jQuery.ajax({
            type: "DELETE",
            url: '/admin/rooms/'+v.data('id')+'/imageupload',
            data: {imageurl:image},
            beforeSend: function(){
                $("#uploadImage").addClass('submitting');
                $("#updateimagemessage").hide();
            },
            success: function(response){
                if(response.success){
                    let data = response.data,
                        tmpl = $.templates('#datarowTpl'),
                        html = tmpl.render(data);
                    $("#roominfo-"+data.id).replaceWith(html);
                    v.closest('li').stop().hide(300, function(){
                        $(this).remove();
                    });
                }else{
                    alert(response.message);
                }
                $("#uploadImage").removeClass('submitting');
            },
            error: function(error){
                $("#uploadImage").removeClass('submitting');
                if(error.responseText){
                    let response = JSON.parse(error.responseText);
                    let tmpl = jQuery.templates("#errors");
                    let html = tmpl.render(response);
                    $("#updateimagemessage").html(html).stop().show();                
                }else {
                    alert(error.message);
                }
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

$("#editModal").on('show.bs.modal', function (event) {
    var v = $(event.relatedTarget);
    if(v.data('create')){
        var tmpl = jQuery.templates("#dataTpl"); // Get compiled template
        let data= {name:''}
        var html = tmpl.render(data); 
        $("#modalBody").html(html);
        var modal = $(this);
        modal.find('.modal-title').text('Create New Room');
    }else{
        var modal = $(this);
        modal.find('.modal-title').text('Edit Room');
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
            $("#updateimagemessage").hide();
        },
        success: function(response){
            form.removeClass('submitting');
            if(response.success){
                let url = response.url,
                    result = response.result,
                    data = {'prop':url, 'rooomid':result.id};
                let tmpl = $.templates('#uploadimage'),
                    html = tmpl.render(data);
                $("#imageList").append(html);
                $('#uploadImage input[type="file"]').val('');
                let rowtmpl = $.templates('#datarowTpl'),
                    rowhtml = rowtmpl.render(result);
                $("#roominfo-"+result.id).replaceWith(rowhtml);
            }else {
                alert(response.message);
            }
        }, 
        error: function(error){
            $("#uploadImage").removeClass('submitting');
            if(error.responseText){
                let response = JSON.parse(error.responseText);
                let tmpl = jQuery.templates("#errors");
                let html = tmpl.render(response);
                $("#updateimagemessage").html(html).stop().show();                
            }else {
                alert(error.message);
            }
        }
    });
});


jQuery(document).on('submit', '#newrowData', function(e){
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
        },
        success: function(response){
            if(response.success){
                let data = response.data;
                let rowtmpl = $.templates('#datarowTpl'),
                    newdata = rowtmpl.render(data);
                $("#listTable tbody").append(newdata);
                $("#editModal .modal-body").html('');
                $("#editModal").modal('hide');
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


jQuery(document).on('click', '.updateData', function(e){
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
                let data = response.data;
                let rowtmpl = $.templates('#datarowTpl'),
                    newdata = rowtmpl.render(data);
                $("#roominfo-"+data.id).replaceWith(newdata);
                $("#updatemessage").html(html).stop().show();
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

jQuery(document).on('click', '.rowDelete', function(e){
        e.preventDefault();
        let v = jQuery(this);
        if(confirm('Are you sure?')){
            jQuery.ajax({
                type:'DELETE',
                url: '/admin/rooms/'+v.data('id'),
                beforeSend: function(){
                    v.closest('tr').addClass('deleting');
                },
                success: function(response){
                    v.closest('tr').removeClass('deleting');
                    if(response){
                        v.closest('tr').stop().slideUp(300, function(){
                            jQuery(this).remove();
                        });
                    }else {
                        alert(response.message);
                    }
                }, 
                error: function(error){
                    v.removeClass('submitting');
                    alert('Failed to Delete');
                }
            })
        }
    });



@endsection