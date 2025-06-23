<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <title>UnitC - Forget Password</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">

     <style>
    .imgbac{
        background: url('./images/Frame\ 1.svg') no-repeat center center;
        background-size: cover;
    height: 100vh;
    }
    .coma{
        height: 20px;
        width: 20px;
    }
    .marginfor{
        margin-top: 90px;
    }
    .leftpara{
        color: white;

    }
    .buton1{
        width: 100%;
        background-color: #1565D8;
        color: white;
        border: none;
        font-size: 14px;
        padding :15px 10px;
        font-weight: 500;
        border-radius: 5px;
    }
    .buton1:hover{
        background-color: white;
        color:  #1565D8;
        border:1px solid #1565D8;
    }
    .buton:hover{
        background-color: #1565D8;
        color:  white;
        border:1px solid #1565D8;
    }
    .buton{
        width: 100%;
        background-color: white;
        color: #0C5097;
        border: none;
        font-size: 14px;
        padding :15px 10px;
        font-weight: 500;
        border-radius: 5px;
    }
    .rightpara{
color: #8692A6;
font-size: 12px;
    }
    label{
        color: #696F79;
        font-weight: 600;
        font-size: 14px;
    }
    .form-control {
    display: block;
    width: 100%;
    padding: .500rem .75rem;
    font-size:16px;
    font-weight: 400;
    line-height: 1.5;
    color: #8692A6;
    background-color: var(--bs-body-bg);
    background-clip: padding-box;
    border: var(--bs-border-width) solid #8692A6;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: var(--bs-border-radius);
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
.form-control::placeholder {
    color: #8692A6;

}
.form-select {
    --bs-form-select-bg-img: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e);
    display: block;
    width: 100%;
    padding: .500rem 2.25rem .500rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #8692A6;
    background-color: var(--bs-body-bg);
    background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
    background-repeat: no-repeat;
    background-position: right .75rem center;
    background-size: 16px 12px;
    border: var(--bs-border-width) solid #8692A6;
    border-radius: var(--bs-border-radius);
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
.or-divider {
            display: flex;
            align-items: center;
            text-align: center;
        }
        .or-divider::before,
        .or-divider::after {
            content: "";
            flex: 1;
            border-top: 2px solid black;
            margin: 0 10px;
        }
        .or-text {
            color: gray;
            font-size: 14px;
        }
        .google-btn {
            display: flex;
            align-items: center;
            justify-content: start;
            gap: 10px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px 10px;
            font-size: 16px;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            width: 100%;
        }
        .google-btn:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        .google-icon {
            width: 24px;
            height: 24px;
        }
        .forget{
            color: #FF6C2D;
            font-size: 14px;
            text-decoration: none;
        }
        .marginlogin{
            margin: 200px 0px;
        }
 </style>
</head>

<body>
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-4 imgbac p-5">
            <img src="./images/Vector (2).svg" class="img-fluid w-25" alt="...">
            <div class="row">
                <div class="col-12 marginfor">
                    <img src="./images/“.svg" class="coma mb-3"  alt="...">
                    <p class="leftpara">The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software.</p>
                <p class="leftpara">Hassan</p>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <img src="./images/Vector 1.svg" class="coma mb-3"  alt="...">
                </div>

            </div>
        </div>

        <div class="col-md-8 marginlogin">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                   <div class="row">
                    <div class="col-md-9">
                        <h4><strong>Forget Password</strong></h4>
                        <p class="rightpara m-0">Enter your registered email address to continue using Unit C.</p>
                              <form action="{{ route('password.email') }}" method="post">
                                    @csrf
                     <label class="my-2">Email address*</label>
                          <input type="email" name="email" class="form-control" placeholder="Enter Registered Email">
                                    @error('email')
                                        <div class="text-danger" style="margin-left: 85px; font-size:12px">{{ $message }}</div>
                                    @enderror
                          <button class="buton1 mt-5"  id="resetPasswordBtn" text="Reset Password">Submit</button>
                         </form>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>
</body>

</html>
