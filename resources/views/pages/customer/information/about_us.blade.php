@extends('layout')
@section('title', 'Contact us - Electronical Store')
@section('content')
    <!-- main-container -->
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="page-title">
                        <h1>About Us</h1>
                    </div>
                    <div class="col-2 registered-users">
                        <div class="content">
                            <h4>Graduation Thesis - National University of Civil Engineering</h4>
                            <h5>Topic : Electronic Store Website</h5>
                            <h5>Student : Trần Văn Định - 1511661 - 61PM1</h5>
                            <h5>Instructor : Phan Hữu Trung</h5>
                        </div>
                    </div>
                </section>
                @include('information_side_bar');
            </div>
        </div>
    </div>
    <!--End main-container -->

@endsection
