@extends('layouts.appowner')
@section('back')
    <a href="{{ url('/dashboard/owner') }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection
@section('container')
    <div id="app-wrap">
        <div class="bill-content">
            <form action="{{ url('/notifications/owner') }}" class="mt-4 mb-6 ms-4 me-4">
                <div class="row">
                    <div class="col-10">
                        @php
                            $filter = [
                                [
                                    "filter" => "read",
                                ],
                                [
                                    "filter" => "unread",
                                ],
                            ];
                        @endphp
                        <select style="width: 100%" name="filter" id="filter" data-live-search="true" class="select2">
                        @foreach($filter as $fil)
                            @if(request('filter') == $fil['filter'])
                                <option value="{{ $fil['filter'] }}"selected>{{ $fil['filter'] }}</option>
                            @else
                                <option value="{{ $fil['filter'] }}">{{ $fil['filter'] }}</option>
                            @endif
                        @endforeach
                    </select>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
            <div class="tf-container">
                <ul class="mt-3 mb-5">
                    @if (count($inboxs) <= 0)
                        <div class="d-flex justify-content-center align-items-center vh-100">
                            <div class="bill-content text-center">
                                <div class="tf-container">
                                    <p class="m-0">Data not available</p>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach ($inboxs as $inbox)
                            @php
                                $user = App\Models\User::find($inbox->data['user_id']);
                            @endphp
                            <li class="list-card-invoice tf-topbar d-flex justify-content-between align-iteinbox-center p-2" style="margin-top: -11px; {{ !$inbox->read_at ? 'background-color: rgb(231, 231, 231)' : 'background-color: rgb(251, 251, 251)' }}">
                                <div class="user-info">
                                    @if($user->profile_photo == null)
                                        <img src="{{ url('/assets/img/foto_default.jpg') }}" alt="image">
                                    @else
                                        <img src="{{ url('/storage/'.$user->profile_photo) }}" alt="image">
                                    @endif
                                </div>
                                <div class="content-right">
                                    <h4><a href="{!! !$inbox->read_at ? url('/notifications/read-message/'.$inbox->id) : url($inbox->data['action']); !!}">{{ $user->name }} <span>{{ $inbox->status_pengajuan }}</span></a></h4>
                                    <p><a style="color: rgb(141, 141, 141)" href="{!! !$inbox->read_at ? url('/notifications/read-message/'.$inbox->id) : url($inbox->data['action']); !!}">{{ $inbox->data['message'] }} <span>{{ date('d M Y H:i:s',strtotime($inbox->created_at)) }}</span></a></p>
                                    <p><a style="color: rgb(141, 141, 141)" href="{!! !$inbox->read_at ? url('/notifications/read-message/'.$inbox->id) : url($inbox->data['action']); !!}">{{ $inbox->deskripsi }}</a></p>
                                </div>
                            </li>
                        @endforeach
                        <div class="d-flex justify-content-end me-4 mt-4">
                            {{ $inboxs->links() }}
                        </div>
                    @endif
                </ul>

            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    @push('script')
        <script>
            $('.select2').select2();
        </script>
    @endpush
@endsection
