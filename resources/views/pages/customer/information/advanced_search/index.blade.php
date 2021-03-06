@extends('layout')
@section('title', 'Advanced search - Electronical Store')
@section('content')
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-main col-sm-9 wow">
                    <div class="my-account">
                        <div class="page-title">
                            <h2>Advanced search</h2>
                        </div>
                        <div class="col-2 registered-users">
                            <div class="content">
                                <h4>Search settings</h4>
                                <form enctype="multipart/form-data" method="GET"
                                    action="{{ route('info.advanced_search.result') }}">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="search" placeholder="name"
                                            value="{{ $search }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="category_id">Category::</label>
                                        <select class="form-control mul-select" name="category_id_list[]" multiple>
                                            <option>Select category </option>
                                            @foreach ($categories as $category)
                                                <option value='{{ $category->id }}' @if ($category_id_list != null)
                                                    @foreach ($category_id_list as $selected)
                                                        @if ($category->id == $selected)
                                                            selected
                                                        @endif
                                                    @endforeach
                                            @endif
                                            >{{ $category->id }} -
                                            {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="producer_id">Producer:</label>
                                        <select class="form-control mul-select" name="producer_id_list[]" multiple>
                                            <option>Select producer </option>
                                            @foreach ($producers as $producer)
                                                <option value='{{ $producer->id }}' @if ($producer_id_list != null)
                                                    @foreach ($producer_id_list as $selected)
                                                        @if ($producer->id == $selected)
                                                            selected
                                                        @endif
                                                    @endforeach
                                            @endif
                                            >{{ $producer->id }} -
                                            {{ $producer->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Price</label>
                                        <input type="number" class="form-control" name="price_from" placeholder="from">
                                        <input type="number" class="form-control" name="price_to" placeholder="to">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="button">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </section>
                @include('information_side_bar');
            </div>
        </div>
    </div>
    {{-- multiselect --}}
    <script src="{{ url('admin/js/chosen.jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ url('admin/css/chosen.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('css/select2.min.css') }}" type="text/css" />
    <script src="{{ url('js/select2.min.js') }}"></script>
    <script>
        // function display_error()
        jQuery(document).ready(function($) {
            // $("#multi_select").chosen();
            $(".mul-select").select2({
                // placeholder: "select object", //placeholder
                tags: true,
                tokenSeparators: ['/', ',', ';', " "]
            });
        });

    </script>
@endsection
