{{-- Account side bar --}}
<aside class="col-right sidebar col-sm-3 wow">
    <div class="block block-account">
        <div class="block-title">Information</div>
        <div class="block-content">
            <ul>
                <li><a href="{{ route('info.site_map.category') }}">Site map</a></li>
                <li class="current"><a href="{{ route('info.search_terms') }}">Search terms</a></li>
                <li><a href="{{ route('info.advanced_search.index') }}">Advanced search</a></li>
                <li><a href="{{ route('info.contact_us') }}">Contact us</a>
                </li>
                <li><a href="{{ route('info.about_us') }}">About us</a>
                </li>
            </ul>
        </div>
    </div>
</aside>
{{-- end of account side bar --}}
