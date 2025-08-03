
<a href="#" class="btn btn-sm p-1 help-tooltip" 
    data-bs-toggle="tooltip" 
    data-bs-trigger="hover" 
    {{-- data-bs-original-title="What help you want?" --}}
    data-route="{{ Route::currentRouteName() }}" >
    
    <span class="btn-label"></span>

    <!--begin::Svg Icon | Info Icon (like "i")-->
    <span class="svg-icon btn-icon svg-icon-2 me-0">
        <svg xmlns="http://www.w3.org/2000/svg" 
            width="24" height="24" viewBox="0 0 24 24" 
            fill="none">
            <path fill="white" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 
                10-4.48 10-10S17.52 2 12 2zm0 17c-.55 0-1-.45-1-1v-6
                c0-.55.45-1 1-1s1 .45 1 1v6c0 .55-.45 1-1 1zm0-10c-.55 0-1-.45-1-1
                s.45-1 1-1 1 .45 1 1-.45 1-1 1z"/>
        </svg>
    </span>
</a>