@extends('web.layouts.web')
@section('content')
    @if (session('case') === 'warning')
        <div class="alert alert-warning">
            <strong>{{ session('title') }}</strong>
            @if (is_array(session('content')))
                <ul>
                    @foreach (session('content') as $field => $errors)
                        @foreach ($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endforeach
                </ul>
            @else
                <p>{{ session('content') }}</p>
            @endif
        </div>
    @endif

    @if (session('case') === 'exist')
        <div class="alert alert-warning">
            <strong>{{ session('title') }}</strong>
            <p>{{ session('content') }}</p>
        </div>
    @endif

    @if (session('case') === 'success')
        <div class="alert alert-success">
            <strong>{{ session('title') }}</strong>
            <p>{{ session('content') }}</p>
        </div>
    @endif

    @if (session('case') === 'error')
        <div class="alert alert-danger">
            <strong>{{ session('title') }}</strong>
            <p>{{ session('content') }}</p>
        </div>
    @endif

    <div class="content" id="content">
        <section class="section section-profile-settings">
            <div class="container-lg">
                <div class="row">
                    @include("web.account.account_left_bar")

                    <div class="col-md-8">
                        <form id="notificationForm">
                            @csrf
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <label class="form-check-label" for="sms">SMS Göndər</label>
                                <div class="form-switch">
                                    <input class="form-check-input notification-switch" type="checkbox" name="notifications[]" value="sms" id="sms" {{$notification->sms_notification==1 ? 'checked':'' }}>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-between align-items-center mt-2">
                                <label class="form-check-label" for="email">E-mail Göndər</label>
                                <div class="form-switch">
                                    <input class="form-check-input notification-switch" type="checkbox" name="notifications[]" value="email" id="email"{{$notification->email_notification==1 ? 'checked':'' }}>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('styles')
    <style>
        .content {
            padding: 20px;
        }

        .section-profile-settings {
            margin-top: 80px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .alert {
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert strong {
            font-weight: bold;
        }

        .alert ul {
            padding-left: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            display: inline-block;
            margin-right: 670px;
        }

        .form-group label {
            display: inline-block;
            font-weight: bold;
            margin-right: 10px;
            color: #856404;
        }

        .form-group input[type="checkbox"] {
            margin-right: 5px;
            vertical-align: middle;
        }

        .btn-primary {
            background-color: #ffc107;
            color: #212529;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #e0a800;
        }

        @media (max-width: 768px) {
            .section-profile-settings {
                padding: 10px;
            }

            .form-group {
                display: block;
                margin-right: 0;
            }

            .btn-primary {
                width: 100%;
                text-align: center;
            }
        }

    </style>
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".notification-switch").forEach(function (checkbox) {
                checkbox.addEventListener("change", function () {
                    let formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}'); // CSRF tokeni ekledik
                    formData.append('type', this.value);
                    formData.append('enabled', this.checked ? 1 : 0);

                    fetch("{{ route('edit-notification') }}", {
                        method: "POST",
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Güncelleme başarılı:", data);
                        })
                        .catch(error => {
                            console.error("Hata oluştu:", error);
                        });
                });
            });
        });
    </script>
@endsection