@extends('admin.layouts.main')

@section('title')Manage Rooms
@endsection

@section('pageHeader')

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" />

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
                    <div class="float-left"><h4>{{$hotel->name}} Rooms</h4></div>
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
                @if ($hotelrooms->count() == 0)
                    <div class="card-body">
                        <div class="emptyMessage">No Rooms found.</div>
                        <table id="listTable" class="table table-striped">
                            <thead class="hidden">
                                <th>{{__('Name') }}</th>
                                <th>{{__('Type') }}</th>
                                <th>{{__('Capacity') }}</th>
                                <th>{{__('Rate') }}</th>
                                <th>{{__('Start Date') }}</th>
                                <th>{{__('End Date') }}</th>
                                <th>{{__('Availability') }}</th>
                                <th>{{__('Room Images') }}</th>
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
                                <th>{{__('Rate') }}</th>
                                <th>{{__('Start Date') }}</th>
                                <th>{{__('End Date') }}</th>
                                <th>{{__('Availability') }}</th>
                                <th>{{__('Room Images') }}</th>
                                <th class="text-right">{{ __('Options') }}</th>
                            <tbody>
                                @foreach($hotelrooms as $hotelroom)
                                    <tr id="roominfo-{{$hotelroom->id}}" data-id="{{$hotelroom->id}}" data-room="{{$hotelroom->room_id}}" data-type="{{$hotelroom->room->room_type_id}}" data-capacity="{{$hotelroom->room->room_capacity_id}}" data-room_type="{{$hotelroom->room->room_type->name}}" data-room_capacity="{{$hotelroom->room->room_type->name}}"
                                        @if($hotelroom->room->images) 
                                            data-images="{{ $hotelroom->room->images }}"
                                        @endif >
                                        <td class="align-middle">
                                            {{ $hotelroom->room->name }}
                                        </td>
                                        <td class="align-middle">{{ $hotelroom->room->room_type->name }}</td>
                                        <td class="align-middle">{{ $hotelroom->room->room_capacity->name }}</td>
                                        <td class="align-middle">${{ $hotelroom->price->rate }}</td>
                                        <td class="align-middle">{{ $hotelroom->date_start }}</td>
                                        <td class="align-middle">{{ $hotelroom->date_end }}</td>
                                        <td class="align-middle">{{ $hotelroom->availability }}</td>
                                        <td class="align-middle">
                                            @if($hotelroom->room->images)
                                                <ul class="imageList">
                                                    @php
                                                        $imagelist = json_decode($hotelroom->room->images);
                                                    @endphp
                                                    @foreach($imagelist as $image)
                                                        <li style="background-image:url({{asset('/storage/rooms/'.$hotelroom->room_id.'/'.$image)}});">
                                                            <a href="{{asset('/storage/rooms/'.$hotelroom->room_id.'/'.$image)}}" target="__blank"></a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <div class="clearfix tools">
                                                <button type="button" data-id="{{$hotelroom->id}}" class="btn btn-danger btn-sm rowDelete">{{__('Delete') }}</button>
                                                <button type="button" class="btn btn-primary btn-sm mr-left-10 editdata">{{ __('Edit') }}</button>
                                                <a href="{{ route('room.show', $hotelroom->id) }}" class="btn btn-success btn-sm mr-left-10 rowView">{{__('View') }}</a>
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
    <div class="modal-dialog" role="document">
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
        <div class="col-sm-12">
            <form name="formData"
                @{{if id}} action="/admin/hotels/{{$hotel->id}}/rooms/@{{:id}}" onsubmit="return false;" @{{else}} action="/admin/hotels/{{$hotel->id}}/rooms" id="newrowData" enctype="multipart/form-data" @{{/if}}
            >
                <input type="hidden" name="hotel_id" value="{{$hotel->id}}" />
                <div class="form-group">
                    <label for="room_id" class="control-label">Please Select Room</label>
                    <select class="form-control" id="room_id" name="room_id">
                        <option value="">{{ __("Please Select Room")}}</option>
                        @foreach($rooms as $room)
                            <option value="{{$room->id}}"">{{$room->name}} ( Type: {{$room->room_type->name}}, Capacity: {{$room->room_capacity->name}} )</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="roomprice_id" class="control-label">Rate</label>
                    <select class="form-control" id="roomprice" name="price_id">
                        <option value="">{{ __("Please Select Room Price")}}</option>
                        @foreach($room_prices as $price)
                            <option value="{{$price->id}}"">{{$price->name}} - ${{$price->rate}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="roomprice_id" class="control-label">Available From</label>
                    <input id="start_date" name="date_start" value="" />
                </div>
                <div class="form-group">
                    <label for="roomprice_id" class="control-label">Available To</label>
                    <input id="end_date" name="date_end" value="" />
                </div>
                <div class="form-group">
                    <label for="roomprice_id" class="control-label">Rooms Available</label>
                    <input name="availability" class="form-control" type="number" min=0 value="" />
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
    </div>
</script>

<script id="datarowTpl" type="text/x-jsrender">
    <tr id="roominfo-@{{:id}}" data-id="@{{:id}}" data-name="@{{:name}}" data-type="@{{:room_type_id}}" data-capacity="@{{:room_capacity_id}}" data-room_type="@{{:type}}" data-room_capacity=@{{:capacity}} 
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

<script type="text/x-jsrender" id="inlineimages">
    <li class="image-thumb" style="background-image:url({{asset("/storage/rooms")}}/@{{:~rooomid}}/@{{:prop}});">
        <a href="{{asset("/storage/rooms")}}/@{{:~rooomid}}/@{{:prop}}" target="__blank"></a>
    </li>
</script>

<script type="text/javascript" src="//cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js"></script>

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
    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#start_date').val(today);
    $('#start_date').datepicker({
        uiLibrary: 'bootstrap4',
        minDate: today,
        maxDate: function () {
            return $('#end_date').val();
        }
    });
    $('#end_date').datepicker({
        uiLibrary: 'bootstrap4',
        minDate: function () {
            console.log($('#start_date').val());
            return $('#start_date').val();
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
                url: '/admin/hotels/{{$hotel->id}}/room/'+v.data('id'),
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