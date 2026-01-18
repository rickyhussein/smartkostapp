@extends('layouts.appowner')

@section('back')
    <a href="{{ url('/user-properties/owner/show/'.$up->id) }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection

@section('container')
    <form action="{{ url('/user-properties/owner/contract/update/'.$up->id) }}" enctype="multipart/form-data" method="POST">
        @method('PUT')
        @csrf
        
        <div id="app-wrap" class="mt-4">
            <div class="bill-content">
                <div class="box-settings-profile style1">
                    <div class="list-setting-profile">
                        <div class="inner-left">
                            <h4 class="fw_6">Edit Kontrak</h4>
                        </div>
                        <div class="inner-right">
                            <input name="edit_contract" id="edit_contract" class="tf-switch-check" type="checkbox" value="{{ old('edit_contract', $up->edit_contract) }}">
                        </div>
                    </div>
                    <div id="contractContainer">
                        <input id="contract" type="hidden" name="contract" value="{{ old('contract', $up->contract) }}">
                        <trix-editor input="contract">{{ old('contract', $up->contract) }}</trix-editor>
                    </div>
                </div>
            </div>
        </div>


        <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:65px">
            <div class="tf-container">
                <button type="submit" class="tf-btn accent large">Simpan</button>
            </div>
        </div>
    </form>

    @push('style')
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
        <style>
            trix-toolbar [data-trix-action="attachFiles"] {
                display: none;
            }

            trix-editor ol {
                list-style-type: decimal !important;
                margin-left: 1.5rem;
            }

            trix-editor ul {
                list-style-type: disc !important;
                margin-left: 1.5rem;
            }

            trix-editor blockquote {
                border-left: 3px solid #ccc;
                margin: 1em 0;
                padding-left: 1em;
                color: #555;
                font-style: italic;
            }
        </style>
    @endpush

    @push('script')
        <script>
            let edit_contract = $('#edit_contract').val();
            if(edit_contract == 1) {
                $('#edit_contract').prop('checked', true);
                $('#contractContainer').show();
            } else {
                $('#edit_contract').prop('checked', false);
                $('#contractContainer').hide();
            }

            $('body').on('change', '#edit_contract', function (event) {
                if(this.checked) {
                    $(this).val(1);
                    $('#contract').val(null);
                    $('#contractContainer').show();
                } else {
                    $(this).val(null);
                    $('#contract').val(null);
                    $('#contractContainer').hide();
                }
            });
        </script>
    @endpush
@endsection
