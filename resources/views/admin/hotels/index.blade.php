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
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-left"><h4>Hotels</h4></div>
                    <div class="float-right">
                        <button type="button" class="btn btn-success btn-small" data-toggle="modal" data-target="#createNewHotel" data-create="true"> + Add New Hotel </button>
                    </div>
                </div>
                @if ($hotels->isEmpty())
                    <div class="card-body">
                        <div class="emptyMessage">No Hotel found.</div>
                        <table id="listTable" class="table table-striped">
                            <thead class="hidden">
                                <th>{{__('Name') }}</th>
                                <th>{{__('Address') }}</th>
                                <th>{{__('City') }}</th>
                                <th>{{__('State') }}</th>
                                <th>{{__('Country') }}</th>
                                <th>{{ __('Zip') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('E-mail') }}</th>
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
                                <th>{{__('City') }}</th>
                                <th>{{__('State') }}</th>
                                <th>{{__('Country') }}</th>
                                <th class="text-right">{{ __('Options') }}</th>
                            </thead>
                            <tbody>
                                @foreach($hotels as $hotel)
                                    <tr id="hoteinfo-{{$hotel->id}}" data-id="{{$hotel->id}}" data-name="{{$hotel->name}}" data-address="{{$hotel->address}}" data-city="{{$hotel->city}}" data-state="{{$hotel->state}}" data-country="{{$hotel->country}}" data-zip="{{$hotel->zip}}" data-phone="{{$hotel->phone}}" data-email="{{$hotel->email}}" 
                                        @if($hotel->image) 
                                            data-image="{{ asset('/images/'.$hotel->id.'/'.$hotel->image) }}"
                                        @endif >
                                        <td>
                                            {{ $hotel->name }}
                                        </td>
                                        <td>{{ $hotel->city }}</td>
                                        <td>{{ $hotel->state }}</td>
                                        <td>{{ $hotel->country }}</td>
                                        <td>
                                            <div class="clearfix tools">
                                                <button type="button" class="btn btn-danger btn-sm">{{__('Delete') }}</button>
                                                <button type="button" class="btn btn-primary btn-sm mr-left-10 editHotel">{{ __('Edit') }}</button>
                                                <a href="{{ route('hotel.rooms', $hotel->id ) }}" class="btn btn-info btn-sm mr-left-10">{{__('Rooms') }}</a>
                                                <a href="{{ route('hotel.show', $hotel->id) }}" class="btn btn-success btn-sm mr-left-10">{{__('View') }}</a>
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

    <div class="row">
        <div class="col-md-12 text-center">
            {!! $hotels; !!}
        </div>
    </div>
    
@endsection


@section('pageFooter')
    
<div class="modal" tabindex="-1" role="dialog" id="createNewHotel" data-backdrop="static">
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

<script id="UpdateHotelTpl" type="text/x-jsrender">
    <tr id="hotelinfo-@{{:id}}" data-id="@{{:id}}" data-name="@{{:name}}" data-address="@{{:address}}" data-city="@{{:city}}" data-state="@{{:state}}" data-country="@{{:country}}" data-phone="@{{:phone}}" data-email="@{{:email}}">
        <td>@{{:name}}</td>
        <td>@{{:city}}</td>
        <td>@{{:state}}</td>
        <td>@{{:country}}</td>
        <td>
            <div class="clearfix tools">
                <button type="button" class="btn btn-danger btn-sm">Delete</button>
                <button type="button" class="btn btn-primary btn-sm mr-left-10 editHotel">Edit</button>
                <a href="/admin/rooms" class="btn btn-info btn-sm mr-left-10">Rooms</a>
                <a href="javascript:void(0)" class="btn btn-success btn-sm mr-left-10"  data-target="#showHotelDetails">View</a>
            </div>
        </td>
    </tr>
</script>
<script id="HotelTpl" type="text/x-jsrender">
    <div class="row">
        @{{if id}}
            <div class="col-sm-6">
        @{{else}}
            <div class="col-sm-12">
        @{{/if}}
            <form name="hotelData"
                @{{if id}} action="/admin/hotels/@{{:id}}" onsubmit="return false;" @{{else}} action="/admin/hotels" id="newHotelData" enctype="multipart/form-data" @{{/if}}
            >
                <div class="form-group">
                    <label for="hotelname" class="control-label">Name</label>
                    <input id="hotelname" type="text" name="name" class="form-control" value="@{{:name}}"" />
                </div>
                <div class="form-group">
                    <label for="address" class="control-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" value="@{{:address}}" />
                </div>
                <div class="form-group">
                    <label for="hotelcity" class="control-label">City</label>
                    <input type="text" id="hotelcity" name="city" class="form-control" value="@{{:city}}" />
                </div>
                <div class="form-group">
                    <label for="hotelstate" class="control-label">State</label>
                    <input type="text" id="hotelstate" name="state" class="form-control" value="@{{:state}}" />
                </div>
                <div class="form-group">
                    <label for="hotelphone" class="control-label">Phone</label>
                    <input type="text" id="hotelphone" name="phone" class="form-control" value="@{{:phone}}" />
                </div>
                <div class="form-group">
                    <label for="hotelemail" class="control-label">E-mail</label>
                    <input type="text" id="hotelemail" name="email" class="form-control" value="@{{:email}}" />
                </div>
                <div class="form-group">
                    <label for="country" class="control-label">Country</label>
                    <select class="form-control" id="country" name="country">
                        <option>{{ __("Please Select Country")}}</option>
                        @foreach($countries as $country)
                            <option value="{{$country}}"">{{$country}}</option>
                        @endforeach
                    </select>
                </div>
                <div id="updatemessage"></div>
                <div class="form-group">
                    @{{if id}}
                        <button type="button" class="btn btn-primary updateHotel">Save</button>
                    @{{else}}
                        <button type="submit" class="btn btn-primary float-right">Create</button>
                    @{{/if}}
                </div>
            </form>
        </div>
        @{{if id}}
            <div class="col-sm-6" id="uploadList">
                <div class="form-group">
                    <label for="newhotelimage" class="control-label">Images</label>
                    <form method="post" action="/admin/hotels/@{{:id}}/imageupload" enctype="multipart/form-data" id="uploadImage">
                        <input type="hidden" name="hotel_id" value="@{{:id}}" />
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="file" name="hotelimage" />
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="imagePreview"><img class="img-thumbnail" 
                    @{{if image}}
                        src="@{{:image}}"
                    @{{/if}}
                /></div>
            </div>
        @{{/if}}
    </div>
</script>

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


@endsection

@section('pageScript')

$(document).ready(function() {
    // var $table = $('#listTable').DataTable();
} );

jQuery(document).on('click', '.editHotel', function(e){
    e.preventDefault();
    var tmpl = jQuery.templates("#HotelTpl"); // Get compiled template
    let hotelinfo = jQuery(this).closest('tr').data();
    /* let data= {name:hotelinfo.name, address:hotelinfo.address, city:hotelinfo.city, state:hotelinfo.state} */
    var html = tmpl.render(hotelinfo); 
    $("#modalBody").html(html);
    if(typeof(hotelinfo.country) !=='undefined' || hotelinfo.country !=''){
        $("#country").val(hotelinfo.country);
    }
    $("#createNewHotel").modal('show');
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