@extends('layouts.admin')
 
@section('main-content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Users</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
<div class="row">
    <div class="col-md-12">
            <table id="usertable" class="table table-bordered">
        <thead>
                    <tr>
            <th>No</th>
            <th>Name</th>
            <th>User name</th>
            <th>Email</th>
            <th width="280px">Action</th>
        </tr>
        </thead>

        @foreach ($users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                    @if (!in_array("admin",$user->roles->pluck("name")->toArray()))
                        <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>

                        @endif

                    @csrf
                    @method('DELETE')
                    @if (!in_array("admin",$user->roles->pluck("name")->toArray()))

                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endif

                </form>
            </td>
        </tr>
        @endforeach
    </table>
    </div>

    </div>    
  
      
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $("#usertable").DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    })
    });
</script>
@endsection