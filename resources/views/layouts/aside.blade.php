<div class="side-bar">
    <a href="{{ route('dashboard') }}">
        <div class="logo"><img src="{{ asset('svg/logo.svg') }}" alt=""></div>
    </a>
    <ul class="inside-bar">
        <li class="inside-bar-item" id="talk-btn">
            <img src="{{ asset('svg/talk.svg') }}" alt="">
            <p class="inside-bar-text">Talk</p>
            <div class="talk-submenu" id="talk-submenu">
                <div>
                    <div
                        style="display: flex;
                                width: 100%;
                                height: fit-content;
                                margin-top: 10px;
                                justify-content: space-between;
                                margin-bottom: 10px;
                                ">
                        <div class="dropdown" style="display: flex;gap: 8px;">
                            <span
                                style="margin-left: 5px;
                                        color: #036AB2;
                                        font-size: 20px;
                                        font-weight: bold;">FMA</span>
                            <button class="btn dropdown-toggle" id="chat-detail" data-bs-toggle="dropdown"
                                type="button"
                                style="
                                    padding: 0px;
                                    ">
                                <span style="font-size: 10px;">Recent Chat</span>
                            </button>
                        </div>
                        <div class="container" id="chat-container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="chat-detail-record" id="chat-detail-record">
                                        <div style="display: flex; column-gap: 68px; margin-bottom: 10px;">
                                            <div style="gap: 5px;display: flex; align-items: flex-end;">
                                                <div>
                                                    <img src="{{ asset('svg/channel.svg') }}" alt="">
                                                </div>
                                                <div>
                                                    <p style="margin-bottom: 0px;font-size: 14px;font-weight: bold;">
                                                        Channels</p>
                                                </div>
                                            </div>
                                            <div style="gap: 5px;display: flex; align-items: flex-end;">
                                                <div>
                                                    <img src="{{ asset('svg/recent-chat.svg') }}" alt="">
                                                </div>
                                                <div>
                                                    <p
                                                        style="margin-bottom: 0px;font-size: 14px;font-weight: bold;font-weight: bold;">
                                                        Recent Chat</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: flex; column-gap: 19px; margin-bottom: 10px;">
                                            <div style="gap: 5px;display: flex; align-items: flex-end;">
                                                <div>
                                                    <img src="{{ asset('svg/private-message.svg') }}" alt="">
                                                </div>
                                                <div>
                                                    <p style="margin-bottom: 0px;font-size: 14px;font-weight: bold;">
                                                        Private Message</p>
                                                </div>
                                            </div>
                                            <div style="gap: 5px;display: flex; align-items: flex-end;">
                                                <div>
                                                    <img src="{{ asset('svg/private-group.svg') }}" alt="">
                                                </div>
                                                <div>
                                                    <p style="margin-bottom: 0px;font-size: 14px;font-weight: bold;">
                                                        Private Group</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: flex; column-gap: 42px; margin-bottom: 10px;">
                                            <div style="gap: 5px;display: flex; align-items: flex-end;">
                                                <div>
                                                    <img src="{{ asset('svg/room.svg') }}" alt="">
                                                </div>
                                                <div>
                                                    <p style="margin-bottom: 0px;font-size: 14px;font-weight: bold;">
                                                        Public Room</p>
                                                </div>
                                            </div>
                                            <div style="gap: 5px;display: flex; align-items: flex-end;">
                                                <div>
                                                    <img src="{{ asset('svg/shout.svg') }}" alt="">
                                                </div>
                                                <div>
                                                    <p style="margin-bottom: 0px;font-size: 14px;font-weight: bold;">
                                                        Shout All</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: flex; column-gap: 15px; margin-bottom: 10px;">
                                            <div style="gap: 5px;display: flex; align-items: flex-end;">
                                                <div>
                                                    <img src="{{ asset('svg/starred.svg') }}" alt="">
                                                </div>
                                                <div>
                                                    <p style="margin-bottom: 0px;font-size: 14px;font-weight: bold;">
                                                        Starred Message</p>
                                                </div>
                                            </div>
                                            <div style="gap: 5px;display: flex; align-items: flex-end;">
                                                <div>
                                                    <img src="{{ asset('svg/history.svg') }}" alt="">
                                                </div>
                                                <div>
                                                    <p style="margin-bottom: 0px;font-size: 14px;font-weight: bold;">
                                                        History</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: flex; column-gap: 70px; margin-bottom: 10px;">
                                            <div style="gap: 5px;display: flex; align-items: flex-end;">
                                                <div>
                                                    <img src="{{ asset('svg/history.svg') }}" alt="">
                                                </div>
                                                <div>
                                                    <p style="margin-bottom: 0px;font-size: 14px;font-weight: bold;">
                                                        Hashtag</p>
                                                </div>
                                            </div>
                                            <div style="gap: 5px;display: flex; align-items: flex-end;">
                                                <div>
                                                    <img src="{{ asset('svg/block-user.svg') }}" alt="">
                                                </div>
                                                <div>
                                                    <p style="margin-bottom: 0px;font-size: 14px;font-weight: bold;">
                                                        Block User</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            style="
                                    gap: 10px;
                                    display: flex;
                                    align-items: center;
                                ">
                            <svg width="18" height="27" viewBox="0 0 26 27" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.38397 22.4156C4.6306 21.9313 4.58238 21.3493 4.25942 20.9122C3.14504 19.404 2.48671 17.5407 2.48671 15.5195C2.48671 10.502 6.5542 6.43448 11.5717 6.43448C16.5892 6.43448 20.6567 10.502 20.6567 15.5195C20.6567 20.5371 16.5892 24.6046 11.5717 24.6046C10.3994 24.6046 9.28229 24.3833 8.25735 23.9815C7.99362 23.8781 7.70518 23.8551 7.4284 23.9154L3.14486 24.8487L4.38397 22.4156ZM3.10571 21.7646L0.493164 26.8946L7.73379 25.317C8.92283 25.7832 10.2174 26.0391 11.5717 26.0391C17.3815 26.0391 22.0912 21.3293 22.0912 15.5195C22.0912 9.70976 17.3815 5 11.5717 5C5.76196 5 1.05224 9.70976 1.05224 15.5195C1.05224 17.8579 1.81518 20.018 3.10571 21.7646ZM12.4726 18.0633L12.1977 20.3011H13.0803L13.3553 18.0633H15.1938V17.1558H13.4668L13.7631 14.744H15.5916V13.8364H13.8746L14.1495 11.5986H13.2668L12.9919 13.8364H10.6514L10.9296 11.5986H10.0469L9.76876 13.8364H7.92099V14.744H9.65597L9.35621 17.1558H7.52316V18.0633H9.24341L8.96529 20.3011H9.84797L10.1261 18.0633H12.4726ZM12.5841 17.1558L12.8804 14.744H10.5387L10.2389 17.1558H12.5841Z"
                                    fill="black" />
                                <circle cx="19" cy="7" r="7" fill="#DE1414" />
                                <path
                                    d="M18.62 10.58C18.1267 10.58 17.6467 10.5033 17.18 10.35C16.72 10.1967 16.3433 9.99 16.05 9.73L16.51 8.94C16.7433 9.16 17.0467 9.34 17.42 9.48C17.7933 9.62 18.1933 9.69 18.62 9.69C19.14 9.69 19.5433 9.58 19.83 9.36C20.1233 9.13333 20.27 8.83 20.27 8.45C20.27 8.08333 20.13 7.79 19.85 7.57C19.5767 7.34333 19.14 7.23 18.54 7.23H17.98V6.53L20.06 3.97L20.2 4.37H16.37V3.5H20.99V4.18L18.92 6.73L18.4 6.42H18.73C19.5767 6.42 20.21 6.61 20.63 6.99C21.0567 7.37 21.27 7.85333 21.27 8.44C21.27 8.83333 21.1733 9.19333 20.98 9.52C20.7867 9.84667 20.4933 10.1067 20.1 10.3C19.7133 10.4867 19.22 10.58 18.62 10.58Z"
                                    fill="white" />
                            </svg>
                            <svg style="margin-right: 10px;" width="17" height="27" viewBox="0 0 19 18"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.52889 1.44C4.65799 1.44 1.52 4.41283 1.52 8.08C1.52 11.7472 4.65799 14.72 8.52889 14.72C10.4233 14.72 12.1422 14.008 13.4037 12.8509C13.426 12.8223 13.4509 12.7948 13.4783 12.7689C13.5057 12.7429 13.5346 12.7194 13.5649 12.6982C14.7862 11.5032 15.5378 9.87474 15.5378 8.08C15.5378 4.41283 12.3998 1.44 8.52889 1.44ZM15.0733 13.2617C16.3121 11.859 17.0578 10.052 17.0578 8.08C17.0578 3.61754 13.2393 0 8.52889 0C3.81851 0 0 3.61754 0 8.08C0 12.5425 3.81851 16.16 8.52889 16.16C10.6104 16.16 12.5178 15.4536 13.9985 14.28L17.7026 17.7891C17.9994 18.0703 18.4806 18.0703 18.7774 17.7891C19.0742 17.5079 19.0742 17.0521 18.7774 16.7709L15.0733 13.2617Z"
                                    fill="black" />
                            </svg>
                        </div>
                    </div>
                    <div class="container" style="margin-left: -15px; width: 285px;">
                        <div class="row" style="align-items: baseline; margin-bottom: 12px;">
                            <div class="col-lg-12">
                                <div style="display: flex; align-items: flex-start; justify-content: space-between;"
                                    class="relevant-chat">
                                    <div style="display: flex;">
                                        <div
                                            style="
                                                border-radius: 50px;
                                                background: #31B6EF;
                                                width: 40px;
                                                height: 40px;
                                                        ">
                                        </div>

                                        <div style="padding-left: 5px;">
                                            <p style="font-size: 10px;margin-bottom: 0px;"><span
                                                    style="font-weight: bold">Mohammad Yaqoob</span>
                                            </p>
                                            <p
                                                style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                                #Policy</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            style="margin-bottom: 0px;
                                                font-size: 10px;
                                                font-weight: 500;">
                                            12:41:00 AM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="align-items: baseline; margin-bottom: 12px;">
                            <div class="col-lg-12">
                                <div style="display: flex; align-items: flex-start; justify-content: space-between;"
                                    class="relevant-chat">
                                    <div style="display: flex;">
                                        <div
                                            style="
                                                border-radius: 50px;
                                                background: #22AE4B;
                                                width: 40px;
                                                height: 40px;
                                                        ">
                                        </div>

                                        <div style="padding-left: 5px;">
                                            <p style="font-size: 10px;margin-bottom: 0px;"><span
                                                    style="font-weight: bold">Thomas Green</span>
                                            </p>
                                            <p
                                                style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                                Give me detail..</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            style="margin-bottom: 0px;
                                                font-size: 10px;
                                                font-weight: 500;">
                                            12:41:00 AM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="align-items: baseline; margin-bottom: 12px;">
                            <div class="col-lg-12">
                                <div style="display: flex; align-items: flex-start; justify-content: space-between;"
                                    class="relevant-chat">
                                    <div style="display: flex;">
                                        <div
                                            style="
                                                border-radius: 50px;
                                                background: #9E57A2;
                                                width: 40px;
                                                height: 40px;
                                                        ">
                                        </div>

                                        <div style="padding-left: 5px;">
                                            <p style="font-size: 10px;margin-bottom: 0px;"><span
                                                    style="font-weight: bold">Neesham Oliver</span>
                                            </p>
                                            <p
                                                style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                                Good news mate!...</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            style="margin-bottom: 0px;
                                                font-size: 10px;
                                                font-weight: 500;">
                                            12:41:00 AM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="align-items: baseline; margin-bottom: 12px;">
                            <div class="col-lg-12">
                                <div style="display: flex; align-items: flex-start; justify-content: space-between;"
                                    class="relevant-chat">
                                    <div style="display: flex;">
                                        <div
                                            style="
                                                border-radius: 50px;
                                                background: darkred;
                                                width: 40px;
                                                height: 40px;
                                                        ">
                                        </div>

                                        <div style="padding-left: 5px;">
                                            <p style="font-size: 10px;margin-bottom: 0px;"><span
                                                    style="font-weight: bold">Mohammad Yaqoob</span>
                                            </p>
                                            <p
                                                style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                                #Policy</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            style="margin-bottom: 0px;
                                                font-size: 10px;
                                                font-weight: 500;">
                                            12:41:00 AM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="align-items: baseline; margin-bottom: 12px;">
                            <div class="col-lg-12">
                                <div style="display: flex; align-items: flex-start; justify-content: space-between;"
                                    class="relevant-chat">
                                    <div style="display: flex;">
                                        <div
                                            style="
                                                border-radius: 50px;
                                                background: #31B6EF;
                                                width: 40px;
                                                height: 40px;
                                                        ">
                                        </div>

                                        <div style="padding-left: 5px;">
                                            <p style="font-size: 10px;margin-bottom: 0px;"><span
                                                    style="font-weight: bold">Mohammad Yaqoob</span>
                                            </p>
                                            <p
                                                style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                                #Policy</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            style="margin-bottom: 0px;
                                                font-size: 10px;
                                                font-weight: 500;">
                                            12:41:00 AM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="align-items: baseline; margin-bottom: 12px;">
                            <div class="col-lg-12">
                                <div style="display: flex; align-items: flex-start; justify-content: space-between;"
                                    class="relevant-chat">
                                    <div style="display: flex;">
                                        <div
                                            style="
                                                border-radius: 50px;
                                                background: #9E57A2;
                                                width: 40px;
                                                height: 40px;
                                                        ">
                                        </div>

                                        <div style="padding-left: 5px;">
                                            <p style="font-size: 10px;margin-bottom: 0px;"><span
                                                    style="font-weight: bold">Walter White Brown</span>
                                            </p>
                                            <p
                                                style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                                Pakistan's Equit Market..</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            style="margin-bottom: 0px;
                                                font-size: 10px;
                                                font-weight: 500;">
                                            12:41:00 AM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="align-items: baseline; margin-bottom: 12px;">
                            <div class="col-lg-12">
                                <div style="display: flex; align-items: flex-start; justify-content: space-between;"
                                    class="relevant-chat">
                                    <div style="display: flex;">
                                        <div
                                            style="
                                                border-radius: 50px;
                                                background: #31B6EF;
                                                width: 40px;
                                                height: 40px;
                                                        ">
                                        </div>

                                        <div style="padding-left: 5px;">
                                            <p style="font-size: 10px;margin-bottom: 0px;"><span
                                                    style="font-weight: bold">Mohammad Yaqoob</span>
                                            </p>
                                            <p
                                                style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                                #Policy</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p
                                            style="margin-bottom: 0px;
                                                font-size: 10px;
                                                font-weight: 500;">
                                            12:41:00 AM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat-submenu" id="chat-submenu">
                <div
                    style="display: flex;
                            background-color: #036AB2;
                            flex: auto;
                            height: fit-content;
                            padding: 6px;
                            justify-content: space-between;
                            ">
                    <div>
                        <span
                            style="margin-left: 5px;
                                color: white;
                        font-size: 15px;
                        font-weight: bold;">Walter
                            White</span>
                    </div>
                    <div
                        style="
                            gap: 10px;
                            display: flex;
                            align-items: center;
                        ">

                        <svg width="17" height="24" viewBox="0 0 22 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.87556 2.09586C5.39346 2.09586 1.76 5.89447 1.76 10.5803C1.76 15.2661 5.39346 19.0647 9.87556 19.0647C12.0691 19.0647 14.0594 18.1549 15.52 16.6765C15.5459 16.6399 15.5747 16.6048 15.6064 16.5717C15.6381 16.5385 15.6717 16.5084 15.7067 16.4813C17.1208 14.9544 17.9911 12.8736 17.9911 10.5803C17.9911 5.89447 14.3577 2.09586 9.87556 2.09586ZM17.4533 17.2014C18.8877 15.409 19.7511 13.1001 19.7511 10.5803C19.7511 4.87827 15.3297 0.255859 9.87556 0.255859C4.42144 0.255859 0 4.87827 0 10.5803C0 16.2823 4.42144 20.9047 9.87556 20.9047C12.2858 20.9047 14.4943 20.0021 16.2088 18.5025L20.4977 22.9864C20.8414 23.3457 21.3986 23.3457 21.7423 22.9864C22.0859 22.6271 22.0859 22.0446 21.7423 21.6853L17.4533 17.2014Z"
                                fill="white" />
                        </svg>

                        <svg width="19" height="5" viewBox="0 0 19 5" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.48074 2.75587C4.48074 3.9932 3.47769 4.99624 2.24037 4.99624C1.00305 4.99624 0 3.9932 0 2.75587C0 1.51855 1.00305 0.515503 2.24037 0.515503C3.47769 0.515503 4.48074 1.51855 4.48074 2.75587ZM11.6499 2.75587C11.6499 3.9932 10.6469 4.99624 9.40956 4.99624C8.17223 4.99624 7.16919 3.9932 7.16919 2.75587C7.16919 1.51855 8.17223 0.515503 9.40956 0.515503C10.6469 0.515503 11.6499 1.51855 11.6499 2.75587ZM16.5787 4.99624C17.8161 4.99624 18.8191 3.9932 18.8191 2.75587C18.8191 1.51855 17.8161 0.515503 16.5787 0.515503C15.3414 0.515503 14.3384 1.51855 14.3384 2.75587C14.3384 3.9932 15.3414 4.99624 16.5787 4.99624Z"
                                fill="white" />
                        </svg>

                        <svg width="20" height="18" viewBox="0 0 27 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.81912 0.138611C2.16227 0.138611 0.819122 1.48175 0.819122 3.13861V14.3731C0.819122 16.03 2.16227 17.3731 3.81912 17.3731H15.9498C17.6066 17.3731 18.9498 16.03 18.9498 14.3731V10.6488L24.7794 14.6265C25.0856 14.8354 25.4823 14.8578 25.8101 14.6846C26.1379 14.5115 26.343 14.1712 26.343 13.8004V3.7113C26.343 3.34058 26.1379 3.00027 25.8101 2.8271C25.4823 2.65393 25.0856 2.67632 24.7794 2.88527L18.9498 6.86294V3.13861C18.9498 1.48176 17.6066 0.138611 15.9498 0.138611H3.81912ZM16.9498 8.75587L16.9498 3.13861C16.9498 2.58633 16.5021 2.13861 15.9498 2.13861H3.81912C3.26684 2.13861 2.81912 2.58633 2.81912 3.13861V14.3731C2.81912 14.9254 3.26684 15.3731 3.81912 15.3731H15.9498C16.5021 15.3731 16.9498 14.9254 16.9498 14.3731L16.9498 8.75587ZM19.724 8.75587L24.343 5.60423V11.9075L19.724 8.75587Z"
                                fill="white" />
                        </svg>
                        <svg id="chat-close" width="14" height="15" viewBox="0 0 14 15" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2.33951 1.28245C1.91892 0.861865 1.23701 0.861865 0.816423 1.28245C0.395834 1.70304 0.395833 2.38495 0.816422 2.80554L5.38535 7.37447L0.435031 12.3248C0.0144421 12.7454 0.0144417 13.4273 0.435031 13.8479C0.85562 14.2685 1.53753 14.2685 1.95812 13.8479L6.90844 8.89756L12.0492 14.0383C12.4698 14.4589 13.1517 14.4589 13.5723 14.0383C13.9929 13.6177 13.9929 12.9358 13.5723 12.5152L8.43152 7.37447L13.1909 2.6151C13.6115 2.19451 13.6115 1.5126 13.1909 1.09201C12.7703 0.671421 12.0884 0.67142 11.6678 1.09201L6.90844 5.85138L2.33951 1.28245Z"
                                fill="white" />
                        </svg>
                    </div>
                </div>
                <div
                    style="display: flex;justify-content: right;
                    margin-right: 5px; margin-top: 10px;">
                    <div
                        style="border-radius: 10px;
                            width: 60%;
                            height: 82px;
                            background: #D9D9D9;
                            padding: 2px 5px 0px 5px;
                            margin: 10px;">
                        <div>
                            <p style="font-size: 12px; margin-bottom: 3px;text-align: end;">This promises greater
                                macro stability in the near term while many indicators are supporting the outlook
                            </p>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <svg width="10" height="11" viewBox="0 0 17 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.8162 0.210338C14.1107 0.499086 14.1202 0.976992 13.8375 1.27777L6.91761 8.64028L7.74963 9.49011L15.7272 0.987541C16.0097 0.686512 16.4776 0.676344 16.7723 0.964831C17.067 1.25332 17.077 1.73121 16.7945 2.03224L8.81692 10.5348C8.24352 11.1459 7.29034 11.1563 6.70434 10.5578L5.89365 9.72972L5.49041 10.1588C4.91683 10.769 3.96436 10.7789 3.37872 10.1808L0.216486 6.95087C-0.0721621 6.65604 -0.0721621 6.17804 0.216486 5.88321C0.505135 5.58839 0.973126 5.58839 1.26177 5.88321L4.42401 9.11311L12.7711 0.232123C13.0538 -0.0686561 13.5217 -0.0784092 13.8162 0.210338Z"
                                        fill="#036AB2" />
                                </svg>
                            </div>
                            <div>
                                <p style="font-size: 11px;margin-bottom: 0px;">06-Dec-21 | 12:41:00 AM</p>
                            </div>
                        </div>
                    </div>
                    <div
                        style="
                                                border-radius: 50px;
                                                background: #D9D9D9;
                                                width: 30px;
                                                height: 30px;
                                                margin-top: 10px;
                                                        ">
                    </div>
                </div>
                <div style="display: flex;
                            margin-left: 5px;">
                    <div
                        style="
                                    border-radius: 50px;
                                    background: #D9D9D9;
                                    width: 30px;
                                    height: 30px;
                                    margin-top: 10px;
                                            ">
                    </div>
                    <div
                        style="border-radius: 10px;
                            width: 60%;
                            height: 82px;
                            background: #2197D7;
                            padding: 2px 5px 0px 5px;
                            margin: 10px;">
                        <div>
                            <p style="font-size: 12px; margin-bottom: 3px;text-align: left;color: white;">This
                                promises greater macro stability in the near term while many indicators are
                                supporting the outlook</p>
                        </div>
                        <div>
                            <p style="font-size: 11px;margin-bottom: 0px;color: white; text-align: end;">06-Dec-21 |
                                12:41:00 AM</p>
                        </div>
                    </div>

                </div>
                <div
                    style="display: flex;justify-content: right;
                        margin-right: 5px; margin-top: 10px;">
                    <div
                        style="border-radius: 10px;
                            width: 60%;
                            height: 82px;
                            background: #D9D9D9;
                            padding: 2px 5px 0px 5px;
                            margin: 10px;">
                        <div>
                            <p style="font-size: 12px; margin-bottom: 3px;text-align: end;">This promises greater
                                macro stability in the near term while many indicators are supporting the outlook
                            </p>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <svg width="10" height="11" viewBox="0 0 17 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M13.8162 0.210338C14.1107 0.499086 14.1202 0.976992 13.8375 1.27777L6.91761 8.64028L7.74963 9.49011L15.7272 0.987541C16.0097 0.686512 16.4776 0.676344 16.7723 0.964831C17.067 1.25332 17.077 1.73121 16.7945 2.03224L8.81692 10.5348C8.24352 11.1459 7.29034 11.1563 6.70434 10.5578L5.89365 9.72972L5.49041 10.1588C4.91683 10.769 3.96436 10.7789 3.37872 10.1808L0.216486 6.95087C-0.0721621 6.65604 -0.0721621 6.17804 0.216486 5.88321C0.505135 5.58839 0.973126 5.58839 1.26177 5.88321L4.42401 9.11311L12.7711 0.232123C13.0538 -0.0686561 13.5217 -0.0784092 13.8162 0.210338Z"
                                        fill="#036AB2" />
                                </svg>
                            </div>
                            <div>
                                <p style="font-size: 11px;margin-bottom: 0px;">06-Dec-21 | 12:41:00 AM</p>
                            </div>
                        </div>
                    </div>
                    <div
                        style="
                                                border-radius: 50px;
                                                background: #D9D9D9;
                                                width: 30px;
                                                height: 30px;
                                                margin-top: 10px;
                                                        ">
                    </div>
                </div>
                <div style="display: flex;
                        margin-left: 5px;">
                    <div
                        style="
                                    border-radius: 50px;
                                    background: #D9D9D9;
                                    width: 30px;
                                    height: 30px;
                                    margin-top: 10px;
                                            ">
                    </div>
                    <div
                        style="border-radius: 10px;
                            width: 60%;
                            height: 82px;
                            background: #2197D7;
                            padding: 2px 5px 0px 5px;
                            margin: 10px;">
                        <div>
                            <p style="font-size: 12px; margin-bottom: 3px;text-align: left;color: white;">This
                                promises greater macro stability in the near term while many indicators are
                                supporting the outlook</p>
                        </div>
                        <div>
                            <p style="font-size: 11px;margin-bottom: 0px;color: white; text-align: end;">06-Dec-21 |
                                12:41:00 AM</p>
                        </div>
                    </div>

                </div>
                <div style="display: flex;align-items: center;justify-content: space-around;margin-bottom: 10px;">
                    <div>
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2.07507 13C2.07507 7.06294 6.88806 2.25 12.8251 2.25C18.7621 2.25 23.5751 7.06294 23.5751 13C23.5751 18.9371 18.7621 23.75 12.8251 23.75C6.88806 23.75 2.07507 18.9371 2.07507 13ZM12.8251 0.75C6.05945 0.75 0.575073 6.23451 0.575073 13C0.575073 19.7655 6.05945 25.25 12.8251 25.25C19.5907 25.25 25.0751 19.7655 25.0751 13C25.0751 6.23451 19.5907 0.75 12.8251 0.75ZM8.59265 14.6586C8.40417 14.2898 7.95251 14.1437 7.58337 14.3322C7.21472 14.5207 7.06873 14.9726 7.2572 15.3414C8.29041 17.3632 10.3954 18.75 12.8251 18.75C15.2552 18.75 17.3597 17.3632 18.3934 15.3414C18.5819 14.9726 18.4354 14.5207 18.0668 14.3322C17.6981 14.1437 17.246 14.2898 17.0575 14.6586C16.2704 16.1985 14.6698 17.25 12.8251 17.25C10.9803 17.25 9.37976 16.1985 8.59265 14.6586ZM15.3251 10.5C15.3251 9.94772 15.7728 9.5 16.3251 9.5C16.8773 9.5 17.3251 9.94772 17.3251 10.5C17.3251 11.0523 16.8773 11.5 16.3251 11.5C15.7728 11.5 15.3251 11.0523 15.3251 10.5ZM9.32507 9.5C8.77283 9.5 8.32507 9.94772 8.32507 10.5C8.32507 11.0523 8.77283 11.5 9.32507 11.5C9.87732 11.5 10.3251 11.0523 10.3251 10.5C10.3251 9.94772 9.87732 9.5 9.32507 9.5Z"
                                fill="black" />
                        </svg>
                    </div>
                    <div>
                        <input type="text" class="form-control" style="width: 300px;">
                    </div>
                    <div>
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M23.7822 0.292921C24.0538 0.564559 24.1458 0.967791 24.0189 1.33038L16.3189 23.3304C16.1835 23.7174 15.8255 23.9825 15.4158 23.9992C15.0062 24.0159 14.6278 23.7808 14.4613 23.4062L10.2175 13.8576L0.66894 9.61384C0.294259 9.44731 0.0591957 9.06894 0.0759095 8.65926C0.0926233 8.24959 0.357727 7.89162 0.744728 7.75617L22.7447 0.0561695C23.1073 -0.0707359 23.5105 0.0212832 23.7822 0.292921ZM12.1678 13.3215L15.2645 20.289L20.6836 4.80571L12.1678 13.3215ZM19.2694 3.3915L3.78615 8.81063L10.7536 11.9073L19.2694 3.3915Z"
                                fill="#1E1E1E" />
                        </svg>
                    </div>
                    <div>
                        <svg width="20" height="23" viewBox="0 0 20 23" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3.55103 21.9562C2.02441 20.9835 1.06846 19.6277 0.683162 17.889C0.297866 16.1503 0.591596 14.5177 1.56435 12.9911L8.22562 2.53705C8.92347 1.44187 9.91082 0.7528 11.1877 0.469848C12.4645 0.186896 13.6505 0.394344 14.7457 1.09219C15.8409 1.79004 16.53 2.77739 16.8129 4.05424C17.0959 5.3311 16.8884 6.51712 16.1906 7.6123L10.1637 17.0707C9.71964 17.7676 9.10368 18.2034 8.31583 18.378C7.52799 18.5526 6.78559 18.4178 6.08866 17.9737C5.39172 17.5297 4.95596 16.9137 4.78138 16.1258C4.60679 15.338 4.74154 14.5956 5.18562 13.8987L11.2125 4.44027L12.7059 5.39188L6.67905 14.8503C6.49931 15.1324 6.44405 15.4296 6.51328 15.7421C6.58251 16.0545 6.75818 16.3006 7.04027 16.4803C7.32236 16.6601 7.61962 16.7153 7.93204 16.6461C8.24446 16.5768 8.49055 16.4012 8.6703 16.1191L14.6972 6.66069C15.1412 5.96376 15.276 5.22137 15.1014 4.43352C14.9268 3.64567 14.4911 3.02971 13.7941 2.58562C13.0972 2.14154 12.3548 2.00679 11.5669 2.18138C10.7791 2.35596 10.1631 2.79173 9.71905 3.48866L3.05778 13.9427C2.35994 15.0379 2.15249 16.2239 2.43544 17.5007C2.71839 18.7776 3.40746 19.7649 4.50264 20.4628C5.59783 21.1606 6.78384 21.3681 8.0607 21.0851C9.33756 20.8022 10.3249 20.1131 11.0228 19.0179L17.684 8.56391L19.1775 9.51552L12.5162 19.9695C11.5434 21.4962 10.1877 22.4521 8.44901 22.8374C6.71031 23.2227 5.07765 22.929 3.55103 21.9562Z"
                                fill="#1D1B20" />
                        </svg>
                    </div>
                </div>
            </div>
        </li>
        <li class="inside-bar-item" id="video-btn" onclick="window.location.href='{{ route('video.authorize') }}'" style="cursor: pointer">
            <img src="{{ asset('svg/video.svg') }}" alt="">
            <p class="inside-bar-text">Video</p>
            <ul class="video-submenu" id="video-submenu">
                <div style="width: 100%; margin-left: -10px;">
                    <div
                        style="display: flex;
                    flex: auto;
                    margin: 15px;
                    height: fit-content;
                    margin-left: -10px;
                    border-bottom: 1px solid lightgray;
                    padding: 3px;
                    justify-content: space-between;
                    ">
                        <div>
                            <svg width="20" height="17" viewBox="0 0 33 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0 2C0 0.895429 0.895431 0 2 0H20.1194C21.224 0 22.1194 0.895431 22.1194 2V18.8906C22.1194 19.9951 21.224 20.8906 20.1194 20.8906H2C0.895432 20.8906 0 19.9951 0 18.8906V2Z"
                                    fill="#036AB2" />
                                <path
                                    d="M22.1864 10.822C21.6124 10.4243 21.6124 9.57568 22.1864 9.17799L30.6804 3.29314C31.3436 2.83366 32.2499 3.30831 32.2499 4.11513V15.8848C32.2499 16.6917 31.3436 17.1663 30.6804 16.7068L22.1864 10.822Z"
                                    fill="#036AB2" />
                            </svg>
                            <span
                                style="margin-left: 5px;
                                color: #036AB2;
                        font-size: 20px;
                        font-weight: bold;">Video</span>
                            <button class="btn dropdown-toggle" id="contact-detail" type="button"
                                style="
                                    height: 50px;padding: 0px;
                                    margin-top: -10px;
                                    margin-bottom: -4px;">
                                <span style="font-size: 10px;">Contacts</span>
                            </button>
                        </div>

                        <div class="contact-detail-record" id="contact-detail-record">
                            <div class="container" id="contact-container">
                                <div class="row">
                                    <div class="col-lg-12 contact-list"
                                        style="display: flex; flex-direction: column; align-items: start; gap: 5px;">
                                        <div style="width: 100%; padding-left: 10px;">
                                            <p
                                                style="font-size: 14px; margin-bottom: 0px; font-weight: bold; text-align: left;">
                                                Contacts</p>
                                        </div>
                                        <div style="width: 100%; padding-left: 10px;">
                                            <p
                                                style="font-size: 14px; margin-bottom: 0px; font-weight: bold; text-align: left;">
                                                Recents</p>
                                        </div>
                                        <div style="width: 100%; padding-left: 10px;">
                                            <p
                                                style="font-size: 14px; margin-bottom: 0px; font-weight: bold; text-align: left;">
                                                Meetings</p>
                                        </div>
                                        <div style="width: 100%; padding-left: 10px;">
                                            <p
                                                style="font-size: 14px; margin-bottom: 0px; font-weight: bold; text-align: left;">
                                                History</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <svg style="margin-right: 10px;" width="17" height="17" viewBox="0 0 17 17"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.23935 3.65672C9.23935 3.29402 8.94532 3 8.58263 3C8.21994 3 7.92591 3.29402 7.92591 3.65672V7.59667H3.65672C3.29402 7.59667 3 7.8907 3 8.25339C3 8.61608 3.29402 8.91011 3.65672 8.91011H7.92591L7.92591 13.3433C7.92591 13.706 8.21994 14 8.58263 14C8.94532 14 9.23935 13.706 9.23935 13.3433V8.91011H13.3433C13.706 8.91011 14 8.61608 14 8.25339C14 7.8907 13.706 7.59667 13.3433 7.59667L9.23935 7.59667V3.65672Z"
                                    fill="black" />
                                <mask id="path-2-inside-1_95_1215" fill="white">
                                    <rect width="17" height="17" rx="1" />
                                </mask>
                                <rect width="17" height="17" rx="1" stroke="black" stroke-width="3"
                                    mask="url(#path-2-inside-1_95_1215)" />
                            </svg>

                            <svg style="margin-right: 10px;" width="19" height="18" viewBox="0 0 19 18"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.52889 1.44C4.65799 1.44 1.52 4.41283 1.52 8.08C1.52 11.7472 4.65799 14.72 8.52889 14.72C10.4233 14.72 12.1422 14.008 13.4037 12.8509C13.426 12.8223 13.4509 12.7948 13.4783 12.7689C13.5057 12.7429 13.5346 12.7194 13.5649 12.6982C14.7862 11.5032 15.5378 9.87474 15.5378 8.08C15.5378 4.41283 12.3998 1.44 8.52889 1.44ZM15.0733 13.2617C16.3121 11.859 17.0578 10.052 17.0578 8.08C17.0578 3.61754 13.2393 0 8.52889 0C3.81851 0 0 3.61754 0 8.08C0 12.5425 3.81851 16.16 8.52889 16.16C10.6104 16.16 12.5178 15.4536 13.9985 14.28L17.7026 17.7891C17.9994 18.0703 18.4806 18.0703 18.7774 17.7891C19.0742 17.5079 19.0742 17.0521 18.7774 16.7709L15.0733 13.2617Z"
                                    fill="black" />
                            </svg>

                            <svg id="video-close" style="margin-left: auto;" width="16" height="16"
                                viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2.45779 0.833283C1.99215 0.367647 1.23721 0.367647 0.771573 0.833283C0.305936 1.29892 0.305936 2.05386 0.771572 2.5195L5.82979 7.57771L0.349227 13.0583C-0.116409 13.5239 -0.116409 14.2789 0.349227 14.7445C0.814863 15.2101 1.56981 15.2101 2.03544 14.7445L7.516 9.26393L13.2074 14.9554C13.6731 15.421 14.428 15.421 14.8936 14.9554C15.3593 14.4897 15.3593 13.7348 14.8936 13.2691L9.20222 7.57771L14.4713 2.30864C14.9369 1.843 14.9369 1.08806 14.4713 0.62242C14.0057 0.156784 13.2507 0.156784 12.7851 0.62242L7.516 5.8915L2.45779 0.833283Z"
                                    fill="black" />
                            </svg>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row" style="align-items: baseline; margin-bottom: 20px;">
                            <div class="col-lg-8">
                                <div style="display: flex; align-items: center;">
                                    <div style="margin-right: 10px;">

                                        <svg width="20" height="31" viewBox="0 0 31 31" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="1" y="1" width="29" height="29" stroke="black"
                                                stroke-width="2" />
                                        </svg>

                                    </div>
                                    <div style="position: relative; display: inline-block;">
                                        <img src="./images/minisite/2.png"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 100px;"
                                            alt="">
                                        <span
                                            style="position: absolute; bottom: 0; right: 0; width: 13px; height: 13px; background: #10AA2E;; border-radius: 50%; border: 2px solid white;"></span>
                                    </div>

                                    <div style="padding-left: 5px;">
                                        <p style="font-size: 14px;margin-bottom: 0px;"><span
                                                style="font-weight: bold">Emma Johnson</span>
                                        </p>
                                        <p
                                            style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                            Tresmark</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">

                            </div>
                            <div class="col-lg-2">
                                <svg width="25" height="18" viewBox="0 0 35 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3 0C1.34315 0 0 1.34314 0 3V19.8906C0 21.5474 1.34315 22.8906 3 22.8906H21.1194C22.7763 22.8906 24.1194 21.5474 24.1194 19.8906V13.338L32.6941 19.1888C33.0003 19.3977 33.397 19.4201 33.7248 19.2469C34.0526 19.0737 34.2577 18.7334 34.2577 18.3627V4.52785C34.2577 4.15712 34.0526 3.81682 33.7248 3.64365C33.397 3.47048 33.0003 3.49287 32.6941 3.70182L24.1194 9.55254V3C24.1194 1.34314 22.7763 0 21.1194 0H3ZM2 3C2 2.44771 2.44771 2 3 2H21.1194C21.6717 2 22.1194 2.44772 22.1194 3V19.8906C22.1194 20.4428 21.6717 20.8906 21.1194 20.8906H3C2.44772 20.8906 2 20.4428 2 19.8906V3ZM32.2577 16.4698L24.8939 11.4453L32.2577 6.42078V16.4698Z"
                                        fill="black" />
                                </svg>
                            </div>
                        </div>
                        <div class="row" style="align-items: baseline; margin-bottom: 20px;">
                            <div class="col-lg-8">
                                <div style="display: flex; align-items: center;">
                                    <div style="margin-right: 10px;">

                                        <svg width="20" height="31" viewBox="0 0 31 31" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="1" y="1" width="29" height="29" stroke="black"
                                                stroke-opacity="0.4" stroke-width="2" />
                                        </svg>

                                    </div>
                                    <div style="position: relative; display: inline-block;">
                                        <img src="./images/minisite/2.png"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 100px;"
                                            alt="">
                                        <span
                                            style="position: absolute; bottom: 0; right: 0; width: 13px; height: 13px; background: #DE2020; border-radius: 50%; border: 2px solid white;"></span>
                                    </div>

                                    <div style="padding-left: 5px;">
                                        <p style="font-size: 14px;margin-bottom: 0px;"><span
                                                style="font-weight: bold">William Brown</span>
                                        </p>
                                        <p
                                            style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                            Tresmark</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">

                            </div>
                            <div class="col-lg-2">
                                <svg width="25" height="23" viewBox="0 0 35 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3 0C1.34315 0 0 1.34314 0 3V19.8906C0 21.5474 1.34315 22.8906 3 22.8906H21.1194C22.7763 22.8906 24.1194 21.5474 24.1194 19.8906V13.338L32.6941 19.1888C33.0003 19.3977 33.397 19.4201 33.7248 19.2469C34.0526 19.0737 34.2577 18.7334 34.2577 18.3627V4.52785C34.2577 4.15712 34.0526 3.81682 33.7248 3.64365C33.397 3.47048 33.0003 3.49287 32.6941 3.70182L24.1194 9.55254V3C24.1194 1.34314 22.7763 0 21.1194 0H3ZM2 3C2 2.44771 2.44771 2 3 2H21.1194C21.6717 2 22.1194 2.44772 22.1194 3V19.8906C22.1194 20.4428 21.6717 20.8906 21.1194 20.8906H3C2.44772 20.8906 2 20.4428 2 19.8906V3ZM32.2577 16.4698L24.8939 11.4453L32.2577 6.42078V16.4698Z"
                                        fill="black" fill-opacity="0.4" />
                                </svg>
                            </div>
                    </div>
                </div>
            </ul>
        </li>
        <li class="inside-bar-item" id="address-btn">
            <img src="{{ asset('svg/address.svg') }}" alt="">
            <p class="inside-bar-text">Address</p>
            <ul class="address-submenu" id="address-submenu">
                <div style="width: 100%; margin-left: -6px;">
                    <div
                        style="display: flex;
                    flex: auto;
                    margin: 15px;
                    height: fit-content;
                    margin-left: -10px;
                    border-bottom: 1px solid lightgray;
                    padding: 10px
                    ">
                        <svg width="20" height="20" viewBox="0 0 31 31" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.9156 2.48C7.59987 2.48 2.48 7.59987 2.48 13.9156C2.48 20.2312 7.59987 25.3511 13.9156 25.3511C17.0065 25.3511 19.811 24.1248 21.8691 22.1322C21.9056 22.0828 21.9461 22.0356 21.9909 21.9909C22.0356 21.9461 22.0828 21.9056 22.1322 21.8691C24.1248 19.811 25.3511 17.0065 25.3511 13.9156C25.3511 7.59987 20.2312 2.48 13.9156 2.48ZM24.5932 22.8396C26.6145 20.4238 27.8311 17.3118 27.8311 13.9156C27.8311 6.23021 21.6009 0 13.9156 0C6.23021 0 0 6.23021 0 13.9156C0 21.6009 6.23021 27.8311 13.9156 27.8311C17.3118 27.8311 20.4238 26.6145 22.8396 24.5932L28.8832 30.6368C29.3674 31.1211 30.1526 31.1211 30.6368 30.6368C31.1211 30.1526 31.1211 29.3674 30.6368 28.8832L24.5932 22.8396Z"
                                fill="black" />
                        </svg>
                        <span
                            style="margin-left: 10px;
                        font-size: 18px;
                        font-weight: bold;">Address
                            book directory</span>
                        <svg id="address-close" style="margin-left: auto;" width="16" height="16"
                            viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.45779 0.833283C1.99215 0.367647 1.23721 0.367647 0.771573 0.833283C0.305936 1.29892 0.305936 2.05386 0.771572 2.5195L5.82979 7.57771L0.349227 13.0583C-0.116409 13.5239 -0.116409 14.2789 0.349227 14.7445C0.814863 15.2101 1.56981 15.2101 2.03544 14.7445L7.516 9.26393L13.2074 14.9554C13.6731 15.421 14.428 15.421 14.8936 14.9554C15.3593 14.4897 15.3593 13.7348 14.8936 13.2691L9.20222 7.57771L14.4713 2.30864C14.9369 1.843 14.9369 1.08806 14.4713 0.62242C14.0057 0.156784 13.2507 0.156784 12.7851 0.62242L7.516 5.8915L2.45779 0.833283Z"
                                fill="black" />
                        </svg>
                    </div>
                    <div class="container">
                        <div class="row" style="align-items: baseline;">
                            <div class="col-lg-8">
                                <div style="display: flex; align-items: center;">
                                    <div>
                                        <img src="./images/address/1.png"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 100px;"
                                            alt="">
                                    </div>
                                    <div style="padding-top: 15px; padding-left: 5px;">
                                        <p style="font-size: 14px;margin-bottom: 0px;"><span
                                                style="font-weight: bold">Walter White</span>
                                            <span style="color: #707070; font-size: 10px; padding: 1px 4px 2px 4px;">
                                                ( Tresmark )
                                            </span>
                                        </p>
                                        <p
                                            style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                            walter@landmark.com</p>
                                        <p style="font-size: 10px;color: #707070; text-align: left;">+92 333 687
                                            7977</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <svg width="20" height="20" viewBox="0 0 25 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1 3C1 1.89543 1.89543 1 3 1H21.1194C22.224 1 23.1194 1.89543 23.1194 3V17.8906C23.1194 18.9951 22.224 19.8906 21.1194 19.8906H9.2115C8.75129 19.8906 8.30517 20.0493 7.94836 20.3399L2.63157 24.6709C1.97827 25.2031 1 24.7382 1 23.8956V3Z"
                                        stroke="black" stroke-width="2" />
                                </svg>
                            </div>
                            <div class="col-lg-2">
                                <svg width="25" height="18" viewBox="0 0 35 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3 0C1.34315 0 0 1.34314 0 3V19.8906C0 21.5474 1.34315 22.8906 3 22.8906H21.1194C22.7763 22.8906 24.1194 21.5474 24.1194 19.8906V13.338L32.6941 19.1888C33.0003 19.3977 33.397 19.4201 33.7248 19.2469C34.0526 19.0737 34.2577 18.7334 34.2577 18.3627V4.52785C34.2577 4.15712 34.0526 3.81682 33.7248 3.64365C33.397 3.47048 33.0003 3.49287 32.6941 3.70182L24.1194 9.55254V3C24.1194 1.34314 22.7763 0 21.1194 0H3ZM2 3C2 2.44771 2.44771 2 3 2H21.1194C21.6717 2 22.1194 2.44772 22.1194 3V19.8906C22.1194 20.4428 21.6717 20.8906 21.1194 20.8906H3C2.44772 20.8906 2 20.4428 2 19.8906V3ZM32.2577 16.4698L24.8939 11.4453L32.2577 6.42078V16.4698Z"
                                        fill="black" />
                                </svg>
                            </div>
                        </div>
                        <div class="row" style="align-items: baseline;">
                            <div class="col-lg-8">
                                <div style="display: flex;align-items: center;">
                                    <div>
                                        <img src="./images/address/1.png"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 100px;"
                                            alt="">
                                    </div>
                                    <div style="padding-top: 15px; padding-left: 5px;">
                                        <p style="font-size: 14px;margin-bottom: 0px;"><span
                                                style="font-weight: bold">Walter White</span>
                                            <span style="color: #707070; font-size: 10px; padding: 1px 4px 2px 4px;">
                                                ( Tresmark )
                                            </span>
                                        </p>
                                        <p
                                            style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                            walter@landmark.com</p>
                                        <p style="font-size: 10px;color: #707070; text-align: left;">+92 333 687
                                            7977</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <svg width="20" height="20" viewBox="0 0 25 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1 3C1 1.89543 1.89543 1 3 1H21.1194C22.224 1 23.1194 1.89543 23.1194 3V17.8906C23.1194 18.9951 22.224 19.8906 21.1194 19.8906H9.2115C8.75129 19.8906 8.30517 20.0493 7.94836 20.3399L2.63157 24.6709C1.97827 25.2031 1 24.7382 1 23.8956V3Z"
                                        stroke="black" stroke-width="2" />
                                </svg>
                            </div>
                            <div class="col-lg-2">
                                <svg width="25" height="18" viewBox="0 0 35 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3 0C1.34315 0 0 1.34314 0 3V19.8906C0 21.5474 1.34315 22.8906 3 22.8906H21.1194C22.7763 22.8906 24.1194 21.5474 24.1194 19.8906V13.338L32.6941 19.1888C33.0003 19.3977 33.397 19.4201 33.7248 19.2469C34.0526 19.0737 34.2577 18.7334 34.2577 18.3627V4.52785C34.2577 4.15712 34.0526 3.81682 33.7248 3.64365C33.397 3.47048 33.0003 3.49287 32.6941 3.70182L24.1194 9.55254V3C24.1194 1.34314 22.7763 0 21.1194 0H3ZM2 3C2 2.44771 2.44771 2 3 2H21.1194C21.6717 2 22.1194 2.44772 22.1194 3V19.8906C22.1194 20.4428 21.6717 20.8906 21.1194 20.8906H3C2.44772 20.8906 2 20.4428 2 19.8906V3ZM32.2577 16.4698L24.8939 11.4453L32.2577 6.42078V16.4698Z"
                                        fill="black" />
                                </svg>
                            </div>
                        </div>
                        <div class="row" style="align-items: baseline;">
                            <div class="col-lg-8">
                                <div style="display: flex; align-items: center;">
                                    <div>
                                        <img src="./images/address/1.png"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 100px;"
                                            alt="">
                                    </div>
                                    <div style="padding-top: 15px; padding-left: 5px;">
                                        <p style="font-size: 14px;margin-bottom: 0px;"><span
                                                style="font-weight: bold">Walter White</span>
                                            <span style="color: #707070; font-size: 10px; padding: 1px 4px 2px 4px;">
                                                ( Tresmark )
                                            </span>
                                        </p>
                                        <p
                                            style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                            walter@landmark.com</p>
                                        <p style="font-size: 10px;color: #707070; text-align: left;">+92 333 687
                                            7977</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <svg width="20" height="20" viewBox="0 0 25 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1 3C1 1.89543 1.89543 1 3 1H21.1194C22.224 1 23.1194 1.89543 23.1194 3V17.8906C23.1194 18.9951 22.224 19.8906 21.1194 19.8906H9.2115C8.75129 19.8906 8.30517 20.0493 7.94836 20.3399L2.63157 24.6709C1.97827 25.2031 1 24.7382 1 23.8956V3Z"
                                        stroke="black" stroke-width="2" />
                                </svg>
                            </div>
                            <div class="col-lg-2">
                                <svg width="25" height="18" viewBox="0 0 35 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3 0C1.34315 0 0 1.34314 0 3V19.8906C0 21.5474 1.34315 22.8906 3 22.8906H21.1194C22.7763 22.8906 24.1194 21.5474 24.1194 19.8906V13.338L32.6941 19.1888C33.0003 19.3977 33.397 19.4201 33.7248 19.2469C34.0526 19.0737 34.2577 18.7334 34.2577 18.3627V4.52785C34.2577 4.15712 34.0526 3.81682 33.7248 3.64365C33.397 3.47048 33.0003 3.49287 32.6941 3.70182L24.1194 9.55254V3C24.1194 1.34314 22.7763 0 21.1194 0H3ZM2 3C2 2.44771 2.44771 2 3 2H21.1194C21.6717 2 22.1194 2.44772 22.1194 3V19.8906C22.1194 20.4428 21.6717 20.8906 21.1194 20.8906H3C2.44772 20.8906 2 20.4428 2 19.8906V3ZM32.2577 16.4698L24.8939 11.4453L32.2577 6.42078V16.4698Z"
                                        fill="black" />
                                </svg>
                            </div>
                        </div>
                        <div class="row" style="align-items: baseline;">
                            <div class="col-lg-8">
                                <div style="display: flex;align-items: center;">
                                    <div>
                                        <img src="./images/address/1.png"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 100px;"
                                            alt="">
                                    </div>
                                    <div style="padding-top: 15px; padding-left: 5px;">
                                        <p style="font-size: 14px;margin-bottom: 0px;"><span
                                                style="font-weight: bold">Walter White</span>
                                            <span style="color: #707070; font-size: 10px; padding: 1px 4px 2px 4px;">
                                                ( Tresmark )
                                            </span>
                                        </p>
                                        <p
                                            style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                            walter@landmark.com</p>
                                        <p style="font-size: 10px;color: #707070; text-align: left;">+92 333 687
                                            7977</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <svg width="20" height="20" viewBox="0 0 25 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1 3C1 1.89543 1.89543 1 3 1H21.1194C22.224 1 23.1194 1.89543 23.1194 3V17.8906C23.1194 18.9951 22.224 19.8906 21.1194 19.8906H9.2115C8.75129 19.8906 8.30517 20.0493 7.94836 20.3399L2.63157 24.6709C1.97827 25.2031 1 24.7382 1 23.8956V3Z"
                                        stroke="black" stroke-width="2" />
                                </svg>
                            </div>
                            <div class="col-lg-2">
                                <svg width="25" height="18" viewBox="0 0 35 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3 0C1.34315 0 0 1.34314 0 3V19.8906C0 21.5474 1.34315 22.8906 3 22.8906H21.1194C22.7763 22.8906 24.1194 21.5474 24.1194 19.8906V13.338L32.6941 19.1888C33.0003 19.3977 33.397 19.4201 33.7248 19.2469C34.0526 19.0737 34.2577 18.7334 34.2577 18.3627V4.52785C34.2577 4.15712 34.0526 3.81682 33.7248 3.64365C33.397 3.47048 33.0003 3.49287 32.6941 3.70182L24.1194 9.55254V3C24.1194 1.34314 22.7763 0 21.1194 0H3ZM2 3C2 2.44771 2.44771 2 3 2H21.1194C21.6717 2 22.1194 2.44772 22.1194 3V19.8906C22.1194 20.4428 21.6717 20.8906 21.1194 20.8906H3C2.44772 20.8906 2 20.4428 2 19.8906V3ZM32.2577 16.4698L24.8939 11.4453L32.2577 6.42078V16.4698Z"
                                        fill="black" />
                                </svg>
                            </div>
                        </div>
                        <div class="row" style="align-items: baseline;">
                            <div class="col-lg-8">
                                <div style="display: flex; align-items: center;">
                                    <div>
                                        <img src="./images/address/1.png"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 100px;"
                                            alt="">
                                    </div>
                                    <div style="padding-top: 15px; padding-left: 5px;">
                                        <p style="font-size: 14px;margin-bottom: 0px;"><span
                                                style="font-weight: bold">Walter White</span>
                                            <span style="color: #707070; font-size: 10px; padding: 1px 4px 2px 4px;">
                                                ( Tresmark )
                                            </span>
                                        </p>
                                        <p
                                            style="font-size: 10px;color: #707070; margin-bottom: 0px; text-align: left;">
                                            walter@landmark.com</p>
                                        <p style="font-size: 10px;color: #707070; text-align: left;">+92 333 687
                                            7977</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <svg width="20" height="20" viewBox="0 0 25 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1 3C1 1.89543 1.89543 1 3 1H21.1194C22.224 1 23.1194 1.89543 23.1194 3V17.8906C23.1194 18.9951 22.224 19.8906 21.1194 19.8906H9.2115C8.75129 19.8906 8.30517 20.0493 7.94836 20.3399L2.63157 24.6709C1.97827 25.2031 1 24.7382 1 23.8956V3Z"
                                        stroke="black" stroke-width="2" />
                                </svg>
                            </div>
                            <div class="col-lg-2">
                                <svg width="25" height="18" viewBox="0 0 35 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M3 0C1.34315 0 0 1.34314 0 3V19.8906C0 21.5474 1.34315 22.8906 3 22.8906H21.1194C22.7763 22.8906 24.1194 21.5474 24.1194 19.8906V13.338L32.6941 19.1888C33.0003 19.3977 33.397 19.4201 33.7248 19.2469C34.0526 19.0737 34.2577 18.7334 34.2577 18.3627V4.52785C34.2577 4.15712 34.0526 3.81682 33.7248 3.64365C33.397 3.47048 33.0003 3.49287 32.6941 3.70182L24.1194 9.55254V3C24.1194 1.34314 22.7763 0 21.1194 0H3ZM2 3C2 2.44771 2.44771 2 3 2H21.1194C21.6717 2 22.1194 2.44772 22.1194 3V19.8906C22.1194 20.4428 21.6717 20.8906 21.1194 20.8906H3C2.44772 20.8906 2 20.4428 2 19.8906V3ZM32.2577 16.4698L24.8939 11.4453L32.2577 6.42078V16.4698Z"
                                        fill="black" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
        </li>
        <a href="{{ route('minisites.index') }}" style="text-decoration: none">
            <li class="inside-bar-item" id="minisite-btn">
                <img src="{{ asset('svg/minisite-1.svg') }}" alt="">
                <p class="inside-bar-text">Minisite</p>
            </li>
        </a>
        <li class="inside-bar-item" style="cursor: pointer" id="createSnap">
            <img src="{{ asset('svg/snap.svg') }}" alt="">
            <p class="inside-bar-text">Snap</p>
        </li>
        <li class="inside-bar-item" id="media-btn" style="cursor: pointer">
            <img src="{{ asset('svg/media.svg') }}" alt="">
            <p class="inside-bar-text">Media</p>
            <ul class="media-submenu" id="media-submenu">
                <div style="width: 95%;">
                    <div
                        style="display: flex;
                                flex: auto;
                                margin: 15px;
                                height: fit-content;
                                margin-left: -10px;
                                border-bottom: 1px solid lightgray;
                                padding: 10px
                                ">
                        <svg width="20" height="20" viewBox="0 0 26 26" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <mask id="path-1-inside-1_93_1117" fill="white">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.9696 4.23524C10.9696 6.5743 9.07346 8.47048 6.73441 8.47048C4.39535 8.47048 2.49916 6.5743 2.49916 4.23524C2.49916 1.89618 4.39535 0 6.73441 0C9.07346 0 10.9696 1.89618 10.9696 4.23524ZM21.6711 9.87377L25.593 19.0459C26.2571 20.5872 26.1068 22.3539 25.1545 23.7573C24.2272 25.1607 22.6609 26.0003 20.9819 26.0003H4.99323C3.25152 26.0003 1.66017 25.1106 0.745456 23.632C-0.169256 22.1535 -0.244438 20.3366 0.532441 18.7703L2.70018 14.4473C3.33923 13.1818 4.30406 12.4049 5.43179 12.2921C6.55951 12.1793 7.66218 12.7181 8.55183 13.8333L8.8275 14.1842C9.46654 14.9987 10.256 15.4122 11.0454 15.337C11.8222 15.2743 12.5365 14.7355 13.0377 13.8333L15.4184 9.56051C16.3081 7.95663 17.4734 7.1171 18.6763 7.17975C19.8918 7.2424 20.9568 8.19471 21.6711 9.87377Z" />
                            </mask>
                            <path
                                d="M25.593 19.0459L24.2138 19.6357L24.2155 19.6395L25.593 19.0459ZM21.6711 9.87377L20.2907 10.4609L20.2918 10.4635L21.6711 9.87377ZM25.1545 23.7573L23.9133 22.9151L23.9081 22.9227L23.903 22.9305L25.1545 23.7573ZM0.745456 23.632L-0.530172 24.4212H-0.530172L0.745456 23.632ZM0.532441 18.7703L-0.808434 18.0979L-0.811343 18.1038L0.532441 18.7703ZM2.70018 14.4473L1.3612 13.7712L1.35932 13.775L2.70018 14.4473ZM5.43179 12.2921L5.28253 10.7996H5.28253L5.43179 12.2921ZM8.55183 13.8333L9.73134 12.9066L9.72442 12.8979L8.55183 13.8333ZM8.8275 14.1842L10.0076 13.2583L10.007 13.2575L8.8275 14.1842ZM11.0454 15.337L10.9248 13.8418L10.914 13.8427L10.9031 13.8437L11.0454 15.337ZM13.0377 13.8333L11.7273 13.1032L11.7264 13.1049L13.0377 13.8333ZM15.4184 9.56051L16.7288 10.2906L16.7302 10.2881L15.4184 9.56051ZM18.6763 7.17975L18.5983 8.67772L18.5991 8.67776L18.6763 7.17975ZM6.73441 9.97048C9.90189 9.97048 12.4696 7.40273 12.4696 4.23524H9.46965C9.46965 5.74587 8.24504 6.97048 6.73441 6.97048V9.97048ZM0.999165 4.23524C0.999165 7.40273 3.56692 9.97048 6.73441 9.97048V6.97048C5.22377 6.97048 3.99916 5.74587 3.99916 4.23524H0.999165ZM6.73441 -1.5C3.56692 -1.5 0.999165 1.06776 0.999165 4.23524H3.99916C3.99916 2.72461 5.22377 1.5 6.73441 1.5V-1.5ZM12.4696 4.23524C12.4696 1.06775 9.90189 -1.5 6.73441 -1.5V1.5C8.24504 1.5 9.46965 2.72461 9.46965 4.23524H12.4696ZM26.9722 18.4562L23.0503 9.28403L20.2918 10.4635L24.2138 19.6357L26.9722 18.4562ZM26.3957 24.5996C27.6408 22.7647 27.8338 20.4556 26.9706 18.4524L24.2155 19.6395C24.6805 20.7187 24.5728 21.9432 23.9133 22.9151L26.3957 24.5996ZM20.9819 27.5003C23.1634 27.5003 25.2003 26.409 26.406 24.5842L23.903 22.9305C23.2541 23.9125 22.1585 24.5003 20.9819 24.5003V27.5003ZM4.99323 27.5003H20.9819V24.5003H4.99323V27.5003ZM-0.530172 24.4212C0.657284 26.3406 2.73067 27.5003 4.99323 27.5003V24.5003C3.77236 24.5003 2.66305 23.8806 2.02108 22.8429L-0.530172 24.4212ZM-0.811343 18.1038C-1.81483 20.1269 -1.72201 22.4947 -0.530172 24.4212L2.02108 22.8429C1.38349 21.8122 1.32596 20.5462 1.87622 19.4368L-0.811343 18.1038ZM1.35932 13.775L-0.808422 18.0979L1.8733 19.4427L4.04105 15.1197L1.35932 13.775ZM5.28253 10.7996C3.49782 10.978 2.15575 12.1977 1.3612 13.7712L4.03916 15.1234C4.52271 14.1658 5.1103 13.8317 5.58104 13.7847L5.28253 10.7996ZM9.72442 12.8979C8.60525 11.495 7.04287 10.6235 5.28253 10.7996L5.58104 13.7847C6.07616 13.7352 6.71912 13.9413 7.37924 14.7688L9.72442 12.8979ZM10.007 13.2575L9.73131 12.9066L7.37236 14.7601L7.64802 15.1109L10.007 13.2575ZM10.9031 13.8437C10.7805 13.8554 10.4438 13.8141 10.0076 13.2583L7.64739 15.1101C8.48933 16.1832 9.73139 16.9689 11.1876 16.8302L10.9031 13.8437ZM11.7264 13.1049C11.3814 13.726 11.0452 13.8321 10.9248 13.8418L11.1659 16.8321C12.5993 16.7165 13.6916 15.745 14.3489 14.5618L11.7264 13.1049ZM14.1081 8.83041L11.7273 13.1032L14.348 14.5634L16.7288 10.2906L14.1081 8.83041ZM18.7543 5.68178C16.7184 5.57574 15.12 7.00609 14.1067 8.83292L16.7302 10.2881C17.4961 8.90717 18.2284 8.65846 18.5983 8.67772L18.7543 5.68178ZM23.0514 9.28662C22.2357 7.36903 20.7999 5.78722 18.7535 5.68174L18.5991 8.67776C18.9836 8.69759 19.678 9.02039 20.2907 10.4609L23.0514 9.28662Z"
                                fill="black" mask="url(#path-1-inside-1_93_1117)" />
                        </svg>
                        <span
                            style="margin-left: 10px;
                        font-size: 18px;
                        font-weight: bold;">Media</span>
                        <svg id="media-close" style="margin-left: auto; cursor: pointer;" width="16"
                            height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.45779 0.833283C1.99215 0.367647 1.23721 0.367647 0.771573 0.833283C0.305936 1.29892 0.305936 2.05386 0.771572 2.5195L5.82979 7.57771L0.349227 13.0583C-0.116409 13.5239 -0.116409 14.2789 0.349227 14.7445C0.814863 15.2101 1.56981 15.2101 2.03544 14.7445L7.516 9.26393L13.2074 14.9554C13.6731 15.421 14.428 15.421 14.8936 14.9554C15.3593 14.4897 15.3593 13.7348 14.8936 13.2691L9.20222 7.57771L14.4713 2.30864C14.9369 1.843 14.9369 1.08806 14.4713 0.62242C14.0057 0.156784 13.2507 0.156784 12.7851 0.62242L7.516 5.8915L2.45779 0.833283Z"
                                fill="black" />
                        </svg>
                    </div>
                    <div>
                        <form id="uploadForm" action="{{ route('media.store') }}" method="POST"
                            enctype="multipart/form-data"
                            style="display: flex; flex-direction: column; align-items: center; padding: 10px; background: linear-gradient(to bottom, #f8f9fa, #ffffff); border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 400px; margin: 16px auto;">
                            @csrf
                            <div style="width: 100%; text-align: center;">
                                <button type="button" onclick="document.getElementById('mediaInput').click();"
                                    style="background: linear-gradient(135deg, #2197D7, #1976D2);
                                               width: 220px;
                                               height: 48px;
                                               border-radius: 24px;
                                               border: none;
                                               color: #FFFFFF;
                                               font-size: 16px;
                                               font-weight: 500;
                                               cursor: pointer;
                                               transition: all 0.3s ease;
                                               box-shadow: 0 2px 4px rgba(33, 151, 215, 0.2);
                                               display: flex;
                                               align-items: center;
                                               justify-content: center;
                                               margin: 0 auto;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(33, 151, 215, 0.3)';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(33, 151, 215, 0.2)';">
                                    Upload Media
                                </button>
                            </div>

                            <input type="file" id="mediaInput" name="media" accept="image/*,video/*,audio/*"
                                style="display: none;" onchange="submitForm(event)">

                            <div id="loader"
                                style="display: none;
                                        text-align: center;
                                        margin-top: 20px;
                                        padding: 20px;
                                        background: rgba(255, 255, 255, 0.9);
                                        border-radius: 8px;
                                        width: 100%;">
                                <div
                                    style="border: 3px solid #f3f3f3;
                                            border-top: 3px solid #2197D7;
                                            border-radius: 50%;
                                            width: 40px;
                                            height: 40px;
                                            animation: spin 1s linear infinite;
                                            margin: 0 auto;">
                                </div>
                                <p
                                    style="margin-top: 15px;
                                          color: #2197D7;
                                          font-weight: 500;">
                                    Uploading...</p>
                            </div>
                        </form>
                        <div id="mediaContainer"
                            style="display: flex; flex-wrap: wrap; justify-content: center; margin-top: 10px;"></div>

                        <div id="successMessage" style="display: none; color: green; text-align: center;">
                            Media uploaded successfully!
                        </div>
                    </div>

                    <div
                        style="display: flex; justify-content: space-between; margin-top: 20px; margin-bottom:10px; font-size: 13px;">
                        <div id="imageTab"
                            style="border-bottom: 4px solid #036AB2; padding-bottom: 3px; cursor: pointer;"
                            onclick="toggleMedia('image')">Images</div>
                        <div id="videoTab" style="cursor: pointer;" onclick="toggleMedia('video')">Videos</div>
                        <div id="audioTab" style="cursor: pointer;" onclick="toggleMedia('audio')">Audio</div>
                    </div>

                    <div style="margin-left: -20px; display: flex; justify-content: space-between;">
                        <!-- Images Section -->
                        <div id="imageSection" style="margin-bottom: 10px; text-align: center; width: 100%;">
                            <div id="imageContainer"
                                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(155px, 1fr)); gap: 10px;">
                                @forelse ($media->where('type', 'image') as $image)
                                    <div class="media-container"
                                        style="position: relative; width: 155px; height: 100px;">
                                        <img src="{{ asset($image->path) }}" class="image-fluid"
                                            style="object-fit: cover; width: 100%; height: 100%; border-radius: 6px;">
                                        <button class="delete-media" data-id="{{ $image->id }}"
                                            style="position: absolute; bottom: 2px; right: 2px; background: red; color: white;
                                                   border: none; padding: 2px; border-radius: 50%; cursor: pointer;">
                                            🗑️
                                        </button>
                                    </div>
                                @empty
                                    <p style="grid-column: span 2; font-size: 14px; font-weight: bold; color: gray;">No
                                        images found</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- VIDEO SECTION -->
                        <div id="videoSection" style="display: none; width: 100%; text-align: center;">
                            <div id="videoContainer"
                                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px;">
                                @forelse ($media->where('type', 'video') as $video)
                                    <div class="media-container"
                                        style="position: relative; width: 150px; height: 120px;">
                                        <video width="100%" height="100%" controls
                                            style="border-radius: 6px; object-fit: cover;">
                                            <source src="{{ asset($video->path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <button class="delete-media" data-id="{{ $video->id }}"
                                            style="position: absolute; top: 2px; right: 2px; background: red; color: white;
                                                   border: none; padding: 1px; border-radius: 50%; cursor: pointer;">
                                            🗑️
                                        </button>
                                    </div>
                                @empty
                                    <p style="grid-column: span 2; font-size: 14px; font-weight: bold; color: gray;">No
                                        videos found</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- AUDIO SECTION -->
                        <div id="audioSection" style="display: none; width: 100%; text-align: center;">
                            <div id="audioContainer" style="display: grid; gap: 10px;">
                                @forelse ($media->where('type', 'audio') as $audio)
                                    <div class="media-container" style="position: relative; display: inline-block;">
                                        <p style="font-size: 12px; font-weight: bold; color: gray; margin-bottom:3px">
                                            {{ $audio->user->name ?? 'Unknown' }} |
                                            {{ \Carbon\Carbon::parse($audio->created_at)->format('d-M-Y h:i A') }}
                                        </p>
                                        <audio src="{{ asset($audio->path) }}" controls preload="metadata"
                                            style="width: 330px; border-radius: 6px;" controlslist="nodownload"
                                            type="audio/mp3">
                                        </audio>
                                        <button class="delete-media" data-id="{{ $audio->id }}"
                                            style="position:absolute; top:57px; right:0px; background: red; color: white; border: none; padding: 2px; border-radius: 50%; cursor: pointer;">
                                            🗑️
                                        </button>
                                    </div>
                                @empty
                                    <p style="grid-column: span 2; font-size: 14px; font-weight: bold; color: gray;">No
                                        audios found</p>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </ul>
        </li>
        <li class="inside-bar-item" id="app-btn">
            <img src="{{ asset('svg/app.svg') }}" alt="">
            <p class="inside-bar-text">App</p>
            <ul class="app-submenu" id="app-submenu">
                <li>
                    <img src="./images/google-calender.png" style="width: 70px; height: 70px;" alt=""
                        srcset="">
                    <p style="font-size: 12px; width: 100px; margin: 2px;">Google Calender</p>
                </li>
                <li>
                    <img src="./images/dropbox.png" style="width: 60px; height: 60px; margin-bottom: 12px;"
                        alt="" srcset="">
                    <p style="font-size: 12px; width: 100px;">Dropbox</p>
                </li>
            </ul>
        </li>
        <li class="inside-bar-item" id="more-btn" style="display:none">
            <img src="{{ asset('svg/more.svg') }}" alt="">
            <div class="more-wrapper">
                <p class="inside-bar-text">More</p>
                <ul class="more-submenu" id="more-submenu">
                    <li>
                        <img src="{{ asset('svg/invite-user.svg') }}" alt="">
                        <p style="font-size: 12px; width: 70px;">Invite User</p>
                    </li>
                    <li>
                        <img src="{{ asset('svg/plugins.svg') }}" alt="">
                        <p style="font-size: 12px; width: 70px;">Plugins</p>
                    </li>
                    <li>
                        <img src="{{ asset('svg/slack.svg') }}" alt="">
                        <p style="font-size: 12px; width: 70px;">Slack</p>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
