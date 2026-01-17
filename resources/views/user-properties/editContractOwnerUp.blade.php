@extends('layouts.appowner')

@section('back')
    <a href="{{ url('/user-properties/owner/show/'.$up->id) }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection

@section('container')
    <form class="tf-form" action="" enctype="multipart/form-data" method="POST">
        <div id="app-wrap" class="mt-4">
            <div class="bill-content">
                <div class="card-secton transfer-section mt-2">
                    <div class="tf-container ms-2 me-2">
                        @csrf
                        <label for="contract">Isi Kontrak</label>
                        <input id="contract" type="hidden" name="contract">
                        <trix-editor input="contract"></trix-editor>

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
        </style>
    @endpush

    @push('script')
        <script>
        </script>
    @endpush
@endsection
