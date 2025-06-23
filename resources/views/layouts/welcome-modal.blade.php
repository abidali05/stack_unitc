<link rel="stylesheet" href="{{ asset('css/welcome_modal.css') }}">
<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
<div class="container-fluid d-flex align-items-center justify-content-center vh-100" id="welcomeModal">
    <div class="row">
        <div class="col-8 col-md-12 rounded-3 mx-auto">
            <div class="row p-3" style="position: relative;background: lightgray;border-radius: 12px;z-index: 9999;">
                <div class="col-12 d-flex justify-content-end">
                    <button id="close" class="close"><img src="{{ asset('svg/union.svg') }}" class="img-fluid"
                            alt="..."></button>
                </div>
                <div class="col-12 col-md-6 p-4 text-center">
                    <div class="row">
                        <div class="col-12 p-3 backcolor rounded-4 animate-bg">
                            <p class="good p-2">Hi, </p>
                            <p class="good1 p-2">{{ auth()->user()->name }}</p>
                            <P class="good11 p-2">Here are some updates and
                                notification waiting for you.</P>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 rounded-3 ">
                    <div class="row ">
                        <div class="position-relative notification-container parent-div">
                            <div class="green-circle"></div>
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <div class="red-dot"></div>
                                                   <img src="{{ asset('svg/common.svg') }}" class="img-fluid" alt="...">
                          
                                </div>
                                <div class="notification-title">
                                    <p class="emailcolor mt-3"> Talk Messages<span class="black5 ms-2">- 5</span>
                                    </p>
                                </div>
                                <div class="notification-arrow"><a href=""><img
                                            src="./images/arrowc.svg" class="w-50 me-3"
                                            alt="..."></a></div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon d-flex align-items-center">
                                    <div class="red-dot"></div>
                                                   <img src="{{ asset('./images/email.svg') }}" class="img-fluid" alt="...">
                          
                                </div>
                                <div class="notification-title">
                                    <p class="emailcolor mt-3"> Email<span class="black5 ms-2">- 5</span>
                                    </p>
                                </div>
                                <div class="notification-arrow"><a href=""><img
                                            src="./images/arrowc.svg" class="w-50 me-3"
                                            alt="..."></a></div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <div class="red-dot"></div>
                                         <img src="{{ asset('./images/filesy.svg') }}" class="img-fluid" alt="...">
                                </div>
                                <div class="notification-title">
                                    <p class="emailcolor mt-3"> File Sync<span class="black5 ms-2">- 5</span>
                                    </p>
                                </div>
                                <div class="notification-arrow"><a href=""><img
                                            src="./images/arrowc.svg" class="w-50 me-3"
                                            alt="..."></a></div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <div class="red-dot"></div>
                                      <img src="{{ asset('./images/videocl.svg') }}" class="img-fluid" alt="...">
                                </div>
                                <div class="notification-title">
                                    <p class="emailcolor mt-3"> Video Missed Calls<span class="black5 ms-2">- 5</span>
                                    </p>
                                </div>
                                <div class="notification-arrow"><a href=""><img
                                            src="./images/arrowc.svg" class="w-50 me-3"
                                            alt="..."></a></div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <div class="red-dot"></div>
                            <img src="{{ asset('./images/claender.svg') }}" class="img-fluid" alt="...">
                                </div>
                                <div class="notification-title">
                                    <p class="emailcolor mt-3"> Calendar Events<span class="black5 ms-2">- 5</span>
                                    </p>
                                </div>
                                <div class="notification-arrow"><a href=""><img
                                            src="./images/arrowc.svg" class="w-50 me-3"
                                            alt="..."></a></div>
                            </div>
                            <div class="large-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const closeButton = document.getElementById('close');
        closeButton.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('welcomeModal').setAttribute('style', 'display: none !important;');
        });
    });
</script>
