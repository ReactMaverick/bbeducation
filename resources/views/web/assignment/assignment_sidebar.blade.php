@php
    $webUserLoginData = Session::get('webUserLoginData');
@endphp
<style>
    .disabled-link {
        pointer-events: none;
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ URL::to('/dashboard') }}" class="brand-link">
        <img src="{{ asset($webUserLoginData->company_logo) }}" alt="" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">
            @if ($webUserLoginData && isset($webUserLoginData->company_name))
                {{ $webUserLoginData->company_name }}
            @endif
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="sidebar-top-text">
            <a href="{{ URL::to('/school-detail/' . $assignmentDetail->school_id) }}" class="skd_id_box new_skd_id_box"
                target="_blank">
                <span class="skl_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="512" height="512" x="0" y="0" viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path
                                d="M457.667 291v-76.473M54.333 214.527v75.157M372.667 122.85V78.002l-106.071-67.42a19.751 19.751 0 0 0-21.191 0l-106.071 67.42v44.848M201.333 122.85H63.773a13.908 13.908 0 0 0-13.575 10.884L36.393 195.7c-1.935 8.688 4.675 16.932 13.575 16.932h89.366M372.667 212.632h89.365c8.901 0 15.511-8.245 13.575-16.932l-13.805-61.966a13.908 13.908 0 0 0-13.575-10.884H310.416M119.771 90.436l19.562-12.434M392.229 90.436l-19.562-12.434M139.333 291v-29.467"
                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="">
                            </path>
                            <path
                                d="M139.333 226.529v-51.001a22.642 22.642 0 0 1 10.496-19.109l95.575-60.748a19.751 19.751 0 0 1 21.191 0l95.575 60.748a22.642 22.642 0 0 1 10.496 19.109V291"
                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="">
                            </path>
                            <path
                                d="M321.333 292v-73.473H190.667V292M256 218.527v73.157M376.338 504.5h94.052c7.807 0 14.137-6.329 14.137-14.137v-20.78H27.474v20.78c0 7.807 6.329 14.137 14.137 14.137h299.724"
                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="">
                            </path>
                            <path
                                d="M444.649 426.667H67.351c-22.024 0-39.878 17.854-39.878 39.878v3.039h457.053v-3.039c0-22.025-17.853-39.878-39.877-39.878zM7.5 406.667v-93.982c0-11.046 8.954-20 20-20h457c11.046 0 20 8.954 20 20v93.982c0 11.046-8.954 20-20 20h-457c-11.046 0-20-8.955-20-20z"
                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="">
                            </path>
                            <path
                                d="M433.004 332.705v53.896c.596.102 18.889 0 18.889 0M197.127 332.705v53.941M234.455 332.705v53.941M197.127 358.751h37.328M166.226 337.311a26.848 26.848 0 0 0-15.08-4.606c-14.896 0-26.971 12.075-26.971 26.971s12.075 26.971 26.971 26.971c6.05 0 11.026-1.992 14.802-5.355a21.83 21.83 0 0 0 2.189-2.258M93.354 338.25s-9.679-8.136-21.093-4.698c-10.481 3.157-11.946 15.242-4.364 20.185 0 0 7.44 3.319 15.693 6.363 19.865 7.327 11.308 26.546-4.684 26.546-8.008 0-14.729-3.507-18.797-7.996"
                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="">
                            </path>
                            <circle cx="291.501" cy="359.676" r="26.971"
                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="">
                            </circle>
                            <circle cx="375.184" cy="359.676" r="26.971"
                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class="">
                            </circle>
                        </g>
                    </svg>
                </span>
                <div class="slk_item">
                    <h2>{{ $assignmentDetail->schooleName }}</h2>
                    <span>{{ $assignmentDetail->school_id }}</span>
                </div>
            </a>
            @if ($assignmentDetail->status_int < 3)
                <a class="skl_check {{ $assignmentDetail->status_int == 3 ? 'assignmentCompleteOuter' : '' }}"
                    style="cursor: pointer;" id="statusAnchId"
                    onclick="changeStatusToComplete({{ $asn_id }}, '{{ $assignmentDetail->teacher_id }}', '{{ $assignmentDetail->techerFirstname . ' ' . $assignmentDetail->techerSurname }}')">
                    <span
                        class="svg_icon {{ $assignmentDetail->status_int == 3 ? 'assignmentComplete' : 'assignmentInComplete' }}"
                        id="statusIconId">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0"
                            viewBox="0 0 512 511" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
                            <g>
                                <path
                                    d="M512 256.5c0 50.531-15 99.672-43.375 142.113-3.855 5.77-10.191 8.887-16.645 8.887-3.82 0-7.683-1.09-11.097-3.375-9.184-6.137-11.649-18.559-5.512-27.742C459.336 340.543 472 299.09 472 256.5c0-18.3-2.29-36.477-6.805-54.016-2.754-10.695 3.688-21.601 14.383-24.355 10.703-2.75 21.602 3.687 24.356 14.383C509.285 213.309 512 234.836 512 256.5zM367.734 441.395C334.141 461.742 295.504 472.5 256 472.5c-119.102 0-216-96.898-216-216s96.898-216 216-216c44.098 0 86.5 13.195 122.629 38.16 9.086 6.278 21.543 4 27.824-5.086 6.277-9.086 4.004-21.543-5.086-27.824C358.523 16.148 308.257.5 256 .5 187.621.5 123.332 27.129 74.98 75.48 26.63 123.832 0 188.121 0 256.5s26.629 132.668 74.98 181.02C123.332 485.87 187.621 512.5 256 512.5c46.813 0 92.617-12.758 132.46-36.895 9.45-5.722 12.47-18.02 6.747-27.468-5.727-9.45-18.023-12.465-27.473-6.742zM257.93 314.492c-3.168.125-6.125-1-8.422-3.187l-104.746-99.317c-8.016-7.601-20.676-7.265-28.274.75-7.601 8.016-7.265 20.676.75 28.274l104.727 99.3c9.672 9.196 22.183 14.188 35.441 14.188.711 0 1.422-.016 2.133-.043 14.043-.566 26.941-6.644 36.316-17.117.239-.262.465-.531.688-.809l211.043-262.5c6.922-8.61 5.555-21.199-3.055-28.117-8.605-6.922-21.199-5.555-28.12 3.055L265.78 310.957a11.434 11.434 0 0 1-7.851 3.535zm0 0"
                                    fill="#000000" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                    </span>
                </a>
            @else
                <a class="skl_check {{ $assignmentDetail->status_int == 3 ? 'assignmentCompleteOuter' : '' }}"
                    style="cursor: pointer;">
                    <span
                        class="svg_icon {{ $assignmentDetail->status_int == 3 ? 'assignmentComplete' : 'assignmentInComplete' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0"
                            viewBox="0 0 512 511" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
                            <g>
                                <path
                                    d="M512 256.5c0 50.531-15 99.672-43.375 142.113-3.855 5.77-10.191 8.887-16.645 8.887-3.82 0-7.683-1.09-11.097-3.375-9.184-6.137-11.649-18.559-5.512-27.742C459.336 340.543 472 299.09 472 256.5c0-18.3-2.29-36.477-6.805-54.016-2.754-10.695 3.688-21.601 14.383-24.355 10.703-2.75 21.602 3.687 24.356 14.383C509.285 213.309 512 234.836 512 256.5zM367.734 441.395C334.141 461.742 295.504 472.5 256 472.5c-119.102 0-216-96.898-216-216s96.898-216 216-216c44.098 0 86.5 13.195 122.629 38.16 9.086 6.278 21.543 4 27.824-5.086 6.277-9.086 4.004-21.543-5.086-27.824C358.523 16.148 308.257.5 256 .5 187.621.5 123.332 27.129 74.98 75.48 26.63 123.832 0 188.121 0 256.5s26.629 132.668 74.98 181.02C123.332 485.87 187.621 512.5 256 512.5c46.813 0 92.617-12.758 132.46-36.895 9.45-5.722 12.47-18.02 6.747-27.468-5.727-9.45-18.023-12.465-27.473-6.742zM257.93 314.492c-3.168.125-6.125-1-8.422-3.187l-104.746-99.317c-8.016-7.601-20.676-7.265-28.274.75-7.601 8.016-7.265 20.676.75 28.274l104.727 99.3c9.672 9.196 22.183 14.188 35.441 14.188.711 0 1.422-.016 2.133-.043 14.043-.566 26.941-6.644 36.316-17.117.239-.262.465-.531.688-.809l211.043-262.5c6.922-8.61 5.555-21.199-3.055-28.117-8.605-6.922-21.199-5.555-28.12 3.055L265.78 310.957a11.434 11.434 0 0 1-7.851 3.535zm0 0"
                                    fill="#000000" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                    </span>
                </a>
            @endif
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ URL::to('/assignment-details/' . $assignmentDetail->asn_id) }}"
                        class="nav-link @if ($title['pageTitle'] == 'Assignments Detail') active @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0"
                            viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
                            <g>
                                <path
                                    d="M9.213 23.835a.9.9 0 0 0 0 1.8h6.837a.9.9 0 0 0 0-1.8zM22.787 15.443H9.214a.9.9 0 0 0 0 1.8h13.573a.9.9 0 0 0 0-1.8zM23.688 20.54a.9.9 0 0 0-.9-.9H9.214a.9.9 0 0 0 0 1.8h13.573a.9.9 0 0 0 .901-.9z"
                                    fill="#000000" opacity="1" data-original="#000000" class=""></path>
                                <path
                                    d="M25.55 4.699h-8.633a.9.9 0 0 0 0 1.8h8.633c.965 0 1.75.78 1.75 1.74V27.35c0 .965-.785 1.75-1.75 1.75H6.45c-.965 0-1.75-.785-1.75-1.75V8.24c0-.96.785-1.74 1.75-1.74h5.562v3.026a.652.652 0 0 1-1.304 0v-.934a.9.9 0 0 0-1.8 0v.935c0 1.353 1.101 2.453 2.453 2.453s2.453-1.101 2.453-2.453V4.225c0-1.723-1.402-3.125-3.125-3.125S7.563 2.502 7.563 4.225V4.7H6.45a3.55 3.55 0 0 0-3.551 3.541V27.35a3.555 3.555 0 0 0 3.551 3.551h19.1a3.555 3.555 0 0 0 3.551-3.551V8.24a3.55 3.55 0 0 0-3.551-3.541zM9.364 4.225c0-.73.594-1.324 1.323-1.324.73 0 1.324.594 1.324 1.324V4.7H9.364z"
                                    fill="#000000" opacity="1" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <p>
                            Assignment
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::to('/assignment-contact/' . $assignmentDetail->asn_id) }}"
                        class="nav-link @if ($title['pageTitle'] == 'Assignments Contact') active @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0"
                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"
                            class="">
                            <g>
                                <path
                                    d="M255.986 368.994c69.385 0 125.834-56.437 125.834-125.807a125.977 125.977 0 0 0-125.834-125.834c-69.37 0-125.806 56.449-125.806 125.834a126.3 126.3 0 0 0 33.62 85.588l-13.013 48.547a15 15 0 0 0 21.993 16.872l50.895-29.408a125.582 125.582 0 0 0 32.311 4.208zm-41.747-33.4-25.091 14.5 5.868-21.89a15 15 0 0 0-4.268-14.863 94.89 94.89 0 0 1-30.568-70.149 95.775 95.775 0 1 1 66.2 91.128 15 15 0 0 0-12.141 1.271zM503.8 253.9c.163-6.138.332-12.485.039-19.093a71.337 71.337 0 0 0-71.782-68.279C402.4 98.677 334.645 51.136 255.986 51.136S109.6 98.676 79.942 166.527a71.339 71.339 0 0 0-71.779 68.257c-.294 6.632-.125 12.98.038 19.119.173 6.486.351 13.193.018 20.73a71.432 71.432 0 0 0 68.18 74.36q1.678.078 3.349.078a70.393 70.393 0 0 0 27.415-5.54 14.973 14.973 0 0 0 8.114-19.377 8.044 8.044 0 0 0-.824-2.021 162.3 162.3 0 0 1-20.491-78.946c0-89.355 72.684-162.051 162.024-162.051s162.052 72.7 162.052 162.051a161.532 161.532 0 0 1-132.157 159.287 41.584 41.584 0 1 0 1.328 30.209 192.361 192.361 0 0 0 130.075-85.231 70.237 70.237 0 0 0 14.951 1.62q1.653 0 3.315-.076a71.366 71.366 0 0 0 68.23-74.383c-.332-7.513-.153-14.226.02-20.713zM77.733 319.023a41.405 41.405 0 0 1-39.543-43.085c.379-8.579.178-16.151 0-22.833-.156-5.875-.3-11.423-.055-17.014a41.394 41.394 0 0 1 31.274-38.35 192.359 192.359 0 0 0 8.3 116.877l-.018.007q.876 2.232 1.809 4.443-.877-.004-1.767-.045zm170.118 111.841a11.589 11.589 0 1 1 11.588-11.593v.022a11.6 11.6 0 0 1-11.588 11.571zm225.958-154.947a41.366 41.366 0 0 1-39.591 43.108q-.864.041-1.724.044a.255.255 0 0 0 .011-.177 192.27 192.27 0 0 0 10.086-121.15 41.391 41.391 0 0 1 31.275 38.371c.247 5.568.1 11.116-.056 16.99-.178 6.682-.38 14.255-.001 22.814zm-252.869-34.2a14.464 14.464 0 0 1 .07 1.47 14.661 14.661 0 0 1-.07 1.48c-.05.48-.13.97-.22 1.45s-.22.96-.36 1.43-.31.93-.5 1.38-.4.9-.63 1.33-.48.85-.75 1.26a12.819 12.819 0 0 1-.87 1.18c-.31.39-.65.75-.99 1.1a14.668 14.668 0 0 1-1.1.99c-.38.31-.78.6-1.18.88-.41.26-.83.52-1.27.75a13.2 13.2 0 0 1-1.32.62 14.253 14.253 0 0 1-1.38.5c-.47.14-.95.26-1.43.36a14.512 14.512 0 0 1-1.45.22 15.681 15.681 0 0 1-2.96 0 14.512 14.512 0 0 1-1.45-.22c-.48-.1-.96-.22-1.43-.36a14.253 14.253 0 0 1-1.38-.5 13.2 13.2 0 0 1-1.32-.62c-.44-.23-.86-.49-1.27-.75-.4-.28-.8-.57-1.18-.88a14.668 14.668 0 0 1-1.1-.99c-.34-.35-.68-.71-.99-1.1a12.819 12.819 0 0 1-.87-1.18q-.4-.615-.75-1.26c-.23-.43-.44-.88-.63-1.33s-.35-.91-.5-1.38-.26-.95-.36-1.43a14.086 14.086 0 0 1-.29-2.93c0-.49.03-.98.07-1.47s.13-.98.22-1.46.22-.95.36-1.42.31-.93.5-1.38.4-.9.63-1.33a15.584 15.584 0 0 1 1.62-2.45c.31-.38.65-.75.99-1.09a14.668 14.668 0 0 1 1.1-.99c.38-.31.78-.61 1.18-.88a14.6 14.6 0 0 1 1.27-.75q.645-.345 1.32-.63c.45-.18.92-.35 1.38-.49a14.242 14.242 0 0 1 1.43-.36 14.718 14.718 0 0 1 5.86 0 14.242 14.242 0 0 1 1.43.36c.46.14.93.31 1.38.49s.89.4 1.32.63a14.6 14.6 0 0 1 1.27.75c.4.27.8.57 1.18.88a14.668 14.668 0 0 1 1.1.99c.34.34.68.71.99 1.09a15.584 15.584 0 0 1 1.62 2.45c.23.43.44.88.63 1.33s.35.91.5 1.38.26.95.36 1.42.17.966.22 1.456zm20.06 1.47a14.988 14.988 0 0 1 14.986-15h.028a15 15 0 1 1-15.014 15zm50.06 1.476a14.661 14.661 0 0 1-.07-1.48 14.464 14.464 0 0 1 .07-1.47c.05-.49.13-.98.22-1.46s.22-.95.36-1.42a13.353 13.353 0 0 1 .5-1.38c.18-.45.4-.9.62-1.33a16.64 16.64 0 0 1 1.63-2.45c.31-.38.65-.75.99-1.09a14.668 14.668 0 0 1 1.1-.99 12.913 12.913 0 0 1 1.18-.88q.615-.4 1.26-.75c.43-.23.88-.44 1.33-.63s.92-.35 1.38-.49a14.242 14.242 0 0 1 1.43-.36 14.684 14.684 0 0 1 4.4-.22 14.277 14.277 0 0 1 1.46.22 13.41 13.41 0 0 1 1.42.36c.47.14.94.31 1.39.49s.89.4 1.32.63a14.6 14.6 0 0 1 1.27.75c.4.27.8.57 1.18.88a12.8 12.8 0 0 1 1.09.99c.35.34.68.71 1 1.09.3.38.6.78.87 1.19a14.425 14.425 0 0 1 .75 1.26c.23.43.44.88.63 1.33a13.294 13.294 0 0 1 .49 1.38 11.812 11.812 0 0 1 .36 1.42 11.959 11.959 0 0 1 .22 1.46 14.479 14.479 0 0 1 .08 1.47 14.676 14.676 0 0 1-.08 1.48 12.1 12.1 0 0 1-.22 1.45 11.967 11.967 0 0 1-.36 1.43 14.174 14.174 0 0 1-.49 1.38c-.19.45-.4.9-.63 1.33s-.48.85-.75 1.26-.57.81-.87 1.18c-.32.39-.65.75-1 1.1a12.8 12.8 0 0 1-1.09.99c-.38.31-.78.6-1.18.87a14.692 14.692 0 0 1-1.27.76 13.2 13.2 0 0 1-1.32.62 13.525 13.525 0 0 1-1.39.5c-.46.14-.94.26-1.42.36a14.461 14.461 0 0 1-2.93.29 14.661 14.661 0 0 1-1.48-.07 14.512 14.512 0 0 1-1.45-.22c-.48-.1-.96-.22-1.43-.36a14.253 14.253 0 0 1-1.38-.5 13.359 13.359 0 0 1-1.33-.62c-.43-.23-.85-.49-1.26-.76a12.819 12.819 0 0 1-1.18-.87 14.668 14.668 0 0 1-1.1-.99c-.34-.35-.68-.71-.99-1.1a12.819 12.819 0 0 1-.87-1.18c-.27-.41-.53-.83-.76-1.26s-.44-.88-.62-1.33a14.253 14.253 0 0 1-.5-1.38c-.14-.47-.26-.95-.36-1.43s-.17-.97-.22-1.45z"
                                    fill="#000000" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                        <p>
                            Contact
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::to('/assignment-candidate/' . $assignmentDetail->asn_id . '?showall=1') }}"
                        class="nav-link @if ($title['pageTitle'] == 'Assignments Candidate') active @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0"
                            viewBox="0 0 5171.524 4796.003" style="enable-background:new 0 0 512 512"
                            xml:space="preserve" class="">
                            <g>
                                <path
                                    d="m3693.28 2439.646-9.56 89.828h1487.804l-9.56-89.828c-28.679-271.877-201.378-494.985-437.854-598.203 112.693-88.271 185.327-225.251 185.327-379.162 0-265.678-216.142-481.717-481.815-481.717s-481.814 216.193-481.814 481.871c0 153.911 72.633 290.712 185.325 378.977-236.482 103.218-409.178 326.351-437.853 598.234zm416.619-977.161c0-175.199 142.529-317.728 317.723-317.728s317.723 142.529 317.723 317.728c0 175.189-142.529 317.718-317.723 317.718s-317.723-142.529-317.723-317.718zm317.723 480.168c263.439 0 487.569 176.591 554.246 422.729H3873.371c66.678-246.138 290.812-422.729 554.251-422.729z"
                                    style="" fill="#000000" data-original="#000000" class=""></path>
                                <path
                                    d="M4842.905 3800.825 3530.38 2620.884c378.722-669.568 283.272-1536.774-286.55-2106.594C2912.186 182.651 2471.244 0 2002.229 0S1092.272 182.651 760.628 514.29c-331.644 331.649-514.29 772.586-514.29 1241.596 0 469.02 182.645 909.957 514.29 1241.606 331.644 331.639 772.586 514.29 1241.601 514.29 303.214 0 594.644-76.442 852.445-220.023l423.804 471.429.004-.005 758.425 843.64c105.772 117.651 251.12 184.764 409.273 188.97 5.253.14 10.486.21 15.719.21 152.264 0 294.853-59.011 403.009-167.167l.005-.01c111.867-111.872 171.163-260.58 166.956-418.733-4.205-158.152-71.314-303.495-188.964-409.268zm-1831.857-580.571 116.087-116.088c40.195-33.657 79.179-69.156 116.695-106.674 37.399-37.397 72.63-76.147 105.943-115.973l106.559-106.559 304.531 273.77-476.044 476.051-273.771-304.527zm-2119.89-353.303C594.383 2570.176 430.942 2175.6 430.942 1755.886c0-419.704 163.441-814.28 460.217-1111.056 296.781-296.786 691.366-460.227 1111.071-460.227s814.29 163.441 1111.066 460.227h.005c296.771 296.776 460.212 691.351 460.212 1111.056 0 419.714-163.441 814.29-460.217 1111.066-296.776 296.786-691.361 460.227-1111.066 460.227s-814.291-163.442-1111.072-460.228zM4748.88 4512.798c-79.702 79.702-185.505 121.977-298.338 118.962-112.683-2.995-216.247-50.818-291.608-134.646l-764.257-850.125 488.39-488.395 850.128 764.258c83.829 75.366 131.642 178.925 134.642 291.598 2.996 112.683-39.254 218.646-118.957 298.348z"
                                    style="" fill="#000000" data-original="#000000" class=""></path>
                                <path
                                    d="M2949.518 808.592c-522.332-522.322-1372.247-522.322-1894.578 0-522.342 522.342-522.342 1372.257 0 1894.599 253.028 253.028 589.45 392.382 947.289 392.382s694.261-139.354 947.289-392.382c522.342-522.343 522.342-1372.258 0-1894.599zM2002.229 2931.48c-314.012 0-609.225-124.13-831.261-346.171-14.278-14.277-28.127-25.068-41.574-45.58h1745.67c-13.447 20.511-27.296 31.303-41.574 45.58-222.041 222.041-517.254 346.171-831.261 346.171zm-419.96-1693.82c0-228.18 185.635-413.815 413.81-413.815s413.81 185.635 413.81 413.815c0 228.17-185.635 413.805-413.81 413.805s-413.81-185.634-413.81-413.805zM1283.31 2375.637c76.317-328.184 368.16-563.765 712.769-563.765s636.452 235.582 712.769 563.765H1283.31zm1611.233 145.694-7.23-68.565c-36.077-342.035-259.948-621.058-563.202-739.701 150.818-104.39 249.871-278.513 249.871-475.405 0-318.659-259.248-577.907-577.902-577.907s-577.902 259.248-577.902 577.907c0 196.892 99.053 371.015 249.871 475.405-303.254 118.642-527.125 397.665-563.202 739.701l-5.862 55.59c-176.289-210.874-272.335-474.273-272.335-752.46 0-314.012 122.283-609.235 344.319-831.266 229.182-229.182 530.219-343.768 831.261-343.768s602.079 114.586 831.261 343.768c222.036 222.031 344.319 517.254 344.319 831.266-.001 283.906-99.987 552.448-283.267 765.435zM1040.39 4004.182c112.694-88.271 185.327-225.461 185.327-379.377 0-265.668-216.142-481.81-481.815-481.81s-481.815 216.142-481.815 481.81c0 153.916 72.633 291.107 185.327 379.377C210.937 4107.396 38.239 4330.914 9.56 4602.786L0 4693.436h1487.804l-9.56-90.649c-28.679-271.873-201.377-495.391-437.854-598.605zm-614.211-379.377c0-175.189 142.529-317.718 317.723-317.718s317.723 142.529 317.723 317.718c0 175.199-142.529 317.728-317.723 317.728s-317.723-142.529-317.723-317.728zm-236.523 904.539c66.677-246.429 290.806-422.719 554.246-422.719s487.569 176.291 554.246 422.719H189.656z"
                                    style="" fill="#000000" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <p>
                            Candidates
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::to('/assignment-school/' . $assignmentDetail->asn_id) }}"
                        class="nav-link @if ($title['pageTitle'] == 'Assignments School Detail') active @endif">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0"
                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <g>
                                <path
                                    d="M362.937 0h-294c-16.542 0-30 13.458-30 30v102c0 5.523 4.478 10 10 10s10-4.477 10-10V30c0-5.514 4.486-10 10-10h294c5.514 0 10 4.486 10 10v372c0 5.514-4.486 10-10 10h-294c-5.514 0-10-4.486-10-10V216.333c0-5.523-4.478-10-10-10s-10 4.477-10 10V402c0 16.542 13.458 30 30 30h294c16.542 0 30-13.458 30-30V30c0-16.542-13.458-30-30-30z"
                                    fill="#000000" opacity="1" data-original="#000000"></path>
                                <path
                                    d="M56.006 169.7c-1.859-1.86-4.439-2.92-7.069-2.92s-5.21 1.06-7.07 2.92a10.107 10.107 0 0 0-2.93 7.07 10.1 10.1 0 0 0 2.93 7.08c1.86 1.86 4.44 2.93 7.07 2.93 2.629 0 5.209-1.07 7.069-2.93a10.078 10.078 0 0 0 2.931-7.08c0-2.63-1.071-5.2-2.931-7.07zM96.066 454.99a10.056 10.056 0 0 0-7.07-2.93c-2.63 0-5.21 1.07-7.069 2.93a10.072 10.072 0 0 0-2.931 7.07c0 2.64 1.071 5.21 2.931 7.07a10.029 10.029 0 0 0 7.069 2.93c2.641 0 5.21-1.06 7.07-2.93a10.054 10.054 0 0 0 2.93-7.07c0-2.63-1.07-5.21-2.93-7.07zM423 40.063c-5.522 0-10 4.477-10 10v392c0 5.514-4.486 10-10 10H129c-5.522 0-10 4.477-10 10s4.478 10 10 10h274c16.542 0 30-13.458 30-30v-392c0-5.523-4.478-10-10-10z"
                                    fill="#000000" opacity="1" data-original="#000000"></path>
                                <path
                                    d="M463.063 80c-5.522 0-10 4.477-10 10v392c0 5.514-4.486 10-10 10h-314c-5.522 0-10 4.477-10 10s4.478 10 10 10h314c16.542 0 30-13.458 30-30V90c0-5.523-4.478-10-10-10zM200.937 74h-96c-5.522 0-10 4.477-10 10v96c0 5.523 4.478 10 10 10h96c5.522 0 10-4.477 10-10V84c0-5.523-4.478-10-10-10zm-10 96h-76V94h76v76zM168.761 235.402c-3.906-3.904-10.236-3.905-14.143 0l-26.583 26.583-12.36-12.361c-3.905-3.905-10.235-3.904-14.143 0-3.905 3.905-3.905 10.237 0 14.142l19.432 19.432a10.003 10.003 0 0 0 14.143 0l33.654-33.654c3.905-3.905 3.905-10.237 0-14.142z"
                                    fill="#000000" opacity="1" data-original="#000000"></path>
                                <path
                                    d="M332.604 249H215.937c-5.522 0-10 4.477-10 10s4.478 10 10 10h116.667c5.522 0 10-4.477 10-10s-4.478-10-10-10zM326.937 74h-70c-5.522 0-10 4.477-10 10s4.478 10 10 10h70c5.522 0 10-4.477 10-10s-4.478-10-10-10zM326.937 122h-70c-5.522 0-10 4.477-10 10s4.478 10 10 10h70c5.522 0 10-4.477 10-10s-4.478-10-10-10zM326.937 170h-70c-5.522 0-10 4.477-10 10s4.478 10 10 10h70c5.522 0 10-4.477 10-10s-4.478-10-10-10zM168.761 311.769c-3.906-3.904-10.236-3.905-14.143 0l-26.583 26.583-12.36-12.361c-3.905-3.905-10.235-3.904-14.143 0-3.905 3.905-3.905 10.237 0 14.142l19.432 19.432a10.003 10.003 0 0 0 14.143 0l33.654-33.654c3.905-3.905 3.905-10.237 0-14.142zM332.604 325H215.937c-5.522 0-10 4.477-10 10s4.478 10 10 10h116.667c5.522 0 10-4.477 10-10s-4.478-10-10-10z"
                                    fill="#000000" opacity="1" data-original="#000000"></path>
                            </g>
                        </svg>
                        <p>
                            School Details
                        </p>
                    </a>
                </li>

                {{-- <div class="sidebar-pages-section @if ($title['pageTitle'] == 'Assignments Finance') sidebar-active @endif">
                    <a href="{{ URL::to('/assignment-finance/' . $assignmentDetail->asn_id) }}" class="sidebar-pages">
                        <div class="page-icon-sec">
                            <i class="fa-solid fa-money-bills"></i>
                        </div>
                        <div class="page-name-sec">
                            <span>Finance</span>
                        </div>
                    </a>
                </div> --}}

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        <div class="skd_id_box">

            <div class="assignment-detail-user-img-sec">
                <div class="user-img-sec">
                    @if ($assignmentDetail->file_location != null || $assignmentDetail->file_location != '')
                        <img class="img-fluid" src="{{ asset($assignmentDetail->file_location) }}" alt="">
                    @else
                        <img class="img-fluid" src="{{ asset('web/images/user-img.png') }}" alt="">
                    @endif
                </div>
            </div>
            <div class="skd_id_item">
                <div class="teacher-name">
                    @if ($assignmentDetail->teacher_id)
                        <a href="{{ URL::to('/candidate-detail/' . $assignmentDetail->teacher_id) }}" class=""
                            target="_blank">
                            <span>{{ $assignmentDetail->techerFirstname . ' ' . $assignmentDetail->techerSurname }}</span>
                        </a>
                    @endif
                </div>
                <div class="sidebar-user-number">
                    <span>{{ $assignmentDetail->teacher_id }}</span>
                </div>
            </div>
        </div>

        <div class="skl_check {{ $assignmentDetail->teacher_id ? 'assignmentCompleteOuter' : '' }}">
            <span
                class="svg_icon {{ $assignmentDetail->teacher_id ? 'assignmentComplete' : 'assignmentInComplete' }}">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="512" height="512" x="0" y="0" viewBox="0 0 512 511"
                    style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                    <g>
                        <path
                            d="M512 256.5c0 50.531-15 99.672-43.375 142.113-3.855 5.77-10.191 8.887-16.645 8.887-3.82 0-7.683-1.09-11.097-3.375-9.184-6.137-11.649-18.559-5.512-27.742C459.336 340.543 472 299.09 472 256.5c0-18.3-2.29-36.477-6.805-54.016-2.754-10.695 3.688-21.601 14.383-24.355 10.703-2.75 21.602 3.687 24.356 14.383C509.285 213.309 512 234.836 512 256.5zM367.734 441.395C334.141 461.742 295.504 472.5 256 472.5c-119.102 0-216-96.898-216-216s96.898-216 216-216c44.098 0 86.5 13.195 122.629 38.16 9.086 6.278 21.543 4 27.824-5.086 6.277-9.086 4.004-21.543-5.086-27.824C358.523 16.148 308.257.5 256 .5 187.621.5 123.332 27.129 74.98 75.48 26.63 123.832 0 188.121 0 256.5s26.629 132.668 74.98 181.02C123.332 485.87 187.621 512.5 256 512.5c46.813 0 92.617-12.758 132.46-36.895 9.45-5.722 12.47-18.02 6.747-27.468-5.727-9.45-18.023-12.465-27.473-6.742zM257.93 314.492c-3.168.125-6.125-1-8.422-3.187l-104.746-99.317c-8.016-7.601-20.676-7.265-28.274.75-7.601 8.016-7.265 20.676.75 28.274l104.727 99.3c9.672 9.196 22.183 14.188 35.441 14.188.711 0 1.422-.016 2.133-.043 14.043-.566 26.941-6.644 36.316-17.117.239-.262.465-.531.688-.809l211.043-262.5c6.922-8.61 5.555-21.199-3.055-28.117-8.605-6.922-21.199-5.555-28.12 3.055L265.78 310.957a11.434 11.434 0 0 1-7.851 3.535zm0 0"
                            fill="#000000" opacity="1" data-original="#000000" class=""></path>
                    </g>
                </svg>
            </span>
        </div>
        <div class="assignment-id-text-sec brand-text">
            <span class="bold_text">Assignment ID :</span>
            <span>{{ $assignmentDetail->asn_id }}</span>
        </div>

    </div>
    <!-- /.sidebar -->

    {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            @if ($schoolDetail->profile_pic != null || $schoolDetail->profile_pic != '')
                <img src="{{ asset($schoolDetail->profile_pic) }}" class="img-circle elevation-2" alt="">
            @else
                <img src="{{ asset('web/images/college.png') }}" class="img-circle elevation-2" alt="">
            @endif
        </div>
        <div class="info">
            <a href="javascript:void(0)" class="d-block">
                {{ $schoolDetail->name_txt }}
            </a>
        </div>
    </div> --}}
