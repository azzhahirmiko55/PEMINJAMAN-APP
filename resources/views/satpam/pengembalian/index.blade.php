@extends('layouts.app')

@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="col-sm-12">
                <div class="dt-responsive table-responsive">
                    <div id="table-style-hover_wrapper" class="dt-container dt-bootstrap5">
                        <div class="row mt-2 justify-content-md-center">
                            <div class="col-12 ">
                                <div id="sect-calendar" class="nk-calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')

<script>
    $(document).ready(function () {
        // initDataTable('table-style-hover');
    });
</script>

@endpush
