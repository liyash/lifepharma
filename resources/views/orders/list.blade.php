@extends('layouts.admin')
@section('main-content')
        <table class="table table-bordered" id="orderTable">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Raised By</th>
                <th scope="col">Total</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->user->name}}</td>
                        <td>
                            {{$order->orderdetails->count()}} Item
                        </td>
                        <td>
                            <a class="btn btn-info" href="{{"/orders/view/{$order->id}/"}}">Show</a>
    
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $("#orderTable").DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    })
    });
</script>
@endsection

