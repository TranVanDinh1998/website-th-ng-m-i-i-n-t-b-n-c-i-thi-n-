@extends('admin.layout')
@section('title', 'Admins management')
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="table-agile-info">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Admins
                    </div>
                    <div class="row w3-res-tb">
                        <div class="col-sm-5 m-b-xs">
                            <span class="btn-group">
                                <a href="{{ route('admin.admin.index') }}" class="btn btn-sm btn-default"><i
                                        class="fa fa-refresh"></i> Refresh</a>
                                <a href="{{ route('admin.admin.recycle') }}" class="btn btn-sm btn-danger"><i
                                        class="fa fa-trash"></i> Recycle</a>
                            </span>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-5">
                            <form enctype="multipart/form-data" method="GET" action="{{ route('admin.admin.index') }}">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" value="{{ $search }}" name="search"
                                        placeholder="Search">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-default">Search</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('admin.admin.bulk_action') }}" enctype="multipart/form-data">

                        <div class="row w3-res-tb">
                            <div class="col-sm-5 m-b-xs">
                                <select id="bulk_action" name="bulk_action"
                                    class="input-sm form-control w-sm inline v-middle">
                                    <option>Bulk action</option>
                                    <option value="0">Deactivate</option>
                                    <option value="1">Activate</option>
                                    <option value="4">Remove</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-default">Apply</button>
                            </div>
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-3">
                            </div>
                        </div>
                        @if (session('success'))
                            <div id="success_msg" class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div id="error_msg" class="alert alert-danger">
                                {!! session('error') !!}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped b-t b-light">
                                <thead>
                                    <tr>
                                        <th style="width:20px;">
                                            <label class="i-checks m-b-none">
                                                <input type="checkbox"><i></i>
                                            </label>
                                        </th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">ID
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a
                                                            href="{{ route('admin.admin.index', ['sort_id' => 0, 'role' => $role, 'status' => $status, 'view' => $view]) }}">Inc</a>
                                                    </li>

                                                    <li><a
                                                            href="{{ route('admin.admin.index', ['sort_id' => 1, 'role' => $role, 'status' => $status, 'view' => $view]) }}">Desc</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button"
                                                    data-toggle="dropdown">Status
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="{{ route('admin.admin.index', []) }}">All</a>
                                                    </li>
                                                    <li><a
                                                            href="{{ route('admin.admin.index', ['sort_id' => $sort_id, 'role' => $role, 'status' => '1', 'view' => $view]) }}">Active</a>
                                                    </li>

                                                    <li><a
                                                            href="{{ route('admin.admin.index', ['sort_id' => $sort_id, 'role' => $role, 'status' => '0', 'view' => $view]) }}">Inactive</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td>
                                                <label class="i-checks m-b-none">
                                                    <input type="checkbox" value="{{ $admin->id }}"
                                                        name="admin_id_list[]"><i></i>
                                                </label>
                                            </td>
                                            <td>
                                                {{ $admin->id }}
                                            </td>
                                            <td>
                                                <img style="width: 70px; height : auto"
                                                    src="{{ url('uploads/users-images/' . $admin->image) }}"
                                                    alt="{{ $admin->name }}">
                                            </td>
                                            <td><span class="text-ellipsis">{{ $admin->name }}</span></td>
                                            <td><span class="text-ellipsis">{{ $admin->email }}</span></td>
                                            <td>
                                                @if ($admin->is_actived == 1)
                                                    <div class="alert alert-success" role="alert">
                                                        <strong>Active</strong>
                                                    </div>
                                                @else
                                                    <div class="alert alert-danger" role="alert">
                                                        <strong>Inactive</strong>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($admin->is_actived == 0)
                                                    <a onclick="return confirm('Are you sure?')"
                                                        href="{{ route('admin.admin.activate', ['id' => $admin->id]) }}"
                                                        class="btn btn-success" title="Activate">
                                                        <span class="glyphicon glyphicon-check"></span>
                                                    </a>
                                                @else
                                                    <a onclick="return confirm('Are you sure?')"
                                                        href="{{ route('admin.admin.deactivate', ['id' => $admin->id]) }}"
                                                        class="btn btn-warning" title="Deactivate">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('admin.admin.remove', ['id' => $admin->id]) }}"
                                                    class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">View :
                                            {{ $view }} of {{ $count_admin }} item(s)
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a
                                                    href="{{ route('admin.admin.index', ['sort_id' => $sort_id, 'role' => $role, 'status' => $status, 'view' => 10]) }}">10</a>
                                            </li>
                                            <li><a
                                                    href="{{ route('admin.admin.index', ['sort_id' => $sort_id, 'role' => $role, 'status' => $status, 'view' => 15]) }}">15</a>
                                            </li>
                                            <li><a
                                                    href="{{ route('admin.admin.index', ['sort_id' => $sort_id, 'role' => $role, 'status' => $status, 'view' => 20]) }}">20</a>
                                            </li>
                                            <li><a
                                                    href="{{ route('admin.admin.index', ['sort_id' => $sort_id, 'role' => $role, 'status' => $status, 'view' => 30]) }}">30</a>
                                            </li>
                                            <li><a
                                                    href="{{ route('admin.admin.index', ['sort_id' => $sort_id, 'role' => $role, 'status' => $status, 'view' => 40]) }}">40</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-7 text-right text-center-xs">
                                    <ul class="pagination pagination-sm m-t-none m-b-none">
                                        {!! $admins->links() !!}
                                    </ul>
                                </div>
                            </div>
                        </footer>
                    </form>

                </div>
            </div>
        </section>
        <!-- footer -->
        @include('admin.footer')
        <!-- / footer -->
    </section>

    <!--main content end-->
    <script>
        $(document).ready(function() {
            $("#success_msg").fadeOut(10000);
            $("#error_msg").fadeOut(10000);
        });

    </script>
@endsection
