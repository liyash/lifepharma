@extends('layouts.admin')
@section('main-content')




        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Data</th>
                <th scope="col">Items</th>
                <th scope="col">Total</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->items}}</td>
                        <td>{{$order->total}}</td>
                        <td>
                            <a href="{{"/orders/{$order->id}/destroy"}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

@endsection