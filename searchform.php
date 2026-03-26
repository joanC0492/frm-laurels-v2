<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
    <div class="search-form-box relative">
        <input type="search" class="search-field" autocomplete="false" placeholder="Search address/location..." value="<?php echo get_search_query() ?>" name="s" />
        <ul class="results absolute w-100"></ul>
    </div>
    <button type="submit" class="search-submit">
        <p>Search</p>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M0.5 8H14.5M14.5 8L7.5 1M14.5 8L7.5 15" stroke="white" />
        </svg>
    </button>
</form>