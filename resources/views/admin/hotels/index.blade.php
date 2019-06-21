@extends('admin.layouts.main')

@section('title')Manage Hotels
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            @if ($hotels->isEmpty())
                <div class="card"><div class="card-body">No Hotels found.</div></div>
            @else
                <table class="table table-striped">
                    <thead>
                        <th>Name</th>
                    </thead>
                    <tbody>
                        @foreach($hotels as $hotel)
                            <tr>
                                <td>
                                    <a href="{!! route('hotel.edit', [$hotel->id]) !!}">{{ $hotel->name }}</a>
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
            {!! $hotels; !!}
        </div>
    </div>

@stop