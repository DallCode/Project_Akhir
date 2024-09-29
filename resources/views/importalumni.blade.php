@extends('layout.main')

@section('content')

<!-- Include necessary styles -->
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('bkk/dist/assets/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/toastify/toastify.css') }}">
<link rel="stylesheet" href="https://unpkg.com/filepond/dist/filepond.css">
<link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
<link rel="stylesheet" href="{{ asset('bkk/dist/assets/css/app.css') }}">

<!-- Include FilePond JS -->
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<div class="col-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Template Format File</h5>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div id="alert-container"></div>
               <h6>Upload file berupa xlsx yang berisi data alumni, gunakan format template yang telah kami sediakan</h6>
               <a href="{{ route('download.template') }}" class="btn btn-primary mt-3">Download</a>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Upload Alumni Data</h5>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div id="alert-container"></div>
                <form id="importForm" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" id="file" class="filepond" />
                    <button type="submit" class="btn btn-primary mt-3">Upload and Import</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Include necessary scripts -->
<script src="{{ asset('bkk/dist/assets/vendors/toastify/toastify.js') }}"></script>
<script src="{{ asset('bkk/dist/assets/js/main.js') }}"></script>

<script>
    // Register FilePond instance
    const pond = FilePond.create(document.querySelector('input[id="file"]'), {
        server: {
            process: {
                url: '{{ route('upload.file') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                onload: (response) => {
                    // This function will be called when the file is successfully uploaded
                    return JSON.parse(response).fileName;
                },
                onerror: (response) => {
                    // This function will be called when there's an error during upload
                    const error = JSON.parse(response);
                    showAlert(error.error || 'An error occurred during file upload', 'danger');
                }
            },
            revert: null,
            restore: null,
            load: null,
            fetch: null,
        },
        allowMultiple: false,
        credits: false
    });

    // Handle form submission
    document.getElementById('importForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Get the file name from FilePond
        const files = pond.getFiles();
        if (files.length === 0) {
            showAlert('Please select a file to import.', 'danger');
            return;
        }
        const fileName = files[0].serverId;

        // Send import request
        fetch('{{ route('import') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ file: fileName })
        })
        .then(response => response.json())
        .then(data => {
            showAlert(data.alert, data.alert_type);
            if (data.alert_type === 'success') {
                pond.removeFile();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred during import. Please check the console for more details.', 'danger');
        });
    });

    function showAlert(message, type) {
        const alertContainer = document.getElementById('alert-container');
        alertContainer.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }
</script>

@endsection
