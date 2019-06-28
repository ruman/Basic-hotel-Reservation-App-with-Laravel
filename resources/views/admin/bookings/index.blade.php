@extends('admin.layouts.main')

@section('title')Manage Hotels
@endsection

@section('pageHeader')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css" />
<link href='{{ asset('css/calendar.css') }}' rel='stylesheet'>

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
            <div id="calendar"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-left"><h4>Reservations</h4></div>
                </div>
                @if ($bookings->isEmpty())
                    <div class="card-body">
                        <div class="emptyMessage">No Reservations found.</div>
                        <table id="listTable" class="table table-striped">
                            <thead class="hidden">
                                <th>{{__('ID') }}</th>
                                <th>{{__('Hotel Name') }}</th>
                                <th>{{__('Room Name') }}</th>
                                <th>{{__('Room Rat') }}</th>
                                <th>{{__('Check-in') }}</th>
                                <th>{{__('Check-out') }}</th>
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
                                <th>{{__('ID') }}</th>
                                <th>{{__('Hotel Name') }}</th>
                                <th>{{__('Room Name') }}</th>
                                <th>{{__('Room Rate') }}</th>
                                <th>{{__('Check-in') }}</th>
                                <th>{{__('Check-out') }}</th>
                                <th class="text-right">{{ __('Options') }}</th>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr id="bookings-{{$booking->id}}" data-id="{{$booking->id}}" data-hotel="{{$booking->hotel_name}}" data-room_name="{{$booking->room_name}}" data-rate="{{$booking->rate}}" data-check_in="{{$booking->check_in}}" data-check_out="{{$booking->check_out}}" data-customer="">
                                        <td>
                                            {{ $booking->id }}
                                        </td>
                                        <td>{{ $booking->hotel_name }}</td>
                                        <td>{{ $booking->room_name }}</td>
                                        <td>{{ $booking->rate }}</td>
                                        <td>{{ $booking->check_in }}</td>
                                        <td>{{ $booking->check_out }}</td>
                                        <td>
                                            <div class="clearfix tools">
                                                <button type="button" class="btn btn-danger btn-sm deleterow">{{__('Delete') }}</button>
                                                <button type="button" class="btn btn-primary btn-sm mr-left-10 editrowData">{{ __('Edit') }}</button>
                                                <a href="javascript:void(0)" class="btn btn-success btn-sm mr-left-10 viewrowData">{{__('View') }}</a>
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

<div class="modal hide fade" id="events-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title">Event</h3>
        </div>
        <div class="modal-body" style="height: 400px">
        </div>
        <div class="modal-footer">
            <a href="#" data-dismiss="modal" class="btn">Close</a>
        </div>
    </div>

@endsection

@section('js')

<script type="text/javascript" src="{{asset('js/admin/calendar.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>

@endsection

@section('pageScript')


@endsection

