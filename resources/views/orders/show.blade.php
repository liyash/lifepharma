@extends('layouts.admin')
@section('main-content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Order details</h2>
            </div>
            <div class="pull-right">
                <a id="backbutton" class="btn btn-primary" href="{{ route('list.orders') }}"> Back</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $orders->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <table class="table table-bordered" id="orderTable">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Raised By</th>
                    <th scope="col">Product</th>
                    <th scope="col">Count</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($orders->orderdetails as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$orders->user->name}}</td>
                            <td>
                                {{$order->product->name}} 
                            </td>
                            <td>
                                {{$order->count}} 
                            </td>
                            <td>
                                {{$order->product->price*$order->count}} 
                            </td>
                            <td>
                                {{-- <a class="btn btn-info" href="{{"/orders/view/{$order->id}/"}}">Process</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-12">
            <h4>Transaction Details</h4>
                <table class="table table-bordered" id="transactionTable">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Transaction ID</th>
                        <th scope="col">Card Details</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($orders->transactiondetails as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>
                                    {{$order->transaction_id}} 
                                </td>
                                <td>
                                    {{$order->card_details}} 
                                </td>
                                <td>
                                    @if ($order->status==1)
                                        Completed
                                        @else
                                        Not completed
                                    @endif
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
    <div class="row" style="padding-bottom: 10px">
        <div class=" col-md-12">
            Fake Shipping Address
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                <a class="btn btn-info" 
                attr-id="{{$orders->id}}" id="processOrder" href="{{"/orders/process/{$orders->id}/"}}">Process</a>

        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).on("click","#processOrder",function(e){
        e.preventDefault();
        let attrid=($(this).attr("attr-id"))
        Swal.fire({
        title: 'Do you want to Process the order?',
        showCancelButton: true,
        confirmButtonText: `Process`,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route("store.processorder")}}",
            type: 'post',
            data: { "id" : attrid},
            success: function (data) {

                if (data.status_code==200) {
                  //  swal("Success", "Processed successfully", "info");
                  Swal.fire(
                    'Success',
                    'Processed!',
                    'success'
                    )
                    setTimeout(() => {
                        $("#backbutton").trigger("click")
                    }, 500);



                } else {
                    swal("Wrong inputs", "Please check credentials and try again", "info");
                }
            },
            fail: function (response) {
                alert('here');
            },
            error: function (xhr, textStatus, thrownError) {
                // associate_errors(xhr.responseJSON.errors, $form);
            },
            
        });
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
        })

        
    })
</script>
    
@endsection