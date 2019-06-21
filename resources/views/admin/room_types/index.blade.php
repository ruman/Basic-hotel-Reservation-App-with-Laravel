@extends('admin.layouts.main')

@section('title')Manage Room Types
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            @if ($room_types->isEmpty())
                <div class="card"><div class="card-body">No Room Types found.</div></div>
            @else
                <table class="table table-striped">
                    <thead>
                        <th>Name</th>
                    </thead>
                    <tbody>
                        @foreach($room_types as $room_type)
                            <tr>
                                <td>
                                    <a href="{!! route('hotel.edit', [$hotel->id]) !!}">{{ $room_type->name }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            {!! $room_types; !!}
        </div>
    </div>

@stop