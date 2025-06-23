@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/news_feed.css') }}">
<style>
.side-bar {
    position: fixed;
    background: #0C5097;
    width: 60px !important;
    height: 650vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 8px;
    top: 0;
    z-index: 6;
}
</style>
    @include('pages.main', ['emails' => $emails])

    <div class="container-fluid" id="feed-content" style="position: absolute; top: 160px; left: 60px; width: 95%;">
        <div class="row">
       <div class="col-md-4 p-4">
           <div class="row">
                    <div class="col-lg-12 p-3 rounded" style=" background-color:#F4F4F4">
                <div style="display: flex; justify-content: space-between; align-items: baseline;">
                    <div class="mb-3" style="display: flex; gap: 5px; align-items: center; ">
                        <div>
                            <p class="m-0" style="font-weight: 600; font-size: 18px; ">Feed</p>
                        </div>
                        <div>
                            <button type="button" class="btn p-0 px-2 " style="background: #0C5097; color:white"
                                data-bs-toggle="modal" data-bs-target="#newsModal">+</button>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: end; ">
                <div style="position: relative; width: 80%;">
    <input type="text" id="searchInput" placeholder="Search news..."
        style="padding: 5px 35px 5px 10px; border: 1px solid #ddd; border-radius: 4px; width: 100%;">

    <svg width="16" height="22" viewBox="0 0 22 22" fill="none"
        xmlns="http://www.w3.org/2000/svg"
        style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
        <path fill-rule="evenodd" clip-rule="evenodd"
            d="M9.87556 1.76C5.39346 1.76 1.76 5.39346 1.76 9.87556C1.76 14.3577 5.39346 17.9911 9.87556 17.9911C12.0691 17.9911 14.0594 17.1208 15.52 15.7067C15.5459 15.6717 15.5747 15.6381 15.6064 15.6064C15.6381 15.5747 15.6717 15.5459 15.7067 15.52C17.1208 14.0594 17.9911 12.0691 17.9911 9.87556C17.9911 5.39346 14.3577 1.76 9.87556 1.76ZM17.4533 16.2088C18.8877 14.4943 19.7511 12.2858 19.7511 9.87556C19.7511 4.42144 15.3297 0 9.87556 0C4.42144 0 0 4.42144 0 9.87556C0 15.3297 4.42144 19.7511 9.87556 19.7511C12.2858 19.7511 14.4943 18.8877 16.2088 17.4533L20.4977 21.7423C20.8414 22.0859 21.3986 22.0859 21.7423 21.7423C22.0859 21.3986 22.0859 20.8414 21.7423 20.4977L17.4533 16.2088Z"
            fill="#0C5097" />
    </svg>
</div>

                        {{-- <div>
                            <svg width="16" height="26" viewBox="0 0 26 26" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M13 1.8803C12.6678 1.8803 12.3492 2.01226 12.1143 2.24716C11.8794 2.48206 11.7474 2.80065 11.7474 3.13285V3.32298C11.7453 3.85912 11.5864 4.38293 11.2904 4.82994C10.9944 5.27695 10.5741 5.62764 10.0813 5.83885C9.99694 5.875 9.90792 5.89854 9.81709 5.90886C9.3649 6.07028 8.87709 6.11085 8.40237 6.02477C7.86188 5.92677 7.36314 5.66911 6.97047 5.285L6.96306 5.27775L6.89732 5.21193C6.78099 5.09547 6.64248 5.00271 6.49042 4.93968C6.33836 4.87665 6.17537 4.8442 6.01077 4.8442C5.84616 4.8442 5.68317 4.87665 5.53112 4.93968C5.37906 5.00271 5.24092 5.0951 5.12459 5.21156L5.12385 5.2123C5.00739 5.32863 4.915 5.46677 4.85197 5.61882C4.78894 5.77088 4.75649 5.93387 4.75649 6.09848C4.75649 6.26308 4.78894 6.42607 4.85197 6.57813C4.915 6.73019 5.00739 6.86833 5.12385 6.98466L5.19733 7.05814C5.58144 7.45081 5.83906 7.94959 5.93706 8.49008C6.0333 9.02081 5.97124 9.56791 5.75897 10.0633C5.56665 10.5693 5.22914 11.0074 4.78852 11.3226C4.33984 11.6435 3.80499 11.822 3.25351 11.8349L3.23152 11.8352H3.13285C2.80065 11.8352 2.48206 11.9671 2.24716 12.202C2.01226 12.4369 1.8803 12.7555 1.8803 13.0877C1.8803 13.4199 2.01226 13.7385 2.24716 13.9734C2.48206 14.2083 2.80065 14.3403 3.13285 14.3403H3.32298C3.85912 14.3424 4.38293 14.5013 4.82994 14.7973C5.27554 15.0924 5.62543 15.511 5.83685 16.0018C6.05701 16.5031 6.12247 17.0588 6.02477 17.5976C5.92677 18.1381 5.66911 18.6369 5.285 19.0295L5.27775 19.0369L5.21192 19.1027C5.09547 19.219 5.00271 19.3575 4.93968 19.5096C4.87665 19.6616 4.8442 19.8246 4.8442 19.9892C4.8442 20.1538 4.87665 20.3168 4.93968 20.4689C5.00271 20.6209 5.0951 20.7591 5.21156 20.8754L5.2123 20.8762C5.32862 20.9926 5.46676 21.085 5.61882 21.148C5.77088 21.2111 5.93387 21.2435 6.09848 21.2435C6.26308 21.2435 6.42607 21.2111 6.57813 21.148C6.73019 21.085 6.86833 20.9926 6.98466 20.8762L7.05814 20.8027C7.45081 20.4186 7.94959 20.1609 8.49008 20.0629C9.02082 19.9667 9.56793 20.0288 10.0633 20.241C10.5693 20.4334 11.0074 20.7709 11.3226 21.2115C11.6435 21.6602 11.822 22.195 11.8349 22.7465L11.8352 22.7685V22.8671C11.8352 23.1993 11.9671 23.5179 12.202 23.7528C12.4369 23.9877 12.7555 24.1197 13.0877 24.1197C13.4199 24.1197 13.7385 23.9877 13.9734 23.7528C14.2083 23.5179 14.3403 23.1993 14.3403 22.8671V22.6808L14.3403 22.677C14.3424 22.1409 14.5013 21.6171 14.7973 21.1701C15.0924 20.7244 15.511 20.3745 16.0019 20.1631C16.5032 19.943 17.0588 19.8775 17.5976 19.9752C18.1381 20.0732 18.6369 20.3309 19.0295 20.715L19.0369 20.7222L19.1027 20.7881C19.219 20.9045 19.3575 20.9973 19.5096 21.0603C19.6616 21.1234 19.8246 21.1558 19.9892 21.1558C20.1538 21.1558 20.3168 21.1234 20.4689 21.0603C20.6209 20.9973 20.7591 20.9049 20.8754 20.7884L20.8762 20.7877C20.9926 20.6714 21.085 20.5332 21.148 20.3812C21.2111 20.2291 21.2435 20.0661 21.2435 19.9015C21.2435 19.7369 21.2111 19.5739 21.148 19.4219C21.085 19.2698 20.9926 19.1317 20.8762 19.0153L20.8027 18.9419C20.4186 18.5492 20.1609 18.0504 20.0629 17.5099C19.9652 16.9711 20.0307 16.4153 20.2509 15.914C20.4623 15.4232 20.8122 15.0047 21.2578 14.7096C21.7048 14.4136 22.2286 14.2547 22.7647 14.2526L22.7685 14.2525L22.8671 14.2525C23.1993 14.2525 23.5179 14.1206 23.7528 13.8857C23.9877 13.6508 24.1197 13.3322 24.1197 13C24.1197 12.6678 23.9877 12.3492 23.7528 12.1143C23.5179 11.8794 23.1993 11.7474 22.8671 11.7474H22.6808L22.677 11.7474C22.1409 11.7453 21.6171 11.5864 21.1701 11.2904C20.7231 10.9944 20.3724 10.5741 20.1612 10.0813C20.125 9.99694 20.1015 9.90792 20.0911 9.8171C19.9297 9.36491 19.8891 8.87709 19.9752 8.40237C20.0732 7.86188 20.3309 7.36315 20.715 6.97047L20.7222 6.96306L20.7881 6.89732C20.9045 6.78099 20.9973 6.64248 21.0603 6.49042C21.1234 6.33836 21.1558 6.17537 21.1558 6.01077C21.1558 5.84617 21.1234 5.68317 21.0603 5.53112C20.9973 5.37906 20.9049 5.24092 20.7884 5.12459L20.7877 5.12385C20.6714 5.00739 20.5332 4.915 20.3812 4.85197C20.2291 4.78894 20.0661 4.75649 19.9015 4.75649C19.7369 4.75649 19.5739 4.78894 19.4219 4.85197C19.2698 4.91501 19.1317 5.00739 19.0153 5.12385L18.9419 5.19733C18.5492 5.58144 18.0504 5.83906 17.5099 5.93706C16.9711 6.03476 16.4154 5.96931 15.9141 5.74916C15.4233 5.53775 15.0047 5.18785 14.7096 4.74223C14.4136 4.29523 14.2547 3.77141 14.2526 3.23527L14.2525 3.23152V3.13285C14.2525 2.80065 14.1206 2.48206 13.8857 2.24716C13.6508 2.01226 13.3322 1.8803 13 1.8803ZM10.7847 0.91759C11.3723 0.330067 12.1691 0 13 0C13.8309 0 14.6277 0.330067 15.2153 0.91759C15.8028 1.50511 16.1328 2.30197 16.1328 3.13285V3.22926C16.1338 3.39818 16.184 3.56317 16.2773 3.70403C16.3708 3.8453 16.5037 3.95613 16.6594 4.02288L16.6687 4.02685C16.8275 4.09695 17.0036 4.1179 17.1745 4.08693C17.3439 4.05621 17.5004 3.97583 17.624 3.85605L17.685 3.79502C17.976 3.50373 18.3215 3.27266 18.7018 3.115C19.0821 2.95734 19.4898 2.87619 19.9015 2.87619C20.3132 2.87619 20.7209 2.95734 21.1012 3.115C21.4815 3.27266 21.8271 3.50374 22.118 3.79502C22.4089 4.08582 22.6398 4.43107 22.7973 4.81107C22.9549 5.19139 23.0361 5.59906 23.0361 6.01077C23.0361 6.42247 22.9549 6.83014 22.7973 7.21046C22.6397 7.59062 22.4088 7.93601 22.1176 8.22689L22.0562 8.28833C21.9364 8.41196 21.8561 8.56841 21.8254 8.73783C21.7944 8.90865 21.8153 9.08482 21.8854 9.24364C21.9158 9.31247 21.9377 9.3845 21.9508 9.45817C22.0164 9.56334 22.1041 9.65371 22.2083 9.72272C22.3491 9.816 22.5141 9.86619 22.683 9.86715H22.8671C23.698 9.86715 24.4949 10.1972 25.0824 10.7847C25.6699 11.3723 26 12.1691 26 13C26 13.8309 25.6699 14.6277 25.0824 15.2153C24.4949 15.8028 23.698 16.1328 22.8671 16.1328H22.7707C22.6018 16.1338 22.4368 16.184 22.296 16.2773C22.1547 16.3708 22.0439 16.5037 21.9771 16.6594L21.9731 16.6687C21.9031 16.8275 21.8821 17.0036 21.9131 17.1745C21.9438 17.3439 22.0241 17.5003 22.1439 17.624L22.205 17.685C22.4963 17.976 22.7273 18.3215 22.885 18.7018C23.0427 19.0821 23.1238 19.4898 23.1238 19.9015C23.1238 20.3132 23.0427 20.7209 22.885 21.1012C22.7274 21.4814 22.4965 21.8268 22.2054 22.1176C21.9145 22.4088 21.5691 22.6397 21.1889 22.7973C20.8086 22.9549 20.4009 23.0361 19.9892 23.0361C19.5775 23.0361 19.1699 22.9549 18.7895 22.7973C18.4094 22.6397 18.064 22.4088 17.7731 22.1176L17.7117 22.0563C17.5881 21.9365 17.4316 21.8561 17.2622 21.8254C17.0914 21.7944 16.9152 21.8153 16.7564 21.8854L16.7471 21.8895C16.5914 21.9562 16.4585 22.067 16.365 22.2083C16.2717 22.3491 16.2215 22.5141 16.2206 22.683V22.8671C16.2206 23.698 15.8905 24.4949 15.303 25.0824C14.7154 25.6699 13.9186 26 13.0877 26C12.2568 26 11.46 25.6699 10.8724 25.0824C10.2849 24.4949 9.95486 23.698 9.95486 22.8671V22.7815C9.94908 22.6104 9.89288 22.4447 9.7932 22.3053C9.69178 22.1635 9.55005 22.0555 9.38643 21.9954C9.36784 21.9885 9.34947 21.9811 9.33135 21.9731C9.17253 21.903 8.99636 21.8821 8.82554 21.9131C8.65611 21.9438 8.49966 22.0242 8.37603 22.1439L8.31497 22.205C8.02408 22.4961 7.67833 22.7274 7.29817 22.885C6.91785 23.0427 6.51018 23.1238 6.09848 23.1238C5.68677 23.1238 5.2791 23.0427 4.89878 22.885C4.51878 22.7275 4.17353 22.4967 3.88272 22.2057C3.59144 21.9148 3.36037 21.5692 3.20271 21.1889C3.04505 20.8086 2.9639 20.4009 2.9639 19.9892C2.9639 19.5775 3.04505 19.1699 3.20271 18.7895C3.36037 18.4092 3.59144 18.0637 3.88272 17.7727L3.94381 17.7117C4.06356 17.588 4.14392 17.4316 4.17464 17.2622C4.20561 17.0914 4.1847 16.9152 4.11461 16.7564L4.11054 16.7471C4.04379 16.5914 3.93301 16.4585 3.79174 16.365C3.65088 16.2717 3.48588 16.2215 3.31696 16.2206H3.13285C2.30197 16.2206 1.50511 15.8905 0.91759 15.303C0.330067 14.7154 0 13.9186 0 13.0877C0 12.2568 0.330067 11.46 0.91759 10.8724C1.50511 10.2849 2.30197 9.95486 3.13285 9.95486H3.21854C3.38964 9.94908 3.5553 9.89288 3.69466 9.7932C3.83646 9.69178 3.94447 9.55005 4.00464 9.38643C4.01148 9.36784 4.0189 9.34947 4.0269 9.33135C4.097 9.17253 4.1179 8.99635 4.08693 8.82554C4.05621 8.65612 3.97585 8.49967 3.85609 8.37604L3.79502 8.31497C3.50374 8.02401 3.27266 7.67849 3.115 7.29817C2.95734 6.91785 2.87619 6.51018 2.87619 6.09848C2.87619 5.68677 2.95734 5.2791 3.115 4.89878C3.27259 4.51862 3.50354 4.17323 3.79465 3.88235C4.08553 3.59125 4.43091 3.3603 4.81107 3.20271C5.1914 3.04505 5.59906 2.9639 6.01077 2.9639C6.42247 2.9639 6.83014 3.04505 7.21046 3.20271C7.59078 3.36037 7.9363 3.59144 8.22726 3.88272L8.28835 3.94381C8.41197 4.06356 8.56841 4.14392 8.73783 4.17464C8.90865 4.20561 9.08482 4.1847 9.24364 4.11461C9.31247 4.08423 9.38451 4.06231 9.45819 4.04917C9.56335 3.98357 9.65372 3.89593 9.72272 3.79174C9.816 3.65088 9.86619 3.48588 9.86715 3.31696V3.13285C9.86715 2.30197 10.1972 1.50511 10.7847 0.91759ZM13 10.6511C11.7027 10.6511 10.6511 11.7027 10.6511 13C10.6511 14.2973 11.7027 15.3489 13 15.3489C14.2973 15.3489 15.3489 14.2973 15.3489 13C15.3489 11.7027 14.2973 10.6511 13 10.6511ZM8.7708 13C8.7708 10.6643 10.6643 8.7708 13 8.7708C15.3357 8.7708 17.2292 10.6643 17.2292 13C17.2292 15.3357 15.3357 17.2292 13 17.2292C10.6643 17.2292 8.7708 15.3357 8.7708 13Z"
                                    fill="#0C5097" />
                            </svg>
                        </div> --}}
                    </div>
                </div>
                <div class="feed rounded " id="newsFeed" style="overflow-y: auto; max-height: 370px;">
                    <div >
                        @if (isset($allArticles['error']))
                            <div style="color: red; text-align: center; font-size: 16px; font-weight: bold; padding: 10px;">
                                {{ $allArticles['error'] }}
                            </div>
                        @else
                            @foreach ($allArticles as $article)
                                <div class="article-container rounded "
                                    style="display: flex; margin-bottom: 20px; cursor: pointer; position: relative;background-color:white;"
                                    onclick="displayNewsDetails({{ json_encode($article) }})">
                                    <div
                                        style="display: flex; align-items: center;border: 1px solid white; border-radius: 5px; padding: 10px; background: white;">
                                        <img src="{{ $article['urlToImage'] ?? asset('images/default-news.webp') }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 20px;"
                                            alt="News Image">
                                    </div>
                                    <div style="padding-left: 5px;padding-right: 5px;">
                                        @if (isset($article['publishedAt']))
                                            <p style="font-size: 12px; margin-bottom: 3px; color: #A2A2A2;">
                                                {{ \Carbon\Carbon::parse($article['publishedAt'])->format('d-M-Y h:i A') }}
                                            </p>
                                        @endif
                                        <p style="font-size: 13px; margin-bottom: 0;">
                                            {{ $article['title'] ?? 'No Title Available' }}
                                        </p>
                                        <a href="{{ $article['url'] ?? '#' }}" target="_blank"
                                            style="font-size: 12px; color: #0C5097 !important;">Read more</a>
                                    </div>
                                    @if (isset($article['user_id']))
                                        <div class="article-actions">
                                            <a href="javascript:void(0)" style="text-decoration: none;" class="edit-icon"
                                                title="Edit" data-bs-toggle="modal" data-bs-target="#editNewsModal"
                                                data-id="{{ $article['id'] }}" data-title="{{ $article['title'] }}"
                                                data-source="{{ $article['source'] }}"
                                                data-content="{{ $article['content'] }}" data-url="{{ $article['url'] }}"
                                                data-description="{{ $article['description'] }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="delete-icon" title="Delete"
                                                data-id="{{ $article['id'] }}">
                                                <i class="fas fa-trash" style="color: red;"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
           </div>
       </div>
             <div class="col-lg-8 p-4"  >
              <div class="row">
                  <div class="col-md-12 rounded" id="news-details" style="padding: 9px 22px;background-color:#F4F4F4 ; ">
                        <p style="font-size: 14px; color: gray; text-align: center;">Click on a news item to see the details.</p>
              </div>
                  </div>
              </div>
        </div>
    </div>

    <!-- Add News Modal -->
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

    <!-- Edit News Modal -->
    <div class="modal fade" id="editNewsModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('news-feed.update', ['news_feed' => '__id__']) }}" method="POST"
                        enctype="multipart/form-data" id="editNewsForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="news_id" id="newsId">
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="newsTitleInput" class="form-label">Title</label>
                                <input type="text" class="form-control" id="newsTitleInput" name="title" required>
                            </div>
                            <div class="col-md-6">
                                <label for="newsSourceInput" class="form-label">Source</label>
                                <input type="text" class="form-control" id="newsSourceInput" name="source" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newsContentInput" class="form-label">Content</label>
                            <textarea class="form-control" id="newsContentInput" name="content" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="newsDescriptionInput" class="form-label">Description</label>
                            <textarea class="form-control" id="newsDescriptionInput" name="description" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="newsUrlInput" class="form-label">Url</label>
                            <input type="text" class="form-control" id="newsUrlInput" name="url"
                                required></input>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="updateNoteButton">Update News</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/feed.js') }}"></script>
@endpush
