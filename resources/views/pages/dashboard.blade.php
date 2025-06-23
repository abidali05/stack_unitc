@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/file_sync.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <div id="main">
        @include('pages.main', ['emails' => $emails])
        <div class="dashboard">
            <div class="container-fluid" style="background: #F2F2F2;">
                <div class="row">
                    <div id="email-table" class="col-lg-8 col-md-8" style="padding-top: 10px;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; padding-top:5px; padding-left:10px; border-bottom:none; border-radius:5px; border: 1px solid gainsboro;">
                            <div style="display: flex; gap: 540px; align-items: baseline;">
                                <div style="display: flex; gap: 10px; align-items: baseline;">
                                    <div>
                                        <p style="font-weight: 600; font-size: 18px; margin-bottom:5px">Email</p>
                                    </div>
                                    <div
                                        style="padding-right:8px; padding-left:8px; background:#0C5097;color:white;border-radius:100px;width:fit-content">
                                        {{ $emails->count() }}
                                    </div>
                                    <div class="dropdown mb-1">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="emailCategoryDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="font-size: 12px;">
                                            <i class="fas fa-inbox me-1"></i> Inbox
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="emailCategoryDropdownBtn"
                                            id="emailCategoryDropdown" style="z-index:3">
                                            <li><a class="dropdown-item" href="#" data-type="inbox"><i
                                                        class="fas fa-inbox me-1"></i>Inbox</a></li>
                                            <li><a class="dropdown-item" href="#" data-type="unread"><i
                                                        class="fas fa-envelope-open-text me-1"></i>Unread</a></li>
                                            <li><a class="dropdown-item" href="#" data-type="starred"><i
                                                        class="fas fa-star me-1"></i>Starred</a></li>
                                            <li><a class="dropdown-item" href="#" data-type="sent"><i
                                                        class="fas fa-paper-plane me-1"></i>Sent</a></li>
                                            <li><a class="dropdown-item" href="#" data-type="draft"><i
                                                        class="fas fa-file-alt me-1"></i>Draft</a></li>
                                            {{-- <li><a class="dropdown-item" href="#" data-type="junk"><i class="fas fa-archive me-1"></i>Junk</a></li>
                                            <li><a class="dropdown-item" href="#" data-type="outbox"><i class="fas fa-share-square me-1"></i>Outbox</a></li> --}}
                                            <li><a class="dropdown-item" href="#" data-type="trash"><i
                                                        class="fas fa-trash me-1"></i>Trash</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div style="display: flex; align-items: baseline; column-gap: 5px;">
                                    <div>
                                        <button type="button" class="dash-buttones"
                                            style="background: #0C5097; color:white; margin-top: 5px; margin-right: 5px;"
                                            data-bs-toggle="modal" data-bs-target="#emailModal">+</button>
                                    </div>
                                    <div id="toggle-icon" style="cursor: pointer;">
                                        <i id="maximize-icon" style="display: block;" class="fas fa-expand-alt"></i>
                                        <i id="minimize-icon" style="display: none;" class="fas fa-compress-alt"></i>
                                    </div>
                                </div>
                            </div>
                            {{-- <div style="display: flex; justify-content: space-between; gap: 10px;">
                                <div>
                                    <svg width="14" height="21" viewBox="0 0 23 21" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1 2.45786V8.45943M1 8.45943H6.72727M1 8.45943L5.42909 4.09829C6.45499 3.02272 7.72417 2.23701 9.11823 1.81446C10.5123 1.39192 11.9858 1.34632 13.4012 1.68191C14.8166 2.01751 16.1278 2.72336 17.2125 3.73361C18.2972 4.74386 19.12 6.02558 19.6041 7.45917M22 18.4621V12.4605M22 12.4605H16.2727M22 12.4605L17.5709 16.8216C16.545 17.8972 15.2758 18.6829 13.8818 19.1055C12.4877 19.528 11.0142 19.5736 9.59882 19.238C8.1834 18.9024 6.87217 18.1966 5.78749 17.1863C4.70281 16.1761 3.88002 14.8943 3.39591 13.4607"
                                            stroke="#0C5097" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div>
                                    <svg width="14" height="22" viewBox="0 0 22 22" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9.87556 1.76C5.39346 1.76 1.76 5.39346 1.76 9.87556C1.76 14.3577 5.39346 17.9911 9.87556 17.9911C12.0691 17.9911 14.0594 17.1208 15.52 15.7067C15.5459 15.6717 15.5747 15.6381 15.6064 15.6064C15.6381 15.5747 15.6717 15.5459 15.7067 15.52C17.1208 14.0594 17.9911 12.0691 17.9911 9.87556C17.9911 5.39346 14.3577 1.76 9.87556 1.76ZM17.4533 16.2088C18.8877 14.4943 19.7511 12.2858 19.7511 9.87556C19.7511 4.42144 15.3297 0 9.87556 0C4.42144 0 0 4.42144 0 9.87556C0 15.3297 4.42144 19.7511 9.87556 19.7511C12.2858 19.7511 14.4943 18.8877 16.2088 17.4533L20.4977 21.7423C20.8414 22.0859 21.3986 22.0859 21.7423 21.7423C22.0859 21.3986 22.0859 20.8414 21.7423 20.4977L17.4533 16.2088Z"
                                            fill="#0C5097" />
                                    </svg>
                                </div>
                                <div>
                                    <svg width="16" height="26" viewBox="0 0 26 26" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13 1.8803C12.6678 1.8803 12.3492 2.01226 12.1143 2.24716C11.8794 2.48206 11.7474 2.80065 11.7474 3.13285V3.32298C11.7453 3.85912 11.5864 4.38293 11.2904 4.82994C10.9944 5.27695 10.5741 5.62764 10.0813 5.83885C9.99694 5.875 9.90792 5.89854 9.81709 5.90886C9.3649 6.07028 8.87709 6.11085 8.40237 6.02477C7.86188 5.92677 7.36314 5.66911 6.97047 5.285L6.96306 5.27775L6.89732 5.21193C6.78099 5.09547 6.64248 5.00271 6.49042 4.93968C6.33836 4.87665 6.17537 4.8442 6.01077 4.8442C5.84616 4.8442 5.68317 4.87665 5.53112 4.93968C5.37906 5.00271 5.24092 5.0951 5.12459 5.21156L5.12385 5.2123C5.00739 5.32863 4.915 5.46677 4.85197 5.61882C4.78894 5.77088 4.75649 5.93387 4.75649 6.09848C4.75649 6.26308 4.78894 6.42607 4.85197 6.57813C4.915 6.73019 5.00739 6.86833 5.12385 6.98466L5.19733 7.05814C5.58144 7.45081 5.83906 7.94959 5.93706 8.49008C6.0333 9.02081 5.97124 9.56791 5.75897 10.0633C5.56665 10.5693 5.22914 11.0074 4.78852 11.3226C4.33984 11.6435 3.80499 11.822 3.25351 11.8349L3.23152 11.8352H3.13285C2.80065 11.8352 2.48206 11.9671 2.24716 12.202C2.01226 12.4369 1.8803 12.7555 1.8803 13.0877C1.8803 13.4199 2.01226 13.7385 2.24716 13.9734C2.48206 14.2083 2.80065 14.3403 3.13285 14.3403H3.32298C3.85912 14.3424 4.38293 14.5013 4.82994 14.7973C5.27554 15.0924 5.62543 15.511 5.83685 16.0018C6.05701 16.5031 6.12247 17.0588 6.02477 17.5976C5.92677 18.1381 5.66911 18.6369 5.285 19.0295L5.27775 19.0369L5.21192 19.1027C5.09547 19.219 5.00271 19.3575 4.93968 19.5096C4.87665 19.6616 4.8442 19.8246 4.8442 19.9892C4.8442 20.1538 4.87665 20.3168 4.93968 20.4689C5.00271 20.6209 5.0951 20.7591 5.21156 20.8754L5.2123 20.8762C5.32862 20.9926 5.46676 21.085 5.61882 21.148C5.77088 21.2111 5.93387 21.2435 6.09848 21.2435C6.26308 21.2435 6.42607 21.2111 6.57813 21.148C6.73019 21.085 6.86833 20.9926 6.98466 20.8762L7.05814 20.8027C7.45081 20.4186 7.94959 20.1609 8.49008 20.0629C9.02082 19.9667 9.56793 20.0288 10.0633 20.241C10.5693 20.4334 11.0074 20.7709 11.3226 21.2115C11.6435 21.6602 11.822 22.195 11.8349 22.7465L11.8352 22.7685V22.8671C11.8352 23.1993 11.9671 23.5179 12.202 23.7528C12.4369 23.9877 12.7555 24.1197 13.0877 24.1197C13.4199 24.1197 13.7385 23.9877 13.9734 23.7528C14.2083 23.5179 14.3403 23.1993 14.3403 22.8671V22.6808L14.3403 22.677C14.3424 22.1409 14.5013 21.6171 14.7973 21.1701C15.0924 20.7244 15.511 20.3745 16.0019 20.1631C16.5032 19.943 17.0588 19.8775 17.5976 19.9752C18.1381 20.0732 18.6369 20.3309 19.0295 20.715L19.0369 20.7222L19.1027 20.7881C19.219 20.9045 19.3575 20.9973 19.5096 21.0603C19.6616 21.1234 19.8246 21.1558 19.9892 21.1558C20.1538 21.1558 20.3168 21.1234 20.4689 21.0603C20.6209 20.9973 20.7591 20.9049 20.8754 20.7884L20.8762 20.7877C20.9926 20.6714 21.085 20.5332 21.148 20.3812C21.2111 20.2291 21.2435 20.0661 21.2435 19.9015C21.2435 19.7369 21.2111 19.5739 21.148 19.4219C21.085 19.2698 20.9926 19.1317 20.8762 19.0153L20.8027 18.9419C20.4186 18.5492 20.1609 18.0504 20.0629 17.5099C19.9652 16.9711 20.0307 16.4153 20.2509 15.914C20.4623 15.4232 20.8122 15.0047 21.2578 14.7096C21.7048 14.4136 22.2286 14.2547 22.7647 14.2526L22.7685 14.2525L22.8671 14.2525C23.1993 14.2525 23.5179 14.1206 23.7528 13.8857C23.9877 13.6508 24.1197 13.3322 24.1197 13C24.1197 12.6678 23.9877 12.3492 23.7528 12.1143C23.5179 11.8794 23.1993 11.7474 22.8671 11.7474H22.6808L22.677 11.7474C22.1409 11.7453 21.6171 11.5864 21.1701 11.2904C20.7231 10.9944 20.3724 10.5741 20.1612 10.0813C20.125 9.99694 20.1015 9.90792 20.0911 9.8171C19.9297 9.36491 19.8891 8.87709 19.9752 8.40237C20.0732 7.86188 20.3309 7.36315 20.715 6.97047L20.7222 6.96306L20.7881 6.89732C20.9045 6.78099 20.9973 6.64248 21.0603 6.49042C21.1234 6.33836 21.1558 6.17537 21.1558 6.01077C21.1558 5.84617 21.1234 5.68317 21.0603 5.53112C20.9973 5.37906 20.9049 5.24092 20.7884 5.12459L20.7877 5.12385C20.6714 5.00739 20.5332 4.915 20.3812 4.85197C20.2291 4.78894 20.0661 4.75649 19.9015 4.75649C19.7369 4.75649 19.5739 4.78894 19.4219 4.85197C19.2698 4.91501 19.1317 5.00739 19.0153 5.12385L18.9419 5.19733C18.5492 5.58144 18.0504 5.83906 17.5099 5.93706C16.9711 6.03476 16.4154 5.96931 15.9141 5.74916C15.4233 5.53775 15.0047 5.18785 14.7096 4.74223C14.4136 4.29523 14.2547 3.77141 14.2526 3.23527L14.2525 3.23152V3.13285C14.2525 2.80065 14.1206 2.48206 13.8857 2.24716C13.6508 2.01226 13.3322 1.8803 13 1.8803ZM10.7847 0.91759C11.3723 0.330067 12.1691 0 13 0C13.8309 0 14.6277 0.330067 15.2153 0.91759C15.8028 1.50511 16.1328 2.30197 16.1328 3.13285V3.22926C16.1338 3.39818 16.184 3.56317 16.2773 3.70403C16.3708 3.8453 16.5037 3.95613 16.6594 4.02288L16.6687 4.02685C16.8275 4.09695 17.0036 4.1179 17.1745 4.08693C17.3439 4.05621 17.5004 3.97583 17.624 3.85605L17.685 3.79502C17.976 3.50373 18.3215 3.27266 18.7018 3.115C19.0821 2.95734 19.4898 2.87619 19.9015 2.87619C20.3132 2.87619 20.7209 2.95734 21.1012 3.115C21.4815 3.27266 21.8271 3.50374 22.118 3.79502C22.4089 4.08582 22.6398 4.43107 22.7973 4.81107C22.9549 5.19139 23.0361 5.59906 23.0361 6.01077C23.0361 6.42247 22.9549 6.83014 22.7973 7.21046C22.6397 7.59062 22.4088 7.93601 22.1176 8.22689L22.0562 8.28833C21.9364 8.41196 21.8561 8.56841 21.8254 8.73783C21.7944 8.90865 21.8153 9.08482 21.8854 9.24364C21.9158 9.31247 21.9377 9.3845 21.9508 9.45817C22.0164 9.56334 22.1041 9.65371 22.2083 9.72272C22.3491 9.816 22.5141 9.86619 22.683 9.86715H22.8671C23.698 9.86715 24.4949 10.1972 25.0824 10.7847C25.6699 11.3723 26 12.1691 26 13C26 13.8309 25.6699 14.6277 25.0824 15.2153C24.4949 15.8028 23.698 16.1328 22.8671 16.1328H22.7707C22.6018 16.1338 22.4368 16.184 22.296 16.2773C22.1547 16.3708 22.0439 16.5037 21.9771 16.6594L21.9731 16.6687C21.9031 16.8275 21.8821 17.0036 21.9131 17.1745C21.9438 17.3439 22.0241 17.5003 22.1439 17.624L22.205 17.685C22.4963 17.976 22.7273 18.3215 22.885 18.7018C23.0427 19.0821 23.1238 19.4898 23.1238 19.9015C23.1238 20.3132 23.0427 20.7209 22.885 21.1012C22.7274 21.4814 22.4965 21.8268 22.2054 22.1176C21.9145 22.4088 21.5691 22.6397 21.1889 22.7973C20.8086 22.9549 20.4009 23.0361 19.9892 23.0361C19.5775 23.0361 19.1699 22.9549 18.7895 22.7973C18.4094 22.6397 18.064 22.4088 17.7731 22.1176L17.7117 22.0563C17.5881 21.9365 17.4316 21.8561 17.2622 21.8254C17.0914 21.7944 16.9152 21.8153 16.7564 21.8854L16.7471 21.8895C16.5914 21.9562 16.4585 22.067 16.365 22.2083C16.2717 22.3491 16.2215 22.5141 16.2206 22.683V22.8671C16.2206 23.698 15.8905 24.4949 15.303 25.0824C14.7154 25.6699 13.9186 26 13.0877 26C12.2568 26 11.46 25.6699 10.8724 25.0824C10.2849 24.4949 9.95486 23.698 9.95486 22.8671V22.7815C9.94908 22.6104 9.89288 22.4447 9.7932 22.3053C9.69178 22.1635 9.55005 22.0555 9.38643 21.9954C9.36784 21.9885 9.34947 21.9811 9.33135 21.9731C9.17253 21.903 8.99636 21.8821 8.82554 21.9131C8.65611 21.9438 8.49966 22.0242 8.37603 22.1439L8.31497 22.205C8.02408 22.4961 7.67833 22.7274 7.29817 22.885C6.91785 23.0427 6.51018 23.1238 6.09848 23.1238C5.68677 23.1238 5.2791 23.0427 4.89878 22.885C4.51878 22.7275 4.17353 22.4967 3.88272 22.2057C3.59144 21.9148 3.36037 21.5692 3.20271 21.1889C3.04505 20.8086 2.9639 20.4009 2.9639 19.9892C2.9639 19.5775 3.04505 19.1699 3.20271 18.7895C3.36037 18.4092 3.59144 18.0637 3.88272 17.7727L3.94381 17.7117C4.06356 17.588 4.14392 17.4316 4.17464 17.2622C4.20561 17.0914 4.1847 16.9152 4.11461 16.7564L4.11054 16.7471C4.04379 16.5914 3.93301 16.4585 3.79174 16.365C3.65088 16.2717 3.48588 16.2215 3.31696 16.2206H3.13285C2.30197 16.2206 1.50511 15.8905 0.91759 15.303C0.330067 14.7154 0 13.9186 0 13.0877C0 12.2568 0.330067 11.46 0.91759 10.8724C1.50511 10.2849 2.30197 9.95486 3.13285 9.95486H3.21854C3.38964 9.94908 3.5553 9.89288 3.69466 9.7932C3.83646 9.69178 3.94447 9.55005 4.00464 9.38643C4.01148 9.36784 4.0189 9.34947 4.0269 9.33135C4.097 9.17253 4.1179 8.99635 4.08693 8.82554C4.05621 8.65612 3.97585 8.49967 3.85609 8.37604L3.79502 8.31497C3.50374 8.02401 3.27266 7.67849 3.115 7.29817C2.95734 6.91785 2.87619 6.51018 2.87619 6.09848C2.87619 5.68677 2.95734 5.2791 3.115 4.89878C3.27259 4.51862 3.50354 4.17323 3.79465 3.88235C4.08553 3.59125 4.43091 3.3603 4.81107 3.20271C5.1914 3.04505 5.59906 2.9639 6.01077 2.9639C6.42247 2.9639 6.83014 3.04505 7.21046 3.20271C7.59078 3.36037 7.9363 3.59144 8.22726 3.88272L8.28835 3.94381C8.41197 4.06356 8.56841 4.14392 8.73783 4.17464C8.90865 4.20561 9.08482 4.1847 9.24364 4.11461C9.31247 4.08423 9.38451 4.06231 9.45819 4.04917C9.56335 3.98357 9.65372 3.89593 9.72272 3.79174C9.816 3.65088 9.86619 3.48588 9.86715 3.31696V3.13285C9.86715 2.30197 10.1972 1.50511 10.7847 0.91759ZM13 10.6511C11.7027 10.6511 10.6511 11.7027 10.6511 13C10.6511 14.2973 11.7027 15.3489 13 15.3489C14.2973 15.3489 15.3489 14.2973 15.3489 13C15.3489 11.7027 14.2973 10.6511 13 10.6511ZM8.7708 13C8.7708 10.6643 10.6643 8.7708 13 8.7708C15.3357 8.7708 17.2292 10.6643 17.2292 13C17.2292 15.3357 15.3357 17.2292 13 17.2292C10.6643 17.2292 8.7708 15.3357 8.7708 13Z"
                                            fill="#0C5097" />
                                    </svg>
                                </div>
                            </div> --}}
                        </div>
                        <div class="email-table"
                            style="overflow-x: auto;overflow-y: auto; height: 150px; background:white; border-radius:5px; border: 1px solid gainsboro;border-top: none;">
                            <table style="width: 100%;">
                                <thead style="background-color: #f9f9f9;">
                                    <tr>
                                        {{-- <th style="padding: 5px 10px 5px 16px"><input type="checkbox"></th> --}}
                                        <th style="padding: 5px 10px 5px 16px"></th>
                                        <th style="font-size: 12px;color: #0C5097; padding: 5px 10px 5px 16px">From</th>
                                        <th style="padding: 5px 10px 5px 16px"></th>
                                        <th style="font-size: 12px;color: #0C5097; padding: 5px 10px 5px 16px">Subject
                                        </th>
                                        <th style="font-size: 12px;color: #0C5097; padding: 5px 10px 5px 16px">Date</th>
                                    </tr>
                                </thead>
                                <tbody id="emailTableBody">
                                    @include('partials.email_rows', ['emails' => $emails])
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="feed" class="col-lg-4 col-md-4" style="padding-top: 10px">
                        <div
                            style="display:flex; justify-content:space-between; padding-left: 10px; border-bottom: none; border-radius: 5px; border: 1px solid gainsboro;">
                            <div style="display: flex; gap: 25px; align-items: baseline;">
                                <div>
                                    <p style="font-weight: 600; font-size: 18px;margin-bottom: 5px; margin-top: 5px;">Feed
                                    </p>
                                </div>
                            </div>
                            {{-- <div id="toggle-icon-feed" style="cursor: pointer;display: flex;align-items: center;margin-right: 10px;">
                                <i id="maximize-icon-feed" style="display: block;" class="fas fa-expand-alt"></i>
                                <i id="minimize-icon-feed" style="display: none;" class="fas fa-compress-alt"></i>
                            </div> --}}
                            <div>
                                <button type="button" class="dash-buttones"
                                    style="background: #0C5097; color:white; margin-top: 5px; margin-right: 5px;"
                                    data-bs-toggle="modal" data-bs-target="#newsModal">+</button>
                            </div>
                        </div>
                        <div class="feed"
                            style="overflow-y: auto; max-height: 150px; border-radius: 5px; background: white; padding:5px; border: 1px solid gainsboro; border-top: none;">
                            @if (isset($allArticles['error']))
                                <div
                                    style="color: red; text-align: center; font-size: 16px; font-weight: bold; padding: 10px;">
                                    {{ $allArticles['error'] }}
                                </div>
                            @else
                                @foreach ($allArticles as $article)
                                    <div class="article-container"
                                        style="display: flex; margin-bottom: 20px; cursor: pointer; position: relative;"
                                        onclick="displayNewsDetails({{ json_encode($article) }})">
                                        <div
                                            style="display: flex; align-items: center;border: 1px solid lightgray; border-radius: 5px; padding: 10px; background: lightgray;">
                                            <img src="{{ $article['urlToImage'] ?? asset('images/default-news.webp') }}"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 20px;"
                                                alt="News Image">
                                        </div>
                                        <div style="padding-left: 5px;">
                                            @if (isset($article['publishedAt']))
                                                <p style="font-size: 12px; margin-bottom: 3px; color: #A2A2A2;">
                                                    {{ \Carbon\Carbon::parse($article['publishedAt'])->format('d-M-Y h:i A') }}
                                                </p>
                                            @endif
                                            <p style="font-size: 13px; margin-bottom: 0;">
                                                {{ $article['title'] ?? 'No Title Available' }}
                                            </p>
                                            <a href="{{ $article['url'] ?? '#' }}" target="_blank"
                                                style="font-size: 12px; color: #007BFF;">Read more</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div style="display: flex; column-gap: 20px;">
                        <div id="below-divs" class="col-lg-8" style="display: flex; column-gap: 9px;">
                            <div class="col-lg-6 col-md-6 mt-3"
                                style="background: #F9F9F9;
                                border-radius: 10px;overflow-x: auto;overflow-y: auto; max-height: 170px;
                                padding: 10px 16px; border: 1px solid gainsboro;">
                                <div style="position: sticky; top: 0; background: #F9F9F9; z-index: 2;">
                                    <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                        <div style="display: flex; gap: 25px; align-items: flex-start; gap:10px">
                                            <div>
                                                <p style="font-weight: 600; font-size: 18px;">File Sync</p>
                                            </div>
                                            <div
                                                style="padding-right:8px; padding-left:8px; background:#0C5097;color:white;border-radius:100px;width:fit-content">
                                                {{ $files->count() }}
                                            </div>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; gap: 15px;">
                                            <form id="upload-form" enctype="multipart/form-data">
                                                @csrf
                                                <div class="dropdown">
                                                    <button class="dash-buttones" type="button" id="uploadDropdown"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        +
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="uploadDropdown">
                                                        <li><a class="dropdown-item" href="#"
                                                                data-upload-type="file" style="font-size:12px">Upload
                                                                File</a></li>
                                                        <li><a class="dropdown-item" href="#"
                                                                data-upload-type="folder" style="font-size:12px">Upload
                                                                Folder</a></li>
                                                    </ul>
                                                </div>

                                                <!-- File Upload Section -->
                                                <div id="file-upload" style="display: none;">
                                                    <input type="file" name="file" id="file"
                                                        style="display: none;">
                                                </div>

                                                <!-- Folder Upload Section -->
                                                <div id="folder-upload" style="display: none;">
                                                    <input type="file" id="files" name="files[]" webkitdirectory
                                                        directory multiple style="display: none;">
                                                </div>
                                            </form>
                                            <div id="upload-status" class="d-none"></div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    use Illuminate\Support\Str;
                                @endphp
                                <div class="file-sync"
                                    style="width: 30%; position: absolute; overflow-y: auto; max-height: 100px">
                                    <div style="display: flex; flex-direction: column; gap: 10px;">
                                        @forelse ($files as $file)
                                            <div id="file-{{ $file->id }}"
                                                style="display: flex; justify-content: space-between;">
                                                <div style="display: flex;">
                                                    <div
                                                        style="background-color: white; border-radius: 10px; border: 1px solid lightgray;">

                                                        @php
                                                            $fileExtension = pathinfo($file->path, PATHINFO_EXTENSION);
                                                            if (in_array($fileExtension, ['png', 'jpg', 'jpeg'])) {
                                                                $imgSrc = asset($file->path);
                                                            } elseif ($fileExtension === 'pdf') {
                                                                $imgSrc = asset('files/pdf.jpg');
                                                            } elseif ($fileExtension === 'zip') {
                                                                $imgSrc = asset('files/exe.jpg');
                                                            } elseif ($file->type === 'folder') {
                                                                $imgSrc = asset('files/folder.png');
                                                            } elseif ($fileExtension === 'xlsx') {
                                                                $imgSrc = asset('files/xlsx.jpg');
                                                            } elseif ($fileExtension === 'txt') {
                                                                $imgSrc = asset('files/txt.jpg');
                                                            } elseif (in_array($fileExtension, ['doc', 'docx'])) {
                                                                $imgSrc = asset('files/word.jpg');
                                                            } elseif (in_array($fileExtension, ['ppt', 'pptx'])) {
                                                                $imgSrc = asset('files/ppt.jpg');
                                                            } else {
                                                                $imgSrc = asset('files/file.png');
                                                            }
                                                        @endphp

                                                        <img src="{{ $imgSrc }}"
                                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 10px;"
                                                            alt="">
                                                    </div>
                                                    <div style="padding-left: 5px;">
                                                        <p style="font-size: 11px; margin-bottom: 3px; color: #A2A2A2;">
                                                            {{ \Carbon\Carbon::parse($file->created_at)->format('d-m-Y h:i A') }}
                                                        </p>
                                                        <p id="file-name-{{ $file->id }}"
                                                            style="font-size: 12px; font-weight: 600; margin-bottom: 0px;">
                                                            {{ Str::limit($file->name, 20) }}</p>
                                                    </div>
                                                </div>
                                                <div class="dropdown"
                                                    style="display: flex; align-items: center; margin-right: 10px;">
                                                    <div class="dropdown-toggle" style="cursor: pointer;">
                                                        <svg width="14" height="4" viewBox="0 0 20 4"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="2" cy="2" r="2" fill="black" />
                                                            <circle cx="10" cy="2" r="2" fill="black" />
                                                            <circle cx="18" cy="2" r="2" fill="black" />
                                                        </svg>
                                                    </div>
                                                    <div class="dropdown-menu">
                                                        <button class="dropdown-item"
                                                            onclick="openFile('{{ asset($file->path) }}')"
                                                            style="cursor: pointer; padding: 5px; display: flex; align-items: center;">
                                                            <i class="fas fa-folder-open"
                                                                style="font-size: 10px; margin-right: 5px;"></i>
                                                            <span style="font-size: 12px">Open</span>
                                                        </button>
                                                        <button class="dropdown-item"
                                                            onclick="renameFile('{{ $file->id }}')"
                                                            style="cursor: pointer; padding: 5px; display: flex; align-items: center;">
                                                            <i class="fas fa-edit"
                                                                style="font-size: 10px; margin-right: 5px;"></i>
                                                            <span style="font-size: 12px">Rename</span>
                                                        </button>
                                                        <button class="dropdown-item"
                                                            onclick="downloadFile('{{ $file->path }}')"
                                                            style="cursor: pointer; padding: 5px; display: flex; align-items: center;">
                                                            <i class="fas fa-download"
                                                                style="font-size: 10px; margin-right: 5px;"></i>
                                                            <span style="font-size: 12px">Download</span>
                                                        </button>
                                                        <button class="dropdown-item"
                                                            onclick="openShareModal('{{ $file->id }}','{{ $file->path }}')"
                                                            style="cursor: pointer; padding: 5px; display: flex; align-items: center;">
                                                            <i class="fas fa-share"
                                                                style="font-size: 10px; margin-right: 5px;"></i>
                                                            <span style="font-size: 12px">Share</span>
                                                        </button>
                                                        <button class="dropdown-item delete-file"
                                                            data-id="{{ $file->id }}"
                                                            style="cursor: pointer; padding: 5px; display: flex; align-items: center;">
                                                            <i class="fas fa-trash-alt"
                                                                style="font-size: 10px; margin-right: 5px;"></i>
                                                            <span style="font-size: 12px">Delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div>
                                                <p>No files.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-5 mt-3 calendar"
                                style="background: #F9F9F9;
                                border-radius: 10px; overflow-x: auto;overflow-y: auto; max-height: 170px;
                                padding: 10px 16px; border: 1px solid gainsboro;">
                                <div
                                    style="position: sticky; top: -10px; background: #F9F9F9; z-index: 2; height:40px; padding-top:5px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="display: flex; gap: 25px; align-items: center;">
                                            <div>
                                                <p style="font-weight: 600; font-size: 18px; margin: 0px;">Calendar</p>
                                            </div>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; gap: 15px;">
                                            <div>
                                                <a href="{{ route('full-calendar') }}" tabindex="0">
                                                    <i class="fas fa-external-link-alt"
                                                        style="color: black; font-size: medium;"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <button class="dash-buttones" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#calendar-modal" aria-expanded="false">
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="feed" style="display:flex; flex-direction: column;">
                                    @foreach ($events as $event)
                                        <div style="display: flex; justify-content: flex-start; gap: 30px;">
                                            <div style="display: flex;">
                                                <div>
                                                    <h1 style="font-weight: bold; font-size: 45px;">
                                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</h1>
                                                </div>
                                                <div style="padding-top: 8px;">
                                                    <p
                                                        style="font-size: 10px;font-weight: 600;margin-bottom: 0px;color: #DE1414;">
                                                        {{ \Carbon\Carbon::parse($event->event_date)->format('l') }}
                                                    </p>
                                                    <p style="font-size: 17px; font-weight: 700; margin-bottom: 0px;">
                                                        {{ \Carbon\Carbon::parse($event->event_date)->format('F') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="display: flex; justify-content: space-between; padding-bottom:5px">
                                            <div style="display: flex;">
                                                <div>
                                                    <p style="font-size: 13px; font-weight: 600; margin-bottom: 0px;">
                                                        {{ $event->event_title }}</p>
                                                    @if ($event->event_start_time && $event->event_end_time)
                                                        <p style="font-size: 11px;margin-bottom: 3px;color: #A2A2A2;">
                                                            @if ($event->event_start_time)
                                                                {{ \Carbon\Carbon::parse($event->event_start_time)->format('h:i A') }}
                                                            @endif
                                                            -
                                                            @if ($event->event_end_time)
                                                                {{ \Carbon\Carbon::parse($event->event_end_time)->format('h:i A') }}
                                                            @endif
                                                        </p>
                                                    @else
                                                        <p style="font-size:11px;margin-bottom: 3px;color: #A2A2A2;">
                                                            All Day
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="dropdown"
                                                style="display: flex; align-items: center; margin-right: 10px;">
                                                <svg width="14" height="4" viewBox="0 0 20 4" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" id="dropdownMenuButton"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    style="cursor: pointer;">
                                                    <circle cx="2" cy="2" r="2" fill="black" />
                                                    <circle cx="10" cy="2" r="2" fill="black" />
                                                    <circle cx="18" cy="2" r="2" fill="black" />
                                                </svg>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item text-danger" href="#"
                                                            id="deleteItem">Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <form id="deleteForm" action="{{ route('event.delete', $event->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-3 dash-table" style="overflow-x: auto;overflow-y: auto;">
                            <table border="1" cellpadding="10" cellspacing="0"
                                style="width: 95%; border-collapse: collapse;border: 1px solid gainsboro; border-radius:5px;; background: #F6F6F6;">
                                <thead style="border-bottom: 1px solid;">
                                    <tr>
                                        <th style="color: #0C5097;padding: 5px 10px 5px 16px; font-size: 12px;">Sr#</th>
                                        <th style="color: #0C5097;padding: 5px 10px 5px 16px; font-size: 12px;">Name
                                        </th>
                                        <th style="color: #0C5097;padding: 5px 10px 5px 16px; font-size: 12px;">Plan
                                        </th>
                                        <th style="color: #0C5097;padding: 5px 10px 5px 16px; font-size: 12px;">Change
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">01</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">Robinson</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">Premium</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">$300</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">02</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">Robinson</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">Basic</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">$100</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">03</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">Robinson</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">Basic</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">$100</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">01</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">Robinson</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">Premium</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">$300</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">01</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">Robinson</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">Premium</td>
                                        <td style="padding: 5px 10px 5px 16px; font-size: 11px;">$300</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4" style="margin-top: 15px;">
                        <div class="col-lg-12"
                            style="background:#F9F9F9;border-radius: 10px;border: 1px solid gainsboro;">
                            <canvas id="myChartLine"
                                style="display: block; box-sizing: border-box; width: 100%;"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4" style="margin-top: 15px;">
                        <div class="col-lg-12"
                            style="background:#F9F9F9;border-radius: 10px;border: 1px solid gainsboro;">
                            <canvas id="myChart" style="display: block; box-sizing: border-box; width: 100%;"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4"
                        style="margin-top: 15px; background:#F9F9F9;border-radius: 10px;border: 1px solid gainsboro;">
                        <div class="row mt-3">
                            <div class="col-6 col-lg-6">
                                <div style="background: #F6F6F6; width: 100%; height: 50px;border: 1px solid gainsboro;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div>
                                            <p style="color: #0C5097; margin-bottom: 0; font-weight: bold;">$903</p>
                                        </div>
                                        <div>
                                            <p style="margin-bottom: 0;font-size: 12px;">MRR Today</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-6">
                                <div style="background: #F6F6F6; width: 100%; height: 50px;border: 1px solid gainsboro;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div>
                                            <p style="color: #0C5097; margin-bottom: 0; font-weight: bold;">$1103</p>
                                        </div>
                                        <div>
                                            <p style="margin-bottom: 0;font-size: 12px;">MRR Yesterday</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6 col-lg-6">
                                <div style="background: #F6F6F6; width: 100%; height: 50px;border: 1px solid gainsboro;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div>
                                            <p style="color: #0C5097; margin-bottom: 0; font-weight: bold;">$903</p>
                                        </div>
                                        <div>
                                            <p style="margin-bottom:0; font-size:12px">MRR Today</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-6">
                                <div style="background: #F6F6F6; width: 100%; height: 50px;border: 1px solid gainsboro;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div>
                                            <p style="color: #0C5097; margin-bottom: 0; font-weight: bold;">$1103</p>
                                        </div>
                                        <div>
                                            <p style="margin-bottom: 0; font-size:12px">MRR Yesterday</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6 col-lg-6">
                                <div style="background: #F6F6F6; width: 100%; height: 50px;border: 1px solid gainsboro;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div>
                                            <p style="color: #0C5097; margin-bottom: 0; font-weight: bold;">$903</p>
                                        </div>
                                        <div>
                                            <p style="margin-bottom:0; font-size:12px">MRR Today</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-6">
                                <div style="background: #F6F6F6; width: 100%; height: 50px;border: 1px solid gainsboro;">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div>
                                            <p style="color: #0C5097; margin-bottom: 0; font-weight: bold;">$1103</p>
                                        </div>
                                        <div>
                                            <p style="margin-bottom: 0; font-size:12px">MRR Yesterday</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal for sharing file -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">Share File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="shareFileForm">
                        <input type="hidden" id="fileId" name="file_id">
                        <label for="users">Select Users:</label>
                        <select id="users" name="user_ids[]" class="form-control" multiple>
                        </select>
                        <label for="teams">Select Teams:</label>
                        <select id="teams" name="team_ids[]" class="form-control" multiple>
                        </select>
                        <button type="submit" class="btn btn-primary" style="margin-top:5px">Share</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal for calendar -->
    <div class="modal fade" id="calendar-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border: none;">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12 ">
                                <form id="event-form" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="text" name="event_title" class="form-control"
                                                id="exampleFormControlInput1" placeholder="Event Title">
                                        </div>
                                        <div class="col-12">
                                            <div class="input-group my-2">
                                                <span class="input-group-text">Event Date:</span>
                                                <input type="date" name="event_date" class="form-control datepicker">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div
                                                class="d-flex align-items-center justify-content-between border rounded p-2">
                                                <label class="fw-bold me-1">From:</label>
                                                <input type="time" name="event_start_time" id="event_start_time"
                                                    class="form-control border-0 w-40 time-picker" value="00:00">
                                                <div class="clock-container" id="start-clock"></div>

                                                <label class="fw-bold mx-2">To:</label>
                                                <input type="time" name="event_end_time" id="event_end_time"
                                                    class="form-control border-0 w-40 time-picker" value="00:00">
                                                <div class="clock-container" id="end-clock"></div>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-check">
                                                <input name="all_day" class="form-check-input" type="checkbox"
                                                    id="allDayCheckbox">
                                                <label class="form-check-label" for="allDayCheckbox">
                                                    <strong> All Day</strong>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <ul class="nav-tabs">
                                                <li><a href="#" id="details-tab" class="tab-link">Details</a>
                                                </li>
                                                <li><a href="#" id="attendees-tab" class="tab-link">Attendees</a>
                                                </li>
                                                <li><a href="#" id="reminders-tab" class="tab-link">Reminders</a>
                                                </li>
                                                <li><a href="#" id="repeat-tab" class="tab-link">Repeat</a></li>
                                            </ul>
                                        </div>

                                    </div>
                                    <div class="row mt-2 tab-content divheeight" id="details-content">
                                        <div class="col-12">
                                            <div class="location-input">
                                                <i class="fa fa-map-marker-alt"></i>
                                                <input type="text" name="event_location" placeholder="Add Location">
                                            </div>
                                            <div class="location-input mt-3">
                                                <i class="fa fa-pencil-alt"></i>
                                                <input type="text" name="event_description"
                                                    placeholder="Add description">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="custom-select-container">
                                                <i class="fa fa-eye"></i>
                                                <select class="ms-3 px-2" name="event_shared">
                                                    <option value="When Shared" selected>When Shared</option>
                                                    <option value="Public">Public</option>
                                                    {{-- <option value="Busy">Busy</option> --}}
                                                    <option value="Private">Private</option>
                                                </select>
                                                <i class="fa fa-chevron-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 tab-content divheeight" id="attendees-content">
                                        <div class="col-12">
                                            <div class="">
                                                <select id="attendees" name="users[]" class="form-control select2"
                                                    multiple>
                                                    <!-- Users will be loaded here via AJAX -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center pt-5">
                                            <img src="{{ asset('svg/invite-user.svg') }}" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="row mt-2 tab-content divheeight" id="reminders-content">
                                        <div class="col-12">
                                            <div class="custom-select-container">
                                                <label for="eventSelect"><strong>Reminder</strong></label>
                                                <select class="ps-2 form-control" id="eventSelect"
                                                    style="margin-left:10px" name="reminder_value">
                                                    <option value="0">At the event's start</option>
                                                    <option value="5">5 minutes before the event</option>
                                                    <option value="10">10 minutes before the event</option>
                                                    <option value="30">30 minutes before the event</option>
                                                    <option value="60">1 hour before the event</option>
                                                    <option value="120">2 hours before the event</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Notification Type Selection -->
                                        <div class="col-12 mt-2">
                                            <strong>How should we notify you?</strong>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="systemNotification"
                                                    name="notification_type[]" value="system" checked>
                                                <label class="form-check-label" for="systemNotification">System
                                                    Notification</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="emailNotification"
                                                    name="notification_type[]" value="email">
                                                <label class="form-check-label" for="emailNotification">Email
                                                    Notification</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2 tab-content divheeight" id="repeat-content">
                                        <div class="col-12">
                                            <div class="row d-flex align-items-center">
                                                <div class="col-3">
                                                    <p class="m-0" style="font-size: 12px; font-weight: 600;">Repeat
                                                        Every</p>
                                                </div>
                                                <div class="col-2 p-0">
                                                    <input type="number" name="recurrence_count"
                                                        class="form-control w-100" min="1" value="1">
                                                </div>
                                                <div class="col-3">
                                                    <select name="recurrence_type" class="form-control ms-2">
                                                        <option value="daily">Days</option>
                                                        <option value="weekly">Weeks</option>
                                                        <option value="monthly">Months</option>
                                                        <option value="yearly">Years</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Recurrence Mode Selection -->
                                            <div class="col-12">
                                                <p>Ends</p>

                                                <!-- Never Option -->
                                                <div class="form-check">
                                                    <input type="radio" name="recurrence_mode" id="recurrenceNever"
                                                        value="never" checked style="margin-right: 12px;">
                                                    <label for="recurrenceNever">Never</label>
                                                </div>

                                                <!-- On a Specific Date Option -->
                                                <div class="form-check d-flex align-items-center">
                                                    <input type="radio" name="recurrence_mode" id="recurrenceOn"
                                                        value="on" style="margin-right: 16px;">
                                                    <label for="recurrenceOn" class="me-2"
                                                        style="margin-right: 22px !important;">On</label>
                                                    <input type="date" name="recurrence_end_date" id="datepicker"
                                                        class="form-control ms-2 w-50" placeholder="MM/DD/YYYY" disabled>
                                                </div>

                                                <!-- After X Occurrences Option -->
                                                <div class="form-check d-flex align-items-center mt-2">
                                                    <input type="radio" name="recurrence_mode" id="recurrenceAfter"
                                                        value="after" style="margin-right: 18px;">
                                                    <label for="recurrenceAfter" class="me-2">After</label>
                                                    <input type="number" name="recurrence_count" id="occurrencesInput"
                                                        class="form-control ms-2 w-25" value="6" min="1"
                                                        disabled>
                                                    <span class="ms-2 text-muted">Occurrences</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row pt-3  px-5">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary"
                                                style="width: 100%;background:#0C5097">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- News Feed Add Modal -->
    <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add News</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('news-feed.store') }}" method="POST" id="news-form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="col-md-6">
                                <label for="source" class="col-form-label">Source:</label>
                                <input type="text" class="form-control" id="source" name="source" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="" class="col-form-label">Content:</label>
                            <textarea class="form-control" name="content" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="" class="col-form-label">Description:</label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="" class="col-form-label">Image:</label>
                                <input class="form-control" type="file" name="urlToImage" id="urlToImage">
                            </div>

                            <div class="col-md-6">
                                <label for="url" class="col-form-label">URL (optional):</label>
                                <input class="form-control" type="url" name="url" id="url">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Send Email</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('email.store') }}" method="POST" id="emailForm"
                        class="p-4 border rounded shadow-sm bg-light">
                        @csrf
                        <input type="hidden" name="draft_id" id="draft_id" value="">
                        <div class="mb-2">
                            <label for="email" class="form-label">To</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Enter Email" required>
                        </div>
                        <div class="mb-2">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control"
                                placeholder="Enter Subject">
                        </div>
                        <div class="mb-2">
                            <label for="body" class="form-label">Body</label>
                            <textarea name="body" id="editor" class="form-control" rows="5"></textarea>
                        </div>
                        <button id="sendBtn" type="submit" class="btn btn-primary w-100"
                            style="background: #0c5097">Send
                            Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <span id="closeModal"
        style="
                            position: absolute;
                            top: 1.5rem;
                            right: 1.5rem;
                            font-size: 1.5rem;
                            color: #666;
                            cursor: pointer;
                            width: 32px;
                            height: 32px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border-radius: 50%;
                            transition: background-color 0.2s;
                            &:hover {
                                background-color: #f5f5f5;
                            }
                        ">&times;</span>

    <div id="successMessage" class="alert alert-success d-none">Event created successfully!</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        const storeEventRoute = "{{ route('dashboard.events.store') }}";
    </script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/calendar.js') }}"></script>
    <script>
        const uploadUrl = "{{ route('file-sync.store') }}";
    </script>
    <script src="{{ asset('js/file_sync.js') }}"></script>
    <script src="{{ asset('js/email.js') }}"></script>
@endpush
