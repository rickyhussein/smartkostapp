@extends('layouts.appowner')

@section('back')
    <a href="{{ url('/properties/owner/room/show/'.$room->id.'/'.$property->id) }}" class="back-btn"> <i class="icon-left"></i> </a>
@endsection

@section('container')
    <form class="tf-form" action="{{ url('/properties/owner/room/store/'.$room->id.'/'.$property->id) }}" enctype="multipart/form-data" method="POST">
        <div id="app-wrap" class="mt-4">
            <div class="bill-content">
                <div class="card-secton transfer-section mt-2">
                    <div class="tf-container ms-2 me-2">
                        @csrf
                        <div class="card" style="border-radius: 10px; border: 1px solid #acacac; font-size: 14px;">
                            <div class="card-body">
                                <div id="propertyContainer">
                                    @if(count($room_photos) > 0)
                                        @foreach($room_photos as $key => $photo)
                                            <div class="propertyItem">
                                                <label for="room_photo_file_path">Foto Kamar {{ $key + 1 }}</label>
                                                <div class="group-input">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <div class="file-input-wrapper">
                                                                <input class="form-control" type="file" name="room_photo_file_path[]" accept="image/*">
                                                                <div class="file-name-display">
                                                                    <span class="current-file">{{ $photo->room_photo_file_name ? basename($photo->room_photo_file_name) : 'Belum ada file dipilih' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="image-preview mt-2">
                                                                <a href="{{ url('/storage/'.$photo->room_photo_file_path) }}">
                                                                    <img src="{{ asset('storage/'.$photo->room_photo_file_path) }}" alt="Preview Foto" style="max-width: 200px; max-height: 200px;">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <button class="tf-btn danger large delete" style="font-size: 12px">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                        <input type="hidden" name="old_room_photo_file_path[]" value="{{ $photo->room_photo_file_path }}">
                                                        <input type="hidden" name="old_room_photo_file_name[]" value="{{ $photo->room_photo_file_name }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="propertyItem">
                                            <label for="room_photo_file_path">Foto Kamar 1</label>
                                            <div class="group-input">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <div class="file-input-wrapper">
                                                            <input class="form-control" type="file" name="room_photo_file_path[]" accept="image/*" required>
                                                            <div class="file-name-display">
                                                                <span class="current-file">Belum ada file dipilih</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <button class="tf-btn danger large delete" style="font-size: 12px">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="old_room_photo_file_path[]">
                                                    <input type="hidden" name="old_room_photo_file_name[]">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button class="tf-btn success large addProperty">+ Tambah Foto</button>
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

        <input type="hidden" name="property_id" id="property_id" class="property_id" value="{{ old('property_id', $property->id) }}">
        <input type="hidden" name="room_id" id="room_id" class="room_id" value="{{ old('room_id', $room->id) }}">

        <div class="bottom-navigation-bar st2 bottom-btn-fixed" style="bottom:65px">
            <div class="tf-container">
                <button type="submit" class="tf-btn accent large">Simpan</button>
            </div>
        </div>
    </form>

    @push('style')
        <style>
            .file-input-wrapper {
                position: relative;
                height: calc(2.25rem + 2px);
                margin-bottom: 10px;
            }

            .file-name-display {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                padding: 0.375rem 0.75rem;
                background-color: #ffffff;
                border: 1px solid #acacac;
                border-radius: 8px;
                pointer-events: none;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                height: calc(2.25rem + 2px);
                line-height: 1.5;
            }

            .file-name-display .current-file {
                color: #495057;
                font-size: 0.875rem;
            }

            input[type="file"] {
                opacity: 0;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                cursor: pointer;
                z-index: 1;
            }

            .image-preview img {
                margin-top: 10px;
                padding: 5px;
                border: 1px dashed #ccc;
                border-radius: 4px;
                display: inline-block;
            }

            .image-preview-container {
                margin-top: 10px;
                padding: 5px;
                border: 1px dashed #ccc;
                border-radius: 4px;
                display: inline-block;
            }

            @media (max-width: 768px) {
                #videoPlayer {
                    max-height: 300px;
                }
            }
        </style>
    @endpush

    @push('script')
        <script>
            $('.addProperty').click(function(e) {
                e.preventDefault();
                let fotoCount = $('#propertyContainer .propertyItem').length + 1;
                let newFoto = `
                    <div class="propertyItem">
                        <label for="room_photo_file_path">Foto Kamar ${fotoCount}</label>
                        <div class="group-input">
                            <div class="row">
                                <div class="col-10">
                                    <div class="file-input-wrapper">
                                        <input class="form-control" type="file" name="room_photo_file_path[]" accept="image/*" required>
                                        <div class="file-name-display">
                                            <span class="current-file">Belum ada file dipilih</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button class="tf-btn danger large delete" style="font-size: 12px">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="old_room_photo_file_path[]">
                                <input type="hidden" name="old_room_photo_file_name[]">
                            </div>
                        </div>
                    </div>
                `;

                $('#propertyContainer').append(newFoto);
            });

            $('#propertyContainer').on('click', '.delete', function(e) {
                e.preventDefault();
                let fotoCount = $('#propertyContainer .propertyItem').length;

                if (fotoCount <= 1) {
                    alert('Minimal harus ada satu foto');
                } else {
                    if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                        const propertyItem = $(this).closest('.propertyItem');
                        propertyItem.remove();
                        $('#propertyContainer .propertyItem').each(function(index) {
                            $(this).find('label').text('Foto ' + (index + 1));
                        });
                    }
                }
            });

            function readURL(input, previewContainer) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        let imgPreviewContainer = previewContainer.querySelector('.image-preview');

                        if (!imgPreviewContainer) {
                            imgPreviewContainer = document.createElement('div');
                            imgPreviewContainer.className = 'image-preview mt-2';
                            previewContainer.appendChild(imgPreviewContainer);
                        }

                        let imgPreview = imgPreviewContainer.querySelector('img');

                        if (!imgPreview) {
                            imgPreview = document.createElement('img');
                            imgPreview.style.maxWidth = '200px';
                            imgPreview.style.maxHeight = '200px';
                            imgPreviewContainer.appendChild(imgPreview);
                        }

                        imgPreview.src = e.target.result;

                        const fileNameDisplay = input.closest('.file-input-wrapper').querySelector('.current-file');
                        fileNameDisplay.textContent = input.files[0].name;
                        fileNameDisplay.style.color = '#28a745';
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            document.getElementById('propertyContainer').addEventListener('change', function(e) {
                if (e.target && e.target.matches('input[type="file"]')) {
                    const fileInput = e.target;
                    const groupInput = fileInput.closest('.group-input');
                    readURL(fileInput, groupInput);
                }
            });
        </script>
    @endpush
@endsection
