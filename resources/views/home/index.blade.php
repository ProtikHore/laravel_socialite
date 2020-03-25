@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="row" style="margin-top: 15px;">
                <div class="col">
{{--                    <button type="button" class="btn btn-sm btn_orange" id="add" data-toggle="tooltip" title="Alt + A">ADD</button>--}}
                </div>
                <div class="col" id="search_section">
                    <form id="search_form">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." id="search_key" name="search_key">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary border-left-0 border btn_orange" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row sr-only" style="margin-top: 15px;" id="record_section">
                <div class="col">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-sm-2" style="padding-top: 10px;">
                            <input type="checkbox" id="bulk_records"> All Check
                        </div>
                        <div class="col-sm-2">
                            <select name="bulk_status" id="bulk_status" class="form-control">
                                <option value="">Bulk Action</option>
                                <option value="Active">Make Active</option>
                                <option value="Inactive">Make Inactive</option>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" id="bulk_apply" class="btn btn-sm btn_orange">APPLY</button>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Status</th>
                            <th>Narrative</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="records"></tbody>
                    </table>
                </div>
            </div>

            <div class="row sr-only" id="no_record_section">
                <div class="col text-center">
                    No Record Found
                </div>
            </div>

            <div class="row sr-only" style="margin-top: 15px; margin-bottom: 50px;">
                <div class="sr-only" id="pagination_section">
                    <ul class="pagination" role="navigation" id="pagination_links">

                    </ul>
                </div>
                <div class="text-right" id="record_count_section">

                </div>
            </div>

            <div class="modal fade" id="modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Category</h5>
                            <button type="button" class="close modal_close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="padding-left: 80px; padding-right: 80px; padding-bottom: 50px;">
                            <div id="form_message" class="text-center text-danger">

                            </div>
                            <form id="form">
                                <input name="id" type="hidden" id="id">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <input name="category" type="text" class="form-control" id="category" placeholder="Category">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="narrative">Narrative</label>
                                    <textarea name="narrative" type="text" class="form-control" id="narrative" placeholder="Narrative"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col text-right">
                                        <button type="button" class="btn btn-primary text-center btn-sm modal_close" data-dismiss="modal">CLOSE</button>
                                        <button type="submit" class="btn btn_orange btn-sm text-center margin_left_fifteen_px" id="form_submit"></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script language="JavaScript">
        function setPageDefaults() {
            $('#record_section').addClass('sr-only');
            $('#bulk_records').prop('checked', false);
            $('#bulk_status').val('');
            $('#records').empty();
            $('#no_record_section').addClass('sr-only');
            $('#record_count_section').removeClass('col-sm-12 col-sm-2');
            $('#pagination_section').removeClass('col-sm-10');
            $('#pagination_section').parent().addClass('sr-only');
            $('#pagination_section').addClass('sr-only');
            $('#pagination_links').empty();
            $('#record_count_section').empty();
            return true;
        }
        function getData(url) {
            setPageDefaults();
            $.ajax({
                method: 'get',
                url: url,
                success: function (result) {
                    console.log(result);
                    totalRecord = result.total;
                    lastPageUrl = result.last_page_url;
                    lastPageNumber = result.last_page;
                    let firstItem = result.current_page - 4;
                    let lastItem = result.current_page + 4;
                    if (result.total > 0) {
                        $('#record_count_section').append('Record: ' + result.from + ' ~ ' + result.to + ' of ' + result.total);
                        if (result.total > '{{ $recordPerPage }}') {
                            let SearchKey = $('#search_key').val() === '' ? 'null' : $('#search_key').val();
                            let link = [];
                            for (let i=1; i<=result.last_page; i++) {
                                let linkUrl = '{{ url('user/get/social/login') }}/' + SearchKey + '?page=' + i;
                                if (result.current_page === i) {
                                    link[i] = '<a href="#" class="page-link btn_orange pagination_active" data-url="' + linkUrl + '">' + i + '</a>';
                                } else {
                                    link[i] = '<a href="#" class="page-link btn_orange" data-url="' + linkUrl + '">' + i + '</a>';
                                }
                            }
                            if (result.last_page <= 9) {
                                for (let i = 1; i<=result.last_page; i++){
                                    $('#pagination_links').append('<li class="page-item">' + link[i] + '<li>');
                                }
                            } else {
                                if (result.current_page <= 5) {
                                    firstItem = 1;
                                } else if (lastItem >= lastPageNumber) {
                                    firstItem = lastPageNumber - 8;
                                }
                                for (let i=0; i<9; i++) {
                                    $('#pagination_links').append('<li class="page-item">' + link[firstItem+i] + '<li>');
                                }
                                let jumpOver = '<div class="form-inline"><label for="jump_pagination">Go To</label><input type="text" pattern="\d+" class="form-control form-control-sm mx-2" id="jump_pagination"><label for="jump_pagination">Page</label></div>';
                                $('#pagination_links').append(jumpOver);
                            }
                            $('#record_count_section').addClass('col-sm-2');
                            $('#pagination_section').addClass('col-sm-10');
                            $('#pagination_section').removeClass('sr-only');
                        } else {
                            $('#record_count_section').addClass('col-sm-12');
                        }
                        let sl = [];
                        for (let j = result.from; j <= result.to; j++) {
                            sl.push(j);
                        }
                        $.each(result.data, function (key, data) {
                            $('#records').append($('<tr></tr>')
                                .append('<td><input type="checkbox" class="bulk_record" value="' + data.id + '"> ' + sl[key] + '</td>')
                                .append('<td>' + data.name + '</td>')
                                .append('<td>' + data.email + '</td>')
                                .append('<td>' + data.mobile_number + '</td>')
                                .append('<td>' + data.status + '</td>')
                                .append('<td>' + data.narrative + '</td>')
                                .append('<td><i class="far fa-edit edit text_orange" data-id="' + data.id + '" style="cursor: pointer; font-size: 1rem;" data-toggle="tooltip" title="Edit"></i></td>')
                            );
                        });
                        $('#record_section').removeClass('sr-only');
                        $('#pagination_section').parent().removeClass('sr-only');
                    } else {
                        $('#no_record_section').removeClass('sr-only');
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
            return true;
        }

        var currentPageUrl = '';
        var lastPageUrl = '';
        var totalRecord = 0;
        var lastPageNumber = 0;

        $(document).ready(function () {
            $('#search_key').val('');
            currentPageUrl = '{{ url('user/get/social/login') }}/null';
            getData(currentPageUrl);
        });

        $(document).on('click', '.page-link', function () {
            currentPageUrl = $(this).data('url');
            getData(currentPageUrl);
            return false;
        });

        $(document).on('submit', '#search_form', function () {
            let SearchKey = $('#search_key').val() === '' ? 'null' : $('#search_key').val();
            currentPageUrl = '{{ url('user/get/social/login') }}/' + SearchKey;
            getData(currentPageUrl);
            return false;
        });

        $('#bulk_records').click(function () {
            $('.bulk_record').not(this).prop('checked', this.checked);
            $('#bulk_records').not(this).prop('checked', this.checked);
            return true;
        });

        $(document).on('click', '#bulk_apply', function () {
            let data = new FormData(),
                status = $('#bulk_status').val(),
                ids = [];
            $('.bulk_record:checkbox:checked').each(function () {
                ids.push($(this).val());
            });
            data.append('ids', ids);
            data.append('status', status);
            data.append('_token', '{{ csrf_token() }}');
            $.ajax({
                method: 'post',
                url: '{{ url('configuration/category/apply/category/bulk/operation') }}',
                data: data,
                contentType: false,
                processData: false,
                cache: false,
                success: function (result) {
                    console.log(result);
                    getData(currentPageUrl);
                },
                error: function (xhr) {
                    console.log(xhr);
                    let message = '';
                    if (xhr.hasOwnProperty('responseJSON')) {
                        if (xhr.responseJSON.hasOwnProperty('errors')) {
                            $.each(xhr.responseJSON.errors, function (key, value) {
                                $.each(value, function (k, v) {
                                    message += v + '<br>';
                                });
                            });
                        }
                    }
                    $.toaster({ title: 'Warning', priority : 'danger', message : message });
                }
            });
            return false;
        });

        function clearForm() {
            $('#form').trigger('reset');
            $('#id').val('');
            $('#form_message').empty();
            $('#form').find('.text-danger').removeClass('text-danger');
            $('#form').find('.is-invalid').removeClass('is-invalid');
            $('#form').find('span').remove();
            return true;
        }

        $(document).on('submit', '#form', function () {
            $('#form_message').empty();
            $('#form').find('.text-danger').removeClass('text-danger');
            $('#form').find('.is-invalid').removeClass('is-invalid');
            $('#orm').find('span').remove();
            let Data = new FormData(this);
            Data.append('_token', '{{ csrf_token() }}');
            $.ajax({
                method: 'post',
                url: '{{ url('configuration/category/save/category') }}',
                data: Data,
                processData: false,
                contentType: false,
                cache: false,
                success: function (result) {
                    console.log(result);
                    console.log(currentPageUrl);
                    $('.modal_close').trigger('click');
                    if (result === 'Data Stored Successfully') {
                        let landingPageUrl;
                        if (totalRecord !== 0 && (totalRecord % '{{ $recordPerPage }}') === 0) {
                            landingPageUrl = lastPageUrl.split('=')[0] + '=' + (parseInt(lastPageUrl.split('=')[1]) + 1);
                        } else {
                            landingPageUrl = lastPageUrl;
                        }
                        currentPageUrl = landingPageUrl;
                        getData(landingPageUrl);
                    } else if (result === 'Data Updated Successfully') {
                        getData(currentPageUrl);
                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                    if (xhr.hasOwnProperty('responseJSON')) {
                        if (xhr.responseJSON.hasOwnProperty('errors')) {
                            $.each(xhr.responseJSON.errors, function (key, value) {
                                if (key !== 'id') {
                                    $('#' + key).after('<span></span>');
                                    $('#' + key).parent().find('label').addClass('text-danger');
                                    $('#' + key).addClass('is-invalid');
                                    $.each(value, function (k, v) {
                                        $('#' + key).parent().find('span').addClass('text-danger').append('<p>' + v + '</p>');
                                    });
                                } else {
                                    $.each(value, function (k, v) {
                                        $('#form_message').append('<p>' + v + '</p>');
                                    });
                                }
                            });
                        }
                    }
                }
            });
            return false;
        });

        $(document).on('click', '#add', function () {
            clearForm();
            $('#form_submit').text('SAVE');
            $('#modal').modal('show').on('shown.bs.modal', function () {
                $('#category').focus();
            });
            return false;
        });

        $(document).on('keydown', function ( e ) {
            if ((e.altKey) && ( String.fromCharCode(e.which).toLowerCase() === 'a') ) {
                clearForm();
                $('#form_submit').text('SAVE');
                $('#modal').modal('show').on('shown.bs.modal', function () {
                    $('#category').focus();
                });
                return false;
            }
        });

        $(document).on('click', '.edit', function () {
            let id = $(this).data('id');
            $.ajax({
                method: 'get',
                url: '{{ url('configuration/category/get/category') }}/' + id,
                cache: false,
                success: function (result) {
                    console.log(result);
                    clearForm();
                    $('#id').val(id);
                    $('#category').val(result.category);
                    $('#status').val(result.status);
                    $('#narrative').val(result.narrative);
                    $('#form_submit').text('UPDATE');
                    $('#modal').modal('show').on('shown.bs.modal', function () {
                        $('#category').focus();
                    });
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
            return false;
        });

        $(document).on('change', '#jump_pagination', function () {
            let pageNumber = parseInt($('#jump_pagination').val());
            console.log(pageNumber);
            if (isPositiveInteger(pageNumber) && pageNumber <= lastPageNumber) {
                let SearchKey = $('#search_key').val() === '' ? 'null' : $('#search_key').val();
                let linkUrl = '{{ url('user/get/social/login') }}/' + SearchKey + '?page=' + pageNumber;
                getData(linkUrl);
            } else {
                $.toaster({ title: 'Warning', priority : 'danger', message : 'Invalid Page Number!' });
            }
            return false;
        });

    </script>
@endsection
