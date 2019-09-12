@extends('admin.layouts.main')

@section('title')Manage Customers
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
                    <div class="float-left"><h4>Customers</h4></div>
                </div>
                @if ($customers->isEmpty())
                    <div class="card-body">
                        <div class="emptyMessage">No Customers found.</div>
                        <table id="listTable" class="table table-striped">
                            <thead class="hidden">
                                <th>{{__('Name') }}</th>
                                <th>{{ __('E-mail') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{__('Country') }}</th>
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
                                <th>{{ __('E-mail') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{__('Country') }}</th>
                                <th class="text-right">{{ __('Options') }}</th>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr id="customer-{{$customer->id}}" data-id="{{$customer->id}}">
                                        <td>
                                            {{ $customer->first_name }} 
                                            {{ $customer->last_name }}
                                        </td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->country }}</td>
                                        <td>
                                            <div class="clearfix tools">
                                                <button type="button" class="btn btn-primary btn-sm mr-left-10 editRow" data-action="edit">{{ __('Edit') }}</button>
                                                <a href="javascript:void(0)" class="btn btn-success btn-sm mr-left-10 viewRow" data-action="view">{{__('View') }}</a>
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
    
<div class="modal" tabindex="-1" role="dialog" id="rowModal" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
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

<script id="UpdaterowTemplate" type="text/x-jsrender">
    <tr id="customer-@{{:id}}" data-id="@{{:id}}">
        <td>@{{:first_name}} @{{last_name}}</td>
        <td>@{{:email}}</td>
        <td>@{{:phone}}</td>
        <td>@{{:country}}</td>
        <td>
            <div class="clearfix tools">
                <button type="button" class="btn btn-primary btn-sm mr-left-10 editRow">Edit</button>
                <a href="javascript:void(0)" class="btn btn-success btn-sm mr-left-10 viewRow">View</a>
            </div>
        </td>
    </tr>
</script>
<script id="rowTemplate" type="text/x-jsrender">
    <div class="row">
        @{{if id}}
            <div class="col-sm-4">
        @{{else}}
            <div class="col-sm-12">
        @{{/if}}
            @{{if viewonly}}
                <div class="row">
                    <div class="col-sm-4"><strong>Name: </strong></div>
                    <div class="col-sm-8">@{{:first_name}} @{{:last_name}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><strong>E-Mail: </strong></div>
                    <div class="col-sm-8">@{{:email}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><strong>Phone: </strong></div>
                    <div class="col-sm-8">@{{:phone}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><strong>Fax: </strong></div>
                    <div class="col-sm-8">@{{:fax}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><strong>City: </strong></div>
                    <div class="col-sm-8">@{{:city}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><strong>Country: </strong></div>
                    <div class="col-sm-8">@{{:country}}</div>
                </div>
            @{{else}}
                <form name="rowData"
                    @{{if id}} action="/admin/customers/@{{:id}}" onsubmit="return false;" @{{/if}}
                >
                    <div class="form-group">
                        <label for="first_name" class="control-label">First Name</label>
                        <input id="first_name" type="text" name="first_name" class="form-control" value="@{{:first_name}}"" />
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="control-label">Last Name</label>
                        <input id="last_name" type="text" name="last_name" class="form-control" value="@{{:last_name}}"" />
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="text" id="address" name="email" disabled class="form-control" value="@{{:email}}" />
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="@{{:phone}}" />
                    </div>
                    <div class="form-group">
                        <label for="city" class="control-label">City</label>
                        <input type="text" id="city" name="city" class="form-control" value="@{{:city}}" />
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
                            <button type="button" class="btn btn-primary updateModal">Save</button>
                        @{{else}}
                            <button type="submit" class="btn btn-primary float-right">Create</button>
                        @{{/if}}
                    </div>
                </form>
            @{{/if}}
        </div>
        @{{if id}}
            <div class="col-sm-8">
                <h4>Booking Information</h4>
                @{{if bookings}}
                    <table class="table table-striped table-sm table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Hotel</th>
                                <th>Room</th>
                                <th>Type</th>
                                <th>Capacity</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Crated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @{{props bookings}}
                                <tr>
                                    <td>@{{:prop.hotel}}</td>
                                    <td>@{{:prop.room}}</td>
                                    <td>@{{:prop.type}}</td>
                                    <td>@{{:prop.capacity}}</td>
                                    <td>@{{:prop.check_in}}</td>
                                    <td>@{{:prop.check_out}}</td>
                                    <td>@{{:prop.created}}</td>
                                </tr>
                            @{{/props}}
                        </tbody>
                @{{/if}}
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

jQuery(document).on('click', '.editRow', function(e){
    e.preventDefault();
    let v = jQuery(this),
        id = v.closest('tr').data('id');
    jQuery.get('/admin/customers/'+id+'/edit', function(response){
        if(response.success){
            var tmpl = jQuery.templates("#rowTemplate"); 
            var data = response.customer;
            var html = tmpl.render(data); 
            $("#modalBody").html(html);
            if(typeof(data.country) !=='undefined' || data.country !=''){
                $("#country").val(data.country);
            }
            $("#rowModal").modal('show', v);
        }else {
            alert(response.message);
        }
    });
});

jQuery(document).on('click', '.viewRow', function(e){
    e.preventDefault();
    let v = jQuery(this),
        id = v.closest('tr').data('id');
    jQuery.get('/admin/customers/'+id, function(response){
        if(response.success){
            var tmpl = jQuery.templates("#rowTemplate"); 
            var data = response.customer;
                data.viewonly = true;
            var html = tmpl.render(data); 
            $("#modalBody").html(html);
            if(typeof(data.country) !=='undefined' || data.country !=''){
                $("#country").val(data.country);
            } 
            $("#rowModal").modal('show', v);
        }else {
            alert(response.message);
        }
    });
});

$("#rowModal").on('show.bs.modal', function (event) {
    var v = $(event.relatedTarget);
    if(v.data('action') == 'view'){
        var modal = $(this);
        modal.find('.modal-title').text('Customer information');
    }else{
        var modal = $(this);
        modal.find('.modal-title').text('Edit Customer information');
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


jQuery(document).on('click', '.updateModal', function(e){
    e.preventDefault();
    let form = $(this).closest('form');
    jQuery.ajax({
        type:'PUT',
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
                let $row = $("#customer-"+data.id),
                    rowtmpl = $.templates('#UpdaterowTemplate'),
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