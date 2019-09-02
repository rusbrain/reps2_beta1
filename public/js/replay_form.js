"use strict";

$(document).ready(function() {
    let $container = $('#replay-uploader-wrapper');

    let replayFileDropzone = new Dropzone("div#file-uploader-dropzone", {
        url: $container.data('upload-url'),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        createImageThumbnails: false,
        acceptedFiles: '.rep,application/x-7z-compressed,application/zip,application/x-rar-compressed',
        maxFiles: 2,
        addRemoveLinks: true
    });
    $('div#file-uploader-dropzone').addClass('dropzone');

    window.aaa = replayFileDropzone;

    let removePreviousFile = function() {
        replayFileDropzone.removeAllFiles();
        if ($('#file-uploader-dropzone .dz-preview').length) {
            $('#file-uploader-dropzone .dz-preview').remove();
        }

        $('#file_id').val('');
    };

    replayFileDropzone.on('success', function(file, response) {
        $('#replay-file-error-container').html('').hide();
        $('#file_id').val(response.file_id);
        if (response.map_id) {
            $('#map_id.form-select-2').val(response.map_id).change();
        }
        if (response.first_race) {
            $('select#first_race').val(response.first_race).change();
        }
        if (response.first_location) {
            $('#first_location').val(response.first_location);
        }
        if (response.second_race) {
            $('select#second_race').val(response.second_race).change();
        }
        if (response.second_location) {
            $('#second_location').val(response.second_location);
        }
        if (response.first_name) {
            $('#first_name').val(response.first_name);
        }
        if (response.second_name) {
            $('#second_name').val(response.second_name);
        }
        if (response.first_APM) {
            $('#first_apm').val(response.first_APM);
        }
        if (response.second_APM) {
            $('#second_apm').val(response.second_APM);
        }
        if (response.name) {
            $('#title').val(response.name);
        }
        if (response.replay_time) {
            $('#start_date').val(response.replay_time);
        }
    }).on('error', function(file, errorResponse, xhr) {
        let $errorMessage = $('#replay-file-error-container');
        let errorHtml = '';

        if (xhr) {
            for (let error of errorResponse.errors.file) {
                errorHtml += '<strong>' + error + '</strong>';
            }
        } else {
            errorHtml = '<strong>' + errorResponse + '</strong>';
        }

        $errorMessage.html(errorHtml).show();
    }).on('addedfile', function(file) {
        //check if file exists
        if ($('#file_id').hasClass('js-file-preloaded')) {
            $('#file_id').removeClass('js-file-preloaded');
            $container.find('.js-remove-preloaded-file:first').click();
        } else if (this.files.length > 1) {
            let firstFile = this.files[0];
            this.removeFile(firstFile);
        }
    });

    $container.on('click', '.js-remove-preloaded-file', function() {
        $(this).closest('.js-file-preview').remove();
        $('#file_id').val('');

        return false;
    });
});
