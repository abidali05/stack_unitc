@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/project.css') }}">
    @include('pages.main', ['emails' => $emails])

    <div class="container-fluid" id="project-content" style="position: absolute; top: 185px; left: 60px; width: 95%;">
        <div class="row">
            <div class="col-lg-5 col-md-4  p-3">
                <div class="row">
                    <div class="col-md-12 rounded p-3" style="background-color:#F4F4F4;">
                        <div style="display: flex;margin-bottom: 15px;justify-content: space-between;">
                            <div>
                                <p style="color: #0C5097;font-weight: bold;font-size: 18px;">Projects Overview</p>
                            </div>
                            <div>
                                <button type="button" class="btn" style="background: #0C5097; color:white"
                                    data-bs-toggle="modal" data-bs-target="#projectModal">+</button>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-lg-6">
                                <div style="border: 0.73px solid #0B9F2A; border-radius: 5px;">
                                    <div class="row" style="padding: 5px;">
                                        <div class="col-lg-8">
                                            <div>
                                                <p style="font-size: 12px; margin-bottom: 0px;color: #10AA2E;">Completed
                                                    Task
                                                </p>
                                            </div>
                                            <div>
                                                <p id="completedProjectsCount"
                                                    style="font-size: 20px;font-weight: bold;color: #10AA2E; margin-bottom: 0px;">
                                                    {{ $completedProjects }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"
                                            style="display: flex;
                                            align-items: center;
                                            justify-content: center;">
                                            <svg width="40" viewBox="0 0 51 51" fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <rect x="0.136719" y="0.355225" width="50.1475" height="50.1475"
                                                    fill="url(#pattern0_246_331)" />
                                                <defs>
                                                    <pattern id="pattern0_246_331" patternContentUnits="objectBoundingBox"
                                                        width="1" height="1">
                                                        <use xlink:href="#image0_246_331" transform="scale(0.0175439)" />
                                                    </pattern>
                                                    <image id="image0_246_331" width="57" height="57"
                                                        xlink:href="data:image/png;base64,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" />
                                                </defs>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" style="margin-left: -10px;">
                                <div style="border: 0.73px solid #FF6C1C; border-radius: 5px;">
                                    <div class="row" style="padding: 5px;">
                                        <div class="col-lg-8">
                                            <div>
                                                <p style="font-size: 12px; margin-bottom: 0px;color: #FF6C1C;">Task in
                                                    progress
                                                </p>
                                            </div>
                                            <div>
                                                <p id="inProgressProjectsCount"
                                                    style="font-size: 20px;font-weight: bold;color: #FF6C1C; margin-bottom: 0px;">
                                                    {{ $inProgressProjects }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"
                                            style="display: flex;
                                align-items: center;
                                justify-content: center;">
                                            <svg width="40" viewBox="0 0 52 53" fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <rect x="0.404297" y="0.628418" width="51.6011" height="51.6011"
                                                    fill="url(#pattern0_246_334)" />
                                                <defs>
                                                    <pattern id="pattern0_246_334" patternContentUnits="objectBoundingBox"
                                                        width="1" height="1">
                                                        <use xlink:href="#image0_246_334" transform="scale(0.0175439)" />
                                                    </pattern>
                                                    <image id="image0_246_334" width="57" height="57"
                                                        xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADkAAAA5CAYAAACMGIOFAAAJT0lEQVRoBc2a+5PdNhXHVVby3ZR3C4XyKqU04f1MKUN4hPJqm2azltdhaAlkKBSaTmgIFChtNvvXMkyZZG1vyq/LfOR7vGd1ZV+v76bpnfFIlo6k8z06L8nXmLvw279s1u9smI9Vm7PH9vLsK/s75j0sU3v33aaYneep/dq5Krc/a7bsD2rvntgrsy/9rzzxyf9cMu+9Cywdz5QAq8r1R5st+71qy/5cP/8+b+5nld3cfV1ADpXVlv0Jwrn1gvnA8XC34iwwcrvIvsauaGC6XpfmAZZp8tnJIXCpvv3SrK3I4vThb5XmfbuF+6YG01d/25uHWel2uf6ZFJDeNm/PTOdwhZHY116efXFo5xbAluuPsuReaT7aC2huq7r/7Y37P7ECq9OH7r9kXOXtTxeARHao+xEKK7L7GsRQHSGKw5rO7RFG7htzX5ObB/fPGsuwO6X5uAbRV9/L7Y92N9039nLzEOOYpzpnPry7aT7EfOxUXc4+X226byO4Q6Dz2ckjsLgaKYaPp9vdsmexQRhlxqacnUqBa3L7/cqvf45dO+rKjAE0Hnr/GTM76vhJ9KjLnQvZVwNAQG7ZszDBZIAlvnVAC3e6OW8+IkKYtOC9GNQU2Rc0QKmjrgFoaTLCB6p3L/hbec1b/sSnBFRc7nn7Q4L/yovcywkI8MFpzFU0Bsn7uyYbmSIoHE1duCdTwGgDPPFuytzvmjEk1X0AaV/F/hAgYYMM6B2NgVq6uPAhNZX0TI8ZWw/Jubd/r322w9Pk9m84trHjj42OwN23i8TFqQuhHQLuUFnY7Xc0ddsvTdYHEBtd5TRQe3epBWdv1JvuO423Z2pvb9JWFVkxVXiTxv13w7y/LmaPk7VowAT5ZROSrtXF2rONdy/WPnueJEISgzp3fwmAfPZLmWdOt1N590fayHBILOrcvVLn7s+Nn23cLs0Hhf7Yy/akYR7CjniWLRBy2cL+85Aqtrt0ERuXdkDIXOSpbbu9WRf2F7V3V4VOSuz22ICSa1aFO73r1x/ZL80JYWRsKbvSMueuVN6+Lox2ZWG3dehBMHVht7v+uUOqvbvSePd7aW+KbHMsH710koOSFMuDqsHEGDdP5tMx5LOchZB+U7jfdu09nhTTCOrJrnv7OtcesqYIrins9V7mx3aEM54CKEApsdFl87DzAqbeXHtG07enCvOA2Kbu03XsUcDRTr3K3Z/CvIV7VdNOqhP7NDBdl/Pjsok7hry9yRXHMvpl/eTGneD82rll9Ev7iWEamNQ5Oy4dPCcAmLKv58eO66NruqTBXTuWK0oOxAJMl4DvYyLVLjbIrqb6uVeFBgBNYV+r8+yF1Bpcr3S7mNunU3Mta0PdievMRfw3lXff0uCkLmfGoQmDg/H2DB5QBfeLegz2eBAu2pSuA+GznV1vf6zpqRMnWxr7Zl1kvyLEaM8c08v7HFwWbBw7nz/trXbC8RDcZXCq5HKq9vZNzXDt7Q1uwTU9twdCgwfdzTNf5Vmpx8pFl4xDu2TMQWlv7BXZl4UmVQaQClwHUnYuLvGMqYloo6/y9l/CAMw33l0mzsZjJNshsHOBJf1cbkk8rXL3B2mXkovokA7OsyXWYs2hOI7WCDBdmhicvA8ZPCreASzcaWEsLjlYCx3fPOJ+0kDpH/Lk5LtCN7Sbxwqy/UjT2pfenRgEOa8wR0YV95MfS39wEDHB/H13c/2zQjfk9Y8VpD46hRSscE/ysYdFNJ/sTlXYN2CwKdzvsBnpp0+yncbbv0q7lHhGMq/w5auw1wXkkAPqBcnnNJJwUiycBg4HfZbFUiWTYYOysJSVdy/FNsNpQvqxMc6lIZy0p5VwgK5y+5ReJ5yGUgm7n21ourje63hiwrHv5Kzz0HHjAAQn/rXn9Bx8tjsICYshhKMWu6bHND7L9Zw4L0xEa4Kml3qIjSnvCkGQwGWzTtzD6926cOLTQ2ohk4axZ43l3gcPCWMp1cOJVUV2UWJpAFDY7SbPLqS0Bk/czuVejAWg147rmID2qlI3fDsMpw5OHuo5ynUHEkRVA2OFfS1eXN4D2M3ZY8F+B450nDyCILy7OuSQZF4pQ4aT2kncvAan6ykpy4S61F6Sz+S6b0qdI1cLMtshzIydo0vlIqAGSWlguj72+lECfu3dtbGCGWK89cruZYBWuf3HEG2qL3hZ8lfUl9yVH2mVBif1VAKdmlRsjRxV+oltwYEU2a+D00h4bNS3zu3TOB+Sd9I5Ga/zXWkbKgMggEVhrBvDtaAAi8s4JHSDVEXiXZvquSdgvFO3g2uNq/r7CTue8ro4qFZd27y4KtzLaqlkFTUl7MgDz+zgIW/M4jE4eR9zCObL1iIo7MluHziRbAfbFS6Jzwdj3JUqcRFGf5y8y3hdAkoAxuWhncXjCbC4lL+o6InjOvmlJNyB+dy9goYgzbpwr7aA3CUZ18ZY7l3tG9CEK83c/eZA9e31oTxV5ol3UYNc0ELsIwYn75wIDklEVohK7AJg8cdY7mEByW4BJtiid9fmwK/oadAqGB21njH3MZcGpusIQM8d6jgLAaZLJJocsDBDuoHPDy0gMh5uztvbc9q0CqdH97eKQDQwqS/sokxDBx5OA+SjTO8AGbikZFdEPQ/AAthdmio8Ar8ASpWHnE7Mn/a0JO2SVsEMCfwY+4znlPdwesHzFmvP4lDGqKSM1SVmkQImbdqL63FdHTAwgOqKlHHH4X9z5ewUwFcB2i00sYJgBEyq5NZilPAEHHygquFvJ+XsFPlsePLZyXv5OX3QFuf/NRotQyQV/vQn4KKSE8soqY1eMU0ou6c1COHHOzkppQy36xGwbjfn7ctOFGm2x7fCOMLEV/D0AZ3sHPFQnC1jYKl3nFKXDI/H0EuJw+MYKOB0KYDYYUDzrKRRAAVACthC2/xjLQtOWRRfQHAnmdCgFur8sSKR8PdKbGwHCy+AilRZVAmnhHcOwsnNg7wj/ZA0c/yZH4E0o0uBzdW1AwzQvhPHWFApOqRMrEuBDTF1vii2DMgxjzDKdUsHIAYUvfP/di2gFK8rtaFSLBIDhUEmZpfGgBMaCdzcLy0F6c3D0IlgVgIyZjDMaaeEO2ccTAiAMaXEW1R9CCS3FJJ9jeHvWGmwtaA+E1QVIcitoJxgYqAB3N1wMqtIgUP2mB0UGv6NKevxuRCQlEEto/tYoTtq+X8fjwTOctVtMAAAAABJRU5ErkJggg==" />
                                                </defs>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-lg-6">
                                <div style="border: 0.73px solid #F12117; border-radius: 5px;">
                                    <div class="row" style="padding: 5px;">
                                        <div class="col-lg-8">
                                            <div>
                                                <p style="font-size: 12px; margin-bottom: 0px;color: #F12117;">Overdue Task
                                                </p>
                                            </div>
                                            <div>
                                                <p id="overdueProjectsCount"
                                                    style="font-size: 20px;font-weight: bold;color: #F12117; margin-bottom: 0px;">
                                                    {{ $overdueProjects }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"
                                            style="display: flex;
                                align-items: center;
                                justify-content: center;">
                                            <svg width="40" viewBox="0 0 52 52" fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <rect x="0.409668" y="0.212891" width="50.8743" height="50.8743"
                                                    fill="url(#pattern0_246_337)" />
                                                <defs>
                                                    <pattern id="pattern0_246_337" patternContentUnits="objectBoundingBox"
                                                        width="1" height="1">
                                                        <use xlink:href="#image0_246_337" transform="scale(0.0175439)" />
                                                    </pattern>
                                                    <image id="image0_246_337" width="57" height="57"
                                                        xlink:href="data:image/png;base64,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" />
                                                </defs>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" style="margin-left: -10px;">
                                <div style="border: 0.73px solid #C2692E; border-radius: 5px;">
                                    <div class="row" style="padding: 5px;">
                                        <div class="col-lg-8">
                                            <div>
                                                <p style="font-size: 12px; margin-bottom: 0px;color: #C2692E;">Task on Hold
                                                </p>
                                            </div>
                                            <div>
                                                <p id="holdProjectsCount"
                                                    style="font-size: 20px;font-weight: bold;color: #C2692E; margin-bottom: 0px;">
                                                    {{ $holdProjects }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"
                                            style="display: flex;
                                            align-items: center;
                                            justify-content: center;">
                                            <svg width="40" viewBox="0 0 52 53" fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <rect x="0.131348" y="0.486328" width="51.6011" height="51.6011"
                                                    fill="url(#pattern0_246_340)" />
                                                <defs>
                                                    <pattern id="pattern0_246_340" patternContentUnits="objectBoundingBox"
                                                        width="1" height="1">
                                                        <use xlink:href="#image0_246_340" transform="scale(0.0175439)" />
                                                    </pattern>
                                                    <image id="image0_246_340" width="57" height="57"
                                                        xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADkAAAA5CAYAAACMGIOFAAAGjElEQVRoBc1a224cNRgeDuIoCCCOotCShmRtT6JCCKcWaKhaQdpSIOGQStwgwV3o2t40XKFIPAHPwGUvkOABeAokys7MBlVCvEXR581Mdz2/vZ7Z2QyRolnb/9j/Z/9nTxTN4O/P60uPpLvs5VTGryU98X6mxEeZFlupFtupFFcTyb5EO5Picr8Xn010Z/UvuTz/b2/l4Rmw09yUN/Xik6kWa4lmHwNI3X8AH3T5qXRvfq457qaY6fZ+dDdOIFXxpbqgfO8lUnyQqPiF21F01xRs1nsVix70ll7qS37Fx2RjYz128aZcfL4etzXeghhlmp1vDEAF0c40e3fmegtjkij2RTBALbZhdAay8x70ta/4K6nsLPe77NVM8tcTJdarSgMMFkS4xvn4X4HuJSp+OwTcoRVd619fOfbHPr/PP/NwdLB/4oFMs+P9buetTPLPQ9bBRjWmq2A0VfzcpIUTzT9Mv+MvYkNCgLloft8/ey+MGazspDVTzc9Mu14EgLBwvsUgjrMwCrlxS3X8qW99iHxtoHhx0gnCn93+LLrHdSpN9GOjBz3+hhdoV5yuJbpeHVRi86DLnmsCROgcg27nhE9fseGhcxm6YUhGRy2whv2dhUcrTdgQMaIqY9gcbidYbeAHXW4CAP/5dvWhhniuNc2ge+oxF1D035LHHvRODLl2OnolNts6QZvp/s7CU66DgJrZ9GNthGouBT9qHRxjjGj0d+OTLl6za/EzxCtRBGvqij4qKzW5QvOdLuOYyfgCuZrJJgiFhh+ctZsgGQroHEZKYos6UVLyXOlSsMUKYGoWJKnqLFIgESSMrWcSXuIUEaqNEQY2smtLS5kS3ySSfdLfWbjf9xqqCKgUpIp/jbDQR0uNQc3IRF2L7TFPgAyB2o06ixofq/gvqWK/mX8pfqCYQ5+x5or/dIeW34DldNG7+g+6MaP472vBi3eonYDPqRMTZpp9VTB9CNR1mlAFm7aO9EA3jTRY0lgYIFN0sgbNrmixVuxChR8QU5txV6I7LJ0cnni+IZJfqbBcQWpyVgsHgCOriVwhHPLBYoYKP9oC6TJAxsqibFiSZy22QxNeG39rIPfm50o4pLgKIxihLmoPwjfazIe22wIJI0aGelA7ALJBQr5DQdl0bYEEH6liGzYW4y/JiL6m0cFCbYKkjA8Sjigv3Y/uAKpq9gmFttsEmXTF6VEc5rdiG1Gp05jhznIoKJuuTZADxd608aAgFlFOFOU+m/nQdpsgUb2zQUJPI0onUfgNBWXTtQkSN2Q2SKOTVH2zFMHbSDztNkFSmZTxFBR6JM8eHN6htkAaP4lsxg7tdGc1wgWoPYA2gl4vGsdgWyBvSfEEhQPhXuSsCGh23IHD290WSFe6lfRWno6QIVA7gMsXLxrHYFsgqWo/wryidEMZH1SrTZriAOPqNhuWJ8x4av6rK9gf7PJn7bSsyAFdCxD9qABQQQ2AF+Tmjt5SWDALUS6IAn+YRFjyGyPMd32vZlr8eIeW/1znWwHceVLSaDKQfHFMTBJJcRlWK6cLfSKHQ30nk/ydSdUFnDJ2HBb97++XHw9dI6eDtKVKbNr8I8gpVSRcV3QoOOcT/h+fSY/FNkC0scElfnFFTRHjftClU6VJjrgDRtN104UKZIkdiGXaYxcpoLgfLL3QcscwSRbrFL/eiG1oNOgrO9wPtoxrbHmUGymAsLIIDMaI7QY+I6FehliQImBPcARtFNlIlwEPEZLwGznHd3CES0HGgvvBI8DhXAI3Vi49hIUOth9OIwSrpcVWnSq3k+sKAzhBF0C4jMqShsSZOk30IVzC/WAF/qYihZExOnj4lSXF15jjD13NWFsq0x4RY9wP1s1WQvmA+sBaUsDyPmRSofOV6MyN0YQFTGVBdRYnRTalySd0IJKBo3eJZw4QiQQOZMJ0/mEDlKqCjZwoFsSlEdKdaU/WBNuIRYlQLQeWP3GCUwPM4WMiVxCfL5g/YQBM/ROXo3vzc5OYwDj8mskH8XmbR+9G16ilgzkg3xPBAlX4yhennqZ0r9gGgKMuasqGmp8xZRcVX6KqhdQ8eR/cRGUr6gNFjeE7GdcHCTkjM3nihLVYC/aDFPNV+4ZOOb4wE0C2viuxPjFUqwqgCr3JHWGBA3SpyoZAjJEuzVw0q4CFVYTDRvmiqp7l4If6y8/BqJQS3irMHAUtfBxOGMxCj+DMzedsim2YehKemp03xgglUdVZRFWtKDo1zOR/vug05P0Gli0AAAAASUVORK5CYII=" />
                                                </defs>
                                            </svg>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row d-none" style="margin-top: 16px; margin-left:0px" id="dropdown">
                            <select class="form-select" id="projectDropdown">
                                @foreach ($projects->unique('project_name') as $project)
                                    <option value="{{ $project->project_name }}">{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 p-3">
                <div class="row">
                    <div class="col-md-12 p-4 rounded d-flex align-items-center"
                        style="background-color:#F4F4F4 ;height:225px">
                        <canvas id="project-bar-chart" width="400" height="100"
                            style="height: 100%; width: 100%;"></canvas>

                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-3 rounded" style="background-color: #F4F4F4; padding: 15px;">
            <div class="d-flex flex-wrap justify-content-between align-items-end w-100">
                {{-- Left Side Filters --}}
                <div class="d-flex flex-wrap align-items-end gap-3">
                    {{-- Project Filter --}}
                    <div class="d-flex flex-column">
                        <div id="project-filter-wrapper">
                            <select id="projectFilter" class="form-select form-select-sm" style="min-width: 160px;">
                                <option value="all" selected>All</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Upcoming Deadlines --}}
                    <div class="d-flex align-items-end">
                        <button id="upcoming" class="btn btn-outline-primary btn-sm px-3">
                            Upcoming Deadlines
                        </button>
                    </div>

                    {{-- Overdue Tasks --}}
                    <div class="d-flex align-items-end">
                        <button id="overdue" class="btn btn-outline-primary btn-sm px-3">
                            Overdue Tasks
                        </button>
                    </div>
                </div>

                {{-- Right Side Controls --}}
                <div class="d-flex flex-wrap align-items-end gap-3">
                    {{-- Date From --}}
                    <div class="d-flex flex-column">
                        <label for="min-date" class="form-label small fw-bold text-muted mb-1">From</label>
                        <input type="date" id="min-date" class="form-control form-control-sm" style="width: 150px;">
                    </div>

                    {{-- Date To --}}
                    <div class="d-flex flex-column">
                        <label for="max-date" class="form-label small fw-bold text-muted mb-1">To</label>
                        <input type="date" id="max-date" class="form-control form-control-sm" style="width: 150px;">
                    </div>

                    {{-- Clear Button --}}
                    <div class="d-flex align-items-end">
                        <button id="clear-date-filter" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times-circle me-1"></i> Clear
                        </button>
                    </div>

                    {{-- View Toggle --}}
                    <div class="btn-group align-items-end" role="group">
                        <button class="btn btn-sm btn-outline-primary" onclick="showContent('content1')"
                            title="List View">
                            <i class="far fa-list-alt me-1"></i> List
                        </button>
                        <button class="btn btn-sm btn-outline-primary" onclick="showContent('content2')"
                            title="Grid View">
                            <i class="fas fa-th-large me-1"></i> Grid
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3 content show" id="content1">
            <div class="col-lg-12 p-3 mb-3 rounded" style="background-color:#F4F4F4">
                <table id="projects-table" class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th style="color: #0C5097; font-weight: bold;">Project</th>
                            <th style="color: #0C5097; font-weight: bold;">Resource</th>
                            <th style="color: #0C5097; font-weight: bold;">Task</th>
                            <th style="color: #0C5097; font-weight: bold;">Start Date</th>
                            <th style="color: #0C5097; font-weight: bold;">End Date</th>
                            <th style="color: #0C5097; font-weight: bold;">Exp Days</th>
                            <th style="color: #0C5097; font-weight: bold;">Days Used</th>
                            <th style="color: #0C5097; font-weight: bold;">Status</th>
                            <th style="color: #0C5097; font-weight: bold;">Category</th>
                            <th style="color: #0C5097; font-weight: bold;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr class="project-row" data-project-name="{{ strtolower($project->project_name) }}"
                                style="background: #F2F2F2;">
                                <td style="font-size: 12px; cursor: pointer;" class="project-name"
                                    data-id="{{ $project->id }}" data-bs-toggle="modal"
                                    data-bs-target="#statusHistoryModal">
                                    {{ $project->project_name }}</td>
                                <td style="font-size: 12px;">{{ $project->user->name }}</td>
                                <td style="font-size: 12px;">{{ $project->task }}</td>
                                <td style="font-size: 12px;">
                                    {{ \Carbon\Carbon::parse($project->start_date)->format('d, M Y') }}
                                    <input type="hidden" class="hidden-start-date"
                                        value="{{ \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') }}">
                                </td>
                                <td style="font-size: 12px;">
                                    @if ($project->end_date)
                                        {{ \Carbon\Carbon::parse($project->end_date)->format('d, M Y') }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td style="font-size: 12px;" class="project-deadline">
                                    {{ $project->expected_days }}
                                    <input type="hidden" class="hidden-deadline" value="{{ $project->deadline }}">
                                </td>
                                <td style="font-size: 12px;">
                                    {{ $project->days_used }}</td>
                                <td class="text-center">
                                    <span
                                        class="
                                    {{ $project->status == 'todo' ? 'bg-primary' : '' }}
                                    {{ $project->status == 'inprogress' ? 'bg-danger' : '' }}
                                    {{ $project->status == 'hold' ? 'bg-dark' : '' }}
                                    {{ $project->status == 'completed' ? 'bg-success' : '' }}
                                    {{ $project->status == 'reopen' ? 'bg-warning' : '' }}
                                    "
                                        style="font-size:12px; border-radius: 5px;width: 100px;display: inline-block;padding: 0.25rem;font-weight: 400; color:white">{{ ucfirst($project->status) }}</span>
                                </td>

                                <td style="font-size: 12px;">
                                    {{ $project->category }}</td>
                                <td>
                                    <a href="#" style="text-decoration: none" class="edit-btn"
                                        data-id="{{ $project->id }}" data-bs-toggle="modal"
                                        data-bs-target="#editProjectModal">
                                        <i class="fas fa-edit" style="font-size: 16px; color: #ffc107;"></i>
                                    </a>

                                    <a href="#" style="text-decoration: none" class="view-btn"
                                        data-id="{{ $project->id }}" data-bs-toggle="modal"
                                        data-bs-target="#viewProjectModal">
                                        <i class="fas fa-eye" style="font-size: 16px; color: #0C5097;"></i>
                                    </a>

                                    <a href="#" style="text-decoration: none" class="delete-btn"
                                        data-id="{{ $project->id }}">
                                        <i class="fas fa-trash-alt" style="font-size: 16px; color: #dc3545;"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <p>No Projects</p>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @php
            $nameColors = [
                'todo' => '#5e6c84',
                'inprogress' => '#00b8d9',
                'hold' => '#ff991f',
                'completed' => '#5aac44',
            ];
        @endphp

        <div class="tab-pane board-tab fade h-screen-90 active content" id="content2" style="margin-bottom: 10px">
            <div class="task-board-wrapper">
                <div class="task-board-container">
                    <div class="task-board d-flex flex-nowrap">
                        @php
                            $statuses = [
                                'todo' => ['name' => 'To Do', 'color' => '#5e6c84'],
                                'inprogress' => ['name' => 'In Progress', 'color' => '#00b8d9'],
                                'hold' => ['name' => 'On Hold', 'color' => '#ff991f'],
                                'completed' => ['name' => 'Done', 'color' => '#5aac44'],
                            ];
                        @endphp

                        @foreach ($statuses as $status => $config)
                            <div class="col-3 project-col {{ $status }}-col pl-2 pr-2">
                                <div class="col-content"
                                    id="{{ $status == 'todo'
                                        ? 'RikyasTodoTasks'
                                        : ($status == 'inprogress'
                                            ? 'RikyasInProgressTasks'
                                            : ($status == 'hold'
                                                ? 'RikyasOnHoldTasks'
                                                : 'RikyasCompletedTasks')) }}"
                                    style="background-color: #fff; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); height: 100%; display: flex; flex-direction: column;">
                                    <!-- Column Header -->
                                    <h5 class="text-center py-2 mb-0"
                                        style="background-color: {{ $config['color'] }}; color: white; border-radius: 5px 5px 0 0;">
                                        {{ $config['name'] }}
                                    </h5>

                                    <ul class="project-list {{ $status }} p-3" data-status="{{ $status }}"
                                        style="list-style: none; margin: 0; border-top: 1px solid #ddd; overflow-y: auto; flex-grow: 1;">
                                        @foreach ($projects->where('status', $status) as $task)
                                            <li class="project-list-item mb-3" data-id="{{ $task->id }}"
                                                style="background-color: #f9f9f9; border-radius: 5px; padding: 10px; border: 1px solid #ddd;">
                                                <!-- Task Header -->
                                                <div
                                                    class="list-item-header d-flex justify-content-between align-items-center">
                                                    <div class="task-assign-to">
                                                        <div class="task-assign-to">
                                                            <span
                                                                class="project-name v-align-middle name-{{ $status }} capitalize"
                                                                style="cursor: pointer;" data-id="{{ $task->id }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#statusHistoryModal2">
                                                                {{ $task->user->name }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="collapse-task">
                                                        <span class="d-inline-block tooltip-customize"
                                                            data-bs-toggle="tooltip" title="Toggle Task Details">
                                                            <i class="fas fa-chevron-down fw-bold collapse-panel-arrow collapse-task-trigger"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#taskCollapse{{ $task->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="taskCollapse{{ $task->id }}"
                                                                data-toggle-icon></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- Date Information (added above the task content) -->
                                                <div class="task-meta d-flex justify-content-between mt-2 mb-2"
                                                    style="font-size: 12px; color: #666;">
                                                    <div>
                                                        <i class="far fa-calendar-alt me-1"></i>
                                                        @if ($task->start_date && $task->end_date)
                                                            {{ $task->start_date->format('M d') }} -
                                                            {{ $task->end_date->format('M d') }}
                                                            ({{ $task->start_date->diffInDays($task->end_date) }} days)
                                                        @elseif($task->deadline)
                                                            Due: {{ $task->deadline->format('M d, Y') }}
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <span class="badge"
                                                            style="background-color: {{ $task->getCategoryColor($task->category) }}; color: white;">
                                                            {{ ucfirst($task->category) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- Task Content (Collapsible) -->
                                                <div class="collapse project-list-collapse p-2"
                                                    id="taskCollapse{{ $task->id }}">
                                                    <div class="list-content" style="color: #333; font-size: 14px;">
                                                        {{ $task->task }}
                                                    </div>

                                                    <div
                                                        class="list-footer d-flex align-items-center justify-content-between mt-2">
                                                        <div>
                                                            @if ($task->document)
                                                                <i class="fas fa-paperclip v-align-middle cursor-pointer"
                                                                    style="color: #0C5097;" data-bs-toggle="modal"
                                                                    data-bs-target="#CreateProjectTaskFileUpload"
                                                                    data-task-id="{{ $task->id }}"></i>
                                                                <small
                                                                    class="ms-1">{{ basename($task->document) }}</small>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">Assigned by:
                                                                {{ $task->assignedBy->name }}</small>
                                                        </div>
                                                    </div>
                                                </div>

                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    {{-- <div class="tab-pane board-tab fade fixed-scroll-container h-screen-90 active content" id="content2"
            class="RikyasTaskBoard" style="margin-bottom: 10px">

            <div class="row m-0 fixed-row-element pr-2 pb-1" style="display:flex;justify-content: space-between;">
                <!--Column header-->
                <div class="col-2 col-header fixed-hd-area pl-2 pr-1">
                    <div class="d-flex align-items-center">
                        <div class="col-heading font-medium fw-bold text-ellipsis">Todo</div>
                    </div>
                </div>

                <!--Column header-->
                <div class="col-2 col-header fixed-hd-area pl-1 pr-1">
                    <div class="d-flex align-items-center">
                        <div class="col-heading font-medium fw-bold text-ellipsis">In progress</div>
                    </div>
                </div>

                <!--Column header-->
                <div class="col-2 col-header fixed-hd-area pl-1 pr-1">
                    <div class="d-flex align-items-center">
                        <div class="col-heading font-medium fw-bold text-ellipsis">On Hold</div>
                    </div>
                </div>

                <!--Column header-->
                <div class="col-2 col-header fixed-hd-area pl-1 pr-1">
                    <div class="d-flex align-items-center">
                        <div class="col-heading font-medium fw-bold text-ellipsis">Completed</div>
                    </div>
                </div>

            </div>

            <div class="row m-0" style="display:flex; justify-content:center">
                @foreach (['todo' => 'RikyasTodoTasks', 'inprogress' => 'RikyasInProgressTasks', 'hold' => 'RikyasOnHoldTasks', 'completed' => 'RikyasCompletedTasks'] as $status => $id)
                    <div class="col-3 project-col {{ $status }}-col pl-2 pr-2">
                        <div class="col-content collapse show" id="{{ $id }}">
                            <ul class="project-list {{ $status }}" data-status="{{ $status }}">
                                @foreach ($projects->where('status', $status) as $task)
                                    <li class="project-list-item" data-id="{{ $task->id }}">
                                        <!-- Task Header -->
                                        <div class="list-item-header align-items-center">
                                            <div class="d-none">
                                                <span class="selected-project">{{ $task->project_name }}</span>
                                            </div>
                                            <div class="task-assign-to">
                                                <span class="project-name v-align-middle" style="cursor: pointer"
                                                    data-id="{{ $task->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#statusHistoryModal2">
                                                    {{ $task->user->name }}
                                                </span>
                                            </div>

                                            <div class="collapse-task">
                                                <span class="d-inline-block tooltip-customize" data-bs-toggle="tooltip"
                                                    title="Toggle Task Details">
                                                    <i class="fas fa-chevron-down fw-bold collapse-panel-arrow collapse-task-trigger"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#taskCollapse{{ $task->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="taskCollapse{{ $task->id }}"
                                                        data-toggle-icon></i>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Task Content (Collapsible) -->
                                        <div class="collapse show project-list-collapse p-0"
                                            id="taskCollapse{{ $task->id }}">
                                            <div class="list-content">{{ $task->task }}</div>

                                            <!-- Task Footer -->
                                            <div class="list-footer d-flex align-items-center">
                                                <i class="fas fa-paperclip v-align-middle cursor-pointer ml-2 mr-1"
                                                    data-bs-toggle="modal" data-bs-target="#CreateProjectTaskFileUpload"
                                                    data-task-id="{{ $task->id }}"></i>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>

        </div> --}}
    </div>

    <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Changed to modal-lg for better spacing -->
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Project</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="store-error-messages" class="alert alert-danger d-none"></div>
                    <form data-route="{{ route('project.store') }}" method="POST" id="project-form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="project_name" class="col-form-label">Project Name:</label>
                                <input type="text" class="form-control" id="project_name" name="project_name"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="col-form-label">Resource:</label>
                                <select class="form-control" id="user_id" name="user_id" required>
                                    <option value="">Select Resource</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="task" class="col-form-label">Task Description:</label>
                            <textarea class="form-control" id="task" name="task" rows="4" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="col-form-label">Category:</label>
                                <select class="form-control" id="category" name="category" required>
                                    <option value="task">Task</option>
                                    <option value="tweak">Tweak</option>
                                    <option value="bug">Bug</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3" id="custom-category" style="display: none;">
                                <label for="custom_category" class="col-form-label">Custom Category:</label>
                                <input type="text" class="form-control" id="custom_category" name="custom_category">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="col-form-label">Status:</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="todo">Todo</option>
                                    <option value="inprogress">In Progress</option>
                                    <option value="hold">Hold</option>
                                    <option value="completed">Completed</option>
                                    {{-- <option value="reopen">Reopen</option> --}}
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="start_date" class="col-form-label">Start Date:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="deadline" class="col-form-label">Expected Deadline:</label>
                                <input type="date" class="form-control" id="deadline" name="deadline" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="document" class="col-form-label">Document:</label>
                                <input type="file" class="form-control" id="document" name="document">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button id="store-project-btn" type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- modal-lg for better spacing -->
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Project</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="update-error-messages" class="alert alert-danger d-none"></div>

                    <form id="update-project-form"
                        action="{{ isset($project) ? route('project.update', $project->id) : '#' }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="project_name" class="col-form-label">Project Name:</label>
                                <input type="text" class="form-control" id="edit_project_name" name="project_name"
                                    value="{{ old('project_name', $project->project_name ?? '') }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="col-form-label">Resource:</label>
                                <select class="form-control" id="edit_user_id" name="user_id" required>
                                    <option value="">Select Resource</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if (isset($project) && $user->id == $project->user_id) selected @endif>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="task" class="col-form-label">Task Description:</label>
                            <textarea class="form-control" id="edit_task" name="task" rows="4" required>{{ old('task', $project->task ?? '') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="col-form-label">Category:</label>
                                <select class="form-control" id="edit_category" name="category" required>
                                    <option value="task" @if (isset($project) && $project->category == 'task') selected @endif>Task</option>
                                    <option value="tweak" @if (isset($project) && $project->category == 'tweak') selected @endif>Tweak</option>
                                    <option value="bug" @if (isset($project) && $project->category == 'bug') selected @endif>Bug</option>
                                    <option value="custom" @if (isset($project) && $project->category == 'custom') selected @endif>Custom
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="col-form-label">Status:</label>
                                <select class="form-control" id="edit_status" name="status" required>
                                    <option value="todo" @if (isset($project) && $project->status == 'todo') selected @endif>Todo</option>
                                    <option value="inprogress" @if (isset($project) && $project->status == 'inprogress') selected @endif>In
                                        Progress</option>
                                    <option value="hold" @if (isset($project) && $project->status == 'hold') selected @endif>Hold</option>
                                    <option value="completed" @if (isset($project) && $project->status == 'completed') selected @endif>Completed
                                    </option>
                                    <option value="reopen" @if (isset($project) && $project->status == 'reopen') selected @endif>Reopen
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="col-form-label">Start Date:</label>
                                <input type="date" class="form-control" id="edit_start_date" name="start_date"
                                    value="{{ old('start_date', isset($project) && $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="deadline" class="col-form-label">Expected Deadline:</label>
                                <input type="date" class="form-control" id="edit_deadline" name="deadline"
                                    value="{{ old('deadline', isset($project) && $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('Y-m-d') : '') }}"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="document" class="col-form-label">Upload Document:</label>
                                <input type="file" class="form-control" id="edit_document" name="document">
                                <small>Leave this blank if you don't want to upload a new document.</small>

                                <!-- Display existing document link -->
                                @if (isset($project) && $project->document)
                                    <div class="mt-2">
                                        <label>Current Document:</label>
                                        <a href="{{ asset($project->document) }}" target="_blank">View Document</a>
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <p>No document attached.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="update-project-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewProjectModal" tabindex="-1" aria-labelledby="viewProjectLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Gradient Header -->
                <div class="modal-header" style="background: #0C5097; color: white; border: none;">
                    <h1 class="modal-title fs-4 fw-bold" id="viewProjectLabel">Project Details</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body" style="padding: 2rem;">
                    <!-- Project Title Section -->
                    <div style="margin-bottom: 2rem;">
                        <h2 class="display-6 fw-bold mb-3" id="view-project-name" style="color: #2197D7;"></h2>
                        <div class="d-flex align-items-center gap-2">
                            <span id="view-project-status"
                                style="padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 500;"></span>
                            <span style="color: #6c757d; font-size: 0.875rem;">•</span>
                            <span style="color: #6c757d; font-size: 0.875rem;" id="view-project-views">
                                <i class="far fa-eye me-1"></i> <span>0</span> views
                            </span>
                        </div>
                    </div>

                    <!-- Project Details Grid -->
                    <div class="row g-4">
                        <!-- Resource Info -->
                        <div class="col-md-6">
                            <div style="background: #f8f9fa; border-radius: 12px; padding: 1.5rem;">
                                <h6 style="color: #6c757d; font-weight: 600; margin-bottom: 1rem;">RESOURCE</h6>
                                <div class="d-flex align-items-center">
                                    <div
                                        style="width: 40px; height: 40px; background: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                        <i class="fas fa-user" style="color: #6c757d;"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-medium" id="view-project-user"></p>
                                        <small style="color: #6c757d;">Assigned Resource</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category Info -->
                        <div class="col-md-6">
                            <div style="background: #f8f9fa; border-radius: 12px; padding: 1.5rem;">
                                <h6 style="color: #6c757d; font-weight: 600; margin-bottom: 1rem;">CATEGORY</h6>
                                <div class="d-flex align-items-center">
                                    <div
                                        style="width: 40px; height: 40px; background: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                        <i class="fas fa-tag" style="color: #6c757d;"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-medium" id="view-project-category"></p>
                                        <small style="color: #6c757d;">Project Category</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Section -->
                        <div class="col-12">
                            <div style="background: #f8f9fa; border-radius: 12px; padding: 1.5rem;">
                                <h6 style="color: #6c757d; font-weight: 600; margin-bottom: 1.5rem;">PROJECT TIMELINE</h6>
                                <div class="d-flex justify-content-between">
                                    <div style="text-align: center; flex: 1;">
                                        <div style="color: #2197D7; font-weight: 600; margin-bottom: 0.5rem;">Start Date
                                        </div>
                                        <p class="mb-0" id="view-project-start-date"></p>
                                    </div>
                                    <div
                                        style="text-align: center; flex: 1; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">
                                        <div style="color: #dc3545; font-weight: 600; margin-bottom: 0.5rem;">Deadline
                                        </div>
                                        <p class="mb-0" id="view-project-deadline"></p>
                                    </div>
                                    <div style="text-align: center; flex: 1;">
                                        <div style="color: #28a745; font-weight: 600; margin-bottom: 0.5rem;">End Date
                                        </div>
                                        <p class="mb-0" id="view-project-end-date"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Task Description -->
                        <div class="col-12">
                            <div style="background: #f8f9fa; border-radius: 12px; padding: 1.5rem;">
                                <h6 style="color: #6c757d; font-weight: 600; margin-bottom: 1rem;">TASK DESCRIPTION</h6>
                                <p class="mb-0" id="view-project-task" style="line-height: 1.6;"></p>
                            </div>
                        </div>

                        <!-- Document Section -->
                        <div class="col-12" id="document-section">
                            <div style="background: #f8f9fa; border-radius: 12px; padding: 1.5rem;">
                                <h6 style="color: #6c757d; font-weight: 600; margin-bottom: 1rem;">ATTACHED DOCUMENT</h6>
                                <div id="view-project-document"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status History Modal -->
    <div class="modal fade" id="statusHistoryModal" tabindex="-1" aria-labelledby="viewProjectLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- Header with Project Info -->
                <div class="modal-header" style="background: #0C5097; color: white;">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-light text-dark projectId">#0000</span>
                            <h5 class="modal-title mb-0 projectTitle">
                                Project Title {{ ' - ' }}<span id="category"></span>
                            </h5>
                        </div>

                        <small class="text-white-50 projectPostedDate">Posted on: --</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">
                    <div class="d-flex">
                        <!-- Left Sidebar - Project Details -->
                        <div class="bg-light p-3" style="width: 280px; border-right: 1px solid #dee2e6;">
                            <div class="project-details">
                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Created By</label>
                                    <div class="fw-medium assignedBy">--</div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Assigned To</label>
                                    <div class="fw-medium text-truncate assignedTo">--</div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="text-muted small mb-1">Start Date</label>
                                        <div class="fw-medium startDate">--</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small mb-1">End Date</label>
                                        <div class="fw-medium endDate">--</div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="text-muted small mb-1">Expected Days</label>
                                        <div class="fw-medium expectedDays">--</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small mb-1">Days Used</label>
                                        <div class="fw-medium daysUsed">--</div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Status</label>
                                    <div class="badge bg-success projectStatus">--</div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Content Area -->
                        <div class="flex-grow-1 p-3">
                            <!-- Description Section -->
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">Description</h6>
                                <div class="description-content projectDescription"
                                    style="max-height: 200px; overflow-y: auto;">
                                    <p id="descriptionText"></p> <!-- Added a paragraph to display the description -->
                                </div>
                            </div>

                            <!-- Tabs Section -->
                            <ul class="nav nav-tabs" role="tablist">
                                {{-- <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#TaskNotes">Notes</button>
                                </li> --}}
                                <li class="nav-item active">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#TaskStatus">Status
                                        History</button>
                                </li>
                            </ul>

                            <div class="tab-content mt-3">
                                <!-- Status History Tab -->
                                <div class="tab-pane show active" id="TaskStatus" style="font-size:12px">
                                    <div id="statusHistory" class="table-responsive" style="max-height: 200px;">
                                        <table class="table table-hover">
                                            <thead style="position: sticky; top: 0; background: white;">
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Category</th>
                                                    <th>Date</th>
                                                    <th>Updated By</th>
                                                </tr>
                                            </thead>
                                            <tbody class="statusHistoryBody"></tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Notes Tab -->
                                {{-- <div class="tab-pane fade show active" id="TaskNotes">
                                    <div class="notes-container" id="notesContainer" style="max-height: 200px; overflow-y: auto;"></div>

                                    <!-- Note Input -->
                                    <div class="note-input mt-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Add a note...">
                                            <button class="btn btn-primary">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusHistoryModal2" tabindex="-1" aria-labelledby="viewProjectLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- Header with Project Info -->
                <div class="modal-header" style="background: #0C5097; color: white;">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-light text-dark projectId">#0000</span>
                            <h5 class="modal-title mb-0 projectTitle">
                                Project Title {{ ' - ' }}<span id="category"></span>
                            </h5>
                        </div>

                        <small class="text-white-50 projectPostedDate">Posted on: --</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-0">
                    <div class="d-flex">
                        <!-- Left Sidebar - Project Details -->
                        <div class="bg-light p-3" style="width: 280px; border-right: 1px solid #dee2e6;">
                            <div class="project-details">
                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Created By</label>
                                    <div class="fw-medium assignedBy">--</div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Assigned To</label>
                                    <div class="fw-medium text-truncate assignedTo">--</div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="text-muted small mb-1">Start Date</label>
                                        <div class="fw-medium startDate">--</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small mb-1">End Date</label>
                                        <div class="fw-medium endDate">--</div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="text-muted small mb-1">Expected Days</label>
                                        <div class="fw-medium expectedDays">--</div>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small mb-1">Days Used</label>
                                        <div class="fw-medium daysUsed">--</div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-muted small mb-1">Status</label>
                                    <div class="badge bg-success projectStatus">--</div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Content Area -->
                        <div class="flex-grow-1 p-3">
                            <!-- Description Section -->
                            <div class="mb-4">
                                <h6 class="text-muted mb-3">Description</h6>
                                <div class="description-content projectDescription"
                                    style="max-height: 200px; overflow-y: auto;">
                                    <p class="descriptionText"></p> <!-- Added a paragraph to display the description -->
                                </div>
                            </div>

                            <!-- Tabs Section -->
                            <ul class="nav nav-tabs" role="tablist">
                                {{-- <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#TaskNotes">Notes</button>
                                </li> --}}
                                <li class="nav-item active">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#TaskStatus">Status
                                        History</button>
                                </li>
                            </ul>

                            <div class="tab-content mt-3">
                                <!-- Status History Tab -->
                                <div class="tab-pane show active" id="TaskStatus" style="font-size:12px">
                                    <div id="statusHistory" class="table-responsive" style="max-height: 200px;">
                                        <table class="table table-hover">
                                            <thead style="position: sticky; top: 0; background: white;">
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Category</th>
                                                    <th>Date</th>
                                                    <th>Updated By</th>
                                                </tr>
                                            </thead>
                                            <tbody class="statusHistoryBody"></tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Notes Tab -->
                                {{-- <div class="tab-pane fade show active" id="TaskNotes">
                                    <div class="notes-container" id="notesContainer" style="max-height: 200px; overflow-y: auto;"></div>

                                    <!-- Note Input -->
                                    <div class="note-input mt-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Add a note...">
                                            <button class="btn btn-primary">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for File Upload -->
    <div class="modal fade" id="CreateProjectTaskFileUpload" tabindex="-1"
        aria-labelledby="CreateProjectTaskFileUploadLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CreateProjectTaskFileUploadLabel">Project Task Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Files will be dynamically displayed here -->
                    <div id="taskFilesContainer">
                        <!-- Files list goes here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        const graphRoute = @json(route('project.graph'));
    </script>
    <script src="{{ asset('js/project.js') }}"></script>
    <script>
        const projectShowRoute = @json(route('project.show', ['project' => ':id']));
        const projectEditRoute = @json(route('project.edit', ['project' => ':id']));
        let updateTaskUrl = @json(route('update.task.status'));
        const fetchProjects = @json(route('fetch.projects'));

        document.addEventListener('DOMContentLoaded', function() {
            $('#projectFilter').select2({
                placeholder: "Select a project",
                allowClear: true,
                width: '150px',
                dropdownParent: $('#project-filter-wrapper'),
                templateResult: function(data) {
                    if (!data.id) return data.text;
                    var $result = $('<span style="color: #000;">' + data.text + '</span>');
                    return $result;
                },
                templateSelection: function(data) {
                    return data.text || "All";
                }
            });

            $('#projectFilter').on('change', function() {
                const filterValue = $(this).val();
                console.log('Selected:', filterValue);
                // Add your filter logic here
            }).trigger('change');
        });
    </script>
@endpush
