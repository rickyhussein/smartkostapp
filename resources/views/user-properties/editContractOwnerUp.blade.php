@extends('layouts.appowner')

@section('back')
    <a href="{{ url('/user-properties/owner/show/'.$up->id) }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection

@section('container')
    <form class="tf-form" action="{{ url('/user-properties/owner/contract/update/'.$up->id) }}" enctype="multipart/form-data" method="POST">
        @method('PUT')
        <div id="app-wrap" class="mt-4">
            <div class="bill-content">
                <div class="card-secton transfer-section mt-2">
                    <div class="tf-container ms-2 me-2">
                        @csrf
                        <div class="card" style="border-radius: 10px; border: 1px solid #acacac; font-size: 14px;">
                            <div class="card-body">
                                <div>
                                    <div class="inner-left">
                                        <h4 class="fw_6">Edit Kontrak</h4>
                                    </div>
                                    <a href="#" class="inner-right">
                                        <input class="tf-switch-check" type="checkbox" value="checkbox" name="check">
                                    </a>
                                </div>
                                <div>
                                    <label for="contract">Isi Kontrak</label>
                                    <input id="contract" type="hidden" name="contract" value="{{ old('contract', $up->contract) }}">
                                    <trix-editor input="contract">{{ old('contract', $up->contract) }}</trix-editor>
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
        </script>
    @endpush
@endsection
