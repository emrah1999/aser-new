@extends('web.layouts.web')
@section('content')
    @php
        use Illuminate\Support\Facades\Auth;

        $user = Auth::check();
        $userDetail = Auth::user();
    @endphp

    <div class="container">
        <div class="left-panel">
            <ul class="locations">
                <li class="section-title">Filiallar</li>
                @foreach($branches as $branch)
                    @if($branch->is_pudo == 0)
                        <li class="branch-item">
                            <label class="map-link row" data-map="{{ $branch->map_location }}">
                                @if($user)
                                <div class="col-md-1">
                                    <input type="radio" class="branch-input" name="point" {{$userDetail->branch_id  == $branch->id  ? 'checked' : '' }} value="{{ $branch->id }}">
                                </div>
                                @endif
                                <div class="col-md-9">
                                    {{ $branch->name }} - {{ $branch->address }}
                                    <br>
                                    @if($branch->is_open == 1)
                                        <label class="opened font-n-b">Açıqdır - Bağlanacaq
                                            @foreach($branch->work_hours as $day => $time)
                                                <tr> @if(strtolower($day) ==strtolower($branch->today_abbr) )
                                                        {{$branch->weekday_end_date}}
                                                    @endif
                                                </tr>
                                            @endforeach
                                            <span class="toggle-schedule" data-id="{{ $branch->id }}" style="cursor: pointer;">
                                                <img src="https://front.ailemiz.az/web/images/content/chevron-down.png"
                                                     width="16" height="16"
                                                     alt="Toggle"
                                                     id="arrow-{{ $branch->id }}"
                                                     class="arrow-icon">
                                            </span>
                                        </label>
                                    @else
                                        <label class="closed font-n-b">Bağlıdır - Açılacaq
                                            @foreach($branch->work_hours as $day => $time)
                                                <tr> @if(strtolower($day) ==strtolower($branch->today_abbr) )
                                                        {{$branch->weekday_start_date}}
                                                    @endif
                                                </tr>
                                            @endforeach
                                            <span class="toggle-schedule" data-id="{{ $branch->id }}" style="cursor: pointer;">
                                                <img src="https://front.ailemiz.az/web/images/content/chevron-down.png"
                                                     width="16" height="16"
                                                     alt="Toggle"
                                                     id="arrow-{{ $branch->id }}"
                                                     class="arrow-icon">
                                            </span>
                                        </label>
                                    @endif

                                    <div class="schedule-table" id="schedule-{{ $branch->id }}">
                                        <table>
                                            @foreach($branch->work_hours as $day => $time)
                                                <tr @if(strtolower($day) ==strtolower($branch->today_abbr) )  style="font-weight: bold;" @endif>
                                                    <td>{{ $day }}:</td>
                                                    <td>{{ $time }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </label>
                        </li>
                    @endif
                @endforeach
                <li class="section-title">Məntəqələr</li>
                @foreach($branches as $branch)
                    @if($branch->is_pudo == 1)
                        <li class="branch-item">
                            <label class="map-link row" data-map="{{ $branch->map_location }}">
                                @if($user)
                                    <div class="col-md-1">
                                        <input type="radio" class="branch-input" name="point" {{$userDetail->branch_id  == $branch->id  ? 'checked' : '' }} value="{{ $branch->id }}">

                                    </div>
                                @endif
                                <div class="col-md-9">
                                    {{ $branch->name }} - {{ $branch->address }}
                                    <br>
                                    @if($branch->is_open == 1)
                                        <label class="opened font-n-b">Açıqdır - Bağlanacaq
                                            @foreach($branch->work_hours as $day => $time)
                                                <tr> @if(strtolower($day) ==strtolower($branch->today_abbr) )
                                                        {{$branch->weekday_end_date}}
                                                    @endif
                                                </tr>
                                            @endforeach
                                            <span class="toggle-schedule" data-id="{{ $branch->id }}" style="cursor: pointer;">
                                                <img src="https://front.ailemiz.az/web/images/content/chevron-down.png"
                                                     width="16" height="16"
                                                     alt="Toggle"
                                                     id="arrow-{{ $branch->id }}"
                                                     class="arrow-icon">
                                            </span>
                                        </label>
                                    @else
                                        <label class="closed font-n-b">Bağlıdır - Açılacaq
                                            @foreach($branch->work_hours as $day => $time)
                                                <tr> @if(strtolower($day) ==strtolower($branch->today_abbr) )
                                                        {{$branch->weekday_start_date}}
                                                    @endif
                                                </tr>
                                            @endforeach
                                            <span class="toggle-schedule" data-id="{{ $branch->id }}" style="cursor: pointer;">
                                                <img src="https://front.ailemiz.az/web/images/content/chevron-down.png"
                                                     width="16" height="16"
                                                     alt="Toggle"
                                                     id="arrow-{{ $branch->id }}"
                                                     class="arrow-icon">
                                            </span>
                                        </label>
                                    @endif

                                    <div class="schedule-table" id="schedule-{{ $branch->id }}">
                                        <table>
                                            @foreach($branch->work_hours as $day => $time)
                                                <tr @if(strtolower($day) ==strtolower($branch->today_abbr) )  style="font-weight: bold;" @endif>
                                                    <td>{{ $day }}:</td>
                                                    <td>{{ $time }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </label>
                        </li>
                    @endif
                @endforeach
            </ul>

            @if($user)
                <div class="change-branch-container">
                    <button id="changeBranchBtn" class="change-branch-btn">Dəyişdir</button>
                </div>
            @endif

        </div>

        <div class="right-panel">
            <div class="media-branches__left">
                <iframe id="map" class="media-branches__map"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d759.7081685227259!2d49.84359226553985!3d40.39040094792123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40307d30e58f34c5%3A0xdbd9946f959d9e!2sAser%20Cargo%20Express!5e0!3m2!1str!2saz!4v1726507917582!5m2!1str!2saz"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="eager"></iframe>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .font-n-b{
            font-size: 12px;
        }
        .section-title {
            text-align: center;
            font-weight: bold;
            padding: 10px;
            color: #f2c516;
            margin: 10px 0;
            border-radius: 4px;
        }

        .arrow-icon {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        .schedule-table {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.4s ease, opacity 0.4s ease;
        }

        .schedule-table.open {
            max-height: 500px;
            opacity: 1;
        }

        .opened {
            color: #32cd30;
        }

        .closed {
            color: red;
        }

        .branch-input {
            height: 15px;
            width: 15px;
        }

        .map-link {
            color: black;
        }

        .thumbnail-branches__link {
            padding: 8px 10px;
        }

        .btn-trns-blue {
            color: black;
        }

        body {
            font-family: Arial, sans-serif;
            margin: -20px;
            padding: 20px;
            background: #f4f4f4;
        }

        .container {
            margin-top: 110px;
            display: flex;
            gap: 20px;
            max-width: 1200px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            height: 700px;
        }

        .left-panel {
            width: 35%;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .right-panel {
            width: 65%;
            height: 100%;
        }

        .locations {
            list-style: none;
            padding: 0;
            margin: 0;
            overflow-y: auto;
            flex-grow: 1;
        }

        .locations li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .branch-item {
            position: relative;
            padding-right: 30px;
        }

        .toggle-schedule {
            right: 10px;
            top: 10px;
        }

        .media-branches__left {
            height: 100%;
        }

        .media-branches__map {
            height: 100%;
            width: 100%;
        }


        .change-branch-container {
            padding: 15px;
            text-align: center;
            border-top: 1px solid #ddd;
        }

        .change-branch-btn {
            background-color: #f2c516;
            color: #000;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s;
            width: 100%;
        }

        .change-branch-btn:hover {
            background-color: #e0b500;
        }

        .change-branch-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
    </style>
@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            $('.map-link').click(function () {
                var url = $(this).attr('data-map');
                $('#map').attr('src', url);
            });

            // Schedule toggle functionality
            $('.toggle-schedule').click(function () {
                const id = $(this).attr('data-id');
                const schedule = $('#schedule-' + id);
                const arrow = $('#arrow-' + id);

                schedule.toggleClass('open');
                arrow.toggleClass('rotate-180');
            });


            $('#changeBranchBtn').click(function() {
                const selectedBranch = $('input[name="point"]:checked').val();

                if (!selectedBranch) {
                    alert('Zəhmət olmasa bir filial seçin!');
                    return;
                }


                $.ajax({
                    url: '{{ route("change_branch",['locale' => 'az']) }}',
                    type: 'POST',
                    data: {
                        branch_id: selectedBranch,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $('#changeBranchBtn').prop('disabled', true).text('Gözləyin...');
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Uğurlu əməliyyat!',
                                text: 'Filial uğurla dəyişdirildi!',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Uğurlu əməliyyat!',
                                text: response.message,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Xəta!',
                            text: 'Zəhmət olmasa yenidən cəhd edin.',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Bağla'
                        });
                    },
                    complete: function() {
                        $('#changeBranchBtn').prop('disabled', false).text('Dəyişdir');
                    }

                });
            });
        });
    </script>
@endsection