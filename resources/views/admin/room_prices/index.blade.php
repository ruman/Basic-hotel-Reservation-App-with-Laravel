@extends('admin.layouts.main')

@section('title')Manage Room Capacity
@endsection

@section('inlinestyle')

    .editform {
        display:none;
    }
    .editform.submitting {
        opacity:0.5;
    }
    .editform.deleting {
        background-color: rgba(255,0,0,0.5);
    }
    .deleteEntry {
    margin-left:8px;
}

@endsection

@section('content')


    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($room_prices->isEmpty())
                <div class="card">
                    <div class="card-header">
                        <div class="float-left"><h4>Room Prices</h4></div>
                        <div class="float-right">
                            <button type="button" class="btn btn-success btn-small" data-toggle="modal" data-target="#createRommType"> + Add New Room Rate </button>
                        </div>
                    </div>
                    <div class="card-body"><div class="emptyMessage">No Room Prices found.</div>
                        <table id="listTable" class="table table-striped">
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
            <div class="card">
                <div class="card-header">
                    <div class="float-left"><h4>Room Prices</h4></div>
                    <div class="float-right">
                        <button type="button" class="btn btn-success btn-small" data-toggle="modal" data-target="#createRommType"> + Add New Room Rate </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="listTable" class="table table-striped">
                        <tbody>
                            @foreach($room_prices as $room_price)
                                <tr class="editrow">
                                    <td colspan="10" class="editarea">
                                        <div class="editresponse">{{ $room_price->name }}</div>
                                        <div class="editform">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control edit-field" name="name" data-id="{{$room_price->id}}" value="{{$room_price->name}}" />
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary editinlinesubmit" type="button">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                            <button type="button" class="btn btn-danger btn-sm deleteEntry float-right" data-id="{{$room_price->id}}">Delete</button>
                                            <button type="button" class="btn btn-primary btn-sm editinline float-right">Edit</button>
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

    <div class="row">
        <div class="col-md-12 text-center">
            {!! $room_prices; !!}
        </div>
    </div>

@endsection

@section('pageFooter')
    
<div class="modal" tabindex="-1" role="dialog" id="createRommType">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Room Rate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="createnew" class="control-label">Name</label>
                    <input type="text" name="name" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary createNewType">Create</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('pageScript')
    jQuery(document).on('click', '.editinline', function(e){
        e.preventDefault();
        let v = jQuery(this);
        v.hide().stop().closest('.editrow').find('.editresponse').stop().hide().end().find('.editform').stop().show();
    });
    jQuery(document).on('click', '.editinlinesubmit', function(e){
        e.preventDefault();
        let v = jQuery(this).closest('.editrow');
        let field = v.find('input.edit-field');
        let data = {
                [field.attr('name')] : field.val()
            }
        jQuery.ajax({
            type:'PUT',
            url: '/admin/roomcapacity/'+field.data('id'),
            data:data,
            beforeSend: function(){
                v.addClass('submitting');
            },
            success: function(response){
                if(response.success){
                    v.removeClass('submitting').stop().find('.editresponse').html(response.data).stop().show().end()
                    .find('.editform').stop().hide().end()
                    .find('.editinline').stop().show();
                }else {
                    alert(response.message);
                }
            }, 
            error: function(error){
                v.removeClass('submitting');
                alert('Failed to Update');
            }
        })
    });

    jQuery(document).on('click', '.deleteEntry', function(e){
        e.preventDefault();
        let v = jQuery(this);
        if(confirm('Are you sure?')){
            jQuery.ajax({
                type:'DELETE',
                url: '/admin/roomcapacity/'+v.data('id'),
                beforeSend: function(){
                    v.closest('.editrow').addClass('deleting');
                },
                success: function(response){
                    v.closest('.editrow').removeClass('deleting');
                    if(response){
                        v.closest('.editrow').stop().slideUp(300, function(){
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

    jQuery(document).on('click','.createNewType', function(e){
        e.preventDefault();
        let v = jQuery(this).closest('.modal-content');
        let field = v.find('input[name="name"]');
        let data = {
            [field.attr('name')] : field.val()
        }
        jQuery.ajax({
            type:'POST',
            url: '/admin/roomcapacity',
            data:data,
            beforeSend: function(){
                v.addClass('submitting');
            },
            success: function(response){
                v.removeClass('submitting');
                if(response.success){
                    $("#createRommType").find('input').val('').end().modal('hide');
                    let data = response.data;
                    $(".emptyMessage").remove();
                    $("#listTable").find('tbody').append(''+
                    '<tr class="editrow">'+
                        '<td colspan="10" class="editarea">'+
                            '<div class="editresponse">'+data.name+'</div>'+
                            '<div class="editform">'+
                                '<div class="input-group mb-3">'+
                                    '<input type="text" class="form-control edit-field" name="name" data-id="'+data.id+'" value="'+data.name+'" />'+
                                    '<div class="input-group-append">'+
                                        '<button class="btn btn-outline-secondary editinlinesubmit" type="button">Save</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</td>'+
                        '<td>'+
                            '<div class="clearfix">'+
                                '<button type="button" class="btn btn-danger btn-sm deleteEntry float-right" data-id="+data.id+">Delete</button>'+
                                '<button type="button" class="btn btn-primary btn-sm editinline float-right">Edit</button>'+
                            '</div>'+
                        '</td>'+
                    '</tr>'+
                    '');
                }else {
                    alert(response.message);
                }
            }, 
            error: function(error){
                v.removeClass('submitting');
                if(error.responseText){
                    let response = JSON.parse(error.responseText);
                    let info = response.errors.name[0];
                    alert(info);
                }else {
                    alert(error.message);
                }
            }
        });
    });
@endsection