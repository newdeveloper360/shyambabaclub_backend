@extends('layouts.app')
@section('title', 'Admin | Notifications')
@section('content')
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('layouts.navbar')
            <div class="main-content">
                <section class="section">
                    <div class="section-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">

                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif
                                
                                @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                                @endif

                                <div class="card">
                                    <div class="card-header">
                                        <h4>Create Group Member Message</h4>
                                    </div>
                                    <form method="post" action="{{ route('group-member-messages.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Message</label>
                                                        <input type="text" name="message" class="form-control" value="{{ old('message') }}" placeholder="Type here...">
                                                        @error('message')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Link</label>
                                                        <input type="text" name="link" class="form-control" value="{{ old('link') }}" placeholder="Enter link">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <label>Image</label>
                                                        <input type="file" name="image" class="form-control" accept="image/*" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group text-right">
                                                <button type="submit" class="btn btn-outline-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table data-searching="false" data-paging="false" data-info="false"
                                                data-order='[[2, "desc"], [0, "desc"]]' id="myTable"
                                                class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Message</th>
                                                        <th>Link</th>
                                                        <th>Image</th>
                                                        <th>Created At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groupMemberMessages as $message)
                                                        <tr>
                                                            <td>{{ $message->message }}</td>
                                                            <td>{{ $message->link }}</td>
                                                            <td>
                                                                @if ($message->image)
                                                                    <img src="public{{ $message->image }}" alt="Image" class="img-fluid" style="width: 40px; height: 40px;">
                                                                @else
                                                                    <span>No image</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $message->created_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="m-2" id="pagination">
                                            {{ $groupMemberMessages->links('pagination.custom') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </div>
        </div>
    </div>
@endsection