</aside>

<!-- Candidate Vetting Modal -->
<div class="modal fade" id="candidateVettingModalSidebar">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section cand-vetting-modal-section">
        <div class="modal-content calendar-modal-content">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Candidate Vetting</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div id="candidateVetAjaxSidebar"></div>

        </div>
    </div>
</div>
<!-- Candidate Vetting Modal -->

<script>
    function changeStatusToComplete(asn_id, teacher_id, candidateName) {
        var count = 0;
        $.ajax({
            type: 'POST',
            url: '{{ url('assignmentStatusEdit') }}',
            data: {
                "_token": "{{ csrf_token() }}",
                asn_id: asn_id,
                status: '3'
            },
            dataType: "json",
            async: false,
            success: function(data) {
                if (data) {
                    count = 1;
                    $('#statusIconId').removeClass('assignmentInComplete');
                    $('#statusIconId').addClass('assignmentComplete');
                    //add class to parent div of status icon
                    $('#statusIconId').parent().addClass('assignmentCompleteOuter');
                    $('#statusAnchId').addClass('disabled-link');
                }
            }
        });
        if (count == 1 && teacher_id) {
            $.ajax({
                type: 'POST',
                url: '{{ url('createCandidateVetting') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    asn_id: asn_id,
                    vetting_id: '',
                    newVetting: "Yes",
                    sidebar: "Yes"
                },
                success: function(data) {
                    if (data) {
                        $('#candidateVetAjaxSidebar').html(data.html);
                        $('#candidateVettingModalSidebar').modal("show");
                    }
                }
            });
        }
    }

    $(document).on('click', '#candVettingEditBtnSidebar', function() {
        // var error = "";
        // $(".vetting-field-validate").each(function() {
        //     if (this.value == '') {
        //         $(this).closest(".form-group").addClass('has-error');
        //         error = "has error";
        //     } else {
        //         $(this).closest(".form-group").removeClass('has-error');
        //     }
        // });
        // if (error == "has error") {
        //     return false;
        // } else {
        var form = $("#candVettingEditForm");
        var actionUrl = form.attr('action');
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            dataType: "json",
            async: false,
            success: function(data) {
                if (data) {
                    $('#candidateVetAjaxSidebar').html(data.html);
                }
            }
        });
        // }
    });
</script>
