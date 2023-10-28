<style>
    #vettingContentModal .modal-dialog.modal-dialog-centered.calendar-modal-section {
        position: relative;
        z-index: 1;
    }

    #vettingContentModal::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        background-color: rgb(0 0 0 / 41%);
    }
</style>

<form action="{{ url('/updateCandidateVetting') }}" method="post" id="candVettingEditForm">
    @csrf
    <div class="modal-input-field-section">
        <input type="hidden" name="vetting_id" value="{{ $vettingDetail->vetting_id }}">
        <input type="hidden" name="schoolId" value="{{ $schoolId }}">
        <input type="hidden" name="teacherId" value="{{ $teacherId }}">
        <input type="hidden" name="asn_id" value="{{ $asn_id }}">

        <div class="row cand-vetting-modal-left">
            <div class="col-md-6 skd_pr">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group cand-vetting-modal-input-field">
                            <label for="">FAO</label>
                            <input type="text" class="form-control vetting-field-validate" id=""
                                name="fao_txt" value="{{ $vettingDetail->fao_txt }}">
                        </div>
                    </div>
                    <div class="col-md-4 sj_row">
                        <div class="cand-vetting-modal-icon-sec">
                            <a href="{{ URL::to('/school-detail/' . $schoolId) }}" target="_blank">
                                <span class="sj_icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0"
                                        y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                        xml:space="preserve" class="">
                                        <g>
                                            <path
                                                d="M457.667 291v-76.473M54.333 214.527v75.157M372.667 122.85V78.002l-106.071-67.42a19.751 19.751 0 0 0-21.191 0l-106.071 67.42v44.848M201.333 122.85H63.773a13.908 13.908 0 0 0-13.575 10.884L36.393 195.7c-1.935 8.688 4.675 16.932 13.575 16.932h89.366M372.667 212.632h89.365c8.901 0 15.511-8.245 13.575-16.932l-13.805-61.966a13.908 13.908 0 0 0-13.575-10.884H310.416M119.771 90.436l19.562-12.434M392.229 90.436l-19.562-12.434M139.333 291v-29.467"
                                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                                fill="none" stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#1e2f65"
                                                class="">
                                            </path>
                                            <path
                                                d="M139.333 226.529v-51.001a22.642 22.642 0 0 1 10.496-19.109l95.575-60.748a19.751 19.751 0 0 1 21.191 0l95.575 60.748a22.642 22.642 0 0 1 10.496 19.109V291"
                                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                                fill="none" stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#1e2f65"
                                                class="">
                                            </path>
                                            <path
                                                d="M321.333 292v-73.473H190.667V292M256 218.527v73.157M376.338 504.5h94.052c7.807 0 14.137-6.329 14.137-14.137v-20.78H27.474v20.78c0 7.807 6.329 14.137 14.137 14.137h299.724"
                                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                                fill="none" stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#1e2f65"
                                                class="">
                                            </path>
                                            <path
                                                d="M444.649 426.667H67.351c-22.024 0-39.878 17.854-39.878 39.878v3.039h457.053v-3.039c0-22.025-17.853-39.878-39.877-39.878zM7.5 406.667v-93.982c0-11.046 8.954-20 20-20h457c11.046 0 20 8.954 20 20v93.982c0 11.046-8.954 20-20 20h-457c-11.046 0-20-8.955-20-20z"
                                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                                fill="none" stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#1e2f65"
                                                class="">
                                            </path>
                                            <path
                                                d="M433.004 332.705v53.896c.596.102 18.889 0 18.889 0M197.127 332.705v53.941M234.455 332.705v53.941M197.127 358.751h37.328M166.226 337.311a26.848 26.848 0 0 0-15.08-4.606c-14.896 0-26.971 12.075-26.971 26.971s12.075 26.971 26.971 26.971c6.05 0 11.026-1.992 14.802-5.355a21.83 21.83 0 0 0 2.189-2.258M93.354 338.25s-9.679-8.136-21.093-4.698c-10.481 3.157-11.946 15.242-4.364 20.185 0 0 7.44 3.319 15.693 6.363 19.865 7.327 11.308 26.546-4.684 26.546-8.008 0-14.729-3.507-18.797-7.996"
                                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                                fill="none" stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#1e2f65"
                                                class="">
                                            </path>
                                            <circle cx="291.501" cy="359.676" r="26.971"
                                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                                fill="none" stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-miterlimit="10" data-original="#1e2f65"
                                                class="">
                                            </circle>
                                            <circle cx="375.184" cy="359.676" r="26.971"
                                                style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"
                                                fill="none" stroke="#1e2f65" stroke-width="15"
                                                stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                                data-original="#1e2f65" class="">
                                            </circle>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                            <a href="{{ URL::to('/candidate-detail/' . $teacherId) }}" target="_blank">
                                <span class="sj_icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512"
                                        x="0" y="0" viewBox="0 0 682.667 682.667"
                                        style="enable-background:new 0 0 512 512" xml:space="preserve"
                                        class="">
                                        <g>
                                            <defs>
                                                <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                                    <path d="M0 512h512V0H0Z" fill="#1e2f65" opacity="1"
                                                        data-original="#1e2f65"></path>
                                                </clipPath>
                                            </defs>
                                            <g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                                                <path
                                                    d="M0 0c7.467 0 13.52 6.052 13.52 13.519 0 6.866 4.623 12.875 11.267 14.603 26.576 6.911 54.784 6.912 81.365 0 6.646-1.728 11.269-7.737 11.269-14.603C117.421 6.052 123.474 0 130.94 0a6.745 6.745 0 0 0 6.744-6.744v-62.209c0-27.862-16.351-53.914-43.081-65.241a69.64 69.64 0 0 0-28.371-5.941c-.256 0-.506.018-.762.021-.256-.003-.506-.021-.763-.021a69.634 69.634 0 0 0-28.369 5.941C9.606-122.867-6.743-96.815-6.743-68.953v62.209A6.743 6.743 0 0 0 0 0Z"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(190.36 395.789)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path
                                                    d="M0 0v-53.078c0-.575.03-1.144.044-1.717-18.783-2.844-33.494 10.728-33.494 27.396C-33.45-10.698-18.727 2.807 0 0Z"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(183.616 379.913)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path
                                                    d="M0 0v53.058c16.352 2.183 33.45-10.367 33.45-27.379C33.45 9.033 18.772-4.563-.042-1.716-.028-1.144 0-.572 0 0Z"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(328.044 326.835)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path
                                                    d="M0 0c-13.729 17.784-27.521 24.896-34.835 27.608-1.213.451-1.039 2.213.24 2.406l10.157 1.529c.927.141 1.386 1.216.829 1.97-10.014 13.565-37.85 28.728-72.048 29.849-57.257 0-78.435-29.085-81.492-43.441-.653-3.067-3.375-5.211-6.506-5.364-12.47-.615-36.931-9.998-15.362-79.675 5.599 3.444 12.615 5.049 20.308 3.895h.001v9.132c0 3.666 2.926 6.772 6.592 6.744 7.535-.056 13.671 6 13.671 13.519 0 6.863 4.628 12.877 11.269 14.603 26.574 6.911 54.781 6.912 81.362 0 6.641-1.726 11.27-7.74 11.27-14.603 0-7.467 6.053-13.519 13.52-13.519a6.744 6.744 0 0 0 6.743-6.744v-9.152c6.594.881 13.307-.638 18.973-3.875 0 20.983 8.459 35.891 15.229 44.462C4.68-14.632 4.691-6.077 0 0Z"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(362.325 441.136)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path d="M0 0v135.339"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(380.222 9.502)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path d="M0 0v-135.339"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(131.778 144.84)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path
                                                    d="M0 0c2.347-3.476 7.181-4.168 10.408-1.49l41.041 34.033-33.877 13.12a7.173 7.173 0 0 0-2.923 2.12l-25.126-20.836a7.094 7.094 0 0 1-1.35-9.43z"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(282.954 191.132)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path
                                                    d="M0 0c3.229-2.678 8.062-1.985 10.408 1.49l11.828 17.517a7.094 7.094 0 0 1-1.351 9.43l-25.15 20.856a7.696 7.696 0 0 0-1.404-1.226l-35.552-13.884Z"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(218.637 189.642)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path
                                                    d="m0 0 .001.001L25.15-20.854a7.094 7.094 0 0 0 1.352-9.431l-1.353-2.003h32.958l-1.351 2.003a7.095 7.095 0 0 0 1.35 9.431L83.232-.019l.001-.002a7.206 7.206 0 0 0-1.69 4.595l-.02 23.726C70.34 20.981 56.992 16.709 42.659 16.709c-15.805 0-29.676 4.382-40.987 11.697V4.618C1.672 2.551.974 1.083 0 0Z"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(214.371 238.934)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path d="M242.293 7.502h27.39v199.144h-27.39z"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    fill="none" stroke="#1e2f65" stroke-width="15"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-miterlimit="10" stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path d="M0 0h47.198v82.598H-13.01V13.009C-13.01 5.824-7.185 0 0 0Z"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(84.58 7.502)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path
                                                    d="M0 0h175.687v82.598h60.208v47.082c0 27.619-17.684 51.761-39.039 60.55-4.857 1.881-96.116 37.225-100.865 39.063a7.22 7.22 0 0 0-4.612 6.713l-.017 23.904a70.674 70.674 0 0 0-10.934-5.817 69.655 69.655 0 0 0-28.37-5.941c-.257 0-.507.018-.763.02-.256-.002-.506-.02-.763-.02a69.65 69.65 0 0 0-28.369 5.941 70.693 70.693 0 0 0-10.655 5.637v-23.679c0-2.975-1.43-4.727-3.075-5.844L-93.926 190.23c-16.69-6.869-39.039-28.48-39.039-60.55V82.598h60.208V0H-35"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(204.535 7.502)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                                <path
                                                    d="M0 0v17.717h-60.208v-82.598h47.199C-5.824-64.881 0-59.057 0-51.871V-35"
                                                    style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;stroke-dasharray:none;stroke-opacity:1"
                                                    transform="translate(440.43 72.383)" fill="none"
                                                    stroke="#1e2f65" stroke-width="15" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-miterlimit="10"
                                                    stroke-dasharray="none" stroke-opacity=""
                                                    data-original="#1e2f65"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                            <a href="{{ URL::to('/assignment-details/' . $asn_id) }}" target="_blank">
                                <span class="sj_icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512"
                                        x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512"
                                        xml:space="preserve" class="">
                                        <g>
                                            <path
                                                d="M42 0H10a5.006 5.006 0 0 0-5 5v1H3a3 3 0 0 0 0 6h2v5H3a3 3 0 0 0 0 6h2v5H3a3 3 0 0 0 0 6h2v5H3a3 3 0 0 0 0 6h2v14a4.995 4.995 0 0 0 5 5h32a7.009 7.009 0 0 0 7-7V7a7.009 7.009 0 0 0-7-7ZM2 9a1 1 0 0 1 1-1h6a1 1 0 0 1 0 2H3a1 1 0 0 1-1-1Zm0 11a1 1 0 0 1 1-1h6a1 1 0 0 1 0 2H3a1 1 0 0 1-1-1Zm0 11a1 1 0 0 1 1-1h6a1 1 0 0 1 0 2H3a1 1 0 0 1-1-1Zm0 11a1 1 0 0 1 1-1h6a1 1 0 0 1 0 2H3a1 1 0 0 1-1-1Zm43.53 14.536A4.912 4.912 0 0 1 43 57.9v-2.978a7.323 7.323 0 0 0 4-2.033V53a4.935 4.935 0 0 1-1.47 3.536ZM7 58v-3h34v3Zm38.53-6.464A4.93 4.93 0 0 1 42 53H7v-2h35a6.911 6.911 0 0 0 4.9-2.012 4.915 4.915 0 0 1-1.37 2.548ZM42 62H10a3.01 3.01 0 0 1-2.118-.872A3.047 3.047 0 0 1 7.184 60H42a6.913 6.913 0 0 0 4.9-2.009A5.007 5.007 0 0 1 42 62Zm5-18a5.009 5.009 0 0 1-5 5H7v-4h2a3 3 0 0 0 0-6H7v-5h2a3 3 0 0 0 0-6H7v-5h2a3 3 0 0 0 0-6H7v-5h2a3 3 0 0 0 0-6H7V5a3 3 0 0 1 3-3h32a5.006 5.006 0 0 1 5 5ZM60 6h-3.99A4.015 4.015 0 0 0 52 10.01V46a1 1 0 0 0 .089.405v.009l5 11a1 1 0 0 0 1.82 0l5-11v-.008A.981.981 0 0 0 64 46V10a4 4 0 0 0-4-4Zm-.112 44.43h-3.776L54.553 47h6.894ZM62 15v30h-3V15Zm-5 30h-3V15h3Zm-.99-37H60a2 2 0 0 1 2 2v3h-8v-2.99A2.011 2.011 0 0 1 56.01 8ZM58 54.582l-.979-2.152h1.958Z"
                                                fill="#1e2f65" opacity="1" data-original="#1e2f65"
                                                class=""></path>
                                            <path
                                                d="M42 7H16a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 0-2H17V9h24v10h-4a1 1 0 0 0 0 2h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1ZM35 40a1 1 0 0 0 0-2H23a1 1 0 0 0 0 2ZM40 43H18a1 1 0 0 0 0 2h22a1 1 0 0 0 0-2Z"
                                                fill="#1e2f65" opacity="1" data-original="#1e2f65"
                                                class=""></path>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <?php $emailExist = 'No'; ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group cand-vetting-modal-input-field">
                            <label for="">FAO Email</label>
                            <select class="form-control vetting-field-validate" id="faoMailAjaxNew"
                                name="faoEmail_txt">
                                <option value="">Choose one</option>
                                @foreach ($contactItems as $key1 => $contact)
                                    {{-- <option value="{{ $contact->contactItem_txt }}"
                                        {{ $vettingDetail->faoEmail_txt == $contact->contactItem_txt ? 'selected' : '' }}>
                                        {{ $contact->contactItem_txt }}
                                    </option> --}}
                                    <option value="{{ $contact->contactItemSch_id }}"
                                        {{ $vettingDetail->faoEmail_id == $contact->contactItemSch_id ? 'selected' : '' }}>
                                        {{ $contact->contactItem_txt }}
                                    </option>
                                    <?php
                                    if ($emailExist == 'No' && $vettingDetail->faoEmail_id == $contact->contactItemSch_id) {
                                        $emailExist = 'Yes';
                                    }
                                    ?>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Candidate</p>
                            <span>{{ $vettingDetail->candidateName_txt }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">

                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Date of Birth</p>
                            <span>{{ $vettingDetail->dateOfBirth_dte != '' ? date('d-m-Y', strtotime($vettingDetail->dateOfBirth_dte)) : '' }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Identity</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Date Checked</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Original ID Seen</p>
                            @if ($vettingDetail->IDType_txt)
                                <span>{{ $vettingDetail->IDType_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->IDSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->IDSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Proof of Address</p>
                            @if ($vettingDetail->addressType_txt)
                                <span>{{ $vettingDetail->addressType_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->addressSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->addressSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Qualification</p>
                            @if ($vettingDetail->qualificationType_txt)
                                <span>{{ $vettingDetail->qualificationType_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if ($vettingDetail->qualificationSeen_dte)
                            <span>{{ date('d-m-Y', strtotime($vettingDetail->qualificationSeen_dte)) }}</span>
                        @else
                            <div class="cand-vetting-modal-field"></div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Reference History</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Date Checked</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>References Recieved</p>
                            @if ($vettingDetail->referencesReceived_int)
                                <span>{{ $vettingDetail->referencesReceived_int }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->referencesSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->referencesSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Employment History</p>
                            @if ($vettingDetail->employmentHistory_txt)
                                <span>{{ $vettingDetail->employmentHistory_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->employmentHistory_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->employmentHistory_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Health Declaration</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Date Checked</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Health Declaration</p>
                            @if ($vettingDetail->healthDeclaration_txt)
                                <span>{{ $vettingDetail->healthDeclaration_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->healthDeclarationSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->healthDeclarationSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Occupational Health</p>
                            @if ($vettingDetail->occupationalHealth_txt)
                                <span>{{ $vettingDetail->occupationalHealth_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            <span></span>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Health Issues</p>
                            @if ($vettingDetail->healthIssues_txt)
                                <span>{{ $vettingDetail->healthIssues_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            <span></span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6 skd_pl">

                <div class="row">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Child Protection</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Date Checked</p>
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>DBS Enhanced Disclosure Number</p>
                            @if ($vettingDetail->dbsNumber_txt)
                                <span>{{ $vettingDetail->dbsNumber_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->dbsSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->dbsSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>DBS Enhanced Disclosure Date</p>
                            @if ($vettingDetail->dbsDate_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->dbsDate_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            <!-- <span>26-07-2016</span> -->
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Candidate on Update Service</p>
                            @if ($vettingDetail->updateService_txt)
                                <span>{{ $vettingDetail->updateService_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->updateServiceSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->updateServiceSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>List 99 Check Result</p>
                            @if ($vettingDetail->list99CheckResult_txt)
                                <span>{{ $vettingDetail->list99CheckResult_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->list99Seen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->list99Seen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Disqualification by Association Act</p>
                            @if ($vettingDetail->disqualAssociation_txt)
                                <span>{{ $vettingDetail->disqualAssociation_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->disqualAssociation_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->disqualAssociation_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div> --}}

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>Mandatory Induction into Safeguarding</p>
                            @if ($vettingDetail->safeguardingInduction_txt)
                                <span>{{ $vettingDetail->safeguardingInduction_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->safeguardingInduction_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->safeguardingInduction_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>NCTL Check</p>
                            @if ($vettingDetail->NCTLCheck_txt)
                                <span>{{ $vettingDetail->NCTLCheck_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->NCTLSeen_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->NCTLSeen_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>s128 Management Check</p>
                            @if ($vettingDetail->s128MgmtCheck_txt)
                                <span>{{ $vettingDetail->s128MgmtCheck_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->s128MgmtCheck_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->s128MgmtCheck_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-input-field">
                            <p>EEA Restriction Check</p>
                            @if ($vettingDetail->EEARestrictCheck_txt)
                                <span>{{ $vettingDetail->EEARestrictCheck_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-input-field">
                            @if ($vettingDetail->EEARestrictCheck_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->EEARestrictCheck_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Other</p>
                        </div>
                        <div class="cand-vetting-modal-input-field">
                            <p>Right To Work</p>
                            @if ($vettingDetail->rightToWork_txt)
                                <span>{{ $vettingDetail->rightToWork_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                        <div class="cand-vetting-modal-input-field">
                            <p>Overseas Police</p>
                            @if ($vettingDetail->vet_overseasPolicy_txt)
                                <span>{{ $vettingDetail->vet_overseasPolicy_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                        <div class="cand-vetting-modal-input-field">
                            <p>Face to Face Interview Date</p>
                            @if ($vettingDetail->interviewDate_dte)
                                <span>{{ date('d-m-Y', strtotime($vettingDetail->interviewDate_dte)) }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                        <div class="cand-vetting-modal-input-field">
                            <p>NI Number</p>
                            @if ($vettingDetail->NINumber_txt)
                                <span>{{ $vettingDetail->NINumber_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                        <div class="cand-vetting-modal-input-field">
                            <p>Emergency Name/Number</p>
                            @if ($vettingDetail->emergencyNameNumber_txt)
                                <span>{{ $vettingDetail->emergencyNameNumber_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                        <div class="cand-vetting-modal-input-field">
                            <p>Teacher Reference Number</p>
                            @if ($vettingDetail->TRN_txt)
                                <span>{{ $vettingDetail->TRN_txt }}</span>
                            @else
                                <div class="cand-vetting-modal-field"></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cand-vetting-modal-heading-sec">
                            <p>Likeness of Candidate</p>
                        </div>

                        <div class="cand-vetting-modal-user-img">
                            @if ($vettingDetail->imageLocation_txt)
                                <img class="img-fluid" src="{{ asset($vettingDetail->imageLocation_txt) }}"
                                    alt="">
                            @else
                                <img class="img-fluid" src="{{ asset('web/images/user-img.png') }}" alt="">
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="sidebar" value="{{ $sidebar }}">

    <!-- Modal footer -->
    <div class="modal-footer calendar-modal-footer cand-vetting-modal-btn">
        @if ($sidebar)
            <button type="button" class="btn btn-secondary" id="candVettingEditBtnSidebar">Update</button>
        @else
            <button type="button" class="btn btn-secondary" id="candVettingEditBtn">Update</button>
        @endif

        <button type="button" class="btn btn-info"
            style="color: #fff !important; background-color: #17a2b8 !important; border-color: #17a2b8 !important;"
            onclick="vettingDownload('{{ $vettingDetail->vetting_id }}')">Download Vetting</button>

        {{-- @if ($emailExist == 'Yes') --}}
        <button type="button" class="btn btn-warning"
            onclick="vettingSend('{{ $vettingDetail->vetting_id }}')">Approve and Send</button>
        {{-- @else
            <button type="button" class="btn btn-warning cand-vetting-approve-disable-btn">Approve and Send</button>
        @endif --}}

        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="vettingContentModal" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered calendar-modal-section" style="max-width: 80%;">
        <div class="modal-content calendar-modal-content">

            <!-- Modal Header -->
            <div class="modal-header calendar-modal-header">
                <h4 class="modal-title">Send Vetting</h4>
                <button type="button" class="close vettingContentCloseBtn">&times;</button>
            </div>

            <form action="{{ url('/approveVettingSend') }}" method="post" class=""
                enctype="multipart/form-data" id="vettingContentFormId">
                @csrf

                <input type="hidden" name="vetting_id" id="contentVettingId" value="">
                <input type="hidden" name="faoMail" id="contentFaoMailId" value="">
                <input type="hidden" name="asn_id" value="{{ $asn_id }}">

                <div class="row mt-3">
                    <div class="modal-input-field-section col-md-6">
                        <div class="modal-input-field">
                            <label class="form-check-label">Mail Body ( For School )</label>
                            <textarea class="form-control" name="school_contnt" id="school_contnt" rows="12" cols="50">{!! $schoolContent !!}</textarea>
                        </div>
                    </div>

                    <div class="modal-input-field-section col-md-6">
                        <div class="modal-input-field">
                            <label class="form-check-label">Mail Body ( For Candidate )</label>
                            <textarea class="form-control" name="teacher_contnt" id="teacher_contnt" rows="12" cols="50">{!! $teacherContent !!}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer calendar-modal-footer">
                    <button type="button" class="btn btn-secondary" id="vettingContentSendBtn">Send</button>

                    <button type="button" class="btn btn-danger cancel-btn vettingContentCloseBtn">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Modal -->

<script>
    $(document).ready(function() {
        CKEDITOR.replace('school_contnt', {
            toolbar: [],
        });
        CKEDITOR.replace('teacher_contnt', {
            toolbar: [],
        });
    });

    function vettingSend(vetting_id) {
        // var eMailExist = "{{ $emailExist }}";
        var eMailExist = $("#faoMailAjaxNew").val();
        if (eMailExist) {
            if (vetting_id) {
                swal({
                        title: "",
                        text: "One copy will send to admin and assignment details send to candidate.",
                        buttons: {
                            cancel: "No",
                            Yes: "Yes"
                        },
                    })
                    .then((value) => {
                        switch (value) {
                            case "Yes":
                                $("#contentVettingId").val(vetting_id);
                                $("#contentFaoMailId").val(eMailExist);
                                $('#vettingContentModal').modal("show");
                                // $('#fullLoader').show();
                                // $.ajax({
                                //     type: 'POST',
                                //     url: '{{ url('approveVettingSend') }}',
                                //     data: {
                                //         "_token": "{{ csrf_token() }}",
                                //         vetting_id: vetting_id,
                                //         faoMail: eMailExist
                                //     },
                                //     dataType: "json",
                                //     success: function(data) {
                                //         // console.log(data);
                                //         // if (data.exist == 'Yes' && data.invoice_path) {
                                //         //     const link = document.createElement('a');
                                //         //     link.href = data.invoice_path;
                                //         //     link.download = data.pdfName;
                                //         //     link.target = '_blank';
                                //         //     link.click();
                                //         // }
                                //         // var subject = data.subject;
                                //         // var body = "Hello";
                                //         // window.location = 'mailto:' + data.sendMail + '?subject=' +
                                //         //     encodeURIComponent(subject) + '&body=' +
                                //         //     encodeURIComponent(body);
                                //         $('#candidateVettingModal').modal("hide");
                                //         swal("",
                                //             "Mail have been send successfully."
                                //         );
                                //         $('#fullLoader').hide();
                                //     }
                                // });
                        }
                    });
            }
        } else {
            swal("",
                "Please update 'FAO Email'."
            );
        }
    }

    $(document).on('click', '#vettingContentSendBtn', function() {
        $('#fullLoader').show();
        $('#vettingContentFormId').submit();
    });

    $(document).on('click', '.vettingContentCloseBtn', function() {
        $('#vettingContentModal').modal("hide");
    });

    function vettingDownload(vetting_id) {
        if (vetting_id) {
            $('#fullLoader').show();
            $.ajax({
                type: 'POST',
                url: '{{ url('approveVettingDownload') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    vetting_id: vetting_id
                },
                dataType: "json",
                success: function(data) {
                    // console.log(data);
                    if (data.exist == 'Yes' && data.invoice_path) {
                        const link = document.createElement('a');
                        link.href = data.invoice_path;
                        link.download = data.pdfName;
                        link.target = '_blank';
                        link.click();
                    }
                    $('#fullLoader').hide();
                }
            });
        }
    }
</script>
