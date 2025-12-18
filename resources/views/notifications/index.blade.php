@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <form action="{{ url('/notifications') }}">
            <div class="form-row mb-2">
                <div class="col-11">
                    <select name="status" id="status" class="form-control select2" data-live-search="true">
                        <option value="">-- Pilih Status --</option>
                        <option value="read" {{ 'read' == request('status') ? 'selected="selected"' : '' }}>read</option>
                        <option value="unread" {{ 'unread' == request('status') ? 'selected="selected"' : '' }}>unread</option>
                    </select>
                </div>
                <div class="col-1">
                    <button type="submit" id="search" class="btn"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <div class="card card-primary">
            <div class="card-body">
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover">
                        <tbody>
                            @if (count($inboxs) <= 0)
                                <tr>
                                    <td colspan="5" class="text-center">Tidak Ada Data</td>
                                </tr>
                            @else
                                @foreach ($inboxs as $inbox)
                                    @php
                                        $user = App\Models\User::find($inbox->data['user_id']);
                                        $bgColor = $inbox->read_at == null ? 'background-color: #f0f0f0;' : 'background-color: #ffffff;';
                                    @endphp
                                    <tr class="clickable-row" data-href="{!! !$inbox->read_at ? url('/notifications/read-message/'.$inbox->id) : url($inbox->data['action']); !!}" style="cursor: pointer; {{ $bgColor }}">
                                        <td>
                                            @if($user->foto == null)
                                                <img style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;" src="{{ url('assets/img/foto_default.jpg') }}" alt="{{ $user->name ?? '-' }}">
                                            @else
                                                <img style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;" src="{{ url('/storage/'.$user->foto) }}" alt="{{ $user->name ?? '-' }}">
                                            @endif
                                        </td>
                                        <td class="mailbox-name" style="color:blue">{{ $user->name }}</td>
                                        <td class="mailbox-subject">{{ $inbox->data['message'] }}
                                        </td>
                                        <td class="mailbox-attachment"></td>
                                        <td class="mailbox-date">{{ date('d M Y H:i:s',strtotime($inbox->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-end mr-4">
                {{ $inboxs->links() }}
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $('.select2').select2();

            $(".clickable-row").click(function() {
                window.location.href = $(this).data("href");
            });
        </script>
    @endpush
@endsection
