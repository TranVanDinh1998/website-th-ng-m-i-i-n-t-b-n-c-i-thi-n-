@extends('layouts.admin.index')
@section('title', 'Liên lạc')
@section('head')
    <script src="{{ url('admin/ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.contact.index') }}">Liên lạc</a></li>
                <li class="active">Liên lạc #{{ $contact->id }}</li>
            </ol>
            <section class="panel">
                <div class="panel-heading">
                    Liên lạc #{{ $contact->id }}
                </div>
                <div class="panel-body">
                    <div class="position-center">
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="hidden" class="form-control" name="id"
                                    value="{{ $contact->id }}">
                                <input type="text" class="form-control" name="name" placeholder="name"
                                    value="{{ $contact->name }}">
                            </div>
                            <div class="form-group">
                                <label for="price">Email</label>
                                <input type="email" class="form-control" value="{{ $contact->email }}" name="email"
                                    placeholder="email">
                            </div>
                            <div class="form-group">
                                <label for="price">Số điện thoại</label>
                                <input type="number" class="form-control" value="{{ $contact->number }}" name="number"
                                    placeholder="email">
                            </div>
                            <div class="form-group">
                                <label for="discount">Khởi tạo vào lúc</label>
                                <input type="datetime" class="form-control" name="discount"
                                    placeholder="create date" value="{{ $contact->created_at }}">
                            </div>
                            <div class="form-group">
                                <label for="">Comment</label>
                                <textarea type="text" class="form-control" id="descript" name="description"
                                    placeholder="Comment">{{ $contact->comment }}</textarea>
                                <script>
                                    CKEDITOR.replace('descript');
                                </script>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </section>


        <!-- footer -->
        @include('components.admin.footer')
        <!-- / footer -->
    </section>

    <!--main content end-->

@endsection
