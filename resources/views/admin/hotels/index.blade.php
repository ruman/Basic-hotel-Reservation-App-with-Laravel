@extends('admin.layouts.main')

@section('title')Manage Hotels
@endsection

@section('inlinestyle')
.tools .btn {
    float:right;
    margin-left:8px;
}
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-left"><h4>Hotels</h4></div>
                    <div class="float-right">
                        <button type="button" class="btn btn-success btn-small" data-toggle="modal" data-target="#createnewHotel"> + Add New Hotel </button>
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
                                    <tr data-name="{{$hotel->name}}" data-address="{{$hotel->address}}" data-city="{{$hotel->city}}" data-state="{{$hotel->state}}" data-country="{{$hotel->country}}" data-zip="{{$hotel->zip}}" data-phone="{{$hotel->phone}}" data-email="{{$hotel->email}}">
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
                                                <a href="{{ route('rooms') }}" class="btn btn-info btn-sm mr-left-10">{{__('Rooms') }}</a>
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
    
<div class="modal" tabindex="-1" role="dialog" id="createNewHotel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Hotel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalBody" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary createNewType">Create</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>

<script id="editHotelTpl" type="text/x-jsrender">
    <div class="form-group">
        <label for="createnew" class="control-label">Name</label>
        <input type="text" name="name" class="form-control" value="@{{:name}}"" />
    </div>
    <div class="form-group">
        <label for="createnew" class="control-label">Address</label>
        <input type="text" name="address" class="form-control" value="@{{:address}}" />
    </div>
    <div class="form-group">
        <label for="createnew" class="control-label">City</label>
        <input type="text" name="city" class="form-control" value="@{{:city}}" />
    </div>
    <div class="form-group">
        <label for="createnew" class="control-label">State</label>
        <input type="text" name="state" class="form-control" value="@{{:state}}" />
    </div>
    <div class="form-group">
        <label for="createnew" class="control-label">Country</label>
        <select class="form-control" id="country" name="country">
            <option>{{ __("Please Select Country")}}</option>
            @foreach($countries as $country)
                <option value={{$country}}>{{$country}}</option>
            @endforeach
        </select>
    </div>
</script>


@endsection

@section('pageScript')

$(document).ready(function() {
    $('#listTable').DataTable();
    
    
} );

jQuery(document).on('click', '.editHotel', function(e){
    e.preventDefault();
    var tmpl = jQuery.templates("#editHotelTpl"); // Get compiled template
    let hotelinfo = jQuery(this).closest('tr').data();
    let data= {name:hotelinfo.name, address:hotelinfo.address, city:hotelinfo.city, state:hotelinfo.state}
    var html = tmpl.render(data); 
    $("#modalBody").html(html);
    if(typeof(hotelinfo.country) !=='undefined' || hotelinfo.country !=''){
        $("#country").val(hotelinfo.country);
    }
    $("#createNewHotel").modal('show');
})



@endsection